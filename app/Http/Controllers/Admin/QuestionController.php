<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
class QuestionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data['main_menu'] = 'ตั้งค่า';
        $data['sub_menu'] = 'คำถาม';
        $data['title_page'] = 'คำถาม';
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();

        return view('Admin.question',$data);
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
        unset($input_all['id']);
        $input_all['status'] = $request->input('status');
        $input_all['created_at'] = date('Y-m-d H:i:s');
        $input_all['updated_at'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
            'text' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                \App\Models\Question::insert($data_insert);
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
        $result = \App\Models\Question::find($id);

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
        $input_all['status'] = $request->input('status','T');
        $input_all['updated_at'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
            'text' => 'required',

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try{
                $data_insert = $input_all;
                \App\Models\Question::where('id',$id)->update($data_insert);
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
            \App\Models\Question::where('id',$id)->delete();
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
        $result = \App\Models\Question::select();
        return \Datatables::of($result)
        ->addIndexcolumn()
        ->editColumn('status',function($rec) {
            $str = '<select class="form-control status" name="status" data-id="'.$rec->id.'">';
            if($rec->status == 'T')
                $str .= '<option value="T">เปิดใช้งาน</option><option value="F">ไม่เปิดใช้งาน</option>';
            else
                $str .= '<option value="F">ไม่เปิดใช้งาน</option><option value="T">เปิดใช้งาน</option>';
            $str .= '</select>';
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

            <button  class="btn btn-xs btn-primary btn-condensed btn-add-answer btn-tooltip" data-id="'.$rec->id.'" data-rel="tooltip" title="เพิ่มคำตอบ">
            <i class="ace-icon fa fa-plus-square bigger-120"></i>
            </button>
            ';
            return $str;
        })
        ->rawColumns(['text','status', 'action'])
        ->make(true);
    }
    public static function getString($string,$length){

        $value = strip_tags($string);

        /*ลบช่องว่าง และสไตล์ต่างๆ*/
        $search = array('&quot;',' ','&nbsp;');
        $replace = array('','','');
        $subject = $value;
        $value = str_replace($search, $replace, $subject);

        if($length > mb_strlen($value)){$dot='';}else{$dot='...';}
        return mb_substr($value,0,$length).$dot; /* UTF8_SUBSTR */
    }
    public function addQuestion() {
        $all = \App\Models\Question::where('status','T')->get();
        foreach ($all as $k => $v) {
            $result[$k]['id'] = $v->id;
            $result[$k]['text'] = $this->getString($v->text,50);
        }
        return json_encode($result);
    }
    public function AnswerRight(Request $request,$id) {
        $input_all = $request->all();
        $input_all['answer_id'] = $request->input('status');
        $input_all['created_at'] = date('Y-m-d H:i:s');
        $input_all['question_id'] = $id;
        unset($input_all['status']);
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $data_insert = $input_all;
                // print_r($data_insert);
                \App\Models\AnswerRight::where('question_id',$id)->delete();
                \App\Models\AnswerRight::insert($data_insert);
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
                \App\Models\question::where('id',$id)->update($data_insert);
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
        $return['title'] = 'เปลี่ยนสถานะ';
        return json_encode($return);
    }
    // public function QustionAnswer(){
    //     \DB::beginTransaction();
    //     try {
    //         \App\Models\Question::where('id',$id)->delete();
    //         \DB::commit();
    //         $return['status'] = 1;
    //         $return['content'] = 'สำเร็จ';
    //     } catch (Exception $e) {
    //         \DB::rollBack();
    //         $return['status'] = 0;
    //         $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
    //     }
    //     $return['title'] = 'ลบข้อมูล';
    //     return $return;
    // }

}
