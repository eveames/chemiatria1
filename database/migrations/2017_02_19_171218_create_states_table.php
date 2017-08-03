<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('studyable_type',100);
            $table->unsignedInteger('studyable_id');
            $table->unsignedInteger('subtype_id');
            $table->text('accuracies');
            $table->text('rts');
            $table->text('history');
            $table->bigInteger('lastStudied')->unsigned();
            $table->bigInteger('priority')->unsigned();
            $table->string('stage', 20);
            $table->unsignedInteger('current'); // 1 if current, 0 otherwise
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
        //
        Schema::drop('states');
    }
}
