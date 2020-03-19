<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public static function storeComment($comment)
    {
        self::create([
            'post_id' => $comment['post_id'],
            'user_id' => $comment['user_id'],
            'user_name' => $comment['name'],
            'content' => $comment['content'],
            'created_at' => $comment['created_at']
            ]);
    }
}
