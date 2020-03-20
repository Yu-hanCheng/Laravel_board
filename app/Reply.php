<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public static function storeReply($reply)
    {
        self::create([
            'comment_id' => $reply['comment_id'],
            'user_id' => $reply['user_id'],
            'user_name' => $reply['name'],
            'content' => $reply['content'],
            'created_at' => $reply['created_at']
            ]);
    }
}
