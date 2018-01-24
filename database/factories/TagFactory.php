<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Tag::class, function (Faker $faker) {
    return [
        'name' => str_random(10),
        'slug' => str_random(10),
        'image' => $faker->imageUrl()
    ];
});


