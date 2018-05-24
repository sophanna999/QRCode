<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsernameAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('admin_users')->insert(
            [
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'nickname' => 'Nickname',
                'username' => 'admin',
                'password' => \Hash::make('123456789'),
                'email' => 'john@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('admin_users')->where('username', '=', 'admin')->delete();
    }
}
