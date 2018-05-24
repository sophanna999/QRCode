<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLimitRandomQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('activity_question', function (Blueprint $table) {
             $table->integer('limit_random');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('activity_question', function (Blueprint $table) {
             $table->dropColumn('limit_random');
         });
     }
}
