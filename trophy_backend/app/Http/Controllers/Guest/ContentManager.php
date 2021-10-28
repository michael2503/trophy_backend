<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use App\Models\AdminBank;
use App\Models\AboutUs;
use App\Models\Faq;
use App\Models\HomeBanner;
use App\Models\Pages;
use App\Models\Testimony;

class ContentManager extends Controller
{
    use ApiResponder;
    

    public function banks(){
        $result = AdminBank::getActiveBanks();
        return $this->successResponse($result);
    }

    public function pages($url){
        $result = Pages::getUrl($url);
        return $this->successResponse($result);
    }
    // DB::connection('mysql2')->select(...);
    public function homeContent(){
        $content = array(
            'banner' => HomeBanner::first(),
            'aboutUs' => AboutUs::aboutUs(),
            'whoWeAre' => AboutUs::whoWeAre(),
            'callToAction' => AboutUs::callToAction(),
            'testimonies' => Testimony::firstTen(),
        );
        return $this->successResponse($content);
    }

}
