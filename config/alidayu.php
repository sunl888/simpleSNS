<?php

return [
    // key
    'accessKeyId' => env('ALI_ACCESS_KEY_ID', 'xxx'),
    'accessKeySecret' => env('ALI_ACCESS_KEY_SECRET', 'xxx'),

    // 发送验证码时间间隔
    'interval' => 60,

    // 验证码有效期
    'term_of_validity' => 60 * 10,

    // sms template
    'template' => [
        'user_register' => [
            'template_code' => 'SMS_122297275',
            'sign_name' => '用户注册',
            'out_id' => 'register'
        ],
    ],

];
