<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToCourses2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('courses', function (Blueprint $table) {
          $table->boolean('private')->default(false);
         $table->boolean('locked_to_owner')->default(false);
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::table('courses', function (Blueprint $table) {
         $table->dropColumn('private');
         $table->dropColumn('locked_to_owner');
       });
     }
}
