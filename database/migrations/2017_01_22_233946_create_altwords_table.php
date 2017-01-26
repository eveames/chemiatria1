<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAltwordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this table holds alternate answers to vocab questions
        //alt is the alternate answer when a word is prompted
        //message is the message to student who enters alt instead of word
        // correct takes values correct, close, wrong, typo
        Schema::create('altwords', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('word_id');
            $table->foreign('word_id')->references('id')->on('words');
            $table->string('alt', 40)->unique();
            $table->string('message', 150)->nullable();
            $table->string('correct', 20);
            $table->string('MCprompt')->nullable();
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
        Schema::drop('altwords');
    }
}
