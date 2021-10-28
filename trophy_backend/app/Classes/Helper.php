<?php

namespace App\Classes;
use App\Classes\CustomDateTime;
use Exception;
use App\Models\User;
use App\Models\Admin;
use App\Classes\Visitor;
use App\Models\InvestmentHistory;
use App\Models\Investments;
use App\Models\WebsiteSettings;

class Helper
{

	/**
	 * Build success response
	 * @param string/array $data
	 * @param int  $code
	 * @return Illuminate\Http\JsonResponse
	*/

	
    public static function loginHandler($user=array()) {
    	$firstToken = Settings::randomStrgsUpperLower(50);
        $secondToken = Settings::randomStrgsUpperLower(50);
        $thirdToken = Settings::randomStrgsUpperLower(50);

        $token = $firstToken.'.'.$secondToken.'.'.$thirdToken;

        User::where('id', $user['id'])->update([
           'api_token' =>  $token
        ]);
        $user['token'] = $token;  

        return $user;
    }


    public static function adminLoginHandler($admin=array()) {
        Admin::where('id', $admin['id'])->update([
            'last_login' 	=> CustomDateTime::currentTime(),
            'last_login_ip' => Visitor::getIP(),
        ]);
        $firstToken = Settings::randomStrgsUpperLower(50);
        $secondToken = Settings::randomStrgsUpperLower(50);
        $thirdToken = Settings::randomStrgsUpperLower(50);

        $token = $firstToken.''.$secondToken.''.$thirdToken;

        Admin::where('id', $admin['id'])->update([
           'admin_token' =>  $token
        ]);
        $admin['token'] = $token;  
              
        return $admin;
    }


}