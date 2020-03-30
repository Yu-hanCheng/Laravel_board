<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $va = Validator::make(['post_id' => $id], [
            'post_id' => 'required|exists:posts,id'
        ]);
        if ($va->fails()) {
            return response()->json(['msg' => (string)$va->errors()], 416);
        }

        $array = [
            'post_id' => $id,
            'user_id' => $request->user()->id,
        ];

        if (Like::where([
            ['post_id', '=', $id],
            ['user_id', '=', $request->user()->id],
            ])->get()->count() > 0) {
                Like::removeLike($array);
                return response()->json(["msg" => "unlike successfully"], 200);
        } else {
            Like::storeLike($array);
            return response()->json(["msg" => "like successfully"], 200);
        }
    }
}