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
        factory(App\Models\User::class, 3)->create();
        \App\Models\User::where('id', 1)->first()->update(['nickname' => 'admin', 'tel_num' => '15705547511', 'email' => '2013855675@qq.com']);
    }
}
