<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use PHPUnit\Framework\Test;

class Testimony extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'testimony',
        'status'
    ];

    protected $hidden = [
        
    ];


    public static function forUser($userID){
        return self::where('user_id', $userID)->first();
    }

    public static function createRow($data, $id){
        if($id){
            self::where('id', $id)->update([
                'testimony' => $data['testimony']
            ]);
            return Testimony::findOrFail($id); 
        } else {
            self::create([
                'user_id' => $data['user_id'],
                'testimony' => $data['testimony']
            ]);
            return Testimony::where('user_id', $data['user_id'])->orderBy('id', 'DESC')->first(); 
        }
    }

    public static function guestTestimony(){
        return self::select('testimonies.*', 'users.first_name', 'users.last_name', 'users.photo')
            ->leftJoin('users', 'users.id', 'testimonies.user_id')
            ->orderBy('testimonies.id', 'DESC')->where('testimonies.status', 'Approved')->get();
    }
    
    public static function firstTen(){
        return self::select('testimonies.*', 'users.first_name', 'users.last_name', 'users.photo')
            ->leftJoin('users', 'users.id', 'testimonies.user_id')
            ->orderBy('testimonies.id', 'DESC')->take(10)
            ->where('testimonies.status', 'Approved')->get();
    }

    public static function userTestAdmin(){
        return self::select('testimonies.*', 'users.first_name', 'users.last_name', 'users.photo')
            ->leftJoin('users', 'users.id', 'testimonies.user_id')
            ->orderBy('testimonies.id', 'DESC')->get();
    }
}
