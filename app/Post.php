<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public static function selectAll()
    {
        $posts = Post::orderBy('created_at','desc')->get();
        return $posts;
    }
}
