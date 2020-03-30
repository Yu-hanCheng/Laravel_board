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
//        SOJ: 更優雅的寫法
//        $result = Like::createOrDestroy(
//            ['post_id' => $id, 'user_id' => $request->user()->id]
//        );
//
//        return response(['msg' => $result], 200);
//
//        SOJ: 永遠不能 unlike
        if (Like::where([
            ['post_id', '=', $id],
            ['user_id', '=', $request->user()->id],
            ])->get()->count() > 0) {
            return response()->json(["msg" => "Already liked!"], 400);
        }
        $array = [
            'post_id' => $id,
            'user_id' => $request->user()->id,
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