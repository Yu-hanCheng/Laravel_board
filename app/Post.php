<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'parent_id', 'updated_at', 'layer', 'user_id'
    ];

    public function replies () {
        return $this->hasMany(self::class, 'parent_id');
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
}
