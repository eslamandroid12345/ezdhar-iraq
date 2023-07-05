<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//================================== auth ============================

Route::group(['middleware' => 'lang'],function (){

Route::group(['namespace' => 'Auth','prefix' => 'auth'],function (){

    Route::post('login','AuthController@login');
    Route::post('logout','AuthController@logout');
    Route::POST('register','AuthController@register');
    Route::get('getProfile','AuthController@getProfile')->middleware('jwt');
    Route::POST('updateProfile','AuthController@updateProfile');
    Route::POST('insertToken','AuthController@insertToken');
    Route::get('service-request','AuthController@userServiceRequest')->middleware('jwt');
});

/////////===========///////////// Home ========//////////===========//////////
Route::group(['namespace'=>'Home','prefix'=>'home'],function(){
    Route::get('index','HomeController@index');
    Route::get('myNotifications','HomeController@myNotifications');
    Route::get('typesOfAdvisors','HomeController@typesOfAdvisors');
    Route::get('advisorsByType','HomeController@advisorsByType');
    Route::get('advisorsOfSubCategories','HomeController@advisorsOfSubCategories');
    Route::get('providersOfSubCategories/{id}','HomeController@providersOfSubCategories');
    Route::get('oneProvider','HomeController@oneProvider');
    Route::get('categories','HomeController@categories');
    Route::get('subCategories','HomeController@subCategories');
    Route::get('oneAdvisor','HomeController@oneAdvisor');
    Route::get('cities','HomeController@cities');
    Route::get('slider','HomeController@slider');
    Route::post('contact_us','HomeController@contact_us');
    Route::get('investmentProjects','HomeController@investmentProjects');
    Route::get('setting','HomeController@setting');
});



/////////===========///////////// Providers ========//////////===========//////////
Route::group(['namespace'=>'Provider','prefix'=>'provider','middleware'=>'jwt'],function(){
    Route::get('statistics','ProviderController@statistics');
    Route::get('myOrders','ProviderController@myOrders');
    Route::POST('controlMyCategories','ProviderController@controlMyCategories');
});




/////////===========///////////// Order ========//////////===========//////////
Route::group(['namespace'=>'Order','prefix'=>'order'],function(){
    Route::POST('makeOrderFromProvider','OrderController@makeOrderFromProvider');
    Route::get('checkPaymentOfProvider','OrderController@checkPaymentOfProvider')->name('checkPaymentOfProvider');
    Route::get('goThroughUrl/{status}/{room_id}','OrderController@goThroughUrl')->name('goThroughUrl');
});


/////////===========///////////// Profile ========//////////===========//////////
Route::group(['namespace'=>'Profile','prefix'=>'profile','middleware'=>'jwt'],function(){

    Route::post('love-report-follow-post','ProfileController@loveReportFollowPost');
    Route::post('requestConsultation','ProfileController@requestConsultation');
    Route::get('likedPost','ProfileController@likedPost');
    Route::get('savedPost','ProfileController@savedPost');
    Route::get('myPosts','ProfileController@myPosts');


    //check payment
    Route::get('addToMyWallet','ProfileController@addToMyWallet');

});



    Route::group(['namespace'=>'Profile','prefix'=>'profile'],function(){

    Route::delete('delete/{id}','ProfileController@deleteProfile');//deleteProfileOfUser

    });
    Route::GET('checkPaymentOfWallet/{user_id}','Profile\ProfileController@checkPaymentOfWallet')->name('checkPaymentOfWallet');

/////////===========///////////// POST ========//////////===========//////////
Route::group(['namespace'=>'Post','prefix'=>'post','middleware'=>'jwt'],function(){

    Route::post('storePost','PostController@storePost');
    Route::post('editPost','PostController@editPost');
    Route::post('deletePost','PostController@deletePost');
});
/////////===========///////////// Project ========//////////===========//////////
Route::group(['namespace'=>'Project','prefix'=>'project','middleware'=>'jwt'],function(){
    Route::post('storeProject','ProjectController@storeProject');
    Route::post('editProject','ProjectController@editProject');
    Route::post('deleteProject','ProjectController@deleteProject');
    Route::get('all','ProjectController@projects');
});

/////////===========///////////// chat ========//////////===========//////////
Route::group(['namespace'=>'Profile','prefix'=>'chat','middleware'=>'jwt'],function(){
    Route::get('myRooms','ChatController@myRooms');
    Route::get('oneRoom','ChatController@oneRoom');
    Route::POST('storeChatData','ChatController@storeChatData');
});



Route::group(['namespace'=>'Contact','prefix'=>'contacts'],function(){

    Route::get('all','ContactUsController@all');
    Route::post('store','ContactUsController@store');

});

Route::group(['namespace'=>'Feasibilities','prefix'=>'Feasibilities'],function(){


    Route::post('feasibilityType/store','FeasibilityController@storeFeasibilityType');
    Route::get('feasibilityType/all','FeasibilityController@allFeasibilityType');
    Route::post('feasibility/store','FeasibilityController@storeFeasibility')->middleware('jwt');
    Route::get('feasibility/all/{id}','FeasibilityController@allFeasibility')->middleware('jwt');


});

    Route::group(['namespace'=>'Order','prefix'=>'orders', 'middleware' => 'jwt'],function(){

        Route::get('home','OrderController@home');
        Route::get('new','OrderController@new');
        Route::get('accepted','OrderController@accepted');
        Route::get('refused','OrderController@refused');
        Route::get('completed','OrderController@completed');
        Route::post('change/status','OrderController@changeStatus');

    });


    //start freelancer services
    Route::group(['namespace'=>'FreelancerSubCategories','prefix'=>'services', 'middleware' => 'jwt'],function(){


        Route::post('store','ServiceController@store');
        Route::post('update','ServiceController@update');
        Route::delete('delete/{id}','ServiceController@delete');


    });


    //start service request
    Route::group(['namespace'=>'ServiceRequest','prefix'=>'service-request'],function(){


        Route::post('store','ServiceRequestController@store')->middleware('jwt');
        Route::get('index','ServiceRequestController@index');
        Route::put('changeStatus/{id}','ServiceRequestController@changeStatus')->middleware('jwt');
        Route::get('details/{id}','ServiceRequestController@details');


    });

     Route::group(['namespace'=>'ServiceRequest','prefix'=>'service-request','middleware' => 'jwt'],function(){

         Route::get('user-accepted','ServiceRequestController@userServiceAccepted');
         Route::get('user-completed','ServiceRequestController@userServiceCompleted');
         Route::get('provider-accepted','ServiceRequestController@providerServiceAccepted');
         Route::get('provider-completed','ServiceRequestController@providerServiceCompleted');

    });

    //rates from user to provider
    Route::group(['namespace'=>'Rates','prefix'=>'rates'],function(){

        Route::get('index','RateProviderController@index');
        Route::post('store','RateProviderController@store')->middleware('jwt');
        Route::delete('delete/{id}','RateProviderController@delete');


    });


    //reports from user
    Route::group(['namespace'=>'Report','prefix'=>'reports'],function(){

        Route::get('index','ReportFromUserController@index');
        Route::post('store','ReportFromUserController@store')->middleware('jwt');
        Route::delete('delete/{id}','ReportFromUserController@delete');


    });

    //orderReport
    Route::group(['namespace'=>'OrderReport','prefix'=>'order-report'],function(){

        Route::post('storeReportByUser','OrderReportController@storeReportByUser')->middleware('jwt');
        Route::post('storeReportByProvider','OrderReportController@storeReportByProvider')->middleware('jwt');


    });

    Route::group(['namespace'=>'PostProvider','prefix'=>'PostProvider'],function(){

        Route::post('store','PostProviderController@store')->middleware('jwt');
        Route::put('update/{id}','PostProviderController@update')->middleware('jwt');
        Route::get('all','PostProviderController@all');
        Route::post('action','PostProviderController@actions')->middleware('jwt');
        Route::get('postsLoveByUser','PostProviderController@postsLoveByUser')->middleware('jwt');

    });

    Route::group(['namespace'=>'PostProvider'],function(){

        Route::get('allPostsFromProvider','PostProviderController@allPostsFromProvider')->middleware('jwt');

    });
Route::fallback(function(){
    return helperJson(null,'url not found',404,404);
});

});

Route::get('callback_paytabs',[\App\Http\Controllers\Api\Profile\ProfileController::class,'callback_paytabs']);
Route::post('return_paytabs',[\App\Http\Controllers\Api\Profile\ProfileController::class,'return_paytabs']);
