<?php

/*
 * add .styleci.yml
 */

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
        // 退出 params: token
        Route::get('logout', 'AuthController@logout');
        // 刷新token params: token
        Route::get('refresh', 'AuthController@refresh');
        // 个人信息 params: token
        Route::get('me', 'AuthController@me');
    });
    // 文章管理 include=post_content
    Route::apiResource('posts', 'PostController');
    /**
     * include=subscribers 收藏集的订阅者
     */
    Route::apiResource('collections', 'CollectionController');
    /**
     * 用户信息更新
     *
     * email  邮箱
     * tel_num  手机号码
     * nickname 昵称
     * avatar_hash 头像 hash
     * introduction 简介
     * city 居住城市
     * location 定位
     * company 公司
     * name 名称
     */
    Route::match(['put', 'patch'], 'user', 'UserController@update');
    /**
     * 显示用户信息
     *
     * include=collections 用户创建的收藏集
     * include=subscribe_collections 用户订阅的收藏集
     */
    Route::get('user', 'UserController@show');
    /**
     * 头像上传
     *
     * file_key => image
     */
    Route::post('ajax_upload_image', 'ImageController@upload');
    // 对文章赞 and 踩
    Route::vote('post', 'PostController');
    // 对评论赞
    Route::vote('comment', 'CommentController', ['except' => 'down_vote']);
    // 获取文章评论
    Route::get('posts/{post}/comments', 'PostController@showComments');
    // 文章评论 content
    Route::post('posts/{post}/comment', 'PostController@storeComment');
    // 关注 / 取消关注 用户
    Route::post('users/{user}/follow', 'UserController@toggleFollow');
    // 订阅 / 取消订阅 收藏集
    Route::post('collections/{collection}/subscribe', 'CollectionController@toggleSubscribe');
    // 通知
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('unread_count', 'NotificationController@showUnreadNotificationsCount');
        Route::get('/', 'NotificationController@getNotifications');
        Route::patch('read/{id?}', 'NotificationController@markAsRead');
    });

    // 反馈 content
    Route::post('feedback', 'FeedbackController@store');
});
