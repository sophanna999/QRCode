<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFreeFormQuestionInit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('question_inits', function (Blueprint $table) {
             $table->char('free_form', 255);
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('question_inits', function (Blueprint $table) {
             $table->dropColumn('free_form');
         });
     }
}
