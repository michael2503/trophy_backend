<?php

namespace App\Http\Controllers\Guest;

use App\Classes\EmailClass;
use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class Contact extends Controller
{
    use ApiResponder;
    

    public function index(Request $request){
        $postData = $request->json()->all();
        EmailClass::guestContact($postData);
        EmailClass::defaultContactReply($postData['full_name'], $postData['email']);
        
        return $this->successResponse($postData);
    }

}
