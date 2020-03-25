<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Carbon\Carbon;

class LikeController extends Controller
{
    protected $hidden = [
        'created_at', 'updated_at', 'user_id'
    ];

    public function store(Request $request, $id)
    {
        $array = [
            'post_id' => $id,
            'user_id' => $request->user()->id,
            'created_at' => Carbon::now('Asia/Taipei')
        ];
        if ($request['isLike']) {
            Like::storeLike($array);
            return response()->json(["msg" => "like successfully"], 200);
        } else {
            Like::removeLike($array);
            return response()->json(["msg" => "unlike successfully"], 200);
        }
        
    }
}