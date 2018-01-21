<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            // 分类名
            $table->string('cate_name')->unique()->comment('分类名');
            // 分类slug
            $table->string('cate_slug')->commnet('分类slug');
            // 分类描述
            $table->string('description', 512)->nullable()->comment('分类描述');

            $table->string('image')->nullable()->comment('分类图片');

            $table->integer('order')->default(0)->index()->comment('排序字段');

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
        Schema::dropIfExists('categories');
    }
}
