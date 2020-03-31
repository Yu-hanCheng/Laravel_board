<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token', 'updated_at', 'created_at', 'api_token'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return $this->attributes['updated_at'] = Carbon::parse($value)->timezone(config('app.timezone'))->toIso8601String();
    }

    public static function check($name, $password)
    {
        $user = self::where('name', $name)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                return $user;
            }
            throw new \Exception('Password does not match');
        }
        throw new \Exception('User does not exist');
    }
}
