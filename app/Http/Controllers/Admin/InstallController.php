<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;
class InstallController extends Controller
{
    public function index(){
    	$data['menu_all'] = \App\Models\AdminMenu::where('main_menu_id',0)->get();
        $data['main_menu'] = 'Install';
        $data['sub_menu'] = '';
        $data['title_page'] = 'Install';
        $data['tables'] = \DB::select('SHOW TABLES');
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        $data['ModelsAll'] = Storage::disk('models')->allFiles('');
        return view('Admin.Install.index',$data);
    }

    public function GetField($table){
    	if($table){
            $columns = \DB::getSchemaBuilder()->getColumnListing($table);
			$columns = \DB::select('show columns from ' . $table);
    		return json_encode($columns);
    	}else{
    		return '';
    	}
    }

    public function DefaultView(){
    	$data['menu_all'] = \App\Models\AdminMenu::where('main_menu_id',0)->get();
        $data['main_menu'] = 'Install';
        $data['sub_menu'] = '';
        $data['title_page'] = 'Install';
        $data['tables'] = \DB::select('SHOW TABLES');
        $data['menus'] = \App\Models\AdminMenu::ActiveMenu()->get();
        return view('Admin.Install.default',$data);
    }

    public function Install(Request $request){
    	$all = $request->all();
    	$name_controller = $request->input('name_controller');
        $name = str_replace("Controller", "", $name_controller);
    	$name_view = $request->input('name_view');
    	$name_model = $request->input('name_model');
    	$table = $request->input('table');
    	$fieldintable = $request->input('fieldintable');
    	$inputtype = $request->input('inputtype');
    	$field = $request->input('field');


    	$default_view = Storage::disk('local')->get('Installs/default_view.txt');



    	$theader = $this->CreateTheader($all);
    	$ColumsDatatable = $this->CreateColumsDatatable($all);
        $FieldForm = $this->CreateFieldForm($all);

        $FormAdd = '';
        $FormEdit = '';
        $ValidateRule = '';
        $ValidateText = '';
        $ControllerValidate = '';
        $SetValueToFormEdit = '';
        $EditColumnDataTable = '';
        $Script = '';
        $ControllerStore = '';
        $ControllerUpdate = '';
        $ControllerShow = '';
        $ControllerIndex = '';
        foreach($FieldForm as $key=>$val){
            $FormAdd.=$val['FormAdd'];
            $FormEdit.=$val['FormEdit'];
            $ValidateRule.=$val['ScriptValidate']['Rule'];
            $ValidateText.=$val['ScriptValidate']['Text'];
            $ControllerValidate.=$val['ControllerValidate'];
            $SetValueToFormEdit.=$val['SetValueToFormEdit'];
            $EditColumnDataTable.=$val['EditColumnDataTable'];
            $Script.=$val['Script'];
            $ControllerStore.=$val['ControllerStore'];
            $ControllerUpdate.=$val['ControllerUpdate'];
            $ControllerShow.=$val['ControllerShow'];
            $ControllerIndex.=$val['ControllerIndex'];
        }

    	$default_view = str_replace('##THEAD##', $theader, $default_view);
        $default_view = str_replace('##COLUMNSDATATABLE##', $ColumsDatatable, $default_view);
        $default_view = str_replace('##FORMADD##', $FormAdd, $default_view);
        $default_view = str_replace('##FORMEDIT##', $FormEdit, $default_view);
        $default_view = str_replace('##VALIDATERULE##', $ValidateRule, $default_view);
        $default_view = str_replace('##VALIDATETEXT##', $ValidateText, $default_view);

        $default_view = str_replace('##URLLIST##', $name.'/Lists', $default_view);
        $default_view = str_replace('##URLGETDETAIL##', $name, $default_view);
        $default_view = str_replace('##URLCREATE##', $name, $default_view);
        $default_view = str_replace('##URLCREATE##', $name, $default_view);
        $default_view = str_replace('##URLEDIT##', $name, $default_view);
        $default_view = str_replace('##URLDELETE##', $name.'/Delete', $default_view);

        $default_view = str_replace('##SETVALUETOFORMEDIT##',$SetValueToFormEdit , $default_view);
    	$default_view = str_replace('##Script##',$Script , $default_view);

    	$path = "Admin/".$name_view.".blade.php";
    	$result = Storage::disk('views')->put($path,$default_view);
        $this->CreateRoutes($name_controller);
        $this->InstallModel($all);
        $this->InstallController($all,$ControllerValidate,$EditColumnDataTable,$ControllerStore,$ControllerUpdate,$ControllerShow,$ControllerIndex,$name_controller);
        return 1;
    }

    public function InstallModel($ar){
    	$name = ucfirst($ar['name_model']);
    	$data = Storage::disk('local')->get('Installs/default_model.txt');
    	$data = str_replace('DefaultModel', $name , $data);
    	$path = $name.".php";
    	$check = Storage::disk('models')->exists($path);
        if(!$check){
            $result = Storage::disk('models')->put($path,$data);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }

    public function CreateTheader($ar){
    	$fieldintable = $ar['fieldintable'];
    	$str='<tr>'."\n";
    	foreach ($fieldintable as $key => $value) {
    		$str.='                                        ';
    		$str.='<th>'.$value.'</th>'."\n";
    	}
    	$str.='                                        ';
    	$str.='<th></th>'."\n";
    	$str.='                                    ';
    	$str.='</tr>';
    	return $str;
    }

	public function CreateColumsDatatable($ar){
		#COLUMNSDATATABLE
		$fieldintable = $ar['fieldintable'];
    	$str='';
    	foreach ($fieldintable as $key => $value) {
    		if($key>0){
				$str.='            ';
    		}

    		$str.='{"data" : "'.$value.'"},';

    		if($key < sizeof($fieldintable)-1){
				$str.="\n";
    		}
    	}
    	return $str;
	}

	public function CreateFieldForm($ar){
        $fields = $ar['field'];
        $inputtype = $ar['inputtype'];
		$required = isset($ar['required']) ? $ar['required']:[];
        $data = [];
		foreach ($fields as $key => $value) {
            if(in_array($value, $required)){
                $require = 'required=""';
            }else{
                $require = null;
            }

            switch($inputtype["'$value'"]){
                case "text":
                    $data[] = $this->CreateFormText($value,$require);
                break;
                case "Password":
                    $data[] = $this->CreateFormPassword($value,$require);
                break;
                case "Number":
                    $data[] = $this->CreateFormNumber($value,$require);
                break;
                case "date":
                    $data[] = $this->CreateFormDate($value,$require);
                break;
                case "DateTime":
                    $data[] = $this->CreateFormDateTime($value,$require);
                break;
                case "Price":
                    $data[] = $this->CreateFormPrice($value,$require);
                break;
                case "OrakSingle":
                    $data[] = $this->CreateFormOrakSingle($value,$require,$ar);
                break;
                case "OrakMulti":
                    $data[] = $this->CreateFormOrakMulti($value,$require,$ar);
                break;
                case "DateRange":
                    $data[] = $this->CreateFormDateRange($value,$require);
                break;
                case "DateTimeRange":
                    $data[] = $this->CreateFormDateTimeRange($value,$require);
                break;
                case "Editor":
                    $data[] = $this->CreateFormEditor($value,$require);
                break;
                case "TextArea":
                    $data[] = $this->CreateFormTextArea($value,$require);
                break;
                case "Checkbox":
                    $data[] = $this->CreateFormCheckbox($value,$require,$ar);
                break;
                case "DropDown":
                    $data[] = $this->CreateFormDropDown($value,$require,$ar);
                break;
                case "radio":
                    $data[] = $this->CreateFormRadio($value,$require,$ar);
                break;
                case "InputTag":
                    $data[] = $this->CreateFormInputTag($value,$require,$ar);
                break;
                case "File":
                    $data[] = $this->CreateFormFileSingle($value,$require,$ar);
                break;
            }
		}
        return $data;
	}

    public function CreateFormEditor($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <textarea id="add_'.$FieldName.'" name="'.$FieldName.'" class="form-control"></textarea>
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <textarea id="edit_'.$FieldName.'" name="'.$FieldName.'" class="form-control"></textarea>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "CKEDITOR.replace('add_".$FieldName."');\n    ";
        $data['Script'].= "CKEDITOR.replace('edit_".$FieldName."');\n";
        $data['SetValueToFormEdit'] = "CKEDITOR.instances['edit_".$FieldName."'].setData(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        return $data;
    }

    public function CreateFormCheckbox($FieldName,$required,$ar){
        $data['FormAdd'] = '
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" class="" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' value="'.$ar["checkboxhas"][$FieldName].'">
                    <label for="add_'.$FieldName.'">
                        '.$FieldName.'
                    </label>
                </div>
        ';
        $data['FormEdit'] = '
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" class="form-control" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' value="'.$ar["checkboxhas"][$FieldName].'">
                    <label for="edit_'.$FieldName.'" class="form-check-label">
                        '.$FieldName.'
                    </label>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "if(rec.".$FieldName."=='".$ar["checkboxhas"][$FieldName]."'){
                $('#edit_".$FieldName."').prop('checked','checked');
            }else{
                $('#edit_".$FieldName."').removeAttr('checked');
            }
                                        ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '$input_all[\''.$FieldName.'\'] = $request->input(\''.$FieldName.'\',\''.$ar["checkboxdonthas"][$FieldName].'\');';
        $data['ControllerUpdate'] = '$input_all[\''.$FieldName.'\'] = $request->input(\''.$FieldName.'\',\''.$ar["checkboxdonthas"][$FieldName].'\');';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormRadio($FieldName,$required,$ar){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label>'.$FieldName.'</label>
                    @foreach($'.$ar['SelectModel']['\''.$FieldName.'\''].'s as $'.$ar['SelectModel']['\''.$FieldName.'\''].')
                    <div class="radio radio-primary">
                        <input type="radio" name="'.$FieldName.'" id="add_'.$FieldName.'-{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}" value="{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}" '.$required.' >
                        <label for="add_'.$FieldName.'-{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}">
                            {{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->'.$ar['fieldcheckbox']['\''.$FieldName.'\''].'}}
                        </label>
                    </div>
                    @endforeach
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group radio-primary">
                    <label>'.$FieldName.'</label>
                    @foreach($'.$ar['SelectModel']['\''.$FieldName.'\''].'s as $'.$ar['SelectModel']['\''.$FieldName.'\''].')
                    <div class="radio">
                        <input type="radio" name="'.$FieldName.'" id="edit_'.$FieldName.'-{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}" value="{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}" '.$required.' >
                        <label for="edit_'.$FieldName.'-{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}">
                            {{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->'.$ar['fieldcheckbox']['\''.$FieldName.'\''].'}}
                        </label>
                    </div>
                    @endforeach
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['Script'].= "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."-'+rec.".$FieldName.").prop('checked','checked');\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '$data[\''.$ar['SelectModel']['\''.$FieldName.'\''].'s\'] = \App\Models\\'.$ar['SelectModel']['\''.$FieldName.'\''].'::get();';

        return $data;
    }

    public function CreateFormDropDown($FieldName,$required,$ar){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <select name="'.$FieldName.'" class="select2 form-control" tabindex="-1" data-placeholder="Select '.$FieldName.'" id="add_'.$FieldName.'" '.$required.' >
                        <option value="">Select '.$FieldName.'</option>
                        @foreach($'.$ar['SelectModel']['\''.$FieldName.'\''].'s as $'.$ar['SelectModel']['\''.$FieldName.'\''].')
                        <option value="{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}">{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->'.$ar['fieldcheckbox']['\''.$FieldName.'\''].'}}</option>
                        @endforeach
                    </select>
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <select name="'.$FieldName.'" data-placeholder="Select '.$FieldName.'" tabindex="-1" class="select2 form-control" id="edit_'.$FieldName.'" '.$required.' >
                        <option value="">Select '.$FieldName.'</option>
                        @foreach($'.$ar['SelectModel']['\''.$FieldName.'\''].'s as $'.$ar['SelectModel']['\''.$FieldName.'\''].')
                        <option value="{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->id}}">{{$'.$ar['SelectModel']['\''.$FieldName.'\''].'->'.$ar['fieldcheckbox']['\''.$FieldName.'\''].'}}</option>
                        @endforeach
                    </select>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "$('#add_".$FieldName."').select2();\n";
        $data['Script'].= "$('#edit_".$FieldName."').select2();\n";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '$data[\''.$ar['SelectModel']['\''.$FieldName.'\''].'s\'] = \App\Models\\'.$ar['SelectModel']['\''.$FieldName.'\''].'::get();';
        return $data;
    }

    public function CreateFormInputTag($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "$('#add_".$FieldName."').select2({
            tags: []
        });";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormText($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormPassword($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="password" class="form-control" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '$input_all[\''.$FieldName.'\'] = \\Hash::make($input_all[\''.$FieldName.'\']);';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormTextArea($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <textarea class="form-control" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'"></textarea>
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <textarea class="form-control" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'"></textarea>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormDateTimeRange($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control date-time-range" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control date-time-range" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormDateRange($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control date-range" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control date-range" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormDate($FieldName,$required){
        $data['FormAdd'] = '
                <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                <div class="input-group" data-date="{{date(\'Y-m-d\')}}">
                    <input type="text" value="" readonly="readonly" class="form-control form_date" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                    <span class="input-group-addon remove_date_time"><i class="glyphicon glyphicon-remove icon-remove"></i></span>
                    <span class="input-group-addon trigger_date_time" for="add_'.$FieldName.'"><i class="glyphicon glyphicon-calendar icon-calendar"></i></span>
                </div>
        ';
        $data['FormEdit'] = '
                <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                <div class="input-group" data-date="{{date(\'Y-m-d\')}}">
                    <input type="text" value="" readonly="readonly" class="form-control form_date" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                    <span class="input-group-addon remove_date_time"><i class="glyphicon glyphicon-remove icon-remove"></i></span>
                    <span class="input-group-addon trigger_date_time" for="edit_'.$FieldName.'"><i class="glyphicon glyphicon-calendar icon-calendar"></i></span>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormDateTime($FieldName,$required){
        $data['FormAdd'] = '
                <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                <div class="input-group" data-date="{{date(\'Y-m-d\')}}">
                    <input type="text" value="" readonly="readonly" class="form-control form_date_time" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                    <span class="input-group-addon remove_date_time"><i class="glyphicon glyphicon-remove icon-remove"></i></span>
                    <span class="input-group-addon trigger_date_time" for="add_'.$FieldName.'"><i class="glyphicon glyphicon-calendar icon-calendar"></i></span>
                </div>
        ';
        $data['FormEdit'] = '
                <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                <div class="input-group" data-date="{{date(\'Y-m-d\')}}">
                    <input type="text" value="" readonly="readonly" class="form-control form_date_time" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                    <span class="input-group-addon remove_date_time"><i class="glyphicon glyphicon-remove icon-remove"></i></span>
                    <span class="input-group-addon trigger_date_time" for="edit_'.$FieldName.'"><i class="glyphicon glyphicon-calendar icon-calendar"></i></span>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate']     = '';
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormNumber($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control number-only" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control number-only" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate'] = "";
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(rec.".$FieldName.");\n            ";
        $data['EditColumnDataTable'] = '
        ->addColumn(\''.$FieldName.'\',function($rec){
            if(is_numeric($rec->'.$FieldName.')){
                return number_format($rec->'.$FieldName.');
            }else{
                return $rec->'.$FieldName.';
            }
        })
        ';
        $data['ControllerStore'] = '
            if(isset($input_all[\''.$FieldName.'\'])){
                $input_all[\''.$FieldName.'\'] = str_replace(\',\', \'\', $input_all[\''.$FieldName.'\']);
            }
        ';
        $data['ControllerUpdate'] = '
            if(isset($input_all[\''.$FieldName.'\'])){
                $input_all[\''.$FieldName.'\'] = str_replace(\',\', \'\', $input_all[\''.$FieldName.'\']);
            }
        ';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormPrice($FieldName,$required){
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control number-only price" name="'.$FieldName.'" id="add_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="text" class="form-control number-only price" name="'.$FieldName.'" id="edit_'.$FieldName.'" '.$required.' placeholder="'.$FieldName.'">
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            '.$FieldName.': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            '.$FieldName.': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate'] = "";
        }
        $data['Script'] = "";
        $data['SetValueToFormEdit'] = "$('#edit_".$FieldName."').val(addNumformat(rec.".$FieldName."));\n            ";
        $data['EditColumnDataTable'] = '
        ->addColumn(\''.$FieldName.'\',function($rec){
            if(is_numeric($rec->'.$FieldName.')){
                return number_format($rec->'.$FieldName.',2);
            }else{
                return $rec->'.$FieldName.';
            }
        })
        ';
        $data['ControllerStore'] = '
            if(isset($input_all[\''.$FieldName.'\'])){
                $input_all[\''.$FieldName.'\'] = str_replace(\',\', \'\', $input_all[\''.$FieldName.'\']);
            }
        ';
        $data['ControllerUpdate'] = '
            if(isset($input_all[\''.$FieldName.'\'])){
                $input_all[\''.$FieldName.'\'] = str_replace(\',\', \'\', $input_all[\''.$FieldName.'\']);
            }
        ';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormOrakMulti($FieldName,$required,$ar){
        $name = ucfirst($ar['name_model']);
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <div id="orak_add_'.$FieldName.'">
                        <div id="add_'.$FieldName.'" orakuploader="on"></div>
                    </div>
                </div>
        ';
        $data['FormEdit'] = '
                <input type="hidden" name="org_'.$FieldName.'" id="org_'.$FieldName.'">
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <div id="orak_edit_'.$FieldName.'">
                        <div id="edit_'.$FieldName.'" orakuploader="on"></div>
                    </div>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            \''.$FieldName.'[]\': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            \''.$FieldName.'[]\': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate'] = "";
        }
        $data['Script'] = "
        $('#add_$FieldName').orakuploader({
            orakuploader_path               : url_gb+'/',
            orakuploader_ckeditor           : false,
            orakuploader_use_dragndrop      : true,
            orakuploader_main_path          : 'uploads/temp/',
            orakuploader_thumbnail_path     : 'uploads/temp/',
            orakuploader_thumbnail_real_path: asset_gb+'uploads/temp/',
            orakuploader_add_image          : asset_gb+'images/add.png',
            orakuploader_loader_image       : asset_gb+'images/loader.gif',
            orakuploader_no_image           : asset_gb+'images/no-image.jpg',
            orakuploader_add_label          : 'เลือกรูปภาพ',
            orakuploader_use_rotation       : false,
            orakuploader_maximum_uploads    : 100,
            orakuploader_hide_on_exceed     : true,
            orakuploader_field_name         : '".$FieldName."',
            orakuploader_finished           : function(){
                $(\".file\").addClass(\"multi_file\");
                centerModals();

            }
        });
        ";


        $data['SetValueToFormEdit'] = "$('#edit_$FieldName').closest('#orak_edit_".$FieldName."').html('<div id=\"edit_$FieldName\" orakuploader=\"on\"></div>');\n";
        $data['SetValueToFormEdit'].= "$('#org_$FieldName').val(rec.$FieldName);
        if(rec.$FieldName){
            var max_file = 100;
            var file = [];
                file[0] = rec.$FieldName;
            var $FieldName = $.parseJSON(rec.$FieldName);
        }else{
            var max_file = 100;
            var file = [];
            var $FieldName = $.parseJSON(rec.$FieldName);
        }
        $('#edit_$FieldName').orakuploader({
            orakuploader_path               : url_gb+'/',
            orakuploader_ckeditor           : false,
            orakuploader_use_dragndrop      : true,
            orakuploader_main_path          : 'uploads/temp/',
            orakuploader_thumbnail_path     : 'uploads/temp/',
            orakuploader_thumbnail_real_path: asset_gb+'uploads/temp/',
            orakuploader_add_image          : asset_gb+'images/add.png',
            orakuploader_loader_image       : asset_gb+'images/loader.gif',
            orakuploader_no_image           : asset_gb+'images/no-image.jpg',
            orakuploader_add_label          : 'เลือกรูปภาพ',
            orakuploader_use_rotation       : false,
            orakuploader_maximum_uploads    : max_file,
            orakuploader_hide_on_exceed     : true,
            orakuploader_attach_images      : ".$FieldName.",
            orakuploader_field_name         : '".$FieldName."',
            orakuploader_finished           : function(){
                $(\".file\").addClass(\"multi_file\");
                centerModals();
            }
        });
        $(\".file\").addClass(\"multi_file\");
        centerModals();
        ";
        $data['SetValueToFormEdit'].= "$('#org_".$FieldName."').val($FieldName)\n";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '
            $file_name = [];
            if(isset($input_all[\''.$FieldName.'\'])){
                foreach($input_all[\''.$FieldName.'\'] as $key=>$val){
                    //$input_all[\''.$FieldName.'\'] = $input_all[\''.$FieldName.'\'][$key];
                    if(Storage::disk("uploads")->exists("temp/".$input_all[\''.$FieldName.'\'][$key])&&!Storage::disk("uploads")->exists("'.$name.'/".$input_all[\''.$FieldName.'\'][$key])){
                        Storage::disk("uploads")->copy("temp/".$input_all[\''.$FieldName.'\'][$key],"'.$name.'/".$input_all[\''.$FieldName.'\'][$key]);
                        Storage::disk("uploads")->delete("temp/".$input_all[\''.$FieldName.'\'][$key]);
                        $file_name[] = $input_all[\''.$FieldName.'\'][$key];
                    }
                }
            }
            $input_all[\''.$FieldName.'\'] = json_encode($file_name);
        ';
        $data['ControllerUpdate'] = '
            $file_name = [];
            if(isset($input_all[\''.$FieldName.'\'])){
                //$input_all[\''.$FieldName.'\'] = $input_all[\''.$FieldName.'\'][0];
                //unset($input_all[\'org_'.$FieldName.'\']);
                foreach($input_all[\''.$FieldName.'\'] as $key=>$val){
                    if(Storage::disk("uploads")->exists("temp/".$input_all[\''.$FieldName.'\'][$key])&&!Storage::disk("uploads")->exists("'.$name.'/".$input_all[\''.$FieldName.'\'][$key])){
                        Storage::disk("uploads")->copy("temp/".$input_all[\''.$FieldName.'\'][$key],"'.$name.'/".$input_all[\''.$FieldName.'\'][$key]);
                        Storage::disk("uploads")->delete("temp/".$input_all[\''.$FieldName.'\'][$key]);
                    }
                    $file_name[] = $input_all[\''.$FieldName.'\'][$key];
                }
            }
            if(isset($input_all[\'org_'.$FieldName.'\'])){
                Storage::disk("uploads")->delete("temp/".$input_all[\'org_'.$FieldName.'\']);
            }
            unset($input_all[\'org_'.$FieldName.'\']);
            $input_all[\''.$FieldName.'\'] = json_encode($file_name);

        ';
        $data['ControllerShow'] = '
            if($result){
                if($result->'.$FieldName.'){
                    $'.$FieldName.'s = json_decode($result->'.$FieldName.');
                    if(sizeof($'.$FieldName.'s) > 0){
                        foreach($'.$FieldName.'s as $'.$FieldName.'){
                            if(Storage::disk("uploads")->exists("'.$name.'/".$'.$FieldName.')){
                                if(Storage::disk("uploads")->exists("temp/".$'.$FieldName.')){
                                    Storage::disk("uploads")->delete("temp/".$'.$FieldName.');
                                }
                                Storage::disk("uploads")->copy("'.$name.'/".$'.$FieldName.',"temp/".$'.$FieldName.');
                            }
                        }
                    }
                }
            }
        ';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormOrakSingle($FieldName,$required,$ar){
        $name = ucfirst($ar['name_model']);
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <div id="orak_add_'.$FieldName.'">
                        <div id="add_'.$FieldName.'" orakuploader="on"></div>
                    </div>
                </div>
        ';
        $data['FormEdit'] = '
                <input type="hidden" name="org_'.$FieldName.'" id="org_'.$FieldName.'">
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <div id="orak_edit_'.$FieldName.'">
                        <div id="edit_'.$FieldName.'" orakuploader="on"></div>
                    </div>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            \''.$FieldName.'[]\': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            \''.$FieldName.'[]\': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate'] = "";
        }
        $data['Script'] = "
        $('#add_$FieldName').orakuploader({
            orakuploader_path               : url_gb+'/',
            orakuploader_ckeditor           : false,
            orakuploader_use_dragndrop      : true,
            orakuploader_main_path          : 'uploads/temp/',
            orakuploader_thumbnail_path     : 'uploads/temp/',
            orakuploader_thumbnail_real_path: asset_gb+'uploads/temp/',
            orakuploader_add_image          : asset_gb+'images/add.png',
            orakuploader_loader_image       : asset_gb+'images/loader.gif',
            orakuploader_no_image           : asset_gb+'images/no-image.jpg',
            orakuploader_add_label          : 'เลือกรูปภาพ',
            orakuploader_use_rotation       : false,
            orakuploader_maximum_uploads    : 1,
            orakuploader_hide_on_exceed     : true,
            orakuploader_field_name         : '".$FieldName."',
            orakuploader_finished           : function(){

            }
        });
        ";


        $data['SetValueToFormEdit'] = "$('#edit_$FieldName').closest('#orak_edit_".$FieldName."').html('<div id=\"edit_$FieldName\" orakuploader=\"on\"></div>');\n";
        $data['SetValueToFormEdit'].= "$('#org_$FieldName').val(rec.$FieldName);
        if(rec.$FieldName){
            var max_file = 0;
            var file = [];
                file[0] = rec.$FieldName;
            var $FieldName = rec.$FieldName;
        }else{
            var max_file = 1;
            var file = [];
            var $FieldName = rec.$FieldName;
        }
        $('#edit_$FieldName').orakuploader({
            orakuploader_path               : url_gb+'/',
            orakuploader_ckeditor           : false,
            orakuploader_use_dragndrop      : true,
            orakuploader_main_path          : 'uploads/temp/',
            orakuploader_thumbnail_path     : 'uploads/temp/',
            orakuploader_thumbnail_real_path: asset_gb+'uploads/temp/',
            orakuploader_add_image          : asset_gb+'images/add.png',
            orakuploader_loader_image       : asset_gb+'images/loader.gif',
            orakuploader_no_image           : asset_gb+'images/no-image.jpg',
            orakuploader_add_label          : 'เลือกรูปภาพ',
            orakuploader_use_rotation       : false,
            orakuploader_maximum_uploads    : max_file,
            orakuploader_hide_on_exceed     : true,
            orakuploader_attach_images      : file,
            orakuploader_field_name         : '".$FieldName."',
            orakuploader_finished           : function(){

            }
        });
        ";
        $data['SetValueToFormEdit'].= "$('#org_".$FieldName."').val($FieldName)\n";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '
            if(isset($input_all[\''.$FieldName.'\'])&&isset($input_all[\''.$FieldName.'\'][0])){
                $input_all[\''.$FieldName.'\'] = $input_all[\''.$FieldName.'\'][0];
                if(Storage::disk("uploads")->exists("temp/".$input_all[\''.$FieldName.'\'])&&!Storage::disk("uploads")->exists("'.$name.'/".$input_all[\''.$FieldName.'\'])){
                    Storage::disk("uploads")->copy("temp/".$input_all[\''.$FieldName.'\'],"'.$name.'/".$input_all[\''.$FieldName.'\']);
                    Storage::disk("uploads")->delete("temp/".$input_all[\''.$FieldName.'\']);
                }
            }
        ';
        $data['ControllerUpdate'] = '
            if(isset($input_all[\''.$FieldName.'\'])&&isset($input_all[\''.$FieldName.'\'][0])){
                $input_all[\''.$FieldName.'\'] = $input_all[\''.$FieldName.'\'][0];
                unset($input_all[\'org_'.$FieldName.'\']);
                if(Storage::disk("uploads")->exists("temp/".$input_all[\''.$FieldName.'\'])){
                    if(Storage::disk("uploads")->exists("'.$name.'/".$input_all[\''.$FieldName.'\'])){
                        Storage::disk("uploads")->delete("'.$name.'/".$input_all[\''.$FieldName.'\']);
                    }
                    Storage::disk("uploads")->copy("temp/".$input_all[\''.$FieldName.'\'],"'.$name.'/".$input_all[\''.$FieldName.'\']);

                }
            }
            if(isset($input_all[\'org_'.$FieldName.'\'])){
                Storage::disk("uploads")->delete("temp/".$input_all[\'org_'.$FieldName.'\']);
            }
            unset($input_all[\'org_'.$FieldName.'\']);
        ';
        $data['ControllerShow'] = '
            if($result){
                if($result->'.$FieldName.'){
                    if(Storage::disk("uploads")->exists("'.$name.'/".$result->'.$FieldName.')){
                        if(Storage::disk("uploads")->exists("temp/".$result->'.$FieldName.')){
                            Storage::disk("uploads")->delete("temp/".$result->'.$FieldName.');
                        }
                        Storage::disk("uploads")->copy("'.$name.'/".$result->'.$FieldName.',"temp/".$result->'.$FieldName.');
                    }
                }
            }
        ';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateFormFileSingle($FieldName,$required,$ar){
        $name = ucfirst($ar['name_model']);
        $data['FormAdd'] = '
                <div class="form-group">
                    <label for="add_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="file" class="upload_file" id="add_'.$FieldName.'">
                    <input type="text" class="value_name_file" name="'.$FieldName.'">
                    <div class="preview_file"></div>
                </div>
        ';
        $data['FormEdit'] = '
                <div class="form-group">
                    <label for="edit_'.$FieldName.'">'.$FieldName.'</label>
                    <input type="file" class="upload_file" id="edit_'.$FieldName.'">
                    <input type="text" class="value_name_file edit_value_name_file_'.$FieldName.'" name="'.$FieldName.'">
                    <div class="preview_file preview_file_'.$FieldName.'"></div>
                </div>
        ';

        if($required){
            $data['ScriptValidate']['Rule'] = '
            \''.$FieldName.'[]\': {
                required: true,
            },';
            $data['ScriptValidate']['Text'] = '
            \''.$FieldName.'[]\': {
                required: "กรุณาระบุ",
            },';
            $data['ControllerValidate'] = "'".$FieldName."' => 'required',\n             ";
        }else{
            $data['ScriptValidate']['Rule'] = '';
            $data['ScriptValidate']['Text'] = '';
            $data['ControllerValidate'] = "";
        }
        $data['Script'] = "

        ";


        $data['SetValueToFormEdit'] = "$('.edit_value_name_file_".$FieldName."').val(rec.".$FieldName.");";
        $data['SetValueToFormEdit'].= "$('.preview_file_".$FieldName."').html('<img src=\"'+asset_gb+'uploads/'+rec.".$FieldName."+'\" class=\"preview-file\">');";
        $data['EditColumnDataTable'] = '';
        $data['ControllerStore'] = '';
        $data['ControllerUpdate'] = '';
        $data['ControllerShow'] = '';
        $data['ControllerIndex'] = '';
        return $data;
    }

    public function CreateRoutes($name){
        $name = str_replace("Controller", "", $name);
        $str= "Route::get('/".$name."', 'Admin\\".$name."Controller@index');\n";
        $data = Storage::disk('routes')->get('admin.php');
        if(!strpos($data,$str)){
            $str.= "        Route::get('/".$name."/Lists', 'Admin\\".$name."Controller@Lists');\n";
            $str.= "        Route::post('/".$name."', 'Admin\\".$name."Controller@store');\n";
            $str.= "        Route::get('/".$name."/{id}', 'Admin\\".$name."Controller@show');\n";
            $str.= "        Route::post('/".$name."/{id}', 'Admin\\".$name."Controller@update');\n";
            $str.= "        Route::post('/".$name."/Delete/{id}', 'Admin\\".$name."Controller@destroy');\n";
            $str.= "\n      ##ROUTEFORINSTALL##";
            $data = str_replace('##ROUTEFORINSTALL##', $str , $data);
            $path = "admin.php";
            Storage::disk('routes')->put($path,$data);
        }
        $result = \App\Models\AdminMenu::where('link',$name)->first();
        if(!$result){
            $data = [
                'link'=>$name,
                'name'=>$name,
                'main_menu_id'=>0
            ];
            $id = \App\Models\AdminMenu::insertGetId($data);
        }else{
            $id = $result->id;
        }
        $result = \App\Models\CrudPermission::where('menu_id',$id)->first();
        if(!$result){
            $data = [
                'menu_id'=> $id,
                'admin_user_id'=>1,
                'created'=>'T',
                'updated'=>'T',
                'deleted'=>'T',
                'readed'=>'T',
                'created_at'=>date('Y-m-d H:i:s'),
            ];
            \App\Models\CrudPermission::insert($data);
        }
    }

    public function InstallController($ar,$ControllerValidate,$EditColumnDataTable,$ControllerStore,$ControllerUpdate,$ControllerShow,$ControllerIndex){
        $name = $ar['name_controller'];
        $name_link = str_replace("Controller","",$name);
        $name_link = str_replace("controller","",$name_link);
        $model = ucfirst($ar['name_model']);
        $view = strtolower($ar['name_view']);
        $data = Storage::disk('local')->get('Installs/default_controller.txt');
        $data = str_replace('DefaultModel', $model , $data);
        $data = str_replace('DefaultController', $name , $data);
        $data = str_replace('ControllerValidate', $ControllerValidate , $data);
        $data = str_replace('DefaultView', $view , $data);
        $data = str_replace('ControllerStore', $ControllerStore , $data);
        $data = str_replace('ControllerUpdate', $ControllerUpdate , $data);
        $data = str_replace('ControllerShow', $ControllerShow , $data);
        $data = str_replace('##EDITCOLUMNDATATABLE##', $EditColumnDataTable , $data);
        $data = str_replace('ControllerIndex', $ControllerIndex , $data);
        $data = str_replace('##MAINMENU##', $name_link , $data);
        $data = str_replace('##SUBMENU##', $name_link , $data);
        $data = str_replace('##TITLEPAGE##', $name_link , $data);
        $path = "Admin/".$name.".php";
        $result = Storage::disk('controllers')->put($path,$data);
        return true;
        $check = Storage::disk('controllers')->exists($path);
        if(!$check){
            $result = Storage::disk('controllers')->put($path,$data);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }

    public function GetFieldDropDown(Request $request){
        $table_name = $request->input('table_name');
        $columns = \DB::getSchemaBuilder()->getColumnListing($table_name);
        $columns = \DB::select('show columns from ' . $table_name);
        return json_encode($columns);
    }
}
