<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->comment('用户ID');
            $table->string('title')->comment('标题');
            // slug
            $table->string('slug')->unique();
            // 摘要
            $table->string('excerpt', 512)->nullable();
            // 文章封面
            $table->string('cover')->nullable()->comment('文章封面');
            $table->unsignedInteger('category_id')->index()->comment('分类 id');
            $table->char('status', 10)->default('publish')->comment('文章状态：publish 发布 draft 草稿');
            // 浏览量
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('up_votes_count')->default(0)->comment('赞数量');// 总数－赞的数量=踩的数量
            //$table->unsignedInteger('down_votes_count')->default(0)->comment('踩数量');
            $table->unsignedInteger('comments_count')->default(0)->comment('评论数量');
            $table->integer('order')->default(0)->index()->comment('排序字段');
            // 发布时间
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
