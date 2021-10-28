<?php

namespace App\Http\Controllers\Guest;

use App\Classes\CustomDateTime;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Testimony;

class TestimonyGuest extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    public function getTestimony(){
        $records = Testimony::guestTestimony();
        return $this->successResponse($records);
    }


}
