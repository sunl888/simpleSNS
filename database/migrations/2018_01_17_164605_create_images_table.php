<?php

/*
 * add .styleci.yml
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->char('hash', 32)->primary();
            $table->string('mime')->nullable()->comment('MIME 类型');
            $table->string('ext')->nullable()->comment('扩展名');
            $table->string('title')->comment('文件名');
            $table->unsignedMediumInteger('width')->nullable()->comment('宽度');
            $table->unsignedMediumInteger('height')->nullable()->comment('高度');
            $table->unsignedInteger('creator_id')->nullable()->comment('创建者');
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
        Schema::dropIfExists('images');
    }
}
