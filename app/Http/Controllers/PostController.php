<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;  
use Carbon\Carbon;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $all = Post::with([
            'comments' => function ($query) {
                    $query->with([
                        'replies' => function ($query) { $query->with('user')->orderBy('created_at','desc')->get();},
                        'user']
                        )->orderBy('created_at','desc')->get();
                    },
            'isLike' => function ($query) use ($request){
                    $query->where('user_id', $request->user()->id)->get();
                    },
            'likeList',
            'user'])
            ->where('layer',0) 
            ->orderBy('created_at','desc')->get();
        return response()->json(["posts" => $all], 200);
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'user_id' => $request->user()->id,
            'parent_id' => $request['parent_id'],
            'layer' => $request['layer'],
            'content' => $request['content'],
            'created_at' => Carbon::now('Asia/Taipei'),
        ]);
        return response()->json(["msg" => "successfully"], 201);
    }
}
