<?php

use App\Models\Category;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => str_random(10),
        'slug' => str_random(10),
        'excerpt' => str_random(128),
        'user_id' => 1,
        'views' => 0,
        'cover' => $faker->imageUrl(),
        'up_votes_count' => 0,
        'comments_count' => 0,
        'category_id' => function () {
            $categoryIDs = Category::all()->pluck('id');
            return $categoryIDs->random(1)->first();
        },
        'status' => array_random([Post::STATUS_PUBLISH, Post::STATUS_DRAFT], 1)[0],
        'published_at' => \Carbon\Carbon::now(),
    ];
});


