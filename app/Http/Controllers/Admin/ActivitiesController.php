<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use QRCode;
use QR_Code\Types\QR_Url;
use View;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['main_menu'] = 'กิจกรรม';
        $data['sub_menu'] = 'กิจกรรม';
        $data['title_page'] = 'กิจกรรม';
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        return view('Admin.activities',$data);
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
        $input_all                 = $request->all();
        $input_all['created_at']   = date('Y-m-d H:i:s');
        $input_all['updated_at']   = date('Y-m-d H:i:s');
        $gen_links                 = md5($input_all['activity_name'].date('Y-m-d H:i:s'));
        //$links                     = url('/admin/Activities/'.$gen_links);
        $links                     = $gen_links;
        $input_all['code'] = $links;
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\Activities::insert($data_insert);
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
        $result = \App\Models\Activities::find($id);

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
        $qrcode = md5($input_all['activity_name'].date('Y-m-d H:i:s'));
        $qrcode = url('/admin/Activities/'.$qrcode);
        $input_all['activity_url'] = $qrcode;
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\Activities::where('activity_id',$id)->update($data_insert);
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
        $return['title'] = 'แก้ไขข้อมูล';
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
            \App\Models\Activities::where('activity_id',$id)->delete();
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
        $result = \App\Models\Activities::select();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->editColumn('status', function($rec){
            $str = '<select class="form-control status" name="status" data-id="'.$rec->activity_id.'">';
            if($rec->status == 'T')
                $str .= '<option value="T">เปิดใช้งาน</option><option value="F">ไม่เปิดใช้งาน</option>';
            else
                $str .= '<option value="F">ไม่เปิดใช้งาน</option><option value="T">เปิดใช้งาน</option>';
            $str .= '</select>';
            return $str;
        })
        ->editColumn('activity_url', function($rec){
            // $str ='<a href="'.url("/QRCODE/".$rec->code).'">'.url("/QRCODE/".$rec->code).'</a>';
            $str ='<a href="'.url("/QRCODE/".$rec->code).'">OPEN</a>';
            return $str;
        })
        ->addColumn('qr_code', function($rec){
            // $urlgen = str_replace("http://","",$rec->activity_url);
            // return '<img src="'.url('admin/gen_qr_code').'?url='.url("admin/Activities/".$rec->code).'" width="150px" height="150px">';
            return \QrCode::size(100)->generate(url("/QRCODE/".$rec->code));
        })
        ->addColumn('action',function($rec){
            $str='
                <button class="btn btn-xs btn-info btn-condensed btn-add-init-question btn-tooltip" data-id="'.$rec->activity_id.'" data-rel="tooltip" title="" data-original-title="เพิ่มคำตอบพิเศษ">
                    <i class="ace-icon fa fa-question-circle bigger-120"></i>
                </button>
                <button class="btn btn-xs btn-primary btn-condensed btn-add-question btn-tooltip" data-id="'.$rec->activity_id.'" data-rel="tooltip" title="" data-original-title="เพิ่มคำถาม">
                    <i class="ace-icon fa fa-plus-square bigger-120"></i>
                </button>
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-reward btn-tooltip" data-rel="tooltip" data-id="'.$rec->activity_id.'" title="จัดการของรางวัล">
                    <i class="ace-icon fa fa-cube bigger-120"></i>
                </button>
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-info btn-condensed btn-staff btn-tooltip" data-rel="tooltip" data-id="'.$rec->activity_id.'" title="จัดการผู้ใช้งาน">
                    <i class="ace-icon fa fa-user bigger-120"></i>
                </button>
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-default btn-condensed btn-qrcode btn-tooltip" data-rel="tooltip" data-id="'.$rec->activity_id.'" title="สร้าง QRCode">
                    <i class="ace-icon fa fa-qrcode bigger-120"></i>
                </button>
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit btn-tooltip" data-rel="tooltip" data-id="'.$rec->activity_id.'" title="แก้ไข">
                    <i class="ace-icon fa fa-edit bigger-120"></i>
                </button>
                <button  class="btn btn-xs btn-danger btn-condensed btn-delete btn-tooltip" data-id="'.$rec->activity_id.'" data-rel="tooltip" title="ลบ">
                     <i class="ace-icon fa fa-trash bigger-120"></i>
                </button>
            ';
            return $str;
        })
        ->rawColumns(['status','activity_url','qr_code', 'action'])
        ->make(true);
    }
    public function RewardLists() {
        $result = \App\Models\Reward::select();
        return \Datatables::of($result)
        ->editColumn('amount',function($rec) {
            $str='
            <input class="form-control" type="text" name="amount['.$rec->id.']" readonly>
            ';
            return $str;
        })
        ->addColumn('reward',function($rec) {
            $str = '<input class="checkbox" type="checkbox" name="reward_id[]" value="'.$rec->id.'">';
            return $str;
        })
        ->addColumn('check',function($rec){
            $str='
                <input class="checkbox" type="checkbox" name="status_t['.$rec->id.']" value="T">
                <label for="add_show">
                    ถูก
                </label>
                <input class="checkbox" type="checkbox" name="status_f['.$rec->id.']" value="F">
                <label for="add_show">
                    ผิด
                </label>
            ';
            return $str;
        })
        ->addColumn('action',function($rec){
            $str='
            <button type="button" class="btn btn-xs btn-info btn-condensed btn-import btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="นำเข้า">
                <i class="ace-icon fa fa-arrow-down bigger-120"></i>
            </button>
            <button type="button" class="btn btn-xs btn-info btn-condensed btn-export btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="นำออก">
                <i class="ace-icon fa fa-arrow-up bigger-120"></i>
            </button>
            ';
            return $str;
        })
        ->rawColumns(['reward','amount','action','check'])
        ->make(true);
    }
    public function RewardAccept(Request $request) {
        $input_all = $request->all();
        $input_all['created_at'] = date('Y-m-d H:i:s');

        // $validator = Validator::make($request->all(), [
        //
        // ]);
        // if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $reward_t = array();
                $reward_f = array();
                \App\Models\ActivityRewardAmount::where('activity_id',$request->activity_id)->update(['amount'=>0]);
                foreach ($request->reward_id as $key => $value) {
                    $check = \App\Models\ActivityRewardAmount::where(['activity_id'=>$request->activity_id,'reward_id'=>$value])->first();
                    $amount = isset($request->amount[$value])?$request->amount[$value]:0;
                    if($check)
                        \App\Models\ActivityRewardAmount::where('id',$check->id)->update(['amount'=>$amount,'updated_at'=>date('Y-m-d H:i:s')]);
                    else
                        \App\Models\ActivityRewardAmount::insert(['activity_id'=>$request->activity_id,'reward_id'=>$value,'amount'=>$amount,'created_at'=>date('Y-m-d H:i:s')]);
                    if(!empty($request->status_t[$value])) {
                        $reward_t[] = $value;
                    }
                    if(!empty($request->status_f[$value])) {
                        $reward_f[] = $value;
                    }
                }
                unset($input_all['amount']);
                unset($input_all['status_f']);
                unset($input_all['status_t']);
                unset($input_all['RewardList_length']);
                // \App\Models\ActivityReward::where('activity_id',$request->activity_id)->delete();
                if(sizeof($reward_t)!=0) {
                    $reward_t = json_encode($reward_t);
                    $input_all['reward_id'] = $reward_t;
                    $input_all['status'] = 'T';
                    $data_insert = $input_all;
                    $check_update = \App\Models\ActivityReward::where(['status'=>'T','activity_id'=>$request->activity_id])->get();
                    if(sizeof($check_update)!=0) {
                        \App\Models\ActivityReward::where(['status'=>'T','activity_id'=>$request->activity_id])->update($data_insert);
                    } else {
                        // $data_insert['status'] = 'T';
                        // dd($data_insert);
                        \App\Models\ActivityReward::insert($data_insert);
                    }
                }
                if(sizeof($reward_f)!=0) {
                    $reward_f = json_encode($reward_f);
                    $input_all['reward_id'] = $reward_f;
                    $input_all['status'] = 'F';
                    $data_insert = $input_all;
                    $check_update = \App\Models\ActivityReward::where(['status'=>'F','activity_id'=>$request->activity_id])->get();
                    if(sizeof($check_update)!=0) {
                        \App\Models\ActivityReward::where(['status'=>'F','activity_id'=>$request->activity_id])->update($data_insert);
                    } else {
                        \App\Models\ActivityReward::insert($data_insert);
                    }
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
        $return['title'] = 'เพิ่มของรางวัล';
        return json_encode($return);
    }
    public function getReward($id)
    {
        $all = \App\Models\ActivityReward::where('activity_id',$id)->get();
        foreach ($all as $key => $value) {
            $result[$value->status] = json_decode($value->reward_id);
        }
        $result['amount'] = \App\Models\ActivityRewardAmount::where('activity_id',$id)->get();
        return json_encode($result);
    }
    public function gen_qr_code(Request $request){
        $url_real = $request->input('url');
        $url = new QR_Url($url_real);
        $url->setSize(8)->setMargin(2)->png();
    }
    public function QRCODE($code)
    {
        $activity = \App\Models\Activities::where('code',$code)->first();
        $return['activity'] = $activity;
        $res='';
        $listRewards = \App\Models\ActivityReward::where('activity_id',$activity->activity_id)->get();
        $activityQuestion = \App\Models\ActivityQuestion::where('activity_id',$activity->activity_id)->first();
        if($activityQuestion && sizeof(json_decode($activityQuestion->question_group_id))!=0 && $activityQuestion->limit_random!=0) {
            $return['check_amount_reward'] = true;
        } else {
            $return['check_amount_reward'] = false;
        }
        foreach ($listRewards as $key => $listReward) {
            $listReward = json_decode($listReward->reward_id);
            $res .= '(';
            foreach ($listReward as $key => $value) {
                $res .=$value.',';
            }
            $res = substr($res, 0, -1);
            $res .=')';
            $random = \DB::select("
            SELECT
            id,reward_id,amount,(SELECT SUM(amount) FROM activity_reward_amount WHERE reward_id IN ".$res." AND activity_id = ".$activity->activity_id.") as 'SUMALL',amount/(SELECT SUM(amount) FROM activity_reward_amount WHERE reward_id IN ".$res." AND activity_id = ".$activity->activity_id.") as 'Percent'
            FROM activity_reward_amount
            WHERE amount <> 0 AND reward_id IN ".$res." AND activity_id = ".$activity->activity_id."
            GROUP BY id,amount,reward_id
            ORDER BY amount DESC
            ");
            if($activityQuestion && sizeof(json_decode($activityQuestion->question_group_id))!=0 && $activityQuestion->limit_random!=0) {
                if(sizeof($random)==0) {
                    $return['check_amount_reward'] = false;
                }
            } else {
                if($random) {
                    $return['check_amount_reward'] = true;
                }
            }
            $res = '';
        }
        $return['check_question'] = \App\Models\ActivityQuestion::where('activity_id',$activity->activity_id)->first();
        $return['check_reward'] = false;
        $t = \App\Models\ActivityReward::where('activity_id',$activity->activity_id)->get();
        if(sizeof($t)!=0) {
            $return['check_reward'] = true;
        }
        // dd($return['check_reward']);

        return View::make('Admin.qr_code',$return);
    }
    public function StoreQRCODE(Request $request)
    {
        // $input_all                 = $request->all();
        // dd($request->all());
        $input_all['phone']      = $request->phone;
        $input_all['branch']      = $request->branch;
        $phone                   = $input_all['phone'];
        $input_all['created_at'] = date('Y-m-d H:i:s');
        $input_all['updated_at'] = date('Y-m-d H:i:s');
        $validator               = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            $check_phone_dup = 0;
            $check_phones = \App\Models\Guest::where('phone',$phone)->get();
            if($check_phones) {
                foreach($check_phones as $check_phone) {
                    $check_activity = \App\Models\AnswerHistory::where('user_id',$check_phone->guest_id)->first();
                    if($check_activity) {
                        $check_phone_activity = \App\Models\AnswerHistory::where(['user_id'=>$check_phone->guest_id,'activity_id'=>$request->activity_id])->first();
                        if($check_phone_activity) {
                            $check_phone_dup = 1;
                        }
                    } else {
                        \App\Models\Guest::where('guest_id',$check_phone->guest_id)->delete();
                    }
                }
            } else {
                $check_phone_dup = 0;
            }
            if ($check_phone_dup==0) {
                \DB::beginTransaction();
                try {
                    $data_insert = $input_all;
                    $return['user_id'] = \App\Models\Guest::insertGetId($data_insert);
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
                $return['content'] = 'มีเบอร์โทรนี้แล้ว ไม่สามารถดําเนินการได้';
            }
        }else{
            $return['status'] = 0;
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return json_encode($return);
    }
    public function getQuestion($code,$userid){
        $activity           = \App\Models\Activities::where('code',$code)->first();
        $check              = \App\Models\ActivityQuestion::where('activity_id',$activity->activity_id)->first();
        $check_init         = \App\Models\ActivityQuestionInit::where('activity_id',$activity->activity_id)->first();
        $status_init        = ''; #if status init = 1 go to random main question
        if($check_init && !empty(json_decode($check_init->question_group_id)) && $check_init->limit_random!=0) {
            // \DB::enableQueryLog();
            // dd(\DB::getQueryLog());
            $check_init_history = \App\Models\AnswerHistoryInit::where('activity_id',$activity->activity_id)->where('user_id',$userid)->first();
            if(sizeof($check_init_history)!=0) {
                $status_init = 1;
            } else {
                $status_init = 0;
            }
        } else {
            $status_init = 1;
        }
        if($check) {
            if($status_init==0) {
                return redirect('Activities/'.$code.'/'.$userid.'/getSpecialQuestion');
            } else {
                if(sizeof(json_decode($check->question_group_id))!=0 && $check->limit_random!=0) {
                    $return['userid']   = $userid;
                    $return['code']     = $code;
                    $check_history = \App\Models\AnswerHistory::where('user_id',$userid)->where('activity_id',$activity->activity_id)->first();
                    if($check_history) {
                        $data_send = $activity->activity_id.'/'.$userid.'/'.$check_history->result.'/'.$check_history->question_id;
                        $str = base64_encode($data_send);
                        return redirect('Activities/randomReward/'.$str);
                    } else {
                        $question_group_id  = json_decode($check->question_group_id);
                        $return['activity'] = $activity;
                        $test =[];
                        $limit_question = $check->limit_random;
                        for($i=0;$i<$limit_question;$i++) {
                            if(sizeof($question_group_id)!=0) {
                                $test[$i] = \App\Models\Question::with('Answer')->whereIn('id',$question_group_id)->where('status','T')->orderBy(\DB::raw('rand()'))->limit(1)->get()[0];
                                foreach ($question_group_id as $key => $value) {
                                    if($value == $test[$i]['id']) {
                                        unset($question_group_id[$key]);
                                    }
                                }
                            }
                        }
                        $return['question'] = $test;
                        // return $return['question'];
                        return View::make('Admin.randomQuestion',$return);
                    }
                } else {
                    return redirect('Activities/randomReward/'.base64_encode($activity->activity_id.'/'.$userid.'/1/0'));
                }
            }
        } else {
            return redirect('QRCODE/'.$code);
        }
    }
    public function getAllSpecialQuestion($code,$userid){
        $activity           = \App\Models\Activities::where('code',$code)->first();
        $check              = \App\Models\ActivityQuestionInit::where('activity_id',$activity->activity_id)->first();
        $status_init        = ''; #if status init = 1 go to random main question
        if($check && !empty(json_decode($check->question_group_id)) && $check->limit_random!=0) {
            // \DB::enableQueryLog();
            // dd(\DB::getQueryLog());
            $check_history = \App\Models\AnswerHistoryInit::where('activity_id',$activity->activity_id)->where('user_id',$userid)->first();
            if(sizeof($check_history)!=0) {
                $status_init = 1;
            } else {
                $status_init = 0;
            }
        } else {
            $status_init = 1;
        }
        if($status_init==1)  {
            return redirect('Activities/'.$code.'/'.$userid.'/getQuestion');
        } else {
            $return['userid']   = $userid;
            $return['code']     = $code;
            $return['id']       = 1;
            $question_group_id  = json_decode($check->question_group_id);
            $limit_question = $check->limit_random;
            $return['activity'] = $activity;
            for($i=0;$i<$limit_question;$i++) {
                if(sizeof($question_group_id)!=0) {
                    $test[$i] = \App\Models\QuestionInit::with('Answer')->whereIn('id',$question_group_id)->where('status','T')->orderBy(\DB::raw('rand()'))->limit(1)->get()[0];
                    foreach ($question_group_id as $key => $value) {
                        if($value == $test[$i]['id']) {
                            unset($question_group_id[$key]);
                        }
                    }
                }
            }
            $return['SpecialQuestion'] = $test;
            return View::make('Admin.randomSpecialQuestion',$return);
        }
    }
    public static function checkResult($question_id,$answer_id){
        return \App\Models\AnswerRight::where([
            'question_id' => $question_id,
            'answer_id' => $answer_id,
        ])->count();
    }
    public function storeHistory(Request $request){
        $input_all = $request->all();
        unset($input_all['_token']);
        unset($input_all['activity_id']);
        unset($input_all['user_id']);
        $check_history = \App\Models\AnswerHistory::where('user_id',$request->user_id)->where('activity_id',$request->activity_id)->first();
        $result = 0; $qtyQustion = 0;
        foreach($input_all as $ia){
            $str = explode('|',$ia);
            $data_insert[] = array(
                'activity_id' => $request->activity_id,
                'user_id' => $request->user_id,
                'question_id' => $str[0],
                'answer_id' => $str[1],
                'result' => $this->checkResult($str[0],$str[1]),
                'created_at' => date('Y-m-d H:i:s')
            );
            $qtyQustion++;
            $result += $this->checkResult($str[0],$str[1]);
        }
        $validator = Validator::make($request->all(), []);
        $string = '';
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if($check_history) {
                        $string = $request->activity_id.'/'.$request->user_id.'/'.$check_history->result.'/'.$check_history->question_id;
                        \DB::rollBack();
                        $return['status'] = 0;
                } else {
                    if(\App\Models\AnswerHistory::insert($data_insert)){
                        \DB::commit();
                        $return['status'] = 1;
                        $return['content'] = 'สำเร็จ';
                        $returns['activity_id'] = $request->activity_id;
                        $returns['user_id'] = $request->user_id;
                        $returns['result'] = $result/$qtyQustion;
                        $string = $returns['activity_id'].'/'.$returns['user_id'].'/'.$returns['result'].'/'.$str[0];
                    }else{
                        throw new $e;
                    }
                }
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
            }
        }else{
            $return['status'] = 0;
        }

        $return['title'] = 'เพิ่มข้อมูล';
        $return['code'] = base64_encode($string);

        return json_encode($return);
    }
    public function storeHistoryInit(Request $request){
        $user_id       = $request->input('user_id');
        $activity_id   = $request->input('activity_id');
        $question_id   = $request->input('question_id');
        $answer_status = $request->input('answer_status');
        $answer_text = $request->input('answer_text');
        $input_all     = $request->all();
        $validator = Validator::make($request->all(), []);

        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                foreach ($answer_status as $key => $value) {
                    $data_insert[] = [
                    'activity_id'   => $request->activity_id,
                    'user_id'       => $request->user_id,
                    'question_id'   => $key,
                    'answer_status' => $value,
                    'answer_text' => '',
                    'created_at'    => date('Y-m-d H:i:s')
                    ];
                }
                foreach ($answer_text as $key => $value) {
                    $data_insert[] = [
                    'activity_id'   => $request->activity_id,
                    'user_id'       => $request->user_id,
                    'question_id'   => $key,
                    'answer_status' => '',
                    'answer_text' => $value,
                    'created_at'    => date('Y-m-d H:i:s')
                    ];
                }
                // return $data_insert;
                $result = \App\Models\AnswerHistoryInit::insert($data_insert);
                if($result){
                    \DB::commit();
                    $return['status'] = 1;
                    $return['content'] = 'สำเร็จ';
                }else{
                    throw new $e;
                }
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
            }
        }else{
            $return['status'] = 0;
        }

        $return['title'] = 'เพิ่มข้อมูล';

        // $returns['activity_id']   = $request->activity_id;
        // $returns['user_id']       = $request->user_id;
        // $returns['question_id']   = $request->user_id;
        // $returns['answer_status'] = $request->user_id;
        // $returns['result'] = $result/$qtyQustion;
        // $string = $returns['activity_id'].'/'.$returns['user_id'].'/'.$returns['result'];

        //$return['code'] = base64_encode($string);

        return json_encode($return);
    }

    public function randomReward($code){
        $str = base64_decode($code);
        $str = explode('/',$str);
        $activity_id=$str[0];$user_id=$str[1];$result=$str[2];$question_id=$str[3];
        $listReward = \App\Models\ActivityReward::where([
            'activity_id' => $activity_id,
            'status' => ($result>0)?'T':'F'
        ])->first()->reward_id;
        $listReward = json_decode($listReward);
        // $randomReward = \App\Models\Reward::where('amount','<>',0)->whereIn('id',$listReward)->with('getRewardPicture')->orderBy(\DB::raw('rand()'))->limit(1)->get()->first();
        // $return['reward'] = $randomReward;
        // $amount_reward = [];
        // $id_reward = [];
        // $percent_reward = [];
        // $i=0;
        // $count_all = 0;
        // foreach ($listReward as $key => $value) {
        //     $check_amount = \App\Models\Reward::find($value);
        //     if($check_amount->amount!=0) {
        //         $amount_reward[$i] = $check_amount->amount;
        //         $id_reward[$i] = $check_amount->id;
        //         $count_all += $check_amount->amount;
        //         $i++;
        //     }
        // }
        // foreach ($amount_reward as $key => $value) {
        //     $percent_reward[$key] = intVal($value*100/$count_all)/100;
        // }
        // rsort($percent_reward);
        $count_all = 0;
        $percent = 0;
        $id_reward = '';
        $res = '(';
        foreach ($listReward as $key => $value) {
            $res .=$value.',';
        }
        $res = substr($res, 0, -1);
        $res .=')';
        $random = \DB::select("
        SELECT
            id,reward_id,amount,(SELECT SUM(amount) FROM activity_reward_amount WHERE reward_id IN ".$res." AND activity_id = ".$activity_id.") as 'SUMALL',amount/(SELECT SUM(amount) FROM activity_reward_amount WHERE reward_id IN ".$res." AND activity_id = ".$activity_id.") as 'Percent'
            FROM activity_reward_amount
            WHERE amount <> 0 AND reward_id IN ".$res." AND activity_id = ".$activity_id."
            GROUP BY id,amount,reward_id
            ORDER BY amount DESC
        ");
        $ran = \DB::select("
            SELECT RAND() as rd
        ")[0]->rd;
        foreach ($random as $key => $value) {
            if($key!=0) {
                $count_all = $value->amount;
                if($ran>$value->Percent) {
                    if(($ran-$value->Percent)<$percent) {
                        $percent = $ran-$value->Percent;
                        $count_all += $value->Percent;
                        $id_reward = $value->reward_id;
                    }
                } else {
                    if(($value->Percent-$ran)<$percent) {
                        $percent = $value->Percent-$ran;
                        $count_all += $value->Percent;
                        $id_reward = $value->reward_id;
                    }
                }
            } else {
                $count_all += $value->Percent;
                $id_reward = $value->reward_id;
                if($ran>$value->Percent) {
                    $percent = $ran-$value->Percent;
                } else {
                    $percent = $value->Percent-$ran;
                }
            }
        }
        $return['reward'] = \App\Models\Reward::find($id_reward);
        $check = \App\Models\ActivityRewardUser::where('activity_id',$activity_id)->where('user_id',$user_id)->get();
        if(sizeof($check)==0) {
            $id = \App\Models\ActivityRewardUser::insertGetId([
                'activity_id'=>$activity_id,
                'user_id'=>$user_id,
                'reward_id'=>$id_reward,
                // 'staff_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')
            ]);
            $get_reward_balance = \App\Models\ActivityRewardAmount::where(['activity_id'=>$activity_id, 'reward_id'=>$id_reward])->first()->amount;
            $this->rewardCheckout($id_reward,$get_reward_balance,$activity_id);
        } else {
            $id = $check[0]->id;
        }
        $check_limit = \App\Models\ActivityQuestion::where('activity_id',$activity_id)->first()->limit_random;
        if($check_limit==1) {
            if($question_id!=0) {
                $remark = \App\Models\AnswerRight::where('question_id',$question_id)->first();
                if($result>0) {
                    $return['text'] = '<center>ยินดีด้วย คุณตอบถูกต้อง</center><br>'.$remark->remark;
                } else {
                    $return['text'] = '<center>คุณตอบผิดนะ คำตอบที่ถูกต้องคือ</center><br>'.$remark->remark;
                }
                $return['id'] = base64_encode($id.'/'.$id_reward);
                $return['str'] = $str[2];
                $return['img'] = App(ActivityRewardUserController::class)->getRewardQrcode($id,$str[2]);
                return View::make('Admin.randomReward',$return);
            } else {
                return redirect('ActivityRewardUser/accept/'.base64_encode($id.'/'.$id_reward).'/'.$str[2]);
            }
        } else {
            return redirect('ActivityRewardUser/accept/'.base64_encode($id.'/'.$id_reward).'/'.$str[2]);
        }
    }
    public function rewardCheckout($id_reward,$get_reward_balance,$activity_id) {
        \App\Models\ActivityRewardAmount::where(['activity_id'=>$activity_id, 'reward_id'=>$id_reward])->update([
            'updated_at' => date('Y-m-d H:i:s'),
            'amount' => --$get_reward_balance,
        ]);
    }

    public function AddQuestion(Request $request, $id) {
        $question = $request->question_group_id;
        $question_group_id = array();
        if(sizeof($request->question_group_id)!=0 || isset($request->question_group_id)) {
            foreach ($question as $k => $v) {
                $question_group_id[$k] = $v;
            }
        } else {
            $question_group_id = [];
        }
        $input_all['question_group_id'] = json_encode($question_group_id);
        $input_all['created_at']   = date('Y-m-d H:i:s');
        $input_all['status']   = 'T';
        $input_all['limit_random']   = $request->limit_random;
        $input_all['activity_id']   = $id;
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                $check = \App\Models\ActivityQuestion::where('activity_id',$id)->first();
                // \App\Models\ActivityQuestion::where('activity_id',$id)->delete();
                // if(sizeof($request->question_group_id)!=0) {
                    if($check)
                        \App\Models\ActivityQuestion::where('activity_id',$id)->update($data_insert);
                    else
                        \App\Models\ActivityQuestion::insert($data_insert);
                // }
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
    public function AddStaff(Request $request, $id) {
        $staff = $request->staff_id;
        $staff_id = array();
        if(isset($request->staff_id) || sizeof($request->staff_id)!=0) {
            foreach ($staff as $k => $v) {
                $staff_id[$k] = $v;
            }
        } else {
            $staff_id = [];
        }
        $input_all['staff_id'] = json_encode($staff_id);
        $input_all['created_at']   = date('Y-m-d H:i:s');
        $input_all['activity_id']   = $id;
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                $check  = \App\Models\ActivityStaff::where('activity_id',$id)->first();
                // \App\Models\ActivityStaff::where('activity_id',$id)->delete();
                // if(sizeof($request->staff_id)!=0) {
                    if($check)
                        \App\Models\ActivityStaff::where('activity_id',$id)->update($data_insert);
                    else
                        \App\Models\ActivityStaff::insert($data_insert);
                // }
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
    public function AddSpecialQuestion(Request $request, $id) {
        $question = $request->question_group_id;
        $question_group_id = array();
        if(isset($request->question_group_id) || sizeof($request->question_group_id)!=0) {
            foreach ($question as $k => $v) {
                $question_group_id[$k] = $v;
            }
        } else {
            $question_group_id = [];
        }
        $input_all['question_group_id'] = json_encode($question_group_id);
        $input_all['created_at']   = date('Y-m-d H:i:s');
        $input_all['limit_random'] = $request->limit_random;
        $input_all['status']   = 'T';
        $input_all['activity_id']   = $id;
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                // \App\Models\ActivityQuestionInit::where('activity_id',$id)->delete();
                $check = \App\Models\ActivityQuestionInit::where('activity_id',$id)->first();
                // if(sizeof($request->question_group_id)!=0) {
                    if($check)
                        \App\Models\ActivityQuestionInit::where('activity_id',$id)->update($data_insert);
                    else
                        \App\Models\ActivityQuestionInit::insert($data_insert);
                // }
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

    public function getActivityQuestion($id) {
        $all = \App\Models\ActivityQuestion::where('activity_id',$id)->get();
        foreach ($all as $key => $value) {
            $result['question'][$key] = json_decode($value->question_group_id);
        }
        $result['limit_random'] = $all[0]->limit_random;
        return json_encode($result);
    }
    // public function getSpecialQuestion($id) {
    //     $all = \App\Models\ActivityQuestionInit::where('activity_id',$id)->get();
    //     foreach ($all as $key => $value) {
    //         $result[$key] = json_decode($value->question_group_id);
    //     }
    //     $result['limit_random'] = $all[0]->limit_random;
    //     return json_encode($result);
    // }
    public function updateStatus(Request $request,$id) {
        $status = $request->status;

        $input_all['updated_at'] = date('Y-m-d H:i:s');
        $input_all['status'] = $status;
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\Activities::where('activity_id',$id)->update($data_insert);
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
        $return['title'] = 'เปลี่ยนสถานะกิจกรรม';
        return json_encode($return);
    }
    public function staff($id) {
        $staff = \App\Models\ActivityStaff::where('activity_id',$id)->first();
        // if($staff)
        //     $result = \App\Models\AdminUser::whereNotIn('id',json_decode($staff->staff_id))->get();
        // else
            $result = \App\Models\AdminUser::get();
            // $result = \App\Models\Employee::get();

        return json_encode($result);
    }
    public function getStaff($id) {
        $all = \App\Models\ActivityStaff::where('activity_id',$id)->get();
        foreach ($all as $key => $value) {
            $result[$key] = json_decode($value->staff_id);
        }
        return json_encode($result);
    }
    public function AllSpeQues($id) {

        $result = \App\Models\QuestionInit::where('status', 'T')->get();
        return json_encode($result);
    }
    public function GetSpecQuestion($id){
        $all = \App\Models\ActivityQuestionInit::where('activity_id',$id)->get();
        foreach ($all as $key => $value) {
            $result[$key] = json_decode($value->question_group_id);
        }
        $result['limit_random'] = $all[0]->limit_random;
        return json_encode($result);
    }
    public function getDownloadQrcode($id) {
        $result = \App\Models\Activities::where('activity_id',$id)->first();
        $data = \QrCode::format('png')->encoding('UTF-8')->size(750)->generate(url("/QRCODE/".$result->code));
        return '<img name="'.$result->code.'" class="download" src="data:image/png;base64, '.base64_encode($data) .'" title="click for download">';
    }
}
