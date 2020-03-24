<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function replies () {
        return $this->hasMany(self::class,'post_id')->where('layer',2);
    }

    public function comments() {
        return $this->hasMany(self::class, 'post_id');
    }

    public function likes () {
        return $this->hasMany(Like::class)->with('user');
    }

    public function likesC () {
        return $this->hasMany(Like::class);
    }
    public function user () {
        return $this->belongsTo(User::class);
    } 

    public static function showComments($post_id)
    {
        $allcommentsWithReplies = Post::with(['replies' => function ($query){
            $query->with('user')->orderBy('created_at','desc')->get();
        },'user'])->where('post_id',$post_id)->orderBy('created_at','desc')->get();
        $post = Post::with('likes')->find($post_id);
        $response['post'] = $post->only('id','content');
        $response['likes'] = $post->likes;
        $response['Allcomments'] = $allcommentsWithReplies;
        return $response;
    }
}
