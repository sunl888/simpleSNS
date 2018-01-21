<?php

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

// 路由：base_url/auth/*
// http://sns.local/api/auth/login?tel_num=15705547511&password=admin
Route::group(['namespace' => 'Api',], function () {
    Route::group(['prefix' => 'auth'], function () {
        // 登录 params: tel_num password
        Route::post('login', 'AuthController@login');
        // 发送验证码 params: tel_num
        Route::post('send_sms_code', 'RegisterController@sendSMSVerificationCode');
        // 注册 params: tel_num sms_verification_code email password
        Route::post('register', 'RegisterController@register');

        Route::group(['middleware' => 'auth:api'], function () {
            // 退出 params: token
            Route::post('logout', 'AuthController@logout');
            // 刷新token params: token
            Route::post('refresh', 'AuthController@refresh');
            // 个人信息 params: token ?include=comments:limit(5|1):order(created_at|desc)
            Route::post('me', 'AuthController@me');
        });
    });
});