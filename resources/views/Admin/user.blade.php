@extends('Admin.layouts.layout')
@section('css_bottom')
@endsection
@section('body')
                <div class="col-lg-12">
                    <h2 class="page-title">
                        {{$title_page or '' }}
                        <div class="pull-right">
                            <button class="btn btn-success btn-add">
                                + เพิ่ม{{$title_page or '' }}
                            </button>
                        </div>
                    </h2>
                    <section class="widget widhget-min-hight">
                        <div class="body no-margin table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="TableUser">
                                <col width="10%">
                                <col width="60%">
                                <col width="15%">
                                <col width="15%">

                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">นามสกุล</th>
                                        <th class="text-center">ชื่อเล่น</th>
                                        <th class="text-center">เบอร์โทร</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </section>
                </div>


<div class="modal fade" id="ModalPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="FormChangePermssion">
                <input type="hidden" name="id" id="permssion_user_id" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">จัดการสิทธิ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center">เมนูไอดี</th>
                            <th rowspan="2" class="text-center">ชื่อเมนู</th>
                            <th colspan="4" class="text-center">สิทธิในการเขียน</th>
                        </tr>
                        <tr>
                            <th class="text-center">เข้าถึง</th>
                            <th class="text-center">สร้าง</th>
                            <th class="text-center">แก้ไข</th>
                            <th class="text-center">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menu_all as $key=>$menu)
                            <tr class="main">
                                <td class="text-center">{{$menu->id}}</td>
                                <td>{{$menu->name}}</td>
                                <td class="text-center">
                                    <label class="block">
                                        <input name="read[{{$menu->id}}]" value="{{$menu->id}}" type="checkbox" class="ace input read_{{$menu->id}}" />
                                        <span class="lbl bigger-120"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="block">
                                        <input name="create[{{$menu->id}}]" value="{{$menu->id}}" type="checkbox" class="ace input create_{{$menu->id}}" />
                                        <span class="lbl bigger-120"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="block">
                                        <input name="edit[{{$menu->id}}]" value="{{$menu->id}}" type="checkbox" class="ace input update_{{$menu->id}}" />
                                        <span class="lbl bigger-120"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="block">
                                        <input name="delete[{{$menu->id}}]" value="{{$menu->id}}" type="checkbox" class="ace input delete_{{$menu->id}}" />
                                        <span class="lbl bigger-120"></span>
                                    </label>
                                </td>
                            </tr>
                            @if($menu->SubMenu)
                                @foreach($menu->SubMenu as $key=>$sub_menu)
                                    <tr class="sub">
                                        <td class="text-center">{{$sub_menu->id}}</td>
                                        <td>{{$menu->name}} > {{$sub_menu->name}}</td>
                                        <td class="text-center">
                                            <label class="block">
                                                <input name="read[{{$sub_menu->id}}]" value="{{$sub_menu->id}}" type="checkbox" class="ace input read_{{$sub_menu->id}}" />
                                                <span class="lbl bigger-120"></span>
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label class="block">
                                                <input name="create[{{$sub_menu->id}}]" value="{{$sub_menu->id}}" type="checkbox" class="ace input create_{{$sub_menu->id}}" />
                                                <span class="lbl bigger-120"></span>
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label class="block">
                                                <input name="edit[{{$sub_menu->id}}]" value="{{$sub_menu->id}}" type="checkbox" class="ace input update_{{$sub_menu->id}}" />
                                                <span class="lbl bigger-120"></span>
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label class="block">
                                                <input name="delete[{{$sub_menu->id}}]" value="{{$sub_menu->id}}" type="checkbox" class="ace input delete_{{$sub_menu->id}}" />
                                                <span class="lbl bigger-120"></span>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
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
                <!-- <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            <div id="photo_add" orakuploader="on"></div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">ชื่อ</label>
                            <input type="text" class="form-control bg-gray-lighter " name="firstname" id="firstname" placeholder="ชื่อ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">นามสกุล</label>
                            <input type="text" class="form-control bg-gray-lighter" name="lastname" id="lastname" placeholder="นามสกุล">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nickname">ชื่อเล่น</label>
                            <input type="text" class="form-control bg-gray-lighter" name="nickname" id="nickname" placeholder="ชื่อเล่น">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">เบอร์โทร</label>
                            <input type="text" class="form-control bg-gray-lighter" name="mobile" id="mobile" placeholder="เบอร์โทร">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">ชื่อเพื่อเข้าสู่ระบบ</label>
                            <input type="text" class="form-control bg-gray-lighter" name="username" id="username" placeholder="ชื่อเพื่อเข้าสู่ระบบ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">รหัสผ่าน</label>
                            <input type="text" class="form-control bg-gray-lighter" name="password" id="exampleInputEmail1" placeholder="รหัสผ่าน">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
    						<label for="add_mobile">แผนก</label>
    						<select class="form-control bg-gray-lighter" name="department_id">
    							<option value="">กรุณาเลือก</option>
    							@foreach($department as $k => $v)
    							<option value="{{$v->department_id}}">{{$v->department_name}}</option>
    							@endforeach
    						</select>
    					</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
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
            <form id="FormEdit">
            <input type="hidden" name="id" id="edit_user_id" placeholder="ชื่อ">
            <input type="hidden" name="photo_old" id="photo_old">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title or 'ข้อมูลใหม่'}}</h4>
            </div>
            <div class="modal-body">
                <!-- <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            <div id="photo_edit" orakuploader="on"></div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">ชื่อ</label>
                            <input type="text" class="form-control bg-gray-lighter" name="firstname" id="edit_firstname" placeholder="ชื่อ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">นามสกุล</label>
                            <input type="text" class="form-control bg-gray-lighter" name="lastname" id="edit_lastname" placeholder="นามสกุล">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nickname">ชื่อเล่น</label>
                            <input type="text" class="form-control bg-gray-lighter" name="nickname" id="edit_nickname" placeholder="ชื่อเล่น">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="mobile">เบอร์โทร</label>
                        <input type="text" class="form-control" name="mobile" id="edit_mobile" placeholder="เบอร์โทร">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
    						<label for="add_mobile">แผนก</label>
    						<select class="form-control bg-gray-lighter" id="edit_departmene_id" name="department_id">
    							<option value="">กรุณาเลือก</option>
    							@foreach($department as $k => $v)
    							<option value="{{$v->department_id}}">{{$v->department_name}}</option>
    							@endforeach
    						</select>
    					</div>
                    </div>
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
<!-- Modal -->
<div class="modal fade" id="ModalChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="FormChangePassword">
            <input type="hidden" name="id" id="user_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">เปลีย่นรหัสผ่าน</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="password">รหัสผ่านใหม่</label>
                    <input type="text" class="form-control bg-gray-lighter" name="password" id="password" placeholder="รหัสผ่านใหม่">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js_bottom')
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>

     var TableUser = $('#TableUser').dataTable({
        "ajax": {
            "url": url_gb+"/admin/user/ListUser",
            "data": function ( d ) {
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            // { "data": "id" },
            { "data": "firstname","orderable": false , "searchable": false},
            { "data": "nickname" , "name":"firstname","visible" : false},
            { "data": "lastname" ,"name":"lastname", "visible" : false },
            { "data": "mobile" ,"name":"mobile"},
            { "data": "action","className":"action text-center","orderable": false , "searchable": false }
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
            url : url_gb+"/admin/user/"+id,
            dataType : 'json'
        }).done(function(rec){
            $('#edit_firstname').val(rec.firstname);
            $('#edit_lastname').val(rec.lastname);
            $('#edit_nickname').val(rec.nickname);
            $('#edit_mobile').val(rec.mobile);
            $('#edit_departmene_id').val(rec.department_id);
            // $('#photo_old').val(rec.photo_profile);
            if(rec.photo_profile){
                var photo = rec.photo_profile;
            }else{
                var photo = [];
            }
            btn.button("reset");
            /*$('#photo_edit').parent().html('<div id="photo_edit" orakuploader="on"></div>');
            $('#photo_edit').orakuploader({
                orakuploader_path         : url_gb+'/',
                orakuploader_ckeditor         : false,
                orakuploader_use_dragndrop       : true,
                orakuploader_main_path : 'uploads/temp/',
                orakuploader_thumbnail_path : 'uploads/temp/',
                orakuploader_thumbnail_real_path : asset_gb+'uploads/temp/',
                orakuploader_add_image       : asset_gb+'images/add.png',
                orakuploader_loader_image       : asset_gb+'images/loader.gif',
                orakuploader_no_image       : asset_gb+'images/no-image.jpg',
                orakuploader_add_label       : 'เลือกรูปภาพ',
                orakuploader_use_rotation: false,
                orakuploader_maximum_uploads : 0,
                orakuploader_hide_on_exceed : true,
                orakuploader_attach_images: [photo],
                orakuploader_finished : function(){

                }
            });*/
            ShowModal('ModalEdit');
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });
    $('body').on('click','.btn-change-password',function(data){
        var id = $(this).data('id');
        $('#user_id').val(id);
        ShowModal('ModalChangePassword');
    });

    $('#FormAdd').validate({
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        focusInvalid: false,
        rules: {
            firstname: {
                required: true,
            },
            nickname: {
                required: true,
            },
            mobile: {
                required: true,
            },
            username: {
                required: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            firstname: {
                required: 'กรุณาระบุ',
            },
            nickname: {
                required: 'กรุณาระบุ',
            },
            mobile: {
                required: 'กรุณาระบุ',
            },
            username: {
                required: 'กรุณาระบุ',
            },
            password: {
                required: 'กรุณาระบุ',
            }
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
            var btn = $(form).find('[type="submit"]');
            btn.button("loading");
            $.ajax({
                method : "POST",
                url : url_gb+"/admin/user",
                dataType : 'json',
                data : $(form).serialize()
            }).done(function(rec){
                btn.button("reset");
                if(rec.status==1){
                    TableUser.api().ajax.reload();
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
            firstname: {
                required: true,
            },
            nickname: {
                required: true,
            },
            mobile: {
                required: true,
            }
        },
        messages: {
            firstname: {
                required: 'กรุณาระบุ',
            },
            nickname: {
                required: 'กรุณาระบุ',
            },
            mobile: {
                required: 'กรุณาระบุ',
            }
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
            var btn = $(form).find('[type="submit"]');
            var id = $('#edit_user_id').val();
            btn.button("loading");
            $.ajax({
                method : "POST",
                url : url_gb+"/admin/user/checkedit/"+id,
                dataType : 'json',
                data : $(form).serialize()
            }).done(function(rec){
                btn.button("reset");
                if(rec.status==1){
                    TableUser.api().ajax.reload();
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

    $('#FormChangePassword').validate({
        errorElement: 'span',
        errorClass: 'help-block',
        focusInvalid: false,
        rules: {
            password: {
                required: true,
            }
        },
        messages: {
            password: {
                required: 'กรุณาระบุ',
            }
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
            var btn = $(form).find('[type="submit"]');
            var id = $(this).data('id');
            // $('#user_id').val(id);
            btn.button("loading");
            $.ajax({
                method : "POST",
                url : url_gb+"/admin/user/change_password",
                dataType : 'json',
                data : $(form).serialize()
            }).done(function(rec){
                btn.button("reset");
                if(rec.status==1){
                    resetFormCustom(form);
                    swal(rec.title,rec.content,"success");
                    $('#ModalChangePassword').modal('hide');
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

    $('body').on('click','.btn-change-permission',function(){
        var id = $(this).data('id');
        var btn = $(this);
        btn.button("loading");
        $('#permssion_user_id').val(id);
        $('#FormChangePermssion')[0].reset();
        $.ajax({
            method : "POST",
            url : url_gb+"/admin/GetPermission/"+id,
            dataType : 'json'
        }).done(function(rec){
            $.each(rec , function(){
                var menu_id = this.menu_id;
                var read = this.readed;
                var create = this.created;
                var update = this.updated;
                var deleted = this.deleted;
                if(create=='T'){
                    $('.create_'+menu_id).prop('checked','checked');
                }
                if(update=='T'){
                    $('.update_'+menu_id).prop('checked','checked');
                }
                if(deleted=='T'){
                    $('.delete_'+menu_id).prop('checked','checked');
                }
                if(read=='T'){
                    $('.read_'+menu_id).prop('checked','checked');
                }
                console.log(menu_id);
                console.log(read);
            });
            btn.button("reset");
            ShowModal('ModalPermission');
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });

    $('body').on('submit','#FormChangePermssion',function(e){
        e.preventDefault();
        var form = this;
        var btn = $(form).find('[type="submit"]');
        btn.button("loading");
        $.ajax({
            method : "POST",
            url : url_gb+"/admin/SetPermission",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            btn.button("reset");
            if(rec.status==1){
                resetFormCustom(form);
                swal(rec.title,rec.content,"success");
                $('#ModalPermission').modal('hide');
            }else{
                swal(rec.title,rec.content,"error");
            }
        }).error(function(){
            swal("system.system_alert","system.system_error","error");
            btn.button("reset");
        });
    });
    $('body').on('click','.btn-delete',function(e){
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');
        swal({
            title: "คุณต้องการลบผู้ใช้งานนี้ใช่หรือไม่",
            text: "หากคุณลบจะไม่สามารถเรียกคืนข้อมูกลับมาได้",
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
                    url : url_gb+"/admin/user/delete/"+id,
                    data : {ID : id}
                }).done(function(rec){
                    if(rec.status==1){
                        swal(rec.title,rec.content,"success");
                        TableUser.api().ajax.reload();
                    }else{
                        swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
                    }
                }).error(function(data){
                    swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
                });
            }
        });
    });

/*$('#photo_add').orakuploader({
    orakuploader_path         : url_gb+'/',
    orakuploader_ckeditor         : false,
    orakuploader_use_dragndrop       : true,
    orakuploader_main_path : 'uploads/temp/',
    orakuploader_thumbnail_path : 'uploads/temp/',
    orakuploader_thumbnail_real_path : asset_gb+'uploads/temp/',
    orakuploader_add_image       : asset_gb+'images/add.png',
    orakuploader_loader_image       : asset_gb+'images/loader.gif',
    orakuploader_no_image       : asset_gb+'images/no-image.jpg',
    orakuploader_add_label       : 'เลือกรูปภาพ',
    orakuploader_use_rotation: false,
    orakuploader_maximum_uploads : 1,
    orakuploader_hide_on_exceed : true,

    orakuploader_finished : function(){

    }
});*/

</script>
@endsection
