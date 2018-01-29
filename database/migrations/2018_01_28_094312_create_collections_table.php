<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * 收藏集.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('收藏集创建者');
            $table->string('title')->comment('收藏集标题');
            $table->string('collect_slug')->commnet('收藏集slug');
            $table->string('introduction')->comment('收藏集简介');
            $table->string('color')->default('#2962ff')->comment('封面颜色');
            $table->string('cover')->nullable()->comment('封面图片');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
