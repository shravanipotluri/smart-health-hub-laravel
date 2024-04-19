<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Get all posts in a forum.
     *
     * @param int $forumId
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * Add a new post to a forum.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $forumId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $forumId)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $request->merge(['forum_id' => $forumId]);
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    /**
     * Update a forum post.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $postId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post->update($request->all());
        return response()->json($post);
    }

    /**
     * Remove a post from the forum.
     *
     * @param int $postId
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
