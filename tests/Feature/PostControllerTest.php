<?php

namespace Tests\Feature\API;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $post;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * Test if posts can be listed.
     *
     * @return void
     */
    public function test_index()
    {
        Post::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->getJson(route('posts.index'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [],
                     'status',
                     'message',
                 ])
                 ->assertJson([
                     'status' => true,
                     'message' => 'Posts retrieved successfully.',
                 ]);
    }

   /**
     * Test if a specific post can be shown.
     *
     * @return void
     */
    public function test_show()
    {
        $this->post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson(route('posts.show', $this->post->id));

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Post retrieved successfully.',
                ])
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'title',
                        'content',
                        'created_at',
                        'updated_at',
                    ],
                ]);

        $response->assertJson([
            'data' => [
                'id' => $this->post->id,
                'title' => $this->post->title,
                'content' => $this->post->content,
            ]
        ]);
    }


    /**
     * Test if a post can be created.
     *
     * @return void
     */
    public function test_store()
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content for the new post.',
        ];

        $response = $this->postJson(route('posts.store'), $postData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Post created successfully.',
                ])
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'title',
                        'content',
                        'created_at',
                        'updated_at',
                    ],
                    'message',
                ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'Test content for the new post.',
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Test if a post can be updated.
     *
     * @return void
     */
    public function test_update()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content for the post.',
        ];

        $response = $this->patchJson(route('posts.update', $post->id), $updatedData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Post updated successfully.',
                ])
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'title',
                        'content',
                        'created_at',
                        'updated_at',
                    ],
                ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content for the post.',
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Test if a post can be deleted.
     *
     * @return void
     */
    public function test_destroy()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
    
        $response = $this->deleteJson(route('posts.destroy', $post->id));
    
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Post deleted successfully.',
                     'data' => [] 
                 ]);
    
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }    
}
