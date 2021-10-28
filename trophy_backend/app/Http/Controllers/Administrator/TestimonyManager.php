<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Withdrawal;
use App\Models\Admin;

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



    public function index($token, $limit=20, $page=1){
        if(Admin::isAdminAuth($token)){
            if(!$page){
                $page = 1; 
                $offset = 0;
            }
            else{				
                $offset = $limit * ($page - 1);
            }
            $results = array(
                'counts' => Testimony::count(), 
                'data' => Testimony::userTestAdmin($limit, $offset),
            );
            return $this->successResponse($results);
        } else {
            return $this->adminAuthError();
        }
    }

    public function approveTestimony($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = Testimony::findOrFail($id);
            if($record->status == 'Pending'){
                $update = Testimony::where('id', $id)->update([
                    'status' => 'Approved'
                ]);
                $newRecord = Testimony::findOrFail($id);
                return $this->successResponse($newRecord);
            } else {
                return $this->errorResponse('Testimony has alread approved', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return $this->adminAuthError();
        }
    }

    public function deleteTestimony($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = Testimony::findOrFail($id);
            $record->delete();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

    
    public function singleTestimony($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = Testimony::findOrFail($id);
            return $this->successResponse($record, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }

    public function updateTestimony(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $record = Testimony::findOrFail($postData['id']);
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

}
