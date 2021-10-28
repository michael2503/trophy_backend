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

class ForgotPassword extends Controller
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


    public function verifyEmail(Request $request){
        $postData = $request->json()->all();
        
        $result = User::emailCheck($postData['email']);
        if($result){
            if($result->status == 'Blocked' || $result->status == 'Suspended') {
                return $this->errorResponse('This account has been Blocked / Suspended. Please Contact support.', Response::HTTP_UNPROCESSABLE_ENTITY);
            } 
            else {
                //SEND TOKEN
                $email_code = Settings::randomStrgs(6);
                UserVerification::createVerification($result->id, $email_code);
                // EmailClass::resetPassword($result, $email_code);
                return $this->successResponse($result->id);
            }
            
        } else {
            return $this->errorResponse('Oops! No record found with your entry.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }  
    }


    public function verifyToken(Request $request){
        $postData = $request->json()->all();
        
        $record = UserVerification::verifyEmail($postData['id'], $postData['email_code']);

        if ($record) {
            return $this->successResponse($record->id);
        } else {
            return $this->errorResponse('Oops! code not matched', Response::HTTP_UNPROCESSABLE_ENTITY);
        } 
    }

    public function resetPassword(Request $request){
        $postData = $request->json()->all();

        if($postData['password'] && $postData['id']){
            $update = User::where('id', $postData['id'])->update([
                'password' => app('hash')->make($postData['password'])
            ]);
            if($update){
                return $this->successResponse(User::findOrFail($postData['id']));
            } else {
                return $this->errorResponse('Sorry, Error in updating your request', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } 
    }
}
