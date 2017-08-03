<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name',50); //category of questions, like polyatomic ion
            $table->string('key', 50); //short side of fact
            $table->string('key_name', 50);//name, such as formula or element
            $table->string('prop',100); //long side of fact
            $table->string('prop_name', 50)->nullable(); //name, if appropriate
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
        Schema::dropIfExists('facts');
    }
}
