<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;  
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::selectAll(session('user')['id']); 
        return view('board', [
            'posts' => $posts, 
            'user_id' => session('user')['id'], 
            'user_name' => session('user')['name']
            ]);
    }

    public function store(Request $request)
    {
        Post::create([
            'user_id' => $request['user_id'],
            'user_name' =>$request['user_name'],
            'content' => $request['content'],
            'created_at' => Carbon::now('Asia/Taipei'),
        ]);
        return redirect()->route('board.show');
    }
}
