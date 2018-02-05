<?php

/*
 * add .styleci.yml
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
