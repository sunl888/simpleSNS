<?php

Route::group(['namespace' => 'Api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        // 登录 params: tel_num password
        Route::post('login', 'AuthController@login');
        // 发送验证码 params: tel_num sms_template:user_register,user_reset_pwd
        Route::post('send_sms_code', 'SendSMSController@sendSMSVerificationCode');
        // 注册 params: tel_num sms_verification_code email password
        Route::post('register', 'RegisterController@register');
        // 忘记密码 params: tel_num sms_verification_code password
        Route::post('reset_password', 'RegisterController@resetPassword');
        // 要登录的接口
        Route::group(['middleware' => 'auth:api'], function () {
            // 退出 params: token
            Route::get('logout', 'AuthController@logout');
            // 刷新token params: token
            Route::get('refresh', 'AuthController@refresh');
            // 个人信息 params: token
            Route::get('me', 'AuthController@me');
        });
    });
    // 文章管理
    Route::apiResource('posts', 'PostController');
    // 收藏集管理
    Route::apiResource('collections', 'CollectionController');
    // 用户信息更新
    Route::match(['put', 'patch'], 'me', 'UserController@update');
    // 头像上传
    Route::post('ajax_upload_image', 'ImageController@upload');
    // 文章赞和踩
    Route::vote('post', 'PostController');
    // 对评论赞
    Route::vote('comment', 'CommentController', ['except' => 'down_vote']);
    // 获取文章的评论
    Route::get('posts/{post}/comments', 'PostController@showComments');
    // 对文章进行评论
    Route::post('posts/{post}/comment', 'PostController@storeComment')->middleware(['auth:api']);

});