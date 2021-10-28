<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Withdrawal;
use App\Models\Wallets;
use App\Models\Admin;
use App\Classes\Helper;

class AdminLogin extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }


    
    public function index(Request $request){
        $postData = $request->json()->all();

        $result = Admin::checkAdmin($postData['admin']);
        if($result){
            if($result->status == 'Blocked' || $result->status == 'Suspended') {
                return $this->errorResponse('This account has been Blocked / Suspended. Please Contact support.', Response::HTTP_UNPROCESSABLE_ENTITY);
            } 
            else if ($this->verifyPassword($postData['password'], $result->password)) {
                return Helper::adminLoginHandler($result);
            }
            else {
                return $this->errorResponse('Oops! Password and Email does not match, please try it again.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return $this->errorResponse('Oops! No record found with your entry.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }  
    }


    public function logout($token){
        if(Admin::isAdminAuth($token)){
            $admin = Admin::isAdminAuth($token);
            Admin::where('id', $admin->id)->update([
                'admin_token' => 'ucdaujdk'
            ]);
        } else {
            return $this->adminAuthError();
        }
    }

}
