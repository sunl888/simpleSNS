<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PostContent::class, function (Faker $faker) {
    return [
        'content' => $faker->text(200),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});


