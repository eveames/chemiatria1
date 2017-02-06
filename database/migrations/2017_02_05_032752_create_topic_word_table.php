<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('topic_word', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('word_id');
            $table->foreign('word_id')->references('id')->on('words');
            $table->unsignedInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('topic_word');
    }
}
