<?php

/*
 * add .styleci.yml
 */

use Faker\Generator as Faker;

$factory->define(\App\Models\Collection::class, function (Faker $faker) {
    $imgUrl = $faker->imageUrl(640, 480);
    $img = app(\App\Services\ImageService::class)->store($imgUrl);
    return [
        'title' => str_random(10),
        'collect_slug' => str_random(10),
        'user_id' => random_int(1, 5),
        'introduction' => $faker->text(100),
        'color' => $faker->hexColor,
        'cover' => $img->hash,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});
