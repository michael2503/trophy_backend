<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Auth;
use App\Classes\Helper;
use App\Classes\Settings;
use App\Classes\EmailClass;

class AccountSettings extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        // $this->middleware('auth');
        //To specific the functions you want to allow only auth user to access
        // $this->middleware('auth', ['only' => ['updateProfile', 'index']]);
    }

    public function emailVerification(Request $request){
        $postData = $request->json()->all();
        $user_id = Auth::user()->id;
        
        $check = UserVerification::verifyEmail($user_id, $postData['email_code']);
        // return $user_id;
        if($check){
            return Helper::loginHandler($check);
        } else {
            return $this->errorResponse('Oops! incorrect token', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    
    public function phoneVerification(Request $request){
        $postData = $request->json()->all();
        $user_id = Auth::user()->id;
        // return $postData;
        $check = UserVerification::verifySMS($user_id, $postData['phone_code']);
        if($check){
            return Helper::loginHandler($check);
        } else {
            return $this->errorResponse('Oops! incorrect token', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function resendToken(){
        $user_id = Auth::user()->id;
        $email_code = Settings::randomStrgs(6);
        $resend = UserVerification::createVerification($user_id, $email_code);
        // EmailClass::email_verification($user, $email_code);
        if($resend){
            return $this->successResponse('success');
        }
    }
    
    public function resendPhoneToken(){
        $user_id = Auth::user()->id;
        $sms_code = Settings::randomNumber(6);
        $resend = UserVerification::createSmsVerification($user_id, $sms_code);
        // EmailClass::email_verification($user, $sms_code);
        if($resend){
            return $this->successResponse('success');
        }
    }

    public function updateProfile(Request $request){
        $user_id = Auth::user()->id;
        $postData = $request->json()->all();

        $thisUser = User::findOrFail($user_id);
        $email = $postData['email'];
        $username = $postData['username'];

        $checkUsername = User::where('username', $username)->count();
        $checkEmail = User::where('email', $email)->count();

        if($username != $thisUser->username && $checkUsername){
            return $this->errorResponse('Oops! this username has been taken', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if($email != $thisUser->email && $checkEmail){
            return $this->errorResponse('Oops! this email has been taken', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $record = User::findOrFail($user_id);
        $record->fill($postData);
        if ($record->isClean()) {
            return Helper::loginHandler($record);
        }
        $record->save();
        return Helper::loginHandler($record);
    }


    public function changePassword(Request $request){
        $user_id = Auth::user()->id;
        $postData = $request->json()->all();
        $record = User::findOrFail($user_id);
        if(!$this->verifyPassword($postData['old_password'], $record->password)){
            return $this->errorResponse('Oops! Old password not matched', Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            User::updatePassword($postData['password'], $user_id);
        }
    }

    public function logout(){
        $user_id = Auth::user()->id;
        $record = User::logout($user_id);
        return $this->successResponse($record);
    }


}
