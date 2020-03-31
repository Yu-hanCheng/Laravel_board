<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Post;  

class PostController extends Controller
{
    const LAYER_POST = 0;

    public function index(Request $request)
    {
//        SOJ: 更優雅的寫法
        $posts = Post::where('parent_id', null)
            ->with([
                'comments', //post.comments comments.replies
                'likeList', //post.likeList
                'user', //post.user
            ])
            ->withCount('likeList')
            ->withCount('isLiked')
            ->orderBy('updated_at', 'desc')
            ->get();
//
//        foreach($posts as $post) {
//            $isLiked = false;
//            foreach($post->likeList as $list) {
//                $userName = $request->user() ? $request->user()->name : '';
//                if ($list->user->name == $userName) {
//                    $isLiked = true;
//                }
//            }
//            $post['isLiked'] = $isLiked;
//        }
//
        return response(['posts' => $posts], 200);

        $all = Post::with([
            'comments' => function ($query) {
                    $query->with([
                        'replies' => function ($query) {
                            $query->with('user')->orderBy('created_at', 'desc')->get();
                        },
                        'user']
                        )->orderBy('created_at', 'desc')->get();
                    },
            'likeList',
            'user'])
            ->withCount(['isLike' => function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id ?? 0);
                    }])
            ->where('layer', self::LAYER_POST)
            ->orderBy('created_at', 'desc')->get();
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
            return response()->json(['msg' => (string)$va->errors()], 416);
        }
        
        if ($request['parent_id'] == ""  and  $request['layer'] != self::LAYER_POST){
            return response()->json(["msg" => "invalid layer"], 400); 
        } elseif ($request['parent_id'] != ""  and  $request['layer'] == self::LAYER_POST) {
            return response()->json(["msg" => "invalid layer"], 400); 
        } else {
            Post::create([
                'user_id' => $request->user()->id,
                'parent_id' => $request['parent_id'],
                'layer' => $request['layer'],
                'content' => $request['content'],
            ]);
//            SOJ: 通常創建成功，要直接回傳 data
            return response()->json(["msg" => "successfully"], 201);
        }
    }
}
