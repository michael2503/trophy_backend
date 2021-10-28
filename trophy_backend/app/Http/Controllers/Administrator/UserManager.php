<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;

class UserManager extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }



    public function users($token, $role, $limit, $page){
        if(Admin::isAdminAuth($token)){
            if(!$page){
                $page = 1; 
                $offset = 0;
            }
            else{				
                $offset = $limit * ($page - 1);
            }
            $results = array(
                'counts' => User::getUserByCount($role), 
                'data' => User::getUserByStatus($role, $limit, $offset)
            );
            return $this->successResponse($results);
        } else {
            return $this->adminAuthError();
        }
    }

    public function userDetails($token, $userID){
        if(Admin::isAdminAuth($token)){
            $record = User::findOrfail($userID);
            $data['userInfo'] = $record;
            return $this->successResponse($data);
        } else {
            return $this->adminAuthError();
        }
    }

    public function updateUser(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $record = User::findOrFail($postData['userID']);
            
            $record->fill($postData);
            if ($record->isClean()) {
                return $this->successResponse($record);
            }
            $record->save();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

    public function deleteUser($token, $user_id){
        if(Admin::isAdminAuth($token)){
            $record = User::findOrFail($user_id);
            $record->delete();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }
    

    public function userAction($token, $userID, $action){
        if(Admin::isAdminAuth($token)){
            $user = User::findOrFail($userID);
            if(mb_strtolower($action) == 'delete') {
                $result = $user->delete();
                return $this->successResponse($result);
            } else {
                $result = User::accountAction($userID, $action);
                if ($result) {
                    return $this->successResponse(User::findOrFail($userID));
                }
            }
        } else {
            return $this->adminAuthError();
        }
    }
}
