<?php

/*
 * add .styleci.yml
 */

return [
    'source_disk'        => env('IMAGE_DISK', 'local'),
    'cache_disk'         => env('IMAGE_DISK', 'local'),
    'source_path_prefix' => 'uploads/images',
    'cache_path_prefix'  => 'uploads/images/.cache',
    'base_url'           => 'img',
    'default_style'      => [
        //  'q' => 90,
        // 'fit' => 'crop'
    ],
    // xs < sm < md < lg
    'presets' => [
        'avatar_xs' => [
            'w'   => 30,
            'h'   => 30,
            'fit' => 'crop',
        ],
        'avatar_sm' => [
            'w'   => 100,
            'h'   => 100,
            'fit' => 'crop',
        ],
        'avatar_md' => [
            'w'   => 160,
            'h'   => 160,
            'fit' => 'crop',
        ],
        'joke_cover' => [
            'w'   => 300,
            'fit' => 'crop',
            'fm'  => 'jpg',
        ],

    ],
    'upload_key' => 'image',
    'route_name' => 'image',

    'image_server' => [
        'scheme'     => env('IMAGE_SERVER_SCHEME', 'http'),
        'host'       => env('IMAGE_SERVER_HOST', '127.0.0.1:10000'),
        'url_prefix' => env('IMAGE_SERVER_URL_PREFIX', 'img'),
    ],
];
