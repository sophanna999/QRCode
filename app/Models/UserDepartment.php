<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    protected $table = 'user_departments';
    protected $primaryKey = 'department_id';
    //protected $timestamps = true;
}