<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'post_id', 'updated_at', 'user_id', 'created_at', 'id'
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public static function storeLike($like)
    {
        self::create([
            'post_id' => $like['post_id'],
            'user_id' => $like['user_id'],
            ]);
    }

    public static function removeLike($like)
    {
        self::where([
            ['user_id', '=', $like['user_id']],
            ['post_id', '=', $like['post_id']]
            ])->delete();
    }

   public static function createOrDestroy($parameters)
   {
       // SOJ: 目前 comment and reply 是也可以按讚
       if (self::where($parameters)->get()->count() > 0) {
           self::removeLike($parameters);
           return ' unLiked successfully';
       } else {
           self::storeLike($parameters);
           return ' liked successfully';
       }
   }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
