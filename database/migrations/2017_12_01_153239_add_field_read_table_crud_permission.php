<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldReadTableCrudPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crud_permissions', function (Blueprint $table) {
            $table->enum('readed',['T','F'])->default('T');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crud_permissions', function (Blueprint $table) {
            $table->dropColumn('readed');
        });
    }
}
