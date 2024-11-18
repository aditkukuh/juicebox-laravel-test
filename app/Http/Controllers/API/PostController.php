<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use Exception;
class PostController extends BaseController
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $posts = Post::where('user_id', Auth::id())
                ->paginate(5);

            return PostResource::collection($posts)->additional([
                'status' => true,
                'message' => 'Posts retrieved successfully.',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve posts', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Post::where('user_id', Auth::id())->find($id);

            if (!$post) {
                return $this->sendError('Post not found');
            }

            return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve post', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => Auth::id(),
            ]);
        
            return $this->sendResponse(new PostResource($post), 'Post created successfully.');
        } catch (Exception $e) {
            return $this->sendError('Failed to create post', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'string|max:255',
                'content' => 'string',
            ]);

            $post = Post::where('user_id', Auth::id())->find($id);

            if (!$post) {
                return $this->sendError('Post not found');
            }

            $post->title = $request->title ?? $post->title;
            $post->content = $request->content ?? $post->content;
            $post->save();

            return $this->sendResponse(new PostResource($post), 'Post updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('Failed to update post', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = Post::where('user_id', Auth::id())->find($id);

            if (!$post) {
                return $this->sendError('Post not found');
            }

            $post->delete();

            return $this->sendResponse([], 'Post deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('Failed to delete post', ['error' => $e->getMessage()]);
        }
    }
}
