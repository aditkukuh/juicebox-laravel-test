<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user, ['*']);
    }

    /**
     * Test getting a user by ID.
     *
     * @return void
     */
    public function test_get_user_by_id()
    {
        $user = User::factory()->create([
            'name' => 'example',
            'email' => 'example@mail.com',
        ]);

        $response = $this->getJson(route('user.getUserById', $user->id));

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'created_at' => $user->created_at->toISOString(),
                        'updated_at' => $user->updated_at->toISOString(),
                    ],
                    'message' => 'Get user by ID successfully.'
                ]);
    }

    /**
     * Test getting a user by ID with invalid ID.
     *
     * @return void
     */
    public function test_get_user_by_invalid_id()
    {
        $invalidId = 9999;

        $response = $this->getJson(route('user.getUserById', $invalidId));

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'User not found',
                 ]);
    }

    /**
     * Test getting all users with pagination.
     *
     * @return void
     */
    public function test_get_all_users()
    {
        User::factory()->count(10)->create();

        $response = $this->getJson(route('user.getAll'));

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'name', 'email', 'created_at', 'updated_at']
                    ],
                    'message'
                ])
                ->assertJson([
                    'status' => true,
                    'message' => 'users retrieved successfully.'
                ]);
    }

}
