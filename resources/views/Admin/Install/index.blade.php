@extends('Admin.layouts.layout')

@section('css_bottom')
@endsection
@section('body')
		<h2 class="page-title">Install <small>Statistics and more</small></h2>
        <div class="row">
            <div class="col-lg-12">
                <section class="widget">
                    <header>
                        <h4>
                            Visits
                            <small>
                                Based on a three months data
                            </small>
                        </h4>
                    </header>
                    <div class="body">
                        <form autocomplete="off" id="FormCreate">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name Controller</label>
                                <input type="text" class="form-control" name="name_controller" placeholder="Name Controller" required="">
                            </div>
                            <div class="form-group" id="">
                                <label for="exampleInputPassword1">Name View</label>
                                <input type="text" class="form-control" name="name_view" placeholder="Name View" required="">
                            </div>
                            <div class="form-group" id="">
                                <label for="exampleInputPassword1">Model View</label>
                                <input type="text" class="form-control" name="name_model" placeholder="Model View" required="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Table</label>
                                <select name="table" id="table" name="table" class="form-control">
                                    <option value="">Select Table</option>
                                    @foreach($tables as $key=>$val)
                                    <option value="{{$val->{'Tables_in_'.strtolower(env('DB_DATABASE'))} }}">{{$val->{'Tables_in_'.strtolower(env('DB_DATABASE'))} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Field Show In Datatable</label>
                                <div id="ListFieldShowInTable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Field Show In Form</label>
                                <div id="ListFieldShowInForm">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>

<div class="hide" id="DefaultListFieldShowInForm">
    <div class="row row-hover">
        <div class="col-sm-3">
            <div class="checkbox">
                <input id="checkbox1" class="FieldInForm" type="checkbox" name="field[]" value="field">
                <label for="checkbox1">
                    NameField
                </label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="checkbox">
                <input id="checkbox2" name="required[]" type="checkbox" value="required" >
                <label for="checkbox2">
                    บังคับ
                </label>
            </div>
        </div>
        <div class="col-sm-2">
          <select name="inputtype" class="form-control select-type-input" data-id="NameField" disabled>
              <option value="">Select Type Input</option>
              <option value="text">Text</option>
              <option value="Password">Password</option>
              <option value="radio">Radio</option>
              <option value="Checkbox">Checkbox</option>
              <option value="TextArea">Text Area</option>
              <option value="Editor">Editor</option>
              <option value="date">Date</option>
              <option value="DateTime">Date Time</option>
              <option value="Number">Number</option>
              <option value="Price">Price</option>
              <option value="SelectTag">Select Tag</option>
              <option value="InputTag">Input Tag</option>
              <option value="Province" disabled="" class="hide" >Province</option>
              <option value="Amphur" disabled="" class="hide" >Amphur</option>
              <option value="DropDown">DropDown</option>
              <option value="File">FileSingle</option>
              <option value="FileMulti">FileMulti</option>
              <option value="DateRange">Date Range</option>
              <option value="DateTimeRange">Date Time Range</option>
              <option value="OrakSingle">Orakuploader Single File</option>
              <option value="OrakMulti">Orakuploader Multi File</option>
          </select>
        </div>
        <div class="col-md-5">

        </div>
    </div>
</div>
<div class="hide" id="DefaultListFieldShowInTable">
    <div class="checkbox">
        <input id="checkbox3" name="fieldintable[]" type="checkbox" value="valuefieldintable" >
        <label for="checkbox3">
            NameField
        </label>
    </div>
</div>
<div class="hide" id="DefaultCheckBox">
    <div class="row">
        <div class="col-md-6">
            <input name="checkboxhas[##FieldName##]" class="form-control" placeholder="กรณีมีค่า" value="">
        </div>
        <div class="col-md-6">
            <input name="checkboxdonthas[##FieldName##]" class="form-control" placeholder="กรณีไม่มีค่า" value="">
        </div>
    </div>
</div>
<div class="hide" id="DefaultModel">
    <div class="row">
        <div class="col-md-4">
            <select name="SelectModel['##FieldName##']" id="" class="form-control SelectModel">
                <option value="">SelectModel</option>
                @foreach($ModelsAll as $model)
                    <option value="{{substr($model,0,-4)}}">{{substr($model,0,-4)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="table" class="form-control table-dropdown" data-field-name="##FieldName##">
                <option value="">Select Table</option>
                @foreach($tables as $key=>$val)
                <option value="{{$val->{'Tables_in_'.strtolower(env('DB_DATABASE'))} }}">{{$val->{'Tables_in_'.strtolower(env('DB_DATABASE'))} }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 column-dropdown">

        </div>
    </div>
</div>
@endsection
@section('js_bottom')
<script>
    $('body').on('change','#table',function(){
        var table = $(this).val();
        console.log(table);
        $.ajax({
            method : "POST",
            url : url_gb+"/admin/Install/GetField/"+table,
            dataType : 'json'
        }).done(function(rec){
            var str = '';
            var strx = '';
            var DefaultListFieldShowInForm = $('#DefaultListFieldShowInForm').html();
            var DefaultListFieldShowInTable = $('#DefaultListFieldShowInTable').html();
            $.each(rec,function(k,v){
                var xxx = DefaultListFieldShowInForm.replace('value="field"','value="'+v.Field+'"');
                xxx = xxx.replace('name="inputtype"','name="inputtype[\''+v.Field+'\']"');
                xxx = xxx.replace('value="required"','value="'+v.Field+'"');
                xxx = xxx.replace('NameField',v.Field);
                xxx = xxx.replace('NameField',v.Field);
                xxx = xxx.replace('checkbox1','checkbox_1_'+v.Field);
                xxx = xxx.replace('checkbox1','checkbox_1_'+v.Field);
                xxx = xxx.replace('checkbox2','checkbox_2_'+v.Field);
                xxx = xxx.replace('checkbox2','checkbox_2_'+v.Field);


                str+=xxx;
                var yyy = DefaultListFieldShowInTable.replace('valuefieldintable',v.Field);
                yyy = yyy.replace('NameField',v.Field);
                yyy = yyy.replace('checkbox3','checkbox_3_'+v.Field);
                yyy = yyy.replace('checkbox3','checkbox_3_'+v.Field);
                strx+=yyy;
            });
            $('#ListFieldShowInForm').html(str);
            $('#ListFieldShowInTable').html(strx);
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });
    $('body').on('submit','#FormCreate',function(e){
        e.preventDefault();
        $.ajax({
            method : "POST",
            url : url_gb+"/admin/Install",
            dataType : 'json',
            data : $(this).serialize()
        }).done(function(rec){
            swal("Create","Success","success");
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });

    $('body').on('click','.FieldInForm',function(e){
        var check = $(this).prop('checked');
        if(check){
            $(this).closest('.row').find('select').prop('required','required').removeAttr('disabled');
        }else{
            $(this).closest('.row').find('select').removeAttr('required').attr('disabled','disabled');
        }
    });

    $('body').on('change','.select-type-input',function(){
        var name_field = $(this).data('id');
        console.log(name_field);
        $(this).parent().next().html('');
        if($(this).val()=='DropDown'||$(this).val()=='radio'){
            var DefaultModel = $("#DefaultModel").html();
            DefaultModel = DefaultModel.replace('##FieldName##',name_field);
            DefaultModel = DefaultModel.replace('##FieldName##',name_field);
            $(this).parent().next().html(DefaultModel);
        }else if($(this).val()=='Checkbox'){
            var DefaultCheckBox = $('#DefaultCheckBox').html();
            DefaultCheckBox = DefaultCheckBox.replace('##FieldName##',name_field);
            DefaultCheckBox = DefaultCheckBox.replace('##FieldName##',name_field);
            $(this).parent().next().html(DefaultCheckBox);
        }
    });


    $('body').on('change','.table-dropdown',function(){
        var table_name = $(this).val();
        var field_name = $(this).data('field-name');
        var ele = $(this);
        $.ajax({
            method : "POST",
            url : url_gb+"/admin/Install/GetFieldDropDown",
            dataType : 'json',
            data : {table_name : table_name}
        }).done(function(rec){
            var str = '<select name="fieldcheckbox[\''+field_name+'\']" class="form-control">';
                str+= '<option value="">เลือกฟิล</option>';
                $.each(rec,function(){
                    str+= '<option value="'+this.Field+'">'+this.Field+'</option>';
                });
                str+= '</select>';
            ele.closest('.row').find('.column-dropdown').html(str);
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });


</script>
@endsection