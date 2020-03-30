<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'parent_id', 'updated_at', 'layer', 'user_id'
    ];
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function replies () 
    {
        return $this->hasMany(self::class, 'parent_id');
//        SOJ: 更優雅的寫法
//        return $this->hasMany(self::class, 'parent_id')
//                ->with('user')
//                ->orderBy('created_at', 'desc');
        //replies.user
    }

    public function comments() 
    {
        return $this->hasMany(self::class, 'parent_id');
//        SOJ: 更優雅的寫法
//        return $this->hasMany(self::class, 'parent_id')
//            ->with('user') //comments.user
//            ->with('replies'); //replies
    }

    public function likeList () 
    {
        return $this->hasMany(Like::class, 'post_id')->with('user');
    }
    
    public function isLike () 
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function user () 
    {
        return $this->belongsTo(User::class);
    }

    // SOJ: local scope
//    public function scopeIdLessTen($query)
//    {
//        return $query->where('id', '<', 10);
//    }
}
