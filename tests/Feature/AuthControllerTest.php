<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_register()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'c_password' => 'password',
        ];

        $response = $this->postJson(route('register'), $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User register successfully.',
                 ])
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'token',
                         'name'
                     ],
                     'message'
                 ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /**
     * Test user login with valid credentials.
     *
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User login successfully.',
                 ])
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'token',
                         'name'
                     ],
                     'message'
                 ]);
    }

    /**
     * Test user login with invalid credentials.
     *
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'message' => 'Unauthorised.',
                    'data' => [
                        'error' => 'Unauthorised'
                    ]
                ]);
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function test_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('MyApp')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson(route('logout'));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User logged out successfully.',
                 ]);
    }
}