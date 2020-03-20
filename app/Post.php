<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function likes () {
        return $this->hasMany(Like::class)->with('user');
    }
}
