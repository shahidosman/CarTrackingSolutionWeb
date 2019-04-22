<?php

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
    return view('auth.login-app');
});


Auth::routes();

Route::group(['namespace'=>'Admin','prefix'=>'admin','as','admin.', 'middleware' => ['admin','auth']],function (){
    Route::get('/dashboard','AdminDashboardController@index')->name('dashboard');
    Route::get('/driver-live-location','ManageDriverController@tracker');
    Route::get('/ride-request','ManagePassengerController@ride_requests');
    Route::post('/ride-request','ManagePassengerController@store_ride_request');
    Route::get('/assign-driver','ManageRideController@assign_driver');
    Route::get('/driver-for-ride/{id}','ManageRideController@driver_for_ride');
    Route::get('/send-driver/{driver_id}/{request_id}','ManageRideController@send_driver');
    Route::get('/current-ride','ManageRideController@current_rides');
    Route::get('/complete-ride','ManageRideController@complete_rides');
    Route::resource('passengers','ManagePassengerController');
    Route::resource('drivers','ManageDriverController');
    Route::resource('driver-cars','ManageDriverCarController');
});

Route::get('error','ErrorHandlerController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test-dashboard',function (){
   return view('admin.test-dashboard');
});