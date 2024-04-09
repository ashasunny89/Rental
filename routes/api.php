<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\rcbookcontroller;
use App\Http\Controllers\finecontroller;
use App\Http\Controllers\licensecontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\VerifyDeviceToken;





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


Route::get('/showqr', function () {
    return view('new');
});

Route::post('login', [logincontroller::class, 'Adminlogin']);

Route::post('Adminedit', [logincontroller::class, 'Adminedit']);

Route::post('userlogin', [logincontroller::class, 'userlogin']);



Route::post('register', [logincontroller::class, 'register']);
    Route::post('expiry_null', [finecontroller::class, 'expiry_null']);




    Route::middleware('auth:sanctum',VerifyDeviceToken::class)->group(function () {
    Route::post('pay', [finecontroller::class, 'payfine']);
    Route::get('district', [finecontroller::class, 'district']);
    Route::post('donation', [finecontroller::class, 'donation']);
    Route::get('history', [finecontroller::class, 'history']);
    Route::get('notification', [NotificationController::class, 'get_notification']);
    Route::post('userprofile', [logincontroller::class, 'citizenprofile']);
    Route::get('userprofile', [logincontroller::class, 'getprofile']);
    Route::get('total', [finecontroller::class, 'total']);
    Route::get('district_wise', [finecontroller::class, 'district_wise']);
    Route::get('max_donation_user_wise', [finecontroller::class, 'max_donation_user_wise']);
    Route::post('max_donation_district_wise', [finecontroller::class, 'max_donation_district_wise']);
    Route::get('weblink', [App\Http\Controllers\Linkcontroller::class, 'weblink']);

    Route::get('event', [EventsController::class, 'datelist']);

    Route::get('directory', [finecontroller::class,'getDirectory']);
    Route::get('home', [EventsController::class,'home']);
    Route::post('id', [finecontroller::class, 'id']);

});


