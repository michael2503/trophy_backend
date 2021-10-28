<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use App\Models\WebsiteSettings;
use App\Models\SocialSettings;
use App\Models\Currency;

class GeneralSettings extends Controller
{
    use ApiResponder;
    
    public function index(){
        // Helper::cronJob();
		$result['websiteSettings'] = WebsiteSettings::first();
		$result['social_link'] = SocialSettings::all();

        return $this->successResponse($result);
    }
    
    public function home(){
        
    }
    

}
