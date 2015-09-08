<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/
  Route::get('/', function() {
       return view('welcome');
    });
  
Route::controller('login', 'LoginController');
Route::get('logout', 'LoginController@getLogout');
 

Route::group(['middleware' => '\App\Http\Middleware\Authenticate','prefix' => 'admin'], function () {
    Route::get('/', function() {
        return redirect('admin/dashboard');
    });
    Route::get('dashboard', 'HomeController@home');
    Route::controller('announcements', 'AnnouncementController');
    Route::controller('categories', 'CategoryController');
    Route::controller('coupons', 'CouponController');
    Route::controller('groups', 'GroupController');
    Route::controller('medias', 'MediaController');
    Route::controller('mailinglists', 'MailinglistController');
    Route::controller('memberships', 'MembershipController');
    Route::controller('modules', 'ModuleController');
    Route::controller('portfolios', 'PortfolioController');
    Route::controller('products', 'ProductController');
    Route::controller('promotions', 'PromotionController');
    Route::controller('purchases', 'PurchaseController');
    Route::controller('reports', 'ReportController');
    Route::controller('users', 'UserController');
    Route::controller('posts', 'PostController');
    Route::controller('pages', 'PageController');
    Route::controller('orders', 'OrderController');
    Route::controller('bundles', 'BundleController');
});

