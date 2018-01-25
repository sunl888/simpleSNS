<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('vote.votes_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->morphs(config('vote.morph_prefix'));
            $table->enum('type', ['up_vote', 'down_vote'])->comment('up_vote - 赞， down_vote - 踩');
            $table->timestampsTz();
            $table->foreign(config('vote.user_foreign_key'))
                ->references('id')->on(config('vote.users_table'))
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
        Schema::dropIfExists(config('vote.votes_table'));
    }
}
