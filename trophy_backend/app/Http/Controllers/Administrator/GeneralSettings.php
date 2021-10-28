<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\WebsiteSettings;
use App\Models\SocialSettings;
use App\Models\Admin;

class GeneralSettings extends Controller
{

    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }


    public function updateWebsiteSettings(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
        
            $id =1;
            $record = WebsiteSettings::findOrFail($id);
            $record->fill($postData);
            $record->save();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }


    public function addSocialLink(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all(); 
            $result = SocialSettings::create($postData);
            return $this->successResponse($result, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }


    public function deleteSocialLink($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = SocialSettings::findOrFail($id);
            $record->delete();
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }

 

    
    
}
