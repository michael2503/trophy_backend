<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\Investment;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Support;

class SupportManager extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    public function index($token, $status, $limit=20, $page=1){
        if(Admin::isAdminAuth($token)){
            
            if(!$page){
                $page = 1; 
                $offset = 0;
            }
            else{				
                $offset = $limit * ($page - 1);
            }
            $results = array(
                'counts' => Support::countForAdmin($status), 
                'data' => Support::adminRecord($status, $limit, $offset),
                'users' => User::get(),
            );

            return $this->successResponse($results);
        } else {
            return $this->adminAuthError();
        }
    }


    public function single($token, $id){
        if(Admin::isAdminAuth($token)){
            $content = array(
                'single' => Support::findOrFail($id),
                'reply' => Support::response($id)
            );
            Support::updateSeenAdmin($id);
            return $this->successResponse($content);
        } else {
            return $this->adminAuthError();
        }
    }


    public function composeOrReply(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $postData['sender'] = 'admin';
            $postData['status'] = 'read';
            $craete  = Support::create($postData);
            
            return $this->successResponse($craete);
        } else {
            return $this->adminAuthError();
        }
    }
    

    public function deleteSupport($token, $id){
        if(Admin::isAdminAuth($token)){
            $result = Support::findOrFail($id);
            $result->delete();            
            return $this->successResponse($result);
        } else {
            return $this->adminAuthError();
        }
    }

    
}
