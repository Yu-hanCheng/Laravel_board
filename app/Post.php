<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

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

    public function replies () {
        return $this->hasMany(self::class, 'parent_id');
//        SOJ: 更優雅的寫法
//        return $this->hasMany(self::class, 'parent_id')
//                ->with('user')
//                ->orderBy('created_at', 'desc');
        //replies.user
    }

    public function comments() {
        return $this->hasMany(self::class, 'parent_id');
//        SOJ: 更優雅的寫法
//        return $this->hasMany(self::class, 'parent_id')
//            ->with('user') //comments.user
//            ->with('replies') //replies
//            ->orderBy('created_at', 'desc');
    }

    public function likeList () {
        return $this->hasMany(Like::class, 'post_id')->with('user');
    }
    
    public function isLiked () {
        return $this->hasMany(Like::class, 'post_id')
            ->where('user_id', auth()->check() ? auth()->user()->id : 0);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    // SOJ: local scope
//    public static function scopeSojIsLike($query, $userId)
//    {
//        return $query->with('user')->
//    }
    public function scopeIsLiked($query)
    {
        if (is_null($query->getQuery()->columns)) {
            $query->select([$query->getQuery()->from . '.*']);
        }
        $relation = Relation::noConstraints(function () {
            return $this->likeList();
        });
        $q = $this->likeList()->getRelationExistenceCountQuery(
            $relation->getRelated()->where('user_id',
                auth()->check() ? auth()->user()->id : 0)->newQuery(), $query
        );
        $query->selectSub($q->toBase(), 'is_liked');
    }
}
