<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'reply_id',
        'subject',
        'contents',
        'image',
        'admin_status',
        'user_status',
        'sender',
    ];


    public static function adminRecord($status, $take, $offset){
        if($status == 'all'){
            return self::take($take)->offset($offset)
                ->select('supports.*', 'users.first_name', 'users.last_name', 'users.username')
                ->leftJoin('users', 'users.id', 'supports.user_id')
                ->orderBy('id', 'DESC')->get();
        } else if($status == 'read'){
            return self::take($take)->offset($offset)
                ->select('supports.*', 'users.first_name', 'users.last_name')
                ->leftJoin('users', 'users.id', 'supports.user_id')
                ->where('supports.admin_status', 'read')->orWhere('supports.sender', 'admin')
                ->orderBy('id', 'DESC')->get();
        } else if($status == 'unread'){
            return self::take($take)->offset($offset)
                ->select('supports.*', 'users.first_name', 'users.last_name')
                ->leftJoin('users', 'users.id', 'supports.user_id')
                ->where('supports.admin_status', 'unread')->Where('sender', 'user')
                ->orderBy('id', 'DESC')->get();
        }
    }

    public static function countForAdmin($status){
        if($status == 'all'){
            return self::count();
        } else if($status == 'read') {
            return self::where('supports.admin_status', 'read')->orWhere('supports.sender', 'admin')->count();
        } else if($status == 'unread') {
            return self::where('supports.admin_status', 'unread')->Where('sender', 'user')->count();
        }
    }

    public static function response($id){
        return self::where('reply_id', $id)->orderBy('id', 'DESC')->get();
    }
    
    
    public static function updateSeenUser($id){
        return self::where('id', $id)->update([
            'user_status' => 'read'
        ]);
    }
    
    public static function updateSeenAdmin($id){
        return self::where('id', $id)->update([
            'admin_status' => 'read'
        ]);
    }



    public static function userRecord($userID, $status, $take, $offset){
        if($status == 'all'){
            return self::take($take)->offset($offset)
                ->where('user_id', $userID)->orderBy('id', 'DESC')->get();
        } /*else if($status == 'read'){
            return self::take($take)->offset($offset)
                ->where('user_id', $userID)
                ->where('user_status', 'read')->orWhere('sender', 'user')->orderBy('id', 'DESC')->get();
        } else if($status == 'unread'){
            return self::take($take)->offset($offset)
                ->where('user_id', $userID)
                ->where('user_status', 'unread')->Where('sender', 'admin')->orderBy('id', 'DESC')->get();
        } */
     }

     public static function countForUser($userID, $status){
        if($status == 'all'){
            return self::where('user_id', $userID)->count();
        } /*else if($status == 'read'){
            return self::where('user_id', $userID)->where('user_status', 'read')->orWhere('sender', 'user')->count();
        } else if($status == 'unread'){
            return self::where('user_id', $userID)
                ->where('user_status', 'unread')->Where('sender', 'admin')->count();
        } */
    }


    public static function userUnread($userID){
        return self::where('user_id', $userID)->where('user_status', 'unread')->where('sender', 'admin')->take(1)->get();
    }

    public static function adminUnread(){
        return self::select('supports.*', 'users.first_name', 'users.last_name')
            ->leftJoin('users', 'users.id', 'supports.user_id')
            ->where('admin_status', 'unread')->where('sender', 'user')->take(1)->get();
    }
    

}
