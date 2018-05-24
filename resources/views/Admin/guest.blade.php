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
			<table class="table table-bordered table-hover table-sm" id="TableList">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<th class="text-center">กิจกรรม</th>
						<th class="text-center">โทรศัพท์</th>
						<th class="text-center">ชื่อ</th>
						<th class="text-center">นามสกุล</th>
						<th class="text-center">อีเมล</th>
						<th class="text-center">บริษัท</th>
						<th class="text-center">เภสัช?</th>
						<th></th>
					</tr>
				</thead>
			</table>
		</div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="FormAdd">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">เพิ่ม {{$title_page or 'ข้อมูลใหม่'}}</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="add_phone">โทรศัพท์</label>
						<input type="text" class="form-control" name="phone" id="add_phone" required="" placeholder="phone">
					</div>

					<div class="form-group">
						<label for="add_firstname">ชื่อ</label>
						<input type="text" class="form-control" name="firstname" id="add_firstname" required="" placeholder="firstname">
					</div>

					<div class="form-group">
						<label for="add_lastname">นามสกุล</label>
						<input type="text" class="form-control" name="lastname" id="add_lastname" required="" placeholder="lastname">
					</div>

					<div class="form-group">
						<label for="add_email">อีเมล</label>
						<input type="text" class="form-control" name="email" id="add_email" required="" placeholder="email">
					</div>

					<div class="form-group">
						<label for="add_company">บริษัท</label>
						<input type="text" class="form-control" name="company" id="add_company" required="" placeholder="company">
					</div>

					<div class="form-group">
						<label for="add_guest_type_id">ประเภทผู้เข้าร่วม</label>
						<div class="form-check form-check-inline">
							<input class="checkbox-circle" type="radio" name="guest_type_id" id="add_guest_type_id" value="T">
							<label class="form-check-label" for="inlineRadio1">เภสัชกร</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="checkbox-circle" type="radio" name="guest_type_id" id="add_guest_type_id" value="F">
							<label class="form-check-label" for="inlineRadio2">บุคคลทัวไป</label>
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
			<input type="hidden" name="id" id="edit_user_id">
			<form id="FormEdit">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title_page or 'ข้อมูลใหม่'}}</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="edit_phone">โทรศัพท์</label>
						<input type="text" class="form-control" name="phone" id="edit_phone" required="" placeholder="phone">
					</div>

					<div class="form-group">
						<label for="edit_firstname">ชื่อ</label>
						<input type="text" class="form-control" name="firstname" id="edit_firstname" required="" placeholder="firstname">
					</div>

					<div class="form-group">
						<label for="edit_lastname">นามสกุล</label>
						<input type="text" class="form-control" name="lastname" id="edit_lastname" required="" placeholder="lastname">
					</div>

					<div class="form-group">
						<label for="edit_email">อีเมล</label>
						<input type="text" class="form-control" name="email" id="edit_email" required="" placeholder="email">
					</div>

					<div class="form-group">
						<label for="edit_company">บริษัท</label>
						<input type="text" class="form-control" name="company" id="edit_company" required="" placeholder="company">
					</div>

					<div class="form-group">
						<label for="add_guest_type_id">ประเภทผู้เข้าร่วม</label>
						<div class="form-check form-check-inline">
							<input class="checkbox-circle" type="radio" name="guest_type_id" id="edit_guest_type_id" value="T">
							<label class="form-check-label" for="inlineRadio1">เภสัชกร</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="checkbox-circle" type="radio" name="guest_type_id" id="edit_guest_type_id" value="F">
							<label class="form-check-label" for="inlineRadio2">บุคคลทัวไป</label>
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
@endsection
@section('js_bottom')
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>
var TableList = $('#TableList').dataTable({
	"ajax": {
		"url": url_gb+"/admin/Guest/Lists",
		"data": function ( d ) {
			//d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{ "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
		{"data" : "activity_name", "name" : "activity.activity_name"},
		{"data" : "phone"},
		{"data" : "firstname"},
		{"data" : "lastname"},
		{"data" : "email"},
		{"data" : "company"},
		{"data" : "guest_type_id","searchable":false,"orderable":false},
		{ "data": "action","className":"action text-center","searchable":false,"orderable":false }
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
		url : url_gb+"/admin/Guest/"+id,
		dataType : 'json'
	}).done(function(rec){
		$('#edit_phone').val(rec.phone);
		$('#edit_firstname').val(rec.firstname);
		$('#edit_lastname').val(rec.lastname);
		$('#edit_email').val(rec.email);
		$('#edit_company').val(rec.company);
		$('input[value="'+rec.guest_type_id+'"]').prop('checked',true);
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

		phone: {
			required: true,
		},
		firstname: {
			required: true,
		},
		lastname: {
			required: true,
		},
		email: {
			required: true,
		},
		company: {
			required: true,
		},
		guest_type_id: {
			required: true,
		},
	},
	messages: {

		phone: {
			required: "กรุณาระบุ",
		},
		firstname: {
			required: "กรุณาระบุ",
		},
		lastname: {
			required: "กรุณาระบุ",
		},
		email: {
			required: "กรุณาระบุ",
		},
		company: {
			required: "กรุณาระบุ",
		},
		guest_type_id: {
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
			url : url_gb+"/admin/Guest",
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

		phone: {
			required: true,
		},
		firstname: {
			required: true,
		},
		lastname: {
			required: true,
		},
		email: {
			required: true,
		},
		company: {
			required: true,
		},
		guest_type_id: {
			required: true,
		},
	},
	messages: {

		phone: {
			required: "กรุณาระบุ",
		},
		firstname: {
			required: "กรุณาระบุ",
		},
		lastname: {
			required: "กรุณาระบุ",
		},
		email: {
			required: "กรุณาระบุ",
		},
		company: {
			required: "กรุณาระบุ",
		},
		guest_type_id: {
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
			url : url_gb+"/admin/Guest/"+id,
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

$('body').on('click','.btn-delete',function(e){
	e.preventDefault();
	var btn = $(this);
	var id = btn.data('id');
	swal({
		title: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่",
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
				url : url_gb+"/admin/Guest/Delete/"+id,
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


</script>
@endsection
