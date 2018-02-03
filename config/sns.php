<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 12:42
 */

return [
    // mock 用户时的默认密码
    'default_user_password' => 'admin',

    'max_per_page' => 40,
    'default_per_page' => 3,

    // 默认 slug 模式
    'default_slug_mode' => 'pinyin',

    // 阅读量统计间隔，每个用户在此时间内重复刷新文章页面只增长 1 个阅读量，单位分钟
    'reading_interval' => 1,

    // 通知选项
    'notification' => [
        //通知将通过什么发送到用户
        'drivers' => [
            'broadcast',
            'database'
        ],
    ],

    // 允许使用什么字段登陆
    'allow_login_fields' => [
        'tel_num',
        'email'
    ],
];
