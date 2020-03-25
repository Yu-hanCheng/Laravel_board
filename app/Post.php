<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'parent_id','updated_at','layer','user_id'
    ];

    public function replies () {
        return $this->hasMany(self::class,'parent_id')->where('layer',2);
    }

    public function comments() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function likeList () {
        return $this->hasMany(Like::class, 'post_id')->with('user');
    }
    
    public function isLike () {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function user () {
        return $this->belongsTo(User::class);
    } 

    public static function showComments($post_id)
    {
        $allcommentsWithReplies = Post::with(['replies' => function ($query){
            $query->with('user')->orderBy('created_at','desc')->get();
        },'user'])->where('parent_id',$post_id)->orderBy('created_at','desc')->get();
        $post = Post::with('likes')->find($post_id);
        $response['post'] = $post->only('id','content');
        $response['likes'] = $post->likes;
        $response['Allcomments'] = $allcommentsWithReplies;
        return $response;
    }
}
