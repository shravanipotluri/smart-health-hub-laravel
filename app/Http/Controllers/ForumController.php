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
}
