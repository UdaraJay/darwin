<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('topics', function (Blueprint $table){
        $table->increments('id');
        $table->string('name');

        $table->integer('course_id');

        $table->integer('created_by');
        $table->longText('description');
        $table->integer('question_count');
        $table->boolean('published')->defualt(true);
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
        Schema::drop('topics');
    }
}
