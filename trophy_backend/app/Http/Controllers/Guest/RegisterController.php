<?php

namespace App\Http\Controllers\Guest;

use App\Classes\CustomDateTime;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\Response;
use App\Classes\Visitor;
use App\Classes\Helper;
use App\Classes\EmailClass;
use App\Classes\Settings;

class RegisterController extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }


    public function createRecord(Request $request){
        $postData = $request->json()->all();
        
        $checkEmail = User::checkUser($postData['email']);
        $checkPhone = User::checkPhone($postData['phone']);        
        $checkUsername = User::checkUser($postData['username']);        
        
        if($checkEmail){
            return $this->errorResponse('Oops! Email already exist', Response::HTTP_CREATED);
        } else if($checkPhone){
            return $this->errorResponse('Oops! Phone number already exist', Response::HTTP_CREATED);
        } else if($checkUsername){
            return $this->errorResponse('Oops! Username already exist', Response::HTTP_CREATED);
        }
        else {
            $postData['last_login_ip'] = Visitor::getIP();
            $postData['signup_ip'] = Visitor::getIP();
            $postData['signup_date'] = CustomDateTime::currentTime();
            $postData['last_login'] = CustomDateTime::currentTime();

            $postData['password'] = app('hash')->make($postData['password']);

            $result = User::create($postData);

            if($result){
                $auth = Helper::loginHandler($result);
                $email_code = Settings::randomStrgs(6);
                $sms_code = Settings::randomNumber(6);
                UserVerification::createVerification($result->id, $email_code);
                UserVerification::createSmsVerification($result->id, $sms_code);
                // EmailClass::email_verification($result, $email_code);

                return $this->successResponse($auth, Response::HTTP_CREATED);
            }
        }
    }
}
