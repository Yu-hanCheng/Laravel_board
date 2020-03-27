<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function indexWithoutLogin(Request $request)
    {
        $all = Post::with([
            'comments' => function ($query) {
                    $query->with([
                        'replies' => function ($query) { $query->with('user')->orderBy('created_at','desc')->get();},
                        'user']
                        )->orderBy('created_at','desc')->get();
                    },
            'isLike' => function ($query) use ($request){
                    $query->where('user_id', 0)->get();
                    },
            'likeList',
            'user'])
            ->where('layer',0) 
            ->orderBy('created_at','desc')->get();
        return response()->json(["posts" => $all], 200);
    }

    public function store(Request $request)
    {
        $va = Validator::make($request->all(), [
            'parent_id' => 'nullable|integer|min:1',
            'layer' =>'required|integer|between:0,2',
            'content' => 'required|max:205',
        ]);
        
        if ($va->fails()) {
            return response()->json(['msg' => $va->errors()], 416);
        }
        
        if ($request['parent_id'] == ""  and  $request['layer'] > 0){
            return response()->json(["msg" => "invalid layer"], 400); 
        } elseif ($request['parent_id'] != ""  and  $request['layer'] == 0) {
            return response()->json(["msg" => "invalid layer"], 400); 
        } else {
            Post::create([
                'user_id' => $request->user()->id,
                'parent_id' => $request['parent_id'],
                'layer' => $request['layer'],
                'content' => $request['content'],
                'created_at' => Carbon::now('Asia/Taipei'),
            ]);
            return response()->json(["msg" => "successfully"], 201);
        }

    }
}
