<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::group(
//    [
//        'prefix' => LaravelLocalization::setLocale(),
//        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
//    ], function () {

Route::get('/', function () {
    return redirect('admin/login');
});

//Route::get('/paytap',[PaymentController::class,'paytap'])->name('paytap');
//Route::get('/paytap_home',[PaymentController::class,'paytap_home'])->name('paytap_home');
//Route::get('/return_paytap',[PaymentController::class,'return_paytap'])->name('return_paytap');

//Route::get('date', function (){
//
//    $start = \Carbon\Carbon::now();
//    $end = \Carbon\Carbon::now()->addDays(3);
//
//    $days = $end->diffInDays($start);
//
//    return $start . $end . "</br>" .$days;
//});
