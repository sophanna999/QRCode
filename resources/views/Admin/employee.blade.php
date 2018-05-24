@extends('Admin.layouts.layout')
@section('css_bottom')
@endsection
@section('body')
<h2 class="page-title">
	{{$title_page or '' }}
	<div class="pull-right">
		<button class="btn btn-success btn-add">
			+ เพิ่ม {{$title_page or '' }}
		</button>
	</div>
</h2>
<div class="col-lg-12">
	<section class="widget widhget-min-hight">
		<div class="body no-margin table-responsive">
			<table class="table table-bordered table-hover" id="TableList">
				<thead>
					<tr>
						<th>ชื่อ</th>
						<th>นามสกุล</th>
						<th>ชื่อเล่น</th>
						<th>แผนก</th>
						<th>มือถือ</th>
						<th>ที่อยู่</th>
						<th>อีเมล</th>
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
						<label for="add_firstname">ชื่อ</label>
						<input type="text" class="form-control" name="firstname" id="add_firstname"  placeholder="firstname">
					</div>

					<div class="form-group">
						<label for="add_lastname">นามสกุล</label>
						<input type="text" class="form-control" name="lastname" id="add_lastname"  placeholder="lastname">
					</div>

					<div class="form-group">
						<label for="add_nickname">ชื่อเล่น</label>
						<input type="text" class="form-control" name="nickname" id="add_nickname"  placeholder="nickname">
					</div>

					<div class="form-group">
						<label for="add_mobile">มือถือ</label>
						<input type="text" class="form-control number-only" name="mobile" id="add_mobile"  placeholder="mobile">
					</div>

					<div class="form-group">
						<label for="add_mobile">แผนก</label>
						<select class="form-control" name="department_id">
							<option value="">กรุณาเลือก</option>
							@foreach($department as $k => $v)
							<option value="{{$v->department_id}}">{{$v->department_name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="add_address">ที่อยู่</label>
						<input type="text" class="form-control" name="address" id="add_address"  placeholder="address">
					</div>

					<div class="form-group">
						<label for="add_email">อีเมล</label>
						<input type="text" class="form-control" name="email" id="add_email"  placeholder="email">
					</div>

					<div class="form-group">
						<label for="add_password">รหัสผ่าน</label>
						<input type="password" class="form-control" name="password" id="add_password"  placeholder="password">
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
					<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title_page or 'ข้อมูลใหม่'}}</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="edit_firstname">ชื่อ</label>
						<input type="text" class="form-control" name="firstname" id="edit_firstname"  placeholder="firstname">
					</div>

					<div class="form-group">
						<label for="edit_lastname">นามสกุล</label>
						<input type="text" class="form-control" name="lastname" id="edit_lastname"  placeholder="lastname">
					</div>

					<div class="form-group">
						<label for="edit_nickname">ชื่อเล่น</label>
						<input type="text" class="form-control" name="nickname" id="edit_nickname"  placeholder="nickname">
					</div>

					<div class="form-group">
						<label for="add_mobile">แผนก</label>
						<select class="form-control" name="department_id" id="edit_departmene_id">
							<option value="">กรุณาเลือก</option>
							@foreach($department as $k => $v)
							<option value="{{$v->department_id}}">{{$v->department_name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="edit_mobile">มือถือ</label>
						<input type="text" class="form-control number-only" name="mobile" id="edit_mobile"  placeholder="mobile">
					</div>

					<div class="form-group">
						<label for="edit_address">ที่อยู่</label>
						<input type="text" class="form-control" name="address" id="edit_address"  placeholder="address">
					</div>

					<div class="form-group">
						<label for="edit_email">อีเมล</label>
						<input type="text" class="form-control" name="email" id="edit_email"  placeholder="email">
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
		"url": url_gb+"/admin/Employee/Lists",
		"data": function ( d ) {
			//d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{"data" : "firstname"},
		{"data" : "lastname"},
		{"data" : "nickname"},
		{"data" : "department_name","searchable":false,"orderable":false},
		{"data" : "mobile"},
		{"data" : "address"},
		{"data" : "email"},
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
		url : url_gb+"/admin/Employee/"+id,
		dataType : 'json'
	}).done(function(rec){
		$('#edit_firstname').val(rec.firstname);
		$('#edit_lastname').val(rec.lastname);
		$('#edit_nickname').val(rec.nickname);
		$('#edit_mobile').val(rec.mobile);
		$('#edit_address').val(rec.address);
		$('#edit_email').val(rec.email);
		$('#edit_departmene_id').val(rec.department_id);

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
		firstname: {
			required: true,
		},
		// lastname: {
		//     required: true,
		// },
		// nickname: {
		//     required: true,
		// },
		// mobile: {
		//     required: true,
		// },
		// address: {
		//     required: true,
		// },
		email: {
			required: true,
		},
		password: {
			required: true,
		},
	},
	messages: {

		firstname: {
			required: "กรุณาระบุ",
		},
		// lastname: {
		//     required: "กรุณาระบุ",
		// },
		// nickname: {
		//     required: "กรุณาระบุ",
		// },
		// mobile: {
		//     required: "กรุณาระบุ",
		// },
		// address: {
		//     required: "กรุณาระบุ",
		// },
		email: {
			required: "กรุณาระบุ",
		},
		password: {
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
			url : url_gb+"/admin/Employee",
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
		firstname: {
			required: true,
		},
		// lastname: {
		//     required: true,
		// },
		// nickname: {
		//     required: true,
		// },
		// mobile: {
		//     required: true,
		// },
		// address: {
		//     required: true,
		// },
		email: {
			required: true,
		},
		password: {
			required: true,
		},
	},
	messages: {
		firstname: {
			required: "กรุณาระบุ",
		},
		// lastname: {
		//     required: "กรุณาระบุ",
		// },
		// nickname: {
		//     required: "กรุณาระบุ",
		// },
		// mobile: {
		//     required: "กรุณาระบุ",
		// },
		// address: {
		//     required: "กรุณาระบุ",
		// },
		email: {
			required: "กรุณาระบุ",
		},
		password: {
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
		if(CKEDITOR!==undefined){
			for ( instance in CKEDITOR.instances ){
				CKEDITOR.instances[instance].updateElement();
			}
		}
		var btn = $(form).find('[type="submit"]');
		var id = $('#edit_user_id').val();
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/Employee/"+id,
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
				url : url_gb+"/admin/Employee/Delete/"+id,
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
