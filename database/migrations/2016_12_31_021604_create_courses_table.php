<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('courses', function (Blueprint $table){
        $table->increments('id');
        $table->string('name');
        $table->integer('created_by');
        $table->integer('subscriber_count')->defualt(0);
        $table->longText('description');
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
        Schema::drop('courses');
    }
}
