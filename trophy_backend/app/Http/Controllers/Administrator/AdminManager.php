<?php

namespace App\Http\Controllers\Administrator;

use App\Classes\Visitor;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Admin;
use App\Classes\Helper;

class AdminManager extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    // list of all admin
    public function admins($token, $limit, $page){
        if(Admin::isAdminAuth($token)){
            if(!$page){
                $page = 1; 
                $offset = 0;
            }
            else{				
                $offset = $limit * ($page - 1);
            }
            $results = array(
                'counts' => Admin::count(), 
                'data' => Admin::take($limit)->offset($offset)->get(),
            );
            return $this->successResponse($results);
        } else {
            return $this->adminAuthError();
        }
    }
    
    // Add admin function
    public function addAdmin(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $postData['password'] = app('hash')->make($postData['password']);
            $postData['signup_ip'] = Visitor::getIP();
            $create = Admin::create($postData);
            return $this->successResponse($create);
        } else {
            return $this->adminAuthError();
        }
    }

    // Fetch single admin function
    public function adminSingle($id, $token){
        if(Admin::isAdminAuth($token)){
            $record = Admin::findOrFail($id);
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

    // Update admin and update profile
    public function updateAdmin(Request $request, $token, $role){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $record = Admin::findOrFail($postData['id']);
            if($role == 'profile'){
                $postData['username'] = $record->username;
                $postData['email'] = $record->email;
                $postData['password'] = $record->password;
                $record->fill($postData);
                if ($record->isClean()) {
                    return $this->successResponse($record);
                }
                $record->save();
                return Helper::adminLoginHandler($record);
            } else {
                $postData['password'] = $record->password;
                $record->fill($postData);
                if ($record->isClean()) {
                    return $this->successResponse($record);
                }
                $record->save();
                return $this->successResponse($record);
            }
        } else {
            return $this->adminAuthError();
        }
        
    }

    // Delete admin function
    public function deleteAdmin($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = Admin::findOrFail($id);
            $record->delete();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

    //Change password function
    public function changePassword(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $adminID = $postData['id'];
            $record = Admin::findOrFail($adminID);
            if(!$this->verifyPassword($postData['oldPassword'], $record->password)){
                // return $this->errorResponse('Oops! Old password not matched', Response::HTTP_UNPROCESSABLE_ENTITY);
                return $this->successResponse('error');
            } else {
                $update = Admin::updatePassword($postData['password'], $adminID);
                return $this->successResponse($update);
            }
        } else {
            return $this->adminAuthError();
        }
    }

    
}
