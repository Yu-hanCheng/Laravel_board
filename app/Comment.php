<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reply;
use App\Like;
use App\Post;

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

    public static function showComments($post_id)
    {
        $allcomments = self::where('post_id',$post_id)->orderBy('created_at','desc')->get();
        $post = Post::find($post_id);
        $results = [];
        foreach ($allcomments as $comment) {
            $replies = Reply::where('comment_id', $comment->id)->orderBy('created_at','desc')->get();
            $comment= json_decode(json_encode($comment), true);
            $comment['reply'] = $replies;
            array_push($results,$comment);
        }
        $userLikes = Like::join('users', 'users.id', 'likes.user_id')
            ->select('users.name as name')->where('post_id',$post_id)->get();
        $response['post'] = $post;
        $response['likes'] = $userLikes;
        $response['Allcomments'] = $results;
        return $response;
    }
}
