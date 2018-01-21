<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('image')->nullable()->comment('分类图片');
            // 分类名
            $table->string('cate_name')->unique()->comment('分类名');
            // 分类描述
            $table->string('description', 512)->nullable()->comment('分类描述');
            // 是否在导航栏显示
            $table->integer('order')->default(0)->index()->comment('排序字段');

            $table->unsignedInteger('creator_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
