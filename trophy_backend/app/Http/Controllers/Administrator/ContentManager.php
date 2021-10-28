<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AboutUs;
use App\Models\EmailTemplate;
use App\Models\HomeBanner;
use App\Models\Admin;

class ContentManager extends Controller
{

    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }


    public function updateAboutUs(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $id = $postData['id'];
            $record = AboutUs::findOrFail($id);
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

    public function getHomeBanner($token){
        if(Admin::isAdminAuth($token)){
            $record = array(
                'slider' => HomeBanner::first(),
                'aboutUs' => AboutUs::aboutUs(),
            );
            return $this->successResponse($record);
        } else {
            return $this->adminAuthError();
        }
    }
    
    public function updateHomeBanner(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $id = $postData['id'];
            $record = HomeBanner::findOrFail($id);
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


    // EMAIL TEMPLATE
    public function emailTemplate($token){
        if(Admin::isAdminAuth($token)){
            $record = EmailTemplate::all();
            return $this->successResponse($record, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }

    public function singleEmailTemplate($token, $id){
        if(Admin::isAdminAuth($token)){
            $record = EmailTemplate::findOrFail($id);
            return $this->successResponse($record, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }

    public function updateEmailTemplate(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $record = EmailTemplate::findOrFail($postData['id']);
            $record->fill($postData);
            if ($record->isClean()) {
                return $this->successResponse($record, Response::HTTP_CREATED);
            }
            $record->save();
            return $this->successResponse($record, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }


    public function getWhoWeAre($token){
        if(Admin::isAdminAuth($token)){
            $info = array(
                'whoWeAre' => AboutUs::where('id', 2)->first(),
                'callToAction' => AboutUs::where('id', 3)->first()
            );
            return $this->successResponse($info, Response::HTTP_CREATED);
        } else {
            return $this->adminAuthError();
        }
    }

    public function updateWhoWeAre(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $id = $postData['id'];
            $record = AboutUs::findOrFail($id);
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

    public function updateCallToAction(Request $request, $token){
        if(Admin::isAdminAuth($token)){
            $postData = $request->json()->all();
            $id = $postData['id'];
            $record = AboutUs::findOrFail($id);
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
