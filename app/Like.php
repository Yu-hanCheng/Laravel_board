<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public static function storeLike($like)
    {
        self::create([
            'post_id' => $like['post_id'],
            'user_id' => $like['user_id'],
            'created_at' => $like['created_at']
            ]);
    }

    public static function removeLike($like)
    {
        self::where([['user_id','=',$like['user_id']],['post_id','=', $like['post_id']]])->delete();
    }
}
