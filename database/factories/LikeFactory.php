<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Like::class, function (Faker $faker) {
    return [
        'post_id' => function () {
            $postIDs = \App\Models\Post::all()->pluck('id');
            return $postIDs->random(1);
        }
    ];
});


