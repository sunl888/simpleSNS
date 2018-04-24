<?php

/*
 * add .styleci.yml
 */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $imgUrl = $faker->imageUrl(640, 480);
    $img = app(\App\Services\ImageService::class)->store($imgUrl);

    return [
        /*'title'          => str_random(10),
        'slug'           => str_random(10),
        'excerpt'        => str_random(128),*/
        'user_id'        => random_int(1, 5),
        'views'          => 0,
        'cover'          => $img->hash,
        'up_votes_count' => 0,
        'comments_count' => 0,
        'collection_id'  => random_int(1, 5),
        'status'         => array_random([Post::STATUS_PUBLISH, Post::STATUS_DRAFT], 1)[0],
        'published_at'   => \Carbon\Carbon::now(),
        'created_at'     => \Carbon\Carbon::now(),
        'updated_at'     => \Carbon\Carbon::now(),
    ];
});
