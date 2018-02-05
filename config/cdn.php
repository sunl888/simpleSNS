<?php

/*
 * add .styleci.yml
 */

return [

    'use_cdn' => env('USE_CDN', false),

    /*
    |--------------------------------------------------------------------------
    | Files to Include
    |--------------------------------------------------------------------------
    |
    | Specify which directories to be uploaded when running the
    | [$ php artisan cdn:push] command
    |
    | Enter the full paths of directories (starting from the application root).
    |
    */
    'include' => [
        'directories' => [public_path()],
        'extensions'  => [],
        'patterns'    => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Files to Exclude
    |--------------------------------------------------------------------------
    |
    | Specify what to exclude from the 'include' directories when uploading
    | to the CDN.
    |
    | 'hidden' is a boolean to excludes "hidden" directories and files (starting with a dot)
    |
    */
    'exclude' => [
        'directories' => ['vendor'],
        'files'       => ['favicon.ico'],
        'extensions'  => ['php', 'txt', 'config', 'json'],
        'patterns'    => [],
        'hidden'      => true,
    ],

];
