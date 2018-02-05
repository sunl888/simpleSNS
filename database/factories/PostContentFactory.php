<?php

/*
 * add .styleci.yml
 */

use Faker\Generator as Faker;

$factory->define(\App\Models\PostContent::class, function (Faker $faker) {
    return [
        //'post_id' => random_int(1,5),
        'content'    => $faker->text(200),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});
