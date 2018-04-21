<?php

/*
 * add .styleci.yml
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)->create();
        factory(App\Models\Collection::class, 10)->create();
        // 生成文章
        factory(App\Models\Post::class, 10)->create()->each(function ($post) {
            // 生成文章正文
            $post->postContent()->save(factory(\App\Models\PostContent::class)->make());
        });

        App\Models\User::where('id', 1)->first()->update([
            'nickname' => 'admin',
            'tel_num'  => '15705547511',
            'email'    => '2013855675@qq.com',
        ]);

        // 清除缓存
        Artisan::call('cache:clear');
    }
}
