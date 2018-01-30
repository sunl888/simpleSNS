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
Route::group(['namespace' => 'Web'], function () {
    Route::get('/', 'IndexController@index');
    // pusher 测试
    Route::get('pusher_test', function () {
        return view('pusher_test');
    });

});
// oauth2
Route::group(['prefix' => 'oauth', 'namespace' => 'Api'], function () {
    Route::get('{driver}', 'AuthController@redirectToProvider');
    Route::get('{driver}/callback', 'AuthController@handleProviderCallback');
});
