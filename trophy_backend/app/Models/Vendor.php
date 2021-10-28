<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'name',
        'website',
        'curr_version',
        'version_date',
    ];

    public static function getRecord(){
        return self::first();
    }

}
