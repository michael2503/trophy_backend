<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    
    
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'admin_token',
        'role',
        'phone',
        'photo',
        'address',
        'city',
        'state',
        'country',
        'bio',
        'status',
        'signup_ip',
        'last_login_ip',
        'last_login',
    ];

    


    protected $hidden = [
        // 'password',
        // 'admin_token'
    ];


    public static function updatePassword($password, $adminID){
        return self::where('id', $adminID)->update([
            'password' => app('hash')->make($password)
        ]);
    }

    public static function checkAdmin($admin){
        return self::where('username', $admin)->orWhere('email', $admin)->first();
    }
    
    public static function checkPhone($phone){
        return self::where('phone', $phone)->first();
    }

    public static function logout($adminID){
        return self::where('id', $adminID)->update([
            'api_token' => null
        ]);
    }

    public static function isAdminAuth($token){
        return self::where('admin_token', $token)->first();
    }
}
