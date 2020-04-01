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
        return response(["posts" => $all], 200);
    }

    public function store(Request $request)
    {
        $va = Validator::make($request->all(), [
            'parent_id' => 'bail|nullable|integer|exists:posts,id',
            'content' => 'bail|required|max:205',
        ]);

        if($va->errors()->has('parent_id')){
            return response(['message' => $va->errors()->messages()['parent_id'][0]], 400);
        };
        if($va->errors()->has('content')){
            return response(['message' => $va->errors()->messages()['content'][0]], 400);
        }; 
        $post = Post::create([
            'user_id' => $request->user()->id,
            'parent_id' => $request['parent_id'],
            'content' => $request['content'],
        ]);
        return response(["message" => $post], 201);
    }
}
