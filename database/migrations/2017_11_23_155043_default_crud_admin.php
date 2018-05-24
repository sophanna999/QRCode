<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultCrudAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $result = \DB::table('admin_menus')->get();
        foreach ($result as $key => $value) {
            $data_insert = [
                'menu_id'=>$value->id,
                'admin_user_id'=>1,
                'created'=>'T',
                'updated'=>'T',
                'deleted'=>'T',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ];
            \DB::table('crud_permissions')->insert($data_insert);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('crud_permissions')->truncate();
    }
}
