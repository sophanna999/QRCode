<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['main_menu'] = 'ตั้งค่า';
        $data['sub_menu'] = 'ของรางวัล';
        $data['title_page'] = 'ของรางวัล';
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        return view('Admin.reward',$data);
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
        $input_all['created_at'] = date('Y-m-d H:i:s');
        $input_all['amount'] = 0;
        // $input_all['updated_at'] = date('Y-m-d H:i:s');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $img['path_picture'] = !empty($input_all['photo'][0])?$input_all['photo'][0]:null;
                unset($input_all['photo']);
                $data_insert = $input_all;
                $id = \App\Models\Reward::insertGetId($data_insert);
                $img['reward_id'] = $id;
                $img['created_at'] = date('Y-m-d H:i:s');
                if(!empty($request->photo[0])) {
                    \App\Models\RewardPicture::insert($img);
                }
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
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
        $result = \App\Models\Reward::leftjoin('reward_picture','reward.id','=','reward_picture.reward_id')->find($id);

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
        $input_all['updated_at'] = date('Y-m-d H:i:s');
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $img['path_picture'] = !empty($input_all['photo_edit'][0])?$input_all['photo_edit'][0]:null;
                unset($input_all['photo_edit']);
                $data_insert = $input_all;
                \App\Models\Reward::where('id',$id)->update($data_insert);
                $img['reward_id'] = $id;
                $img['updated_at'] = date('Y-m-d H:i:s');
                if(!empty($request->photo_edit[0])) {
                    \App\Models\RewardPicture::where('reward_id',$id)->delete();
                    \App\Models\RewardPicture::insert($img);
                } else {
                    \App\Models\RewardPicture::where('reward_id',$id)->delete();
                }
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
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
            \App\Models\Reward::where('id',$id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }

    public function Lists(){
        $result = \App\Models\Reward::select();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('img', function($rec) {
            $str = '';
            $img = \App\Models\RewardPicture::where('reward_id',$rec->id)->first();
            if($img) {
                $str = '<img src="'.asset("uploads/temp").'/'.$img->path_picture.'"height="50" width="auto">';
            }
            return $str;
        })
        ->addColumn('action',function($rec){
            $str='
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit btn-tooltip" data-rel="tooltip" data-id="'.$rec->id.'" title="แก้ไข">
                    <i class="ace-icon fa fa-edit bigger-120"></i>
                </button>
                <button  class="btn btn-xs btn-danger btn-condensed btn-delete btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="ลบ">
                    <i class="ace-icon fa fa-trash bigger-120"></i>
                </button>
                <!--<button  class="btn btn-xs btn-info btn-condensed btn-import btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="นำเข้า">
                    <i class="ace-icon fa fa-arrow-down bigger-120"></i>
                </button>
                <button  class="btn btn-xs btn-info btn-condensed btn-export btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="นำออก">
                    <i class="ace-icon fa fa-arrow-up bigger-120"></i>
                </button>-->
            ';
            return $str;
        })
        ->rawColumns(['img', 'action'])
        ->make(true);
    }

    public function Import(Request $request,$id=null) {
        $input_all = $request->all();
        $input_all['created_at'] = date('Y-m-d H:i:s');
        // $input_all['updated_at'] = date('Y-m-d H:i:s');

        // $validator = Validator::make($request->all(), [
        //     'qty' => 'required',
        // ]);
        // if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $user = \Auth::guard('admin')->user();
                $input_all['staff_id'] = $user->id;
                \App\Models\RewardImport::insert($input_all);
                $amount = \App\Models\Reward::find($input_all['reward_id']);
                $balance = ($amount->amount != NULL)?$amount->amount:0;
                $balance += $input_all['qty'];
                \App\Models\Reward::where('id',$input_all['reward_id'])->update(['amount'=>$balance,"updated_at"=>date('Y-m-d H:i:s')]);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
            }
        // }else{
        //     $return['status'] = 0;
        // }
        $return['title'] = 'เพิ่มข้อมูล';
        return json_encode($return);
    }

    public function Export(Request $request,$id=null) {
        $input_all = $request->all();
        $input_all['created_at'] = date('Y-m-d H:i:s');
        // $input_all['updated_at'] = date('Y-m-d H:i:s');

        // $validator = Validator::make($request->all(), [
        //     'qty' => 'required',
        // ]);
        // if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $user = \Auth::guard('admin')->user();
                $input_all['staff_id'] = $user->id;
                if($id==null) {
                    \App\Models\RewardExport::insert($input_all);
                    $amount = \App\Models\Reward::find($input_all['reward_id']);
                    $balance = ($amount->amount != NULL)?$amount->amount:0;
                    $balance -= $input_all['qty'];
                    \App\Models\Reward::where('id',$input_all['reward_id'])->update(['amount'=>$balance,"updated_at"=>date('Y-m-d H:i:s')]);
                } else {
                    // $reward_id = \App\Models\ActivityRewardAmount::where(['activity_id'=>$id,'reward_id',$request->reward_id])->first();
                    // if($reward_id) {
                    //     $input_all['reward_id'] = $reward_id->id;
                    //     \App\Models\RewardExport::insert($input_all);
                    //     $amount = \App\Models\ActivityRewardAmount::find($input_all['reward_id']);
                    //     $balance = ($amount->amount != NULL)?$amount->amount:0;
                    //     $balance -= $input_all['qty'];
                    //     \App\Models\ActivityRewardAmount::where('id',$input_all['reward_id'])->update(['amount'=>$balance,"updated_at"=>date('Y-m-d H:i:s')]);
                    // }
                }
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
            }
        // }else{
        //     $return['status'] = 0;
        // }
        $return['title'] = 'เพิ่มข้อมูล';
        return json_encode($return);
    }
}
