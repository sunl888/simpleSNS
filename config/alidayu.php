<?php

return [
    // key
    'accessKeyId' => env('ALI_ACCESS_KEY_ID', 'xxx'),
    'accessKeySecret' => env('ALI_ACCESS_KEY_SECRET', 'xxx'),

    // 发送验证码时间间隔  单位:秒
    'interval' => 60,

    // 验证码有效期 单位:秒
    'term_of_validity' => 60 * 10,

    // sms template
    'template' => [
        // 用户注册模板
        'user_register' => [
            'sign_name' => '孙龙',
            'template_code' => 'SMS_122297275',
            'out_id' => 'register'
        ],
        // 重置密码模板
        'user_reset_pwd' => [
            'sign_name' => '孙龙',
            'template_code' => 'SMS_122299761',
            'out_id' => 'reset_password'
        ],
    ],

];
