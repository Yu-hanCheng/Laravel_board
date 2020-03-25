<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','password', 'remember_token', 'updated_at', 'created_at', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function storeUser($user)
    { 
        $isUnique = self::where('name',$user['name'])->first();
        if ($isUnique) {
            return false;
        } else {
            self::create(
                ['name' => $user['name'],
                'password' => $user['password'],
                'created_at' => $user['created_at']]);
            return true;
        }
    }

    public static function isUser($name, $password)
    {
        $user = self::where('name', $name)->first();
          if ($user) {
              if (hash('sha256', $password) == $user->password) {
                $user = json_decode(json_encode($user), true);
                return [1, $user];
              } else {
                  return [0, "Password does not match"];
              }
          } else {
              return [0, "User does not exist"];
          }
    } 
}
