<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'api_token',
        'phone',
        'interest',
        'address',
        'state',
        'country',
        'photo',
        'email_verify',
        'phone_verify',
        'status',
        'signup_ip',
        'signup_date',
        'last_login_ip',
        'last_login',
    ];

    


    protected $hidden = [
        'password',
        'api_token'
    ];


    public static function updatePassword($password, $user_id){
        return self::where('id', $user_id)->update([
            'password' => app('hash')->make($password)
        ]);
    }

    public static function checkUser($checkUser){
        return self::where('email', $checkUser)->orWhere('phone', $checkUser)->orWhere('username', $checkUser)->first();
    }

    public static function emailCheck($checkUser){
        return self::Where('email', $checkUser)->first();
    }
    
    public static function checkPhone($phone){
        return self::where('phone', $phone)->first();
    }

    public static function logout($user_id){
        return self::where('id', $user_id)->update([
            'api_token' => null
        ]);
    }

    public static function blockUser(){
        return self::where('status', 'Blocked')->orWhere('status', 'Suspended')->count();
    }
    
    public static function susUser(){
        return self::Where('status', 'Suspended')->count();
    }
    
    public static function activeUser(){
        return self::where('status', 'Active')->count();
    }


    public static function getUserByStatus($role, $limit, $offset){
        if($role == 'all'){
            return self::take($limit)->offset($offset)->orderBy('id', 'DESC')->get();
        } else {
            return self::where('status', ucwords($role))->take($limit)->offset($offset)->orderBy('id', 'DESC')->get();
        }
    }

    public static function getUserByCount($role){
        if($role == 'all'){
            return self::count();
        } else {
            return self::where('status', ucwords($role))->count();
        }
    }

    public static function accountAction($userID, $action){
        return self::where('id', $userID)->update([
            'status' => $action,
            'email_verify' => 1,
        ]); 
    }

    public static function getReferral($userName){
        return self::where('username', $userName)->first();
    }


    public static function allReferral($userName, $limit, $offset){
        return self::where('referral', $userName)->take($limit)->offset($offset)->orderBy('id', 'DESC')->get();
    }
    
    public static function countAllReferral($userName){
        return self::where('referral', $userName)->count();
    }


    public static function topTenAdmin(){
        return self::orderby('id', 'DESC')->take(10)->get();
    }



    public static function userReferral($username, $take, $offset){
        return self::where('referral', $username)->take($take)->offset($offset)->orderBy('id', 'DESC')->get();
    }
    
    
    public static function countRef($username){
        return self::where('referral', $username)->count();
    }
    





}
