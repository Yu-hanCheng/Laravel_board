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
            'post_id' => 'bail|required|integer|exists:posts,id'
        ]);
        if ($va->fails()) {
            return response()->json(['msg' => (string)$va->errors()], 416);
        }

        $likeResult = Like::createOrDestroy([
            'post_id' => $id,
            'user_id' => $request->user()->id
            ]);

        return response(['msg' => $id . $likeResult]);
    }
}