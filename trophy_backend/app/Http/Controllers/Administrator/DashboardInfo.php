<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\WebsiteSettings;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Admin;
use App\Models\Support;

class DashboardInfo extends Controller
{
    
    use ApiResponder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    public function index($token){
        if(Admin::isAdminAuth($token)){
            $content = array(
                'allUser' => User::count(),
                'blockSuspUsers' => User::blockUser(),
                'activeUser' => User::activeUser(),
                'susUser' => User::susUser(),
                'recentSignUp' => User::all()->take(10),
                'recentUser' => User::topTenAdmin(),

                'clientInfo' => WebsiteSettings::clientInfo(),
                'vendorInfo' => Vendor::getRecord(),
                'unreadSupport' => Support::adminUnread(),
            );
            return $this->successResponse($content);
        } else {
            return $this->adminAuthError();
        }
    }

    
}
