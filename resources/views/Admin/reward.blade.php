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
    <section class="widget widhget-min-hight ">
        <div class="body no-margin table-responsive">
            <table class="table table-bordered table-hover table-sm" id="TableList">
                <col width="15%">
				<col width="35%">
				<col width="35%">
				<!-- <col width="10%"> -->
				<col width="15%">
                <thead>
                    <tr>
                        <th class="text-center">รหัส</th>
                        <th class="text-center">ภาพ</th>
                        <th class="text-center">ชื่อของรางวัล</th>
                        <!-- <th class="text-center">คงเหลือ</th> -->
                        <th class="text-center"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="FormAdd">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่ม {{$title_page or 'ข้อมูลใหม่'}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div id="photo" orakuploader="on"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="add_name">ชื่อของรางวัล</label>
                        <input type="text" class="form-control" name="name" id="add_name" required="" placeholder="name">
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
            <input type="hidden" name="id" id="edit_user_id">
            <form id="FormEdit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title_page or 'ข้อมูลใหม่'}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div id="photo_edit" orakuploader="on"></div>
                        </div>
                        <div class="form-group">
                            <label for="edit_name">ชื่อของรางวัล</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required="" placeholder="name">
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
<div class="modal fade" id="ModalImport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="FormImport">
                <input type="hidden" name="reward_id" id="import_user_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ขำเข้า {{$title_page or 'ข้อมูลใหม่'}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="import_name">จำนวนนำเข้า</label>
                        <input type="text" class="form-control" name="qty" id="import_qty" required="" placeholder="qty">
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
<div class="modal fade" id="ModalExport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="FormExport">
                <input type="hidden" name="reward_id" id="export_user_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ขำเข้า {{$title_page or 'ข้อมูลใหม่'}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="export_name">จำนวนนำออก</label>
                        <input type="text" class="form-control" name="qty" id="export_qty" required="" placeholder="qty">
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
        "url": url_gb+"/admin/Reward/Lists",
        "data": function ( d ) {
            //d.myKey = "myValue";
            // d.custom = $('#myInput').val();
            // etc
        }
    },
    "columns": [
        { "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
        // {"data" : "id","searchable":false,"orderable":false},
        {"data" : "img","searchable":false,"orderable":false},
        {"data" : "name"},
        // {"data" : "amount", "className": "text-right"},
        { "data": "action","className":"action text-center","searchable":false,"orderable":false }
    ]
});
$('body').on('click','.btn-add',function(data){
    // $('#ModalAdd').find('div.picture_delete').trigger('click');
    ShowModal('ModalAdd');
});
$('body').on('click','.btn-edit',function(data){
    var btn = $(this);
    btn.button('loading');
    var id = $(this).data('id');
    $('#edit_user_id').val(id);
    $.ajax({
        method : "GET",
        url : url_gb+"/admin/Reward/"+id,
        dataType : 'json'
    }).done(function(rec){
        $('#edit_name').val(rec.name);
        $('#edit_amount').val(rec.amount);
        $('body').find('#photo_edit').closest('.col-md-12').html('<div id="photo_edit" orakuploader="on"></div>');
        if(rec.path_picture){
            $('#photo_edit').orakuploader({
                orakuploader_path         : url_gb+'/',
                orakuploader_ckeditor         : true,
                orakuploader_use_dragndrop            : true,
                orakuploader_use_sortable   : true,
                orakuploader_main_path : 'uploads/temp/',
                orakuploader_thumbnail_path : 'uploads/temp/',
                orakuploader_thumbnail_real_path : asset_gb+'uploads/temp/',
                orakuploader_loader_image       : asset_gb+'images/loader.gif',
                orakuploader_no_image       : asset_gb+'images/no-image.jpg',
                orakuploader_add_label       : 'เลือกรูปภาพ',
                orakuploader_use_rotation: true,
                orakuploader_maximum_uploads : 1,
                orakuploader_hide_on_exceed : true,
                orakuploader_maximum_uploads : 0,
                orakuploader_attach_images: [rec.path_picture],
            });
        }else{
            $('#photo_edit').orakuploader({
                orakuploader_path         : url_gb+'/',
                orakuploader_ckeditor         : true,
                orakuploader_use_dragndrop            : true,
                orakuploader_use_sortable   : true,
                orakuploader_main_path : 'uploads/temp/',
                orakuploader_thumbnail_path : 'uploads/temp/',
                orakuploader_thumbnail_real_path : asset_gb+'uploads/temp/',
                orakuploader_loader_image       : asset_gb+'images/loader.gif',
                orakuploader_no_image       : asset_gb+'images/no-image.jpg',
                orakuploader_add_label       : 'เลือกรูปภาพ',
                orakuploader_use_rotation: true,
                orakuploader_maximum_uploads : 1,
                orakuploader_hide_on_exceed : true,
                orakuploader_maximum_uploads : 1,
            });
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

        name: {
            required: true,
        },
    },
    messages: {

        name: {
            required: "กรุณาระบุ",
        },
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
        var data_ar = removePriceFormat(form,$(form).serializeArray());
        btn.button("loading");
        $.ajax({
            method : "POST",
            url : url_gb+"/admin/Reward",
            dataType : 'json',
            data : $(form).serialize()
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
            $('#photo').parent().html('<div id="photo" orakuploader="on"></div>');
            $('#photo').orakuploader({
                orakuploader_path         : url_gb+'/',
                orakuploader_ckeditor         : true,
                orakuploader_use_dragndrop            : true,
                orakuploader_use_sortable   : true,
                orakuploader_main_path : 'uploads/temp/',
                orakuploader_thumbnail_path : 'uploads/temp/',
                orakuploader_thumbnail_real_path : asset_gb+'uploads/temp/',
                orakuploader_loader_image       : asset_gb+'images/loader.gif',
                orakuploader_no_image       : asset_gb+'images/no-image.jpg',
                orakuploader_add_label       : 'เลือกรูปภาพ',
                orakuploader_use_rotation: true,
                orakuploader_maximum_uploads : 1,
                orakuploader_hide_on_exceed : true,
                orakuploader_maximum_uploads : 1,
            });
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

        name: {
            required: true,
        },
    },
    messages: {

        name: {
            required: "กรุณาระบุ",
        },
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
            url : url_gb+"/admin/Reward/"+id,
            dataType : 'json',
            data : $(form).serialize()
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
$('#FormExport').validate({
    errorElement: 'div',
    errorClass: 'invalid-feedback',
    focusInvalid: false,
    rules: {

        qty: {
            required: true,
        },
    },
    messages: {

        qty: {
            required: "กรุณาระบุ",
        },
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
            url : url_gb+"/admin/Reward/Export",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            btn.button("reset");
            if(rec.status==1){
                TableList.api().ajax.reload();
                resetFormCustom(form);
                swal(rec.title,rec.content,"success");
                $('#ModalExport').modal('hide');
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
$('#FormImport').validate({
    errorElement: 'div',
    errorClass: 'invalid-feedback',
    focusInvalid: false,
    rules: {

        qty: {
            required: true,
        },
    },
    messages: {

        qty: {
            required: "กรุณาระบุ",
        },
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
            url : url_gb+"/admin/Reward/Import",
            dataType : 'json',
            data : $(form).serialize()
        }).done(function(rec){
            btn.button("reset");
            if(rec.status==1){
                TableList.api().ajax.reload();
                resetFormCustom(form);
                swal(rec.title,rec.content,"success");
                $('#ModalImport').modal('hide');
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
        title: "คุณต้องการลบของรางวัลใช่หรือไม่",
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
                url : url_gb+"/admin/Reward/Delete/"+id,
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
$('#photo').orakuploader({
    orakuploader_path         : url_gb+'/',
    orakuploader_ckeditor : true,
    orakuploader_use_dragndrop : true,
    orakuploader_use_sortable   : true,
    orakuploader_main_path : 'uploads/temp/',
    orakuploader_thumbnail_path : 'uploads/temp/',
    orakuploader_thumbnail_real_path : asset_gb+'uploads/temp/',
    orakuploader_loader_image       : asset_gb+'images/loader.gif',
    orakuploader_no_image       : asset_gb+'images/no-image.jpg',
    orakuploader_add_label       : 'เลือกรูปภาพ',
    orakuploader_use_rotation: true,
    orakuploader_maximum_uploads : 1,
    orakuploader_hide_on_exceed : true,
    orakuploader_maximum_uploads : 1,
});
$('body').on('click','.btn-import',function(e){
    e.preventDefault();
    var btn = $(this);
    var id = btn.data('id');
    $('#import_user_id').val(id);
    ShowModal('ModalImport');
});
$('body').on('click','.btn-export',function(e){
    e.preventDefault();
    var btn = $(this);
    var id = btn.data('id');
    $('#export_user_id').val(id);
    ShowModal('ModalExport');
});
</script>
@endsection
