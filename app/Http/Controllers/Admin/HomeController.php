<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\Admin\PermissionCRUDProvider as Permission;

class HomeController extends Controller
{
    public function index(){
        $permission = \App\Models\AdminMenu::ActiveMenu()->get();
        // dd($permission);
        if(sizeof($permission)!=0 && $permission[0]->name =="กิจกรรม") {
            //dd(\Session::get('permission'));
            return redirect('admin/Activities');
        } else {
            $data['main_menu'] = 'dashboard';
            $data['sub_menu'] = '';
            $data['title_page'] = 'หน้าแรก';
            $data['permission'] = Permission::CheckPermission($data['main_menu'],$data['sub_menu']);
            $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
            return view('Admin.dashboard',$data);
        }
    }
}
