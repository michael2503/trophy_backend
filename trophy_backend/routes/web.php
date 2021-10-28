<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return $router->app->version();
});

// USER URL
$router->group(['middleware' => 'auth'], function() use($router){
    $router->post('/user/account-settings/profile', 'User\AccountSettings@updateProfile');
    $router->post('/user/account-settings/change-password', 'User\AccountSettings@changePassword');
    
    
    $router->get('/user/dashboard', 'User\Dashboard@index');
    

    $router->put('/user/account-settings/logout', 'User\AccountSettings@logout');
    
    $router->post('/user/account-settings/email-verify', 'User\AccountSettings@emailVerification');
    $router->get('/user/account-settings/resend-token', 'User\AccountSettings@resendToken');
    
    $router->post('/user/account-settings/phone-verify', 'User\AccountSettings@phoneVerification');
    $router->get('/user/account-settings/resend-phone-token', 'User\AccountSettings@resendPhoneToken');



    // USER TESTIMONIAL
    $router->group(['user' => 'investment'], function() use($router){
        $router->get('/user/testimony', 'User\TestimonyManager@getTestimony');
        $router->post('/user/testimony/create', 'User\TestimonyManager@createTestimony');
    });

     // USER SUPPORT
     $router->group(['user' => 'support'], function() use($router){
        $router->get('/user/support/{status}/{limit}/{page}', 'User\UserSupport@index');
        $router->get('/user/support/single/{id}', 'User\UserSupport@single');
        $router->post('/user/support/compose', 'User\UserSupport@composeOrReply');
    });

});

// GUSET CONTENT URL
$router->group(['guest' => 'root'], function() use($router){
    $router->post('/login', 'Guest\LoginController@loginHere');
    $router->post('/register', 'Guest\RegisterController@createRecord');
    $router->post('/forgot-password', 'Guest\ForgotPassword@verifyEmail');
    $router->post('/forgot-password/submit-token', 'Guest\ForgotPassword@verifyToken');
    $router->post('/forgot-password/reset-password', 'Guest\ForgotPassword@resetPassword');
    $router->post('/fileupload/{folder}/{name}', 'Guest\FileManager@uploadProcess');

    $router->group(['contents' => 'root'], function($router){
        $router->get('/contents', 'Guest\ContentManager@homeContent');
        $router->get('/contents/faq', 'Guest\ContentManager@faq');
        $router->get('/general_settings', 'Guest\GeneralSettings@index');
        $router->get('/contents/pages/{url}', 'Guest\ContentManager@pages');
        $router->get('/testimony', 'Guest\TestimonyGuest@getTestimony');
        $router->post('/contact', 'Guest\Contact@index');
    });
});



$router->group(['admin' => 'root'], function() use($router){
    $router->post('/admin/login', 'Administrator\AdminLogin@index');
    $router->get('/admin/logout/{token}', 'Administrator\AdminLogin@logout');
    
    $router->get('/admin/dashboard/{token}', 'Administrator\DashboardInfo@index');
    

    //USER MANAGER
    $router->get('/admin/user/{token}/{role}/{limit}/{page}', 'Administrator\UserManager@users');
    $router->get('/admin/user/single/{token}/{userID}', 'Administrator\UserManager@userDetails');
    $router->post('/admin/user/update/{token}', 'Administrator\UserManager@updateUser');
    $router->delete('/admin/user/delete/{token}/{user_id}', 'Administrator\UserManager@deleteUser');
    $router->get('/admin/user/account-action/{token}/{userID}/{action}', 'Administrator\UserManager@userAction');
    

    // ADMIN MANAGER
    $router->group(['admin-manager' => 'administrator'], function($router){
        $router->get('/admin/admin-manager/all/{token}/{limit}/{page}', 'Administrator\AdminManager@admins');
        $router->post('/admin/admin-manager/add/{token}', 'Administrator\AdminManager@addAdmin');
        $router->get('/admin/admin-manager/single/{token}/{id}', 'Administrator\AdminManager@adminSingle');
        $router->put('/admin/admin-manager/update/{token}/{role}', 'Administrator\AdminManager@updateAdmin');
        $router->delete('/admin/admin-manager/delete/{token}/{id}', 'Administrator\AdminManager@deleteAdmin');
        $router->post('/admin/admin-manager/change-password/{token}', 'Administrator\AdminManager@changePassword');
    });

    
    // GENERAL SETTINGS
    $router->group(['general-settings' => 'administrator'], function($router){
        $router->put('/admin/update-web-settings/{token}', 'Administrator\GeneralSettings@updateWebsiteSettings');
        $router->post('/admin/add-social-link/{token}', 'Administrator\GeneralSettings@addSocialLink');
        $router->delete('/admin/delete-social-link/{token}/{id}', 'Administrator\GeneralSettings@deleteSocialLink');
    });

    // Content Management
    $router->group(['content-management' => 'administrator'], function($router){
        $router->put('/admin/update-about-us/{token}', 'Administrator\ContentManager@updateAboutUs');
        
        $router->get('/admin/who-we-call-to/{token}', 'Administrator\ContentManager@getWhoWeAre');
        $router->put('/admin/update-who-we-are/{token}', 'Administrator\ContentManager@updateWhoWeAre');
        $router->put('/admin/update-call-to-action/{token}', 'Administrator\ContentManager@updateCallToAction');
        
        $router->get('/admin/home-banner/{token}', 'Administrator\ContentManager@getHomeBanner');
        $router->put('/admin/home-banner/update/{token}', 'Administrator\ContentManager@updateHomeBanner');
    });
    
    // Pages
    $router->group(['pages' => 'administrator'], function($router){
        $router->get('/admin/page/{token}', 'Administrator\PagesManager@pages');
        $router->post('/admin/page/add/{token}', 'Administrator\PagesManager@addPage');
        $router->get('/admin/page/{token}/{id}', 'Administrator\PagesManager@pageSingle');
        $router->put('/admin/page/update/{token}', 'Administrator\PagesManager@updatePage');
        $router->delete('/admin/page/delete/{token}/{id}', 'Administrator\PagesManager@deletePage');
    });
    

    // TESTIMONY MANAGER
    $router->group(['testimony' => 'administrator'], function($router){
        $router->get('/admin/testimonial/{token}/{limit}/{page}', 'Administrator\TestimonyManager@index');
        $router->post('/admin/testimonial/{token}/add', 'Administrator\TestimonyManager@addNews');
        $router->get('/admin/testimonial/single/edit/{token}/{id}', 'Administrator\TestimonyManager@singleTestimony');
        $router->put('/admin/testimonial/update/{token}', 'Administrator\TestimonyManager@updateTestimony');
        $router->delete('/admin/testimonial/delete/{id}', 'Administrator\TestimonyManager@deleteTestimony');
    });
    


    // EMAIL TEMPLATE
    $router->group(['testimony' => 'administrator'], function($router){
        $router->get('/admin/email-template/{token}', 'Administrator\ContentManager@emailTemplate');
        $router->get('/admin/email-template/single/edit/{token}/{id}', 'Administrator\ContentManager@singleEmailTemplate');
        $router->put('/admin/email-template/update/{token}', 'Administrator\ContentManager@updateEmailTemplate');
    });

    // ADMIN SUPPORT
    $router->group(['administrator' => 'support'], function() use($router){
        $router->get('/admin/support/{token}/{status}/{limit}/{page}', 'Administrator\SupportManager@index');
        $router->get('/admin/support/single/{token}/{id}', 'Administrator\SupportManager@single');
        $router->post('/admin/support/compose/{token}', 'Administrator\SupportManager@composeOrReply');
        $router->delete('/admin/support/delete/{token}/{id}', 'Administrator\SupportManager@deleteSupport');
    });
});