<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use QRCode;
use View;
class ActivityRewardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['main_menu'] = 'รายการแจกของรางวัล';
        $data['sub_menu'] = 'รายการแจกของรางวัล';
        $data['title_page'] = 'รายการแจกของรางวัล';
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();

        return view('Admin.activity_reward_user',$data);
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
        $input_all['updated_at'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\ActivityRewardUser::insert($data_insert);
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
        $result = \App\Models\ActivityRewardUser::find($id);

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

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\ActivityRewardUser::where('id',$id)->update($data_insert);
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
            \App\Models\ActivityRewardUser::where('id',$id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
        }
        $return['title'] = 'ลบข่อมูล';
        return $return;
    }

    public function Lists(){
        $result = \App\Models\ActivityRewardUser::leftjoin('users','activity_reward_user.user_id','=','users.id')
        ->leftjoin('reward','activity_reward_user.reward_id','=','reward.id')
        ->leftjoin('activity','activity_reward_user.activity_id','=','activity.activity_id')
        ->leftjoin('admin_users','activity_reward_user.staff_id','=','admin_users.id')
        ->select('activity_reward_user.*','users.firstname','users.lastname','reward.name','activity.activity_name','admin_users.firstname as staff_firstname','admin_users.lastname as staff_lastname');
        return \Datatables::of($result)
        ->addIndexColumn()
        ->editColumn('user_id', function($rec) {
            return $rec->firstname.' '.$rec->lastname;
        })
        ->editColumn('staff_id', function($rec) {
            return $rec->staff_firstname.' '.$rec->staff_lastname;
        })
        ->editColumn('activity_id', function($rec) {
            return $rec->activity_name;
        })
        ->editColumn('reward_id', function($rec) {
            return $rec->name;
        })
        ->addColumn('url',function($rec){
            // return '<a href="'.url("ActivityRewardUser/accept/".base64_encode($rec->id.'/'.$rec->reward_id)).'">'.url("ActivityRewardUser/accept/".base64_encode($rec->id.'/'.$rec->reward_id)).'</a>';
            if($rec->staff_id=='') {
                // return '<a href="'.url("ActivityRewardUser/accept/".base64_encode($rec->id.'/'.$rec->reward_id)).'">ยืนยัน</a>';
                // return '<button class="btn accept btn-warning" data-accept="'.base64_encode($rec->id.'/'.$rec->reward_id).'">ยืนยัน</button>';
                return '<button  class="btn btn-xs btn-warning btn-condensed accept btn-tooltip" data-accept="'.base64_encode($rec->id.'/'.$rec->reward_id).'" data-rel="tooltip" title="ยืนยัน">
                                <i class="ace-icon fa fa-edit bigger-120"></i>
                            </button>
                        ';
            } else {
                return '';
            }
        })
        ->addColumn('qrcode',function($rec){
            return \QrCode::size(100)->generate(url("ActivityRewardUser/accept/".base64_encode($rec->id.'/'.$rec->reward_id)));
        })
        // ->addColumn('action',function($rec){
        //     $str = '';
        //     if($rec->staff_id==null) {
        //         $str='
        //             <!--<button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit btn-tooltip" data-rel="tooltip" data-id="'.$rec->id.'" title="แก้ไข">
        //                 <i class="ace-icon fa fa-edit bigger-120"></i>
        //             </button> -->
        //             <button  class="btn btn-xs btn-danger btn-condensed btn-delete btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="ลบ">
        //                 <i class="ace-icon fa fa-trash bigger-120"></i>
        //             </button>
        //         ';
        //     }
        //     return $str;
        // })
        ->rawColumns(['url', 'qrcode', 'action'])
        ->make(true);
    }
    public function acceptRewardUser($id,$result=null) {
        $encode = base64_decode($id);
        $val = explode('/',$encode);
        $check = \App\Models\ActivityRewardUser::where('id',$val[0])->where('staff_id',NULL)->first();
        if($check) {
            $staff = \App\Models\ActivityStaff::where('activity_id',$check->activity_id)->first();
            if (in_array(\Auth::guard('admin')->user()->id, json_decode($staff->staff_id))){
                \App\Models\ActivityRewardUser::where('id',$val[0])->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                    'staff_id' =>\Auth::guard('admin')->user()->id,
                ]);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
                // $get_reward_balance = \App\Models\Reward::find($val[1])->amount;
                // \App\Models\Reward::where('id',$val[1])->update([
                //     'updated_at' => date('Y-m-d H:i:s'),
                //     'amount' => --$get_reward_balance,
                // ]);
            } else {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ';
            }
        } else {
            $check = \App\Models\ActivityRewardUser::where('id',$val[0])->first();
        }
        $return['reward'] = \App\Models\Reward::find($check->reward_id);
        $return['pic'] = \App\Models\RewardPicture::where('reward_id',$check->reward_id)->first();
        $check_question = \App\Models\ActivityQuestion::where('activity_id',$check->activity_id)->first();
        if($check_question->limit_random!=0 && sizeof(json_decode($check_question->question_group_id))!=0) {
            $question = \App\Models\AnswerHistory::where('activity_id',$check->activity_id)->where('user_id',$check->user_id)->first();
            if($result!=null) {
                $remark = \App\Models\AnswerRight::where('question_id',$question->question_id)->first();
                if($result>0) {
                    $return['text'] = '<center>ยินดีด้วย คุณตอบถูกต้อง</center><br>'.$remark->remark;
                } else {
                    $return['text'] = '<center>คุณตอบผิดนะ คำตอบที่ถูกต้องคือ</center><br>'.$remark->remark;
                }
                $return['img'] = App(ActivityRewardUserController::class)->getRewardQrcode($id,$result);
                // dd($return['img']);

                return View::make('Admin.randomRewardQrcode',$return);
                // return View::make('Admin.randomReward',$return);
            } else {
                $return['title'] = 'ยืนยันของรางวัล';
                return $return;
                // return redirect('admin/ActivityRewardUser');
            }
        } else {
            $return['img'] = App(ActivityRewardUserController::class)->getRewardQrcode($id,$result);
            return View::make('Admin.randomRewardQrcode',$return);
        }
    }
    public static function getRewardQrcode($id,$r) {
        $result = \App\Models\ActivityRewardUser::where('id',$id)->first();
        // $data = \QrCode::format('png')->encoding('UTF-8')->size(300)->generate(url("ActivityRewardUser/accept/".base64_encode($id.'/'.$result->reward_id).'/'.$r));
        $data = \QrCode::format('png')->encoding('UTF-8')->size(300)->generate(url("ActivityRewardUser/accept/".$id.'/'.$r));
        return '<img src="data:image/png;base64, '.base64_encode($data) .'">';
        // return "<a href='".url('ActivityRewardUser/accept/'.base64_encode($id.'/'.$result->reward_id).'/'.$r)."'>";
        // return "<a href='".url('ActivityRewardUser/accept/'.$id.'/'.$r)."'>";
    }
    public function report($start,$end) {
        $s = '';
        $e = '';
        if($start < $end) {
            $s = $start.' 00:00:00';
            $e = $end.' 23:59:59';
        } else {
            $s = $end.' 00:00:00';
            $e = $start.' 23:59:59';
        }
        $result['data'] = \DB::select('
                    SELECT q.text as q_text, q.id as q_id, a.text as a_text, sum(ans_count) as ans_count, a.answer_id as a_id
                    FROM question as q
                    LEFT JOIN answer as a
                    ON a.question_id = q.id
                    LEFT JOIN (SELECT question_id,answer_id,COUNT(answer_id) as ans_count
                    	FROM answer_history
                    	WHERE created_at BETWEEN "'.$s.'" AND "'.$e.'"
                    	GROUP BY answer_id) as qh
                    ON q.id = qh.question_id AND a.answer_id = qh.answer_id
                    GROUP BY a.answer_id
                    ORDER BY q.id');
        return json_encode($result);
    }
}
