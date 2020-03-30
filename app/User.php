<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password'
//        SOJ: api_token 應該要加入白名單
//        'name', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token', 'updated_at', 'created_at', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public static function isUser($name, $password)
    {
        $user = self::where('name', $name)->first();
          if ($user) {
              if (Hash::check($password, $user->password)) {
                return [1, $user];
              } else {
                  return [0, "Password does not match"];
              }
          } else {
              return [0, "User does not exist"];
          }
    }

//    SOJ: 更優雅的寫法
//    public static function check($name, $password)
//    {
//        $user = self::where('name', $name)->first();
//        if ($user) {
//            if (Hash::check($password, $user->password)) {
//                return $user;
//            }
//            throw new \Exception('Password does not match');
//        }
//        throw new \Exception('User does not exist');
//    }
}
