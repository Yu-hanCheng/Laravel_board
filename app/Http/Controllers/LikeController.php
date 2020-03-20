<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Carbon\Carbon;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $array = [
            'post_id' => $request['post_id'],
            'user_id' => session('user')['id'],
            'created_at' => Carbon::now('Asia/Taipei')
        ];
        if ($request['isStore']) {
            Like::storeLike($array);
        } else {
            Like::removeLike($array);
        }
        return redirect()->route('board.show');
    }
}