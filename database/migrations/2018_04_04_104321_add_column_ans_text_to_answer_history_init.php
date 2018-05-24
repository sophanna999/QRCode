<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAnsTextToAnswerHistoryInit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('answer_history_init', function (Blueprint $table) {
             $table->char('answer_text', 255)->nullable();
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('answer_history_init', function (Blueprint $table) {
             $table->dropColumn('answer_text');
         });
     }
}
