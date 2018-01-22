<?php

return [
    'source_disk' => env('IMAGE_DISK', 'local'),
    'cache_disk' => env('IMAGE_DISK', 'local'),
    'source_path_prefix' => 'uploads/images',
    'cache_path_prefix' => 'uploads/images/.cache',
    'base_url' => 'img',
    'default_style' => [
        'q' => 90,
        'fit' => 'crop'
    ],
    // xs < sm < md < lg
    'presets' => [
        'avatar_xs' => [
            'w' => 30,
            'h' => 30,
            'fit' => 'crop',
        ],
        'avatar_sm' => [
            'w' => 100,
            'h' => 100,
            'fit' => 'crop',
        ],
        'avatar_md' => [
            'w' => 160,
            'h' => 160,
            'fit' => 'crop',
        ],
        'case_cover' => [
            'w' => 255,
            'h' => 180,
            'fit' => 'crop',
        ],
        'list_news_cover' => [
            'w' => 350,
            'h' => 230,
            'fit' => 'crop',
        ],
    ],
    'upload_key' => 'image',
    'route_name' => 'image'
];
