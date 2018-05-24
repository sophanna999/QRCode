<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use Session;
class PermissionCRUDProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->InitSessionPermission();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function InitSessionPermission(){
        $user_id = \Auth::guard('admin')->user()->id;
        $result = \App\Models\CrudPermission::with('AdminMenu')->where('admin_user_id',$user_id)->get();
        $data = [];
        foreach ($result as $key => $value) {
            $data[$value->AdminMenu->link] = [
                'C'=>$value->created,
                'U'=>$value->updated,
                'D'=>$value->deleted,
            ];
        }
        Session::put('permission', $data);
    }

    public static function CheckPermission($link_main = null , $link_sub = null){
        if (!Session::has('permission')){
            self::InitSessionPermission();
        }
    }
}
