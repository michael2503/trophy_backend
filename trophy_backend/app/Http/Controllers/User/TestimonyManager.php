<?php

namespace App\Http\Controllers\User;

use App\Classes\CustomDateTime;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Testimony;
use App\Models\Investments;
use App\Models\investmentHistory;
use Illuminate\Support\Facades\Auth;

class TestimonyManager extends Controller
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
        $user_id = Auth::user()->id;
        $records = Testimony::forUser($user_id);
        return $this->successResponse($records);
    }


    public function createTestimony(Request $request){
        $postData = $request->json()->all(); 
        $user_id = Auth::user()->id;
        $postData['user_id'] = $user_id;
        $id = $postData['id'];

        $result = Testimony::createRow($postData, $id);

        return $this->successResponse($result);
    }

}
