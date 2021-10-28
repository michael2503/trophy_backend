<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    public function index(){
        $user_id = Auth::user()->id;
        $content = array(
            'unreadSupport' => Support::userUnread($user_id)
        );
        return $this->successResponse($content);
    }


}
