<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/
  Route::get('/', function() {
      return redirect('admin/dashboard');
    });



Route::group(['prefix'=>'auth'],function(){

    Route::get('/', function() {
         return redirect('auth/login');
    });

   Route::get('login', 'Mall\AuthController@getLogin');
   Route::get('logout', 'Mall\AuthController@getLogout');
   Route::get('register', 'Mall\AuthController@getRegister');
   Route::post('register', 'Mall\AuthController@postRegister');
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

    Route::get('orders/detail/{id}', 'OrderController@getDetail');
});
