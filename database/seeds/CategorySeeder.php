<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert(
            [
                [
                    'id' => 1,
                    'cate_name' => '前端',
                    'description' => '我是描述',
                    'image' => app(Faker\Generator::class)->imageUrl(),
                    'cate_slug' => str_random(10),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ], [
                'id' => 2,
                'cate_name' => '后端',
                'description' => '我是描述',
                'image' => app(Faker\Generator::class)->imageUrl(),
                'cate_slug' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 3,
                'cate_name' => 'Laravel',
                'description' => '我是描述',
                'image' => app(Faker\Generator::class)->imageUrl(),
                'cate_slug' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 4,
                'cate_name' => 'Vue',
                'description' => '我是描述',
                'image' => app(Faker\Generator::class)->imageUrl(),
                'cate_slug' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 5,
                'cate_name' => 'PHP',
                'description' => '我是描述',
                'image' => app(Faker\Generator::class)->imageUrl(),
                'cate_slug' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            ]
        );
    }
}
