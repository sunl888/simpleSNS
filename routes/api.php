<?php

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
            // 个人信息 params: token ?include=posts:limit(5|1):order(created_at|desc),follows,likes
            Route::post('me', 'AuthController@me');
        });
    });
    Route::group(['middleware' => 'auth:api'], function () {
        /**
         * 文章管理
         *
         * 路由列表: method name/params 描述
         * get posts 获取列表 include= user, post_content, category, tags, likes
         * get posts/{postID}  获取单个文章
         * post posts 创建文章
         * put posts/{postID} 更新文章
         * delete posts/{postID} 删除文章
         */
        Route::apiResource('posts', 'PostController');
        // 点赞
        Route::post('posts/{post}/add_like', 'PostController@addLikes');
        // 取消点赞
        Route::post('posts/{post}/sub_like', 'PostController@subLikes');
        //



        Route::apiResource('tags', 'TagsController');
    });
});