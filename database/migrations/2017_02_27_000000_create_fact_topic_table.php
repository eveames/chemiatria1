<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('fact_topic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fact_id');
            $table->foreign('fact_id')->references('id')->on('facts');
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
        if (Schema::hasTable('fact_topic')) {
          Schema::drop('fact_topic');
        }
    }
}
