<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $table = 'admin_menus';

    public function scopeActiveMenu($q,$main_menu=0){
    	$user = \Auth::guard('admin')->user();
        $condition = [];
        foreach ($user->CrudPermission as $key => $value) {
            if($value->readed=='T'){
                $condition[] = $value->menu_id;
            }
        }
        $q->with('SubMenu');
    	$q->where('show','T');
    	$q->where('main_menu_id',$main_menu);
        $q->whereIn('id',$condition);
    	$q->orderBy('sort_id');
    }

    public function SubMenu(){
    	return $this->hasMany('\App\Models\AdminMenu','main_menu_id','id')->orderBy('sort_id');
    }

    public function MainMenu(){
        return $this->hasOne('\App\Models\AdminMenu','id','main_menu_id');
    }
}
