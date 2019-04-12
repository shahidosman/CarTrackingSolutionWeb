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
    Route::resource('passengers','ManagePassengerController');
    Route::resource('drivers','ManageDriverController');
});

Route::get('error','ErrorHandlerController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test-dashboard',function (){
   return view('admin.test-dashboard');
});