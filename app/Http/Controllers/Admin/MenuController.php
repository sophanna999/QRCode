<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['main_menu'] = 'user';
        $data['sub_menu'] = 'user';
        $data['title_page'] = 'สมาชิก';
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        $data['AdminMenus'] = \App\Models\AdminMenu::get();
        return view('Admin.menu',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input_all = $request->all();
        $input_all['show'] = $request->input('show','F');
        $input_all['created_at'] = date('Y-m-d H:i:s');
        $input_all['updated_at'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
            
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\AdminMenu::insert($data_insert);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();;
            }
        }else{
            $return['status'] = 0;
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return json_encode($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = \App\Models\AdminMenu::find($id);
        
        return json_encode($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input_all = $request->all();
        $input_all['show'] = $request->input('show','F');
        $input_all['updated_at'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
            
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\AdminMenu::where('id',$id)->update($data_insert);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();;
            }
        }else{
            $return['status'] = 0;
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return json_encode($return);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            \App\Models\AdminMenu::where('id',$id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();;
        }
        $return['title'] = 'ลบข่อมูล';
        return $return;
    }

    public function Lists(){
        $result = \App\Models\AdminMenu::with('MainMenu');
        return \Datatables::of($result)
        ->editColumn('main_menu_id',function($rec){
            if(!empty($rec->MainMenu)){
                return $rec->MainMenu->name;
            }else{
                return 'Main Menu';
            }
        })
        ->addColumn('sort_id',function($rec){
            if(is_numeric($rec->sort_id)){
                return number_format($rec->sort_id);
            }else{
                return $rec->sort_id;
            }
        })
        
        ->addColumn('action',function($rec){
            $str='
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit btn-tooltip" data-rel="tooltip" data-id="'.$rec->id.'" title="แก้ไข">
                    <i class="ace-icon fa fa-edit bigger-120"></i>
                </button>
                <button  class="btn btn-xs btn-danger btn-condensed btn-delete btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="ลบ">
                    <i class="ace-icon fa fa-trash bigger-120"></i>
                </button>
            ';
            return $str;
        })->make(true);
    }

    public function SetPermission(Request $request){
        $user_id = $request->input('id');
        $read = $request->input('read',null);
        $create = $request->input('create');
        $edit = $request->input('edit');
        $delete = $request->input('delete');
        \DB::beginTransaction();
        try {
            \App\Models\CrudPermission::where('admin_user_id',$user_id)->update(['readed'=>'F','deleted'=>'F','created'=>'F','updated'=>'F']);
            if($read){
                foreach ($read as $key => $value) {
                    $data = [];
                    $result = \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->first();
                    if($result){
                        $data['readed'] = 'T';
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->update($data);
                    }else{
                        $data['menu_id'] = $value;
                        $data['readed'] = 'T';
                        $data['admin_user_id'] = $user_id;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::insert($data);
                    }
                }
            }

            if($create){
                foreach ($create as $key => $value) {
                    $data = [];
                    $result = \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->first();
                    if($result){
                        $data['created'] = 'T';
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->update($data);
                    }else{
                        $data['menu_id'] = $value;
                        $data['created'] = 'T';
                        $data['admin_user_id'] = $user_id;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::insert($data);
                    }
                }
            }

            if($edit){
                foreach ($edit as $key => $value) {
                    $data = [];
                    $result = \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->first();
                    if($result){
                        $data['updated'] = 'T';
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->update($data);
                    }else{
                        $data['menu_id'] = $value;
                        $data['updated'] = 'T';
                        $data['admin_user_id'] = $user_id;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::insert($data);
                    }
                }
            }

            if($delete){
                foreach ($delete as $key => $value) {
                    $data = [];
                    $result = \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->first();
                    if($result){
                        $data['deleted'] = 'T';
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::where('admin_user_id',$user_id)->where('menu_id',$value)->update($data);
                    }else{
                        $data['menu_id'] = $value;
                        $data['deleted'] = 'T';
                        $data['admin_user_id'] = $user_id;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        \App\Models\CrudPermission::insert($data);
                    }
                }
            }
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();;
        }
        $return['title'] = 'บันทึกข้อมูล';
        return $return;
    }

    public function GetPermission($id){
        $result = \App\Models\CrudPermission::where('admin_user_id',$id)->get();
        return $result;
    }

}
