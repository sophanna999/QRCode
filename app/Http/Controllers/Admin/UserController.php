<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
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
        $data['title_page'] = 'ผู้ดูแลระบบ';
        $data['department'] = \App\Models\UserDepartment::get();
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        $data['menu_all'] = \App\Models\AdminMenu::with(['SubMenu','MainMenu'])->where('show','=','T')->get();
        return view('Admin.user',$data);
    }

    /**
     * View Edit Profile
     * @return html
     */
    public function profile(){
        $data['main_menu'] = 'profile';
        $data['sub_menu'] = 'profile';
        $data['title_page'] = 'แก้ไขข้อมูลส่วนตัว';
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        return view('Admin.user.profile',$data);
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
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $nickname = $request->input('nickname');
        $mobile = $request->input('mobile');
        $username = $request->input('username');
        $password = $request->input('password');
        $photo = $request->input('photo_add');
        $department_id = $request->input('department_id');
        $new_password = \Hash::make($password);

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'mobile' => 'required',
            'nickname' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if($photo){
                    $photo = $photo[0];
                    Storage::disk('uploads')->move('temp/'.$photo, 'avatars/'.$photo);
                }else{
                    $photo = null;
                }
                $data_insert = [
                    'username'=>$username,
                    'password'=>$new_password,
                    'mobile'=>$mobile,
                    'nickname'=>$nickname,
                    'firstname'=>$firstname,
                    'lastname'=>$lastname,
                    'photo_profile'=>$photo,
                    'department_id'=>$department_id,
                ];
                \App\Models\AdminUser::insert($data_insert);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
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
        $result = \App\Models\AdminUser::find($id);
        if($result->photo_profile){
            $photo = $result->photo_profile;
            $exists = Storage::disk('uploads')->exists('temp/'.$photo);
            if(!$exists){
                Storage::disk('uploads')->copy('avatars/'.$photo, 'temp/'.$photo);
            }
        }
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
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $nickname = $request->input('nickname');
        $mobile = $request->input('mobile');
        $photo_old = $request->input('photo_old');
        $department_id = $request->input('department_id');
        $photo = $request->input('photo_edit');

        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'nickname' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                /*if($photo_old){
                    Storage::disk('uploads')->delete('avatars/'.$photo_old);
                }
                if($photo){
                    $photo = $photo[0];
                    Storage::disk('uploads')->move('temp/'.$photo, 'avatars/'.$photo);
                }else{
                    $photo = null;
                }*/
                $data_insert = [
                    'mobile'=>$mobile,
                    'nickname'=>$nickname,
                    'firstname'=>$firstname,
                    'lastname'=>$lastname,
                    'department_id'=>$department_id,
                    // 'photo_profile'=>$photo,
                ];
                \App\Models\AdminUser::where('id',$id)->update($data_insert);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
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
            \App\Models\AdminUser::where('id',$id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
        }
        $return['title'] = 'ลบข่อมูล';
        return $return;
    }

    public function ListUser(){
        $result = \App\Models\AdminUser::select();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->editColumn('firstname',function($rec){
            $str = $rec->firstname.' '.$rec->lastname.' ('.$rec->nickname.')';
            return $str;
        })->addColumn('action',function($rec){
            $str='
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit btn-tooltip" data-rel="tooltip" data-id="'.$rec->id.'" title="แก้ไข">
                    <i class="ace-icon fa fa-edit bigger-120"></i>
                </button>
                <button  data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-info btn-condensed btn-change-password btn-tooltip" data-rel="tooltip" data-id="'.$rec->id.'" title="เปลี่ยนรหัส">
                    <i class="ace-icon fa fa-key bigger-120"></i>
                </button>
                <button  data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-success btn-condensed btn-change-permission btn-tooltip" data-rel="tooltip" data-id="'.$rec->id.'" title="จัดการสิทธิ">
                    <i class="ace-icon fa fa-lock bigger-120"></i>
                </button> ';
                if($rec->id!=1) {
                    $str .= '<button  class="btn btn-xs btn-danger btn-condensed btn-delete btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="ลบ">
                    <i class="ace-icon fa fa-trash bigger-120"></i>
                    </button>
                    ';
                }else{
                    $str .= '<button  class="btn btn-xs btn-danger btn-condensed btn-delete btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="ลบ" disabled>
                    <i class="ace-icon fa fa-trash bigger-120"></i>
                    </button>
                    ';
                }
            return $str;
        })->make(true);
    }

    public function change_password(Request $request){
        $id = $request->input('id');
        $password = $request->input('password');
        $new_password = \Hash::make($password);

        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_update = [
                    'password'=>$new_password
                ];
                \App\Models\AdminUser::where('id',$id)->update($data_update);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
            }
        }else{
            $return['status'] = 0;
        }
        $return['title'] = 'เปลี่ยนรหัสผ่าน';
        return json_encode($return);
    }
}
