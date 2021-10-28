<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'title',
        'overview',
        'contents',
        'url',
        'status',
    ];

    public static function getUrl($url){
        return self::where('url', $url)->first();
    }

}
