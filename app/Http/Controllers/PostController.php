<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;  
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
    {
        $all = Post::with([
            'comments' => function ($query) {
                    $query->with([
                        'replies' => function ($query) { $query->with('user')->orderBy('created_at','desc')->get();},
                        'user']
                        )->orderBy('created_at','desc')->get();
                    },
            'likes' => function ($query) {
                    $query->where('user_id', session('user')['id']);
                    },
            'likesC',
            'user'])
            ->where('layer',0) 
            ->orderBy('created_at','desc')->get();
        return view('board', [
            'posts' => $all, 
            'user_id' => session('user')['id'], 
            'user_name' => session('user')['name']
            ]);
    }

    public function store(Request $request)
    {
        Post::create([
            'user_id' => $request['user_id'],
            'post_id' => null,
            'layer' => 0,
            'content' => $request['content'],
            'created_at' => Carbon::now('Asia/Taipei'),
        ]);
        return redirect()->route('board.show');
    }
}
