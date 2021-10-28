<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AdminAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['adminAuth']->viaRequest('api', function ($request) {
            if ($request->header('api_token') || $request->header('admin_token')) {
                $api_token = $request->header('api_token');
                $admin_token = $request->header('admin_token');
            } else {
                $api_token = $request->input('api_token');
                $admin_token = $request->input('admin_token');
            }

            if($api_token){
                return User::where('api_token', $api_token)->first();
            } else if($admin_token){
                return Admin::where('admin_token', $admin_token)->first();
            }
            return null;
        });
    }
}
