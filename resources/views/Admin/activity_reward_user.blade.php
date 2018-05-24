@extends('Admin.layouts.layout')
@section('css_bottom')
@endsection
@section('body')
<div class="col-lg-12">
	<h2 class="page-title">
		{{$title_page or '' }}
		<div class="pull-right">
			<!-- <button class="btn btn-success btn-add">
			+ เพิ่ม {{$title_page or '' }}
		</button> -->
		</div>
	</h2>
	<section class="widget widhget-min-hight">
		<div class="body no-margin table-responsive">
			<table class="table table-bordered table-hover table-sm" id="TableList">
				<col width="10%">
				<col width="20%">
				<col width="5%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
				<col width="10%">
				<col width="10%">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<!-- <th class="text-center">qrcode</th> -->
						<th class="text-center">กิจกรรม</th>
						<th class="text-center">ยืนยัน</th>
						<th class="text-center">ของรางวัล</th>
						<th class="text-center">ผู้เข้าร่วมกิจกรรม</th>
						<!-- <th class="text-center">firstname</th>
						<th class="text-center">lastname</th> -->
						<th class="text-center">พนักงาน</th>
						<!-- <th class="text-center"staff_firstname</th>
						<th class="text-center">staff_lastname</th> -->
						<th class="text-center">วันที่กิจกรรม</th>
						<th class="text-center">วันที่ยืนยัน</th>
						<!-- <th class="text-center"></th> -->
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
						<label for="add_activity_id">activity_id</label>
						<input type="text" class="form-control" name="activity_id" id="add_activity_id"  placeholder="activity_id">
					</div>

					<div class="form-group">
						<label for="add_reward_id">reward_id</label>
						<input type="text" class="form-control" name="reward_id" id="add_reward_id"  placeholder="reward_id">
					</div>

					<div class="form-group">
						<label for="add_user_id">user_id</label>
						<input type="text" class="form-control" name="user_id" id="add_user_id"  placeholder="user_id">
					</div>

					<div class="form-group">
						<label for="add_staff_id">staff_id</label>
						<input type="text" class="form-control" name="staff_id" id="add_staff_id"  placeholder="staff_id">
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
						<label for="edit_activity_id">activity_id</label>
						<input type="text" class="form-control" name="activity_id" id="edit_activity_id"  placeholder="activity_id">
					</div>

					<div class="form-group">
						<label for="edit_reward_id">reward_id</label>
						<input type="text" class="form-control" name="reward_id" id="edit_reward_id"  placeholder="reward_id">
					</div>

					<div class="form-group">
						<label for="edit_user_id">user_id</label>
						<input type="text" class="form-control" name="user_id" id="edit_user_id"  placeholder="user_id">
					</div>

					<div class="form-group">
						<label for="edit_staff_id">staff_id</label>
						<input type="text" class="form-control" name="staff_id" id="edit_staff_id"  placeholder="staff_id">
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
		"url": url_gb+"/admin/ActivityRewardUser/Lists",
		"data": function ( d ) {
			//d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{ "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
		// {"data" : "id","searchable":false,"orderable":false},
		// {"data" : "qrcode","searchable":false,"orderable":false},
		{"data" : "activity_name", "name" : "activity.activity_name"},
		{"data" : "url","searchable":false,"orderable":false,"className":"text-center"},
		{"data" : "name", "name" : "reward.name"},
		{"data" : "user_id","searchable":false,"orderable":false},
		// {"data" : "firstname", "name" : "users.firstname" ,"visible":false},
		// {"data" : "lastname", "name" : "users.lastname" ,"visible":false},
		{"data" : "staff_id","searchable":false,"orderable":false},
		// {"data" : "firstname", "name" : "admin_users.firstname" ,"visible":false},
		// {"data" : "lastname", "name" : "admin_users.lastname" ,"visible":false},
		{"data" : "created_at","className":"text-center"},
		{"data" : "updated_at","className":"text-center"},
		// { "data": "action","className":"action text-center","searchable":false,"orderable":false }
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
		url : url_gb+"/admin/ActivityRewardUser/"+id,
		dataType : 'json'
	}).done(function(rec){
		$('#edit_activity_id').val(rec.activity_id);
		$('#edit_reward_id').val(rec.reward_id);
		$('#edit_user_id').val(rec.user_id);
		$('#edit_staff_id').val(rec.staff_id);

		btn.button("reset");
		ShowModal('ModalEdit');
	}).error(function(){
		swal("system.system_alert","system.system_error","error");
		btn.button("reset");
	});
});

$('body').on('click','button.accept',function() {
	var btn = $(this);
	btn.button('loading');
	$.ajax({
		method : "GET",
		url : url_gb+"/ActivityRewardUser/accept/"+$(this).data('accept'),
		dataType : 'json',
	}).done(function(rec){
		if(rec.status==1){
			TableList.api().ajax.reload();
			swal(rec.title,rec.content,"success");
		}else{
			swal(rec.title,rec.content,"error");
		}
	}).error(function(){
		swal("system.system_alert","system.system_error","error");
	});
	btn.button("reset");
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

		var btn = $(form).find('[type="submit"]');
		var data_ar = removePriceFormat(form,$(form).serializeArray());
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/ActivityRewardUser",
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

		var btn = $(form).find('[type="submit"]');
		var id = $('#edit_user_id').val();
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/ActivityRewardUser/"+id,
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
				url : url_gb+"/admin/ActivityRewardUser/Delete/"+id,
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
