<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Config;

class WebsiteSettings extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'biz_name',
        'site_name',
        'site_title',
        'site_email',
        'site_description',
        'site_url',
        'favicon_url',
        'logo_url',
        'biz_addr',
        'biz_city',
        'biz_state',
        'biz_country',
        'biz_phone',
        'chat_code',
    ];

    public static function clientInfo(){
        return array(
            'name' => self::single()->biz_name,
            'server' => Config::host(),
            'ip' => gethostbyname(Config::serverName())
        );
    }
    
    
    public static function single(){
        return self::first();
    }

}
