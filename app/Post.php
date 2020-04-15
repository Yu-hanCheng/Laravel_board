<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'parent_id', 'created_at', 'user_id'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return $this->attributes['updated_at'] = Carbon::parse($value)->timezone(config('app.timezone'))->toIso8601String();
    }
   
    public function replies () 
    {
        return $this->hasMany(self::class, 'parent_id')
                    ->with('user')
                    ->orderBy('updated_at', 'desc');
    }

    public function comments() 
    {
        return $this->hasMany(self::class, 'parent_id')
                    ->with('replies','user')
                    ->orderBy('updated_at', 'desc');
    }

    public function likeList () 
    {
        return $this->hasMany(Like::class, 'post_id')
                    ->with('user');
    }

    public function scopeWithIsLikes(Builder $query, $user_id)
    {
            $query->leftJoinSub(
                "select post_id,count(user_id)isLike  from likes where user_id = ".$user_id.' group by post_id',
                'likes',
                'likes.post_id',
                'posts.id'
            );
    }
    
    public function user () 
    {
        return $this->belongsTo(User::class);
    } 
}
