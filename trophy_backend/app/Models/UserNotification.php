<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'status',
    ];

    public static function createRow($user_id, $title, $contents){
        return self::create([
            'user_id' => $user_id,
            'title' => $title,
            'contents' => $contents
        ]);
    }

    public static function forUser($userID){
        return self::where('user_id', $userID)->where('status', 0)->orderBy('id', 'DESC')->get();
    }

}
