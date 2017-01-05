<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('questions', function (Blueprint $table){
        $table->increments('id');
        $table->longText('question');

        $table->integer('user_id');
        $table->integer('course_id');
        $table->integer('topic_id');


        $table->longText('question_explanation');

        $table->boolean('published')->defualt(true);
        $table->boolean('challenged')->defualt(false);
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
      Schema::drop('questions');
    }
}
