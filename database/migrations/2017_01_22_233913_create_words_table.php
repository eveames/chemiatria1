<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        // table holds vocab words
        // prompts are phrases that are given to student; student should enter the word
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->string('word', 50)->unique();
            $table->text('prompts');
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
        Schema::drop('words');
    }
}
