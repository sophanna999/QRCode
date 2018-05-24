@extends('Admin.layouts.layout')
@section('css_bottom')
@endsection
@section('body')
		<h2 class="page-title">
            Admin Users
            <small>Statistics and more</small>
            <div class="pull-right">
                <button class="btn btn-success btn-add">
                    + เพิ่ม {{$title_page or '' }}
                </button>
            </div>
        </h2>
            <div class="row">
                <div class="col-lg-12">
                    <section class="widget widhget-min-hight">
                        <div class="body no-margin">
                            <table class="table table-bordered table-hover" id="TableList">
                                <thead>
                                    <tr>
                                        <th>main_menu_id</th>
                                        <th>name</th>
                                        <th>icon</th>
                                        <th>link</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                </div>
            </div>

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="FormAdd">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูล {{$title or 'ข้อมูลใหม่'}}</h4>
            </div>
            <div class="modal-body">
            	
                <div class="form-group">
                    <label for="add_main_menu_id">main_menu_id</label>
                    <select name="main_menu_id" class="select2 form-control" tabindex="-1" data-placeholder="Select main_menu_id" id="add_main_menu_id"  >
                        <option value="0">Select main_menu_id</option>
                        @foreach($AdminMenus as $AdminMenu)
                        <option value="{{$AdminMenu->id}}">{{$AdminMenu->name}}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="add_name">name</label>
                    <input type="text" class="form-control" name="name" id="add_name"  placeholder="name">
                </div>
        
                <div class="form-group">
                    <label for="add_icon">icon</label>
                    <input type="text" class="form-control" name="icon" id="add_icon"  placeholder="icon">
                </div>
        
                <div class="form-group">
                    <label for="add_link">link</label>
                    <input type="text" class="form-control" name="link" id="add_link"  placeholder="link">
                </div>
        
                <div class="form-group">
                    <label for="add_sort_id">sort_id</label>
                    <input type="text" class="form-control number-only" name="sort_id" id="add_sort_id"  placeholder="sort_id">
                </div>
        
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" class="" name="show" id="add_show" checked=""  value="T">
                    <label for="add_show">
                        show
                    </label>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" name="id" id="edit_user_id">
            <form id="FormEdit">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title or 'ข้อมูลใหม่'}}</h4>
            </div>
            <div class="modal-body">
            	
                <div class="form-group">
                    <label for="edit_main_menu_id">main_menu_id</label>
                    <select name="main_menu_id" data-placeholder="Select main_menu_id" tabindex="-1" class="select2 form-control" id="edit_main_menu_id"  >
                        <option value="0">Select main_menu_id</option>
                        @foreach($AdminMenus as $AdminMenu)
                        <option value="{{$AdminMenu->id}}">{{$AdminMenu->name}}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="edit_name">name</label>
                    <input type="text" class="form-control" name="name" id="edit_name"  placeholder="name">
                </div>
        
                <div class="form-group">
                    <label for="edit_icon">icon</label>
                    <input type="text" class="form-control" name="icon" id="edit_icon"  placeholder="icon">
                </div>
        
                <div class="form-group">
                    <label for="edit_link">link</label>
                    <input type="text" class="form-control" name="link" id="edit_link"  placeholder="link">
                </div>
        
                <div class="form-group">
                    <label for="edit_sort_id">sort_id</label>
                    <input type="text" class="form-control number-only" name="sort_id" id="edit_sort_id"  placeholder="sort_id">
                </div>
        
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" class="form-control" name="show" id="edit_show"  value="T">
                    <label for="edit_show" class="form-check-label">
                        show
                    </label>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> บันทึก</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js_bottom')
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>

     var TableList = $('#TableList').dataTable({
        "ajax": {
            "url": url_gb+"/admin/Menu/Lists",
            "data": function ( d ) {
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {"data" : "main_menu_id"},
            {"data" : "name"},
            {"data" : "icon"},
            {"data" : "link"},
            { "data": "action","className":"action text-center" }
        ]
    });
    $('body').on('click','.btn-add',function(data){
        ShowModal('ModalAdd');
    });
    $('body').on('click','.btn-edit',function(data){
        var btn = $(this);
        btn.button('loading');
        var id = $(this).data('id');
        $('#edit_user_id').val(id);
        $.ajax({
            method : "GET",
            url : url_gb+"/admin/Menu/"+id,
            dataType : 'json'
        }).done(function(rec){
            $('#edit_main_menu_id').val(rec.main_menu_id);
            $('#edit_name').val(rec.name);
            $('#edit_icon').val(rec.icon);
            $('#edit_link').val(rec.link);
            $('#edit_sort_id').val(rec.sort_id);
            if(rec.show=='T'){
                $('#edit_show').prop('checked','checked');
            }else{
                $('#edit_show').removeAttr('checked');
            }
                                        
            btn.button("reset");
            ShowModal('ModalEdit');
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });

    $('#FormAdd').validate({
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        focusInvalid: false,
        rules: {
        	
        },
        messages: {
        	
        },
        highlight: function (e) {
            validate_highlight(e);
        },
        success: function (e) {
            validate_success(e);
        },

        errorPlacement: function (error, element) {
            validate_errorplacement(error, element);
        },
        submitHandler: function (form) {
            if(CKEDITOR!==undefined){
                for ( instance in CKEDITOR.instances ){
                    CKEDITOR.instances[instance].updateElement();
                }
            }
            var btn = $(form).find('[type="submit"]');
            var data_ar = removePriceFormat(form,$(form).serializeArray());
            btn.button("loading");
            $.ajax({
                method : "POST",
                url : url_gb+"/admin/Menu",
                dataType : 'json',
                data : data_ar
            }).done(function(rec){
                btn.button("reset");
                if(rec.status==1){
                    TableList.api().ajax.reload();
                    resetFormCustom(form);
                    swal(rec.title,rec.content,"success");
                    $('#ModalAdd').modal('hide');
                }else{
                    swal(rec.title,rec.content,"error");
                }
            }).error(function(){
                swal("system.system_alert","system.system_error","error");
                btn.button("reset");
            });
        },
        invalidHandler: function (form) {

        }
    });

    $('#FormEdit').validate({
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        focusInvalid: false,
        rules: {
        	
        },
        messages: {
        	
        },
        highlight: function (e) {
            validate_highlight(e);
        },
        success: function (e) {
            validate_success(e);
        },

        errorPlacement: function (error, element) {
            validate_errorplacement(error, element);
        },
        submitHandler: function (form) {
            if(CKEDITOR!==undefined){
                for ( instance in CKEDITOR.instances ){
                    CKEDITOR.instances[instance].updateElement();
                }
            }
            var data_ar = removePriceFormat(form,$(form).serializeArray());
            var btn = $(form).find('[type="submit"]');
            var id = $('#edit_user_id').val();
            btn.button("loading");
            $.ajax({
                method : "POST",
                url : url_gb+"/admin/Menu/"+id,
                dataType : 'json',
                data : data_ar
            }).done(function(rec){
                btn.button("reset");
                if(rec.status==1){
                    TableList.api().ajax.reload();
                    resetFormCustom(form);
                    swal(rec.title,rec.content,"success");
                    $('#ModalEdit').modal('hide');
                }else{
                    swal(rec.title,rec.content,"error");
                }
            }).error(function(){
                swal("system.system_alert","system.system_error","error");
                btn.button("reset");
            });
        },
        invalidHandler: function (form) {

        }
    });

	$('body').on('click','.btn-delete',function(e){
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');
        swal({
            title: "คุณต้องการลบสินค้าใช่หรือไม่",
            text: "หากคุณลบจะไม่สามารถุเรียกคืนข้อมูกลับมาได้",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ใช่ ฉันต้องการลบ",
            cancelButtonText: "ยกเลิก",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        }, function(data) {
            if(data){
                $.ajax({
                    method : "POST",
                    url : url_gb+"/admin/Menu/Delete/"+id,
                    data : {ID : id}
                }).done(function(rec){
                    if(rec.status==1){
                        swal(rec.title,rec.content,"success");
                        TableList.api().ajax.reload();
                    }else{
                        swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
                    }
                }).error(function(data){
                    swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
                });
            }
        });
    });

    $('#add_main_menu_id').select2();
$('#edit_main_menu_id').select2();

</script>
@endsection