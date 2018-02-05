<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Collection::class, function (Faker $faker) {
    return [
        'title' => str_random(10),
        'collect_slug' => str_random(10),
        'user_id' => random_int(1,5),
        'introduction' => $faker->text(100),
        'color' => $faker->hexColor,
        'cover' => $faker->imageUrl(),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});