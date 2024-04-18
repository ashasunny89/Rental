<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuiteController;
use App\Http\Controllers\RentalController;


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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Auth::routes(['register' => false]);
Route::post('/register', 'App\Http\Controllers\logincontroller@register')->name('register');


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::post('profile', ['as' => 'profile.create', 'uses' => 'App\Http\Controllers\ProfileController@add']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('userlist', [App\Http\Controllers\AdminController::class, 'userlist']);
	Route::get('AddUser', function () {return view('users.AddUser');});
	Route::get('edituser/{user_id}',[App\Http\Controllers\AdminController::class, 'edituser']);
	Route::post('userupdate',['as' => 'profile.userupdate', 'uses' => 'App\Http\Controllers\ProfileController@userupdate']);
	Route::post('userpassword',['as' => 'profile.userpassword', 'uses' => 'App\Http\Controllers\ProfileController@userpassword']);


			
	//********************** NOTIFICTION *********************//
	Route::get('/notification/send', ['as' => 'pages/notification/send', 'uses' => 'App\Http\Controllers\NotificationController@sendnotification']);  // add notification route
	Route::get('/notification/list', ['as' => 'pages/notification/list', 'uses' => 'App\Http\Controllers\NotificationController@listnotification']);  // list notification route
	Route::post('/notification/send', [App\Http\Controllers\NotificationController::class, 'notification'])->name('pages.notification.send');
	Route::get('/notification/list', [App\Http\Controllers\NotificationController::class, 'list'])->name('pages.notification.list');
	Route::get('/notification/edit/{id}', [App\Http\Controllers\NotificationController::class, 'EditNotification'])->name('pages.notification.edit');  // list notification route
	Route::POST('/messageupdate/{id}', [App\Http\Controllers\NotificationController::class, 'UpdateNotification']);
	Route::get('/delete/{id}', [App\Http\Controllers\NotificationController::class,'DeleteNotification']);  // list notification route
	//Push Notification
	Route::post('/notifications/send-push', [App\Http\Controllers\NotificationController::class, 'sendPushNotification'])->name('sendPush');
	Route::get('/pushnotification', ['as' => 'pages.pushnotification', 'uses' => 'App\Http\Controllers\NotificationController@pushnotification']);	



	//********************** EVENTS *******************//

	Route::get('/event/add', ['as' => 'pages/event/add', 'uses' => 'App\Http\Controllers\EventsController@addevents']);  // add notification route
	Route::get('/event/list', ['as' => 'pages/event/list', 'uses' => 'App\Http\Controllers\EventsController@eventlist']);  // list notification route
	Route::post('/event/add', [App\Http\Controllers\EventsController::class, 'events'])->name('pages.event.add');
	Route::get('/event/list', [App\Http\Controllers\EventsController::class, 'list'])->name('pages.event.list');
	Route::get('/event/edit/{id}', [App\Http\Controllers\EventsController::class, 'EditEvent'])->name('pages.event.edit');  // list notification route
	Route::POST('/eventupdate/{id}', [App\Http\Controllers\EventsController::class, 'UpdateEvent']);
	Route::get('eventdelete/{id}', [App\Http\Controllers\EventsController::class,'DeleteEvent']);  // list notification route


	//********************** REPORT *******************//
	Route::get('/reports/payment', [App\Http\Controllers\ReportController::class, 'paymentReport']);
	Route::POST('/reports/payment', [App\Http\Controllers\ReportController::class, 'district_wise'])->name('pages.reports.payment');

	Route::get('/reports/user', [App\Http\Controllers\ReportController::class, 'UserReport']);
	Route::get('/reports/user', [App\Http\Controllers\ReportController::class, 'user_wise'])->name('pages.reports.user');


	Route::get('/home', 'App\Http\Controllers\HomeController@total')->name('home');

	//********************** Meeting Link *******************//
	Route::get('/link', [App\Http\Controllers\Linkcontroller::class, 'LinkShow'])->name('link');
	Route::post('/link-add', [App\Http\Controllers\Linkcontroller::class, 'store'])->name('link-add');

	//********************** Banner *******************//
	Route::get('/banner', [App\Http\Controllers\BannerController::class, 'BannerShow'])->name('banner');
	Route::post('/banneradd', [App\Http\Controllers\BannerController::class, 'BannerStore'])->name('banneradd');
	Route::get('/banner-list', [App\Http\Controllers\BannerController::class, 'BannerList'])->name('banner-list');
	Route::get('/banner-edit/{id}', [App\Http\Controllers\BannerController::class, 'BannerEdit'])->name('banner-edit');  // list notification route
	Route::put('/banner-update/{id}', [App\Http\Controllers\BannerController::class, 'BannerUpdate']);
	Route::get('banner-delete/{id}', [App\Http\Controllers\BannerController::class,'BannerDelete']);  // list notification route

	//********************** DIRECTORY *******************//
	Route::get('/directory', [App\Http\Controllers\DirectoryController::class, 'ShowDirectory'])->name('directory');
	Route::post('/directoryadd', [App\Http\Controllers\DirectoryController::class, 'AddDirectory'])->name('directoryadd');
	Route::get('/directory-list', [App\Http\Controllers\DirectoryController::class, 'ListDirectory'])->name('directory-list');
	Route::get('/directory-edit/{id}', [App\Http\Controllers\DirectoryController::class, 'EditDirectory'])->name('directory-edit');  // list notification route
	Route::put('/directory-update/{id}', [App\Http\Controllers\DirectoryController::class, 'UpdateDirectory']);
	Route::get('directory-delete/{id}', [App\Http\Controllers\DirectoryController::class, 'DeleteDirectory']); 


	//********************** SPONSORED ADS *******************//
	Route::get('/sponsor', [App\Http\Controllers\SponsoredaddsController::class, 'ShowAds'])->name('sponsor');
	Route::post('/sponsor-add', [App\Http\Controllers\SponsoredaddsController::class, 'AddSponsor'])->name('sponsor-add');
	Route::get('/product-list', [App\Http\Controllers\ProductController::class, 'ListProduct'])->name('product-list');
	Route::get('/sponsor-edit/{id}', [App\Http\Controllers\SponsoredaddsController::class, 'EditSponsor'])->name('sponsor-edit'); 
	Route::put('/sponsor-update/{id}', [App\Http\Controllers\SponsoredaddsController::class, 'UpdateSponsore']);
	Route::get('sponsor-delete/{id}', [App\Http\Controllers\SponsoredaddsController::class, 'DeleteSponsor']); 

		//********************** COMMITEE *******************//
	Route::get('/commitee', [App\Http\Controllers\DirectoryController::class, 'ShowCommitee'])->name('commitee');
	Route::post('/committe-add', [App\Http\Controllers\DirectoryController::class, 'AddCommitte'])->name('committe-add');
	// Route::get('/directory', [App\Http\Controllers\DirectoryController::class, 'showForm'])->name('directory');

		//********************** Suites *******************//
		Route::resource('suit_pieces', SuiteController::class);

		Route::resource('rental', RentalController::class);

		Route::post('/check-availability', [App\Http\Controllers\RentalController::class,'checkAvailability'])->name('checkAvailability');

	










	//***************************** CAROUSEL **********************************//

	// Route::get('banner', [App\Http\Controllers\CarouselController::class, 'BannerAdd'])->name('una.carousel.banner');
	// Route::post('banner', [App\Http\Controllers\CarouselController::class, 'BannerQuery'])->name('una.carousel.banner');

	// Route::get('bannerlist', [App\Http\Controllers\CarouselController::class, 'BannerList'])->name('una.carousel.bannerlist');
	// Route::get('bannerlist', [App\Http\Controllers\CarouselController::class, 'ListBanner'])->name('una.carousel.bannerlist');

	// Route::get('/banneredit/edit/{id}', [App\Http\Controllers\CarouselController::class, 'EditBanner'])->name('una.carousel.banneredit');  // list notification route
	// Route::POST('/bannerupdate/{id}', [App\Http\Controllers\CarouselController::class, 'UpdateBanner']);
	// Route::GET('/delete/{id}', [App\Http\Controllers\CarouselController::class,'DeleteBanner']);  // list notification route


	// Route::post('addbanner', ['as' => 'una.carousel.banner', 'uses' => 'App\Http\Controllers\CarouselController@BannerQuery']);  // add notification route



});

//  Route::get('/qrcode/code', [App\Http\Controllers\QrCodeController::class, 'QrcodeShow'])->name('pages.qrcode.code');

//  Route::get('/ShowQR', [App\Http\Controllers\QrCodeController::class, 'Qrcodelist'])->name('pages.qrcode.code');

// // Route::get('/Qrcode/code', ['as' => 'pages/Qrcode/code', 'uses' => 'App\Http\Controllers\QrCodeController@QrcodeShow']);  // add notification route


// Route::get('gallery', [App\Http\Controllers\GalleryController::class, 'GalleryIndex'])->name('una.gallery');
