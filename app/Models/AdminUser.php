<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $table = "admin_users";

    public function CrudPermission(){
    	return $this->hasMany('\App\Models\CrudPermission','admin_user_id','id');
    }
}
