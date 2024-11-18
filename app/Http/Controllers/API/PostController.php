<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
     /**
     * Display a listing of the posts (only posts belonging to the authenticated user), paginated.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('user_id', Auth::id())
            ->paginate(5);

        return $result = PostResource::collection($posts)->additional([
            'status' => true,
            'message' => 'Posts retrieved successfully.',
        ]);;
    }

    /**
     * Display a specific post (only the post belonging to the authenticated user).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('user_id', Auth::id())->find($id);

        if (!$post) {
            return $this->sendError('Post not found');
        }

        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
    }

    /**
     * Create a new post (post belongs to the authenticated user).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Update a post (only the post belonging to the authenticated user).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
    }

    /**
     * Delete a post (only the post belonging to the authenticated user).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('user_id', Auth::id())->find($id);

        if (!$post) {
            return $this->sendError('Post not found');
        }

        $post->delete();

        return $this->sendResponse([], 'Post deleted successfully.');
    }
}
