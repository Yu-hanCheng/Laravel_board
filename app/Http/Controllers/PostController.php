<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Post;  

class PostController extends Controller
{
    public function index(Request $request)
    {
        $all = Post::where('parent_id', null)
            ->with([
                'comments', 
                'likeList',
                'user'])
            ->withCount('isLike')
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json(["posts" => $all], 200);
    }

    public function store(Request $request)
    {
        $va = Validator::make($request->all(), [
            'parent_id' => 'nullable|integer|min:1',
            'content' => 'required|max:205',
        ]);
        
        if ($va->fails()) {
            return response()->json(['msg' => (string)$va->errors()], 416);
        }
        
        $post = Post::create([
            'user_id' => $request->user()->id,
            'parent_id' => $request['parent_id'],
            'content' => $request['content'],
        ]);
        return response()->json(["msg" => $post], 201);
    }
}
