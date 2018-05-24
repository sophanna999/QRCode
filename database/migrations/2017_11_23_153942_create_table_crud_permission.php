<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCrudPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned()->default(0);
            $table->integer('admin_user_id')->unsigned()->default(0);
            $table->enum('created',['T','F'])->default('T');
            $table->enum('updated',['T','F'])->default('T');
            $table->enum('deleted',['T','F'])->default('T');
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('admin_menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crud_permissions');
    }
}
