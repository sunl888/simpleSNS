<?php

/*
 * add .styleci.yml
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('姓名');
            $table->string('username')->nullable()->comment('用户名');
            $table->char('tel_num', 11)->unique()->nullable()->comment('手机号码');
            $table->char('email')->nullable()->comment('email');
            $table->string('provider')->nullable()->comment('服务提供者');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('password')->nullable();
            $table->char('avatar_hash', 32)->nullable()->comment('头像');
            $table->string('introduction')->nullable()->comment('简介');
            $table->enum('is_banned', ['yes', 'no'])->default('no')->index();
            $table->string('city')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable()->comment('地址');
            $table->string('oauth_token')->nullable()->comment('oauth token');
            $table->timestampTz('last_actived_at')->nullable();
            $table->rememberToken();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
