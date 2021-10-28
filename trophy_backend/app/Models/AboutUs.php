<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'title',
        'sub_title',
        'vision',
        'mission',
        'content',
        'banner',
    ];

    public static function aboutUs(){
        return self::where('id', 1)->first();
    }


    public static function whoWeAre(){
        return self::where('id', 2)->first();
    }
    
    public static function callToAction(){
        return self::where('id', 3)->first();
    }

}
