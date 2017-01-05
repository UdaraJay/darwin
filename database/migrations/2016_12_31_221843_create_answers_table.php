<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('answers', function (Blueprint $table){
        $table->increments('id');
        $table->string('answer');
        $table->boolean('correct')->defualt(false);

        $table->integer('user_id');
        $table->integer('course_id');
        $table->integer('topic_id');
        $table->integer('question_id');

        $table->longText('answer_explanation');

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
        Schema::drop('answers');
    }
}
