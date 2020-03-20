<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $user_id = "";

    public static function selectAll($user_id)
    {
        $posts = Post::leftJoin('likes', function($join) use ($user_id){
            $join->where('likes.user_id','=', $user_id)
            ->on('posts.id', '=', 'likes.post_id');})
            ->select('posts.*','likes.id as like')->orderBy('created_at','desc')->get();
        return $posts;
    }
}
