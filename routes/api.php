<?php

// http://sns.local/api/auth/login?username=15705547511&password=admin
Route::group(['namespace' => 'Api',], function () {

    Route::group(['prefix' => 'auth'], function () {
        // 登录 params: tel_num password
        Route::post('login', 'AuthController@login');

        // 发送验证码 params: tel_num sms_template:user_register,user_reset_pwd
        //    阿里云短信服务接口触发天级流控Permits:10，这是个阿里云返回来的错误信息。
        //    错误原因是因为短信发送有默认的频率限制：
        //    限制如下：
        //    短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天。
        //    短信通知： 使用同一个签名和同一个短信模板ID，对同一个手机号码发送短信通知，支持50条/日
        Route::post('send_sms_code', 'SendSMSController@sendSMSVerificationCode');
        // 注册 params: tel_num sms_verification_code email password
        Route::post('register', 'RegisterController@register');
        // 忘记密码 params: tel_num sms_verification_code password
        Route::post('reset_password', 'RegisterController@resetPassword');

        Route::group(['middleware' => 'auth:api'], function () {
            // 退出 params: token
            Route::get('logout', 'AuthController@logout');
            // 刷新token params: token
            Route::get('refresh', 'AuthController@refresh');
            // 个人信息 params: token ?include=posts:limit(5|1):order(created_at|desc),follows,likes
            Route::get('me', 'AuthController@me');
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
        Route::apiResource('posts', 'PostController')->except('index');
        //
        //Route::apiResource('tags', 'TagsController');

        /**
         * 用户管理
         *
         * 路由列表: method name/params 描述
         * get users 获取列表 include= user, post_content, category, tags, likes
         * get users/{userID}  获取单个用户
         * post users 创建用户 【暂时禁用】
         * put users/{usersID} 更新用户
         * delete users/{usersID} 删除用户 【暂时禁用】
         */
        Route::apiResource('users', 'UserController');

        Route::post('ajax_upload_image', 'ImageController@upload');

        // 文章赞和踩
        Route::vote('post', 'PostController');
        // 对评论赞
        Route::vote('comment', 'CommentController', ['except' => 'down_vote']);

        // 获取文章的评论
        Route::get('posts/{post}/comments', 'PostController@showComments');
        // 对文章进行评论
        Route::post('posts/{post}/comment', 'PostController@storeComment');
    });

});