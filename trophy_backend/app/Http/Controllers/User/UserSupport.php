<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReferralBonus;
use App\Models\Support;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserSupport extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }



    public function index($status, $limit=20, $page=1){
        $userID = Auth::user()->id;
        if(!$page){
            $page = 1; 
            $offset = 0;
        }
        else{				
            $offset = $limit * ($page - 1);
        }
        $results = array(
            'counts' => Support::countForUser($userID, $status), 
            'data' => Support::userRecord($userID, $status, $limit, $offset),
        );

        return $this->successResponse($results);
    }

    public function single($id){
        $content = array(
            'single' => Support::findOrFail($id),
            'reply' => Support::response($id)
        );
        Support::updateSeenUser($id);
        return $this->successResponse($content);
    }


    public function composeOrReply(Request $request){
        $postData = $request->json()->all();
        $postData['sender'] = 'user';
        $postData['status'] = 'read';
        $craete  = Support::create($postData);
        
        return $this->successResponse($craete);
    }


}
