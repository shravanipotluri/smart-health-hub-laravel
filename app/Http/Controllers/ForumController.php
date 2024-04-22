<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    /**
     * Create a new forum topic.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getForums() {
        $forums = Forum::all();
    
        return response()->json($forums, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $forum = Forum::create($request->all());
        return response()->json($forum, 201);
    }
    public function update(Request $request, $id) {
        $forum = Forum::find($id);
    
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }
    
        $forum->topic = $request->get('topic', $forum->topic);
        $forum->category = $request->get('category', $forum->category);
        $forum->content = $request->get('content', $forum->content);
        $forum->user_id = $request->get('user_id', $forum->user_id);
    
        $forum->save();
    
        return response()->json($forum, 200);
    }
    
    public function destroy($id) {
        $forum = Forum::find($id);
    
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }
    
        $forum->delete();
    
        return response()->json(['message' => 'Forum deleted'], 200);
    }
}
