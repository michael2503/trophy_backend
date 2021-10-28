<?php

namespace App\Http\Controllers\Guest;

use App\Classes\Settings;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\CustomDateTime;
use App\Classes\Helper;
use Illuminate\Http\Response;

class LoginController extends Controller
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


    public function loginHere(Request $request){
        $postData = $request->json()->all();

        $result = User::checkUser($postData['user']);

        if($result){
            if($result->status == 'Blocked' || $result->status == 'Suspended') {
                return $this->errorResponse('This account has been Blocked / Suspended. Please Contact support.', Response::HTTP_UNPROCESSABLE_ENTITY);
            } 
            else if ($this->verifyPassword($postData['password'], $result->password)) {
                User::where('id', $result->id)->update([
                 'last_login' =>  CustomDateTime::currentTime()
                ]);
                return Helper::loginHandler($result);
            }
            else {
                return $this->errorResponse('Oops! Password and Email does not match, please try it again.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return $this->errorResponse('Oops! No record found with your entry.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }  
    }


    public function home(){
        // return view('welcome', [
        //     'users' => User::get()
        // ]);
    }


}
