<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'parent_id', 'created_at', 'user_id'
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];
   
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

    public function isLike() 
    {
        return $this->hasMany(Like::class, 'post_id')
                    ->where('user_id', auth()->check() ? auth()->user()->id : 0);
    }
    
    public function user () 
    {
        return $this->belongsTo(User::class);
    } 
}
