<?php

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
        // 文章分类
        $this->call(CategorySeeder::class);

        factory(App\Models\User::class, 20)->create()->each(function ($u) {
            // 生成文章
            $post = $u->posts()->save(factory(App\Models\Post::class)->make());
            // 生成文章正文
            $post->postContent()->save(factory(\App\Models\PostContent::class)->make());
            // 生成文章点赞
            $u->likes()->create(['post_id' => $post->id]);
        });

        \App\Models\User::where('id', 1)->first()->update(['nickname' => 'admin', 'tel_num' => '15705547511', 'email' => '2013855675@qq.com']);

        // 用户互相关注
        $this->call(FollowSeeder::class);
    }
}
