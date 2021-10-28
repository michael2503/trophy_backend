<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class UserVerification extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    
    
    protected $fillable = [
        'user_id',
        'email_code',
        'email_verify',
        'sms_code',
        'sms_verify'
    ];

    protected $hidden = [
        
    ];


    public static function createVerification($user_id, $code){
        return self::create([
            'user_id' => $user_id,
            'email_code' => $code,
        ]);
    }

    public static function createSmsVerification($user_id, $code){
        return self::create([
            'user_id' => $user_id,
            'sms_code' => $code,
        ]);
    }
    
    public static function verifyEmail($user_id, $code){
        $info = self::where('user_id', $user_id)->where('email_code', $code)->first();
        if($info){
            self::where('user_id', $user_id)->where('email_code', $code)->update([
                'email_verify' => 1
            ]);
            $user = User::where('id', $user_id)->update([
                'email_verify' => 1
            ]);
            return User::findOrFail($user_id);
        } else {
            return null;
        }
    }




    public static function verifySMS($user_id, $code){
        $info = self::where('user_id', $user_id)->where('sms_code', $code)->first();
        // return $info;
        if($info){
            self::where('user_id', $user_id)->where('sms_code', $code)->update([
                'sms_verify' => 1
            ]);
            $user = User::where('id', $user_id)->update([
                'phone_verify' => 1
            ]);
            return User::findOrFail($user_id);
        } else {
            return null;
        }
    }


    
}
