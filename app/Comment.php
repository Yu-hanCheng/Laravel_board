<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reply;
use App\Like;
use App\Post;

class Comment extends Model
{
    protected $guarded = [];

    public function replies () {
        return $this->hasMany(Reply::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

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

    public static function showComments($post_id)
    {
        $allcommentsWithReplies = self::with('replies')->where('post_id',$_GET['post_id'])->orderBy('created_at','desc')->get();
        $post = Post::with('likes')->find($post_id);
        $response['post'] = $post->only('id','content');
        $response['likes'] = $post->likes;
        $response['Allcomments'] = $allcommentsWithReplies;
        return $response;
    }
}
