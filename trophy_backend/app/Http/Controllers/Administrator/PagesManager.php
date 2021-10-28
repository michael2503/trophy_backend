<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Pages;
use App\Models\Admin;
use App\Classes\Settings;


class PagesManager extends Controller
{

    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }


    public function pages($token){
        if(Admin::isAdminAuth($token)){
            $result = Pages::all();
            return $this->successResponse($result);
        } else {
            return $this->adminAuthError();
        }
    }

    public function addPage(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $postData['url'] = Settings::cleanUrl($postData['title']);
            $result = Pages::create($postData);
            return $this->successResponse($result, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }

    public function pageSingle($token, $id){
        if(Admin::isAdminAuth($token)){
            $result = Pages::findOrFail($id);
            return $this->successResponse($result);
        } else {
            return $this->adminAuthError();
        }
    }

    public function updatePage(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $id = $postData['id'];
            $stat = $postData['status'];
            if($stat == 'Active'){
                $status = 1;
            } else {
                $status = 0; 
            }
            $update = Pages::where('id', $id)->update([
                'title' => $postData['title'],
                'contents' => $postData['contents'],
                'status' => $status,
            ]);
            $record = Pages::findOrFail($id);
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

    public function deletePage($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = Pages::findOrFail($id);
            $record->delete();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

    
    
}
