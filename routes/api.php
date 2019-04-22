<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'driver'
],function ($router){
   Route::post('login','Api\LoginController@login');
   Route::post('token','Api\DriverController@save_token');
   Route::post('live-location','Api\DriverController@live_location');
   Route::post('update-pick-up-loc','Api\DriverRideController@update_pick_up_loc');
   Route::post('ride-live-location','Api\DriverRideController@ride_live_location');
   Route::post('complete-ride','Api\DriverRideController@complete_ride');
   Route::post('ride-video','Api\DriverRideController@ride_video');
});
