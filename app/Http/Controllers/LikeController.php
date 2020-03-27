<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $va = Validator::make(['post_id' => $id], [
            'post_id' => 'required|exists:posts,id'
        ]);
        if ($va->fails()) {
            return response()->json(['msg' => $va->errors()], 416);
        }
        if (Like::where([
            ['post_id', '=', $id],
            ['user_id', '=', $request->user()->id],
            ])->get()->count() > 0) {
            return response()->json(["msg" => "Already liked!"], 400);
        }
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