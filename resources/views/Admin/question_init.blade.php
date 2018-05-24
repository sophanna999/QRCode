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
				<col width="10%">
				<col width="35%">
				<col width="10%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<th class="text-center">คำถาม</th>
						<th class="text-center">ประเภทคำถาม</th>
						<th class="text-center">สถานะ</th>
						<th class="text-center">วันที่สร้าง</th>
						<th class="text-center"></th>
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
						<label for="add_text">คําถาม</label>
						<input type="text" class="form-control" name="text" id="add_text" required="" placeholder="คําถาม">
					</div>

					<div class="form-group">
						<label for="status">สถานะ</label>
						<div class="radio radio-primary">
							<input type="radio" name="status" id="add_status1" value="T">
							<label for="add_status1"> แสดง </label>
						</div>
						<div class="radio radio-primary">
							<input type="radio" name="status" id="add_status2" value="F">
							<label for="add_status2"> ไม่แสดง </label>
						</div>
					</div>
					<div class="form-group">
						<label for="status">ประเภทคำถาม</label>
						<div class="radio radio-primary">
							<input type="radio" name="free_form" id="add_free_form1" value="T">
							<label for="add_free_form1"> อัตนัย </label>
						</div>
						<div class="radio radio-primary">
							<input type="radio" name="free_form" id="add_free_form2" value="F">
							<label for="add_free_form2"> ปรนัย </label>
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
						<label for="edit_text">text</label>
						<input type="text" class="form-control" name="text" id="edit_text" required="" placeholder="text">
					</div>

					<div class="form-group">
						<label for="status">Status</label>
						<div class="radio radio-primary">
							<input class="radio-danger" type="radio" name="status" id="edit_status1" value="T">
							<label class="form-check-label" for="edit_status1">แสดง</label>
						</div>
						<div class="radio radio-primary">
							<input class="radio-danger" type="radio" name="status" id="edit_status2" value="F">
							<label class="form-check-label" for="edit_status2">ไม่แสดง</label>
						</div>
					</div>
					<div class="form-group">
						<label for="free_form">ประเภทคำถาม</label>
						<div class="radio radio-primary">
							<input type="radio" name="free_form" id="edit_free_form1" value="T">
							<label for="edit_free_form1"> อัตนัย </label>
						</div>
						<div class="radio radio-primary">
							<input type="radio" name="free_form" id="edit_free_form2" value="F">
							<label class="checkbox-inline" for="edit_free_form2"> ปรนัย </label>
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
<div class="modal fade" id="ModalAnswer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<input type="hidden" name="question_id" id="question_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title_page or 'ข้อมูลใหม่'}}</h4>
			</div>
			<div class="modal-body">
				<div class="answer">
					<form id="FormAddAnswer">
						<div class="form-group row">
							<input type="hidden" id="idQuestion" name="question_id">
							<label for="textAnswer" class="col-sm-2 col-form-label"><h4>คำตอบ</h4></label>
							<div class="col-sm-8">
								<input type="text" name="text" class="form-control editor" id="textAnswer" placeholder="answer">
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-primary">เพิ่ม</button>
							</div>
						</div>
					</form>
				</div>
				<form id="FormSaveAnswer">
					<div class="answerContainer">
						<h4>รายการแสดงคำตอบทั้งหมด</h4>
						<table class="table table-bordered table-hover">
							<col width="10%">
							<col width="60%">
							<col width="30%">
							<thead>
								<tr >
									<th class="text-center" style="color:black;">ลำดับ</th>
									<th class="text-center" style="color:black;">คำตอบ</th>
									<th class="text-center" style="color:black;">ลบ</th>
								</tr>
							</thead>
							<tbody id="listAnswer">

							</tbody>
						</table>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-save"></i> บันทึก</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js_bottom')
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>

var TableList = $('#TableList').dataTable({
	"ajax": {
		"url": url_gb+"/admin/QuestionInit/Lists",
		"data": function ( d ) {
			//d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{"data" : "id","className":"action text-center"},
		{"data" : "text"},
		{"data" : "free_form","searchable": false},
		{"data" : "status","searchable":false,"orderable":false,"className":"text-center"},
		{"data" : "created_at","className":"text-center"},
		{ "data": "action","className":"action text-center" ,"searchable": false, "orderable": false}
	]
});
$('body').on('change','.status',function() {
	var id = $(this).data('id');
	$.ajax({
		method : "POST",
		url : url_gb+"/admin/QuestionInit/updateStatus/"+id,
		data : {status : $(this).val()},
		dataType: 'json',
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
});
$('body').on('click','.btn-add',function(data){
	ShowModal('ModalAdd');
	$('#add_status1').prop('checked', false);
	$('#add_status2').prop('checked', false);
	$('#add_free_form1').prop('checked', false);
	$('#add_free_form2').prop('checked', false);
});
$('body').on('click','.btn-edit',function(data){
	var btn = $(this);
	btn.button('loading');
	var id = $(this).data('id');
	$('#edit_user_id').val(id);
	$.ajax({
		method : "GET",
		url : url_gb+"/admin/QuestionInit/"+id,
		dataType : 'json'
	}).done(function(rec){
		$('#edit_text').val(rec.text);
		// $('#edit_status').val(rec.status);
		$('input[name="status"][value="'+rec.status+'"]').prop('checked',true);
		$('input[name="free_form"][value="'+rec.free_form+'"]').prop('checked',true);

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
		free_form: {
			required: true,
		},
		text: {
			required: true,
		},
		status: {
			required: true,
		},
	},
	messages: {

		text: {
			required: "กรุณาระบุ",
		},
		free_form: {
			required: "กรุณาระบุ",
		},
		status: {
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
			url : url_gb+"/admin/QuestionInit",
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
$('body').on('click','.btn-add-answer',function(){
	var question_id = $(this).data('id');
	$('#idQuestion').val(question_id);
	getQuestionAnswer(question_id);
	// ShowModal('ModalAnswer');
});
$('#FormAddAnswer').validate({
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {
		text: "required",
	},
	messages: {
		text: "กรุณากรอกคำตอบก่อน",
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
	submitHandler: function (form){
		var btn = $(form).find('[type="submit"]');
		var data_ar = removePriceFormat(form,$(form).serializeArray());
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/QuestionInit/AddAnswer",
			dataType : 'json',
			data : $(form).serialize(),
		}).done(function(rec){
			btn.button("reset");
			if(rec.status==1){
				TableList.api().ajax.reload();
				resetFormCustom(form);
				swal(rec.title,rec.content,"success");
				getQuestionAnswer(rec.question_id);
				//$('#ModalAdd').modal('hide');
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
function getQuestionAnswer(id){
	$.ajax({
		method : "POST",
		url : url_gb+"/admin/QuestionInit/showAnswerQuestionInit/"+id,
		dataType : 'json',
	}).done(function(rec){
		var str = '';
		$.each(rec.listAnswer, function(i,val){
			str +=
			`<tr>
			<td>
			`+(i+1)+`
			</label>
			</td>
			<td>`+val.text+`</td>
			<td><center><button class="btn btn-sm btn-danger btn-delete-answer" data-id="`+val.answer_id+`" data-qid="`+val.question_id+`">ลบ</button></center></td>
			</tr>`;
		});
		$('#listAnswer').html(str);
		$('#question_id').val(id);
		$('#textAnswer').removeClass('is-invalid');
		ShowModal('ModalAnswer');
	});
}
$('body').on('click','.btn-delete-answer',function(e){
	e.preventDefault();
	var btn = $(this);
	var id = btn.data('id');
	var qid = btn.data('qid');
	swal({
		title: "คุณต้องการลบคำตอบใช่หรือไม่",
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
				url : url_gb+"/admin/QuestionInit/deleteAnswer/"+id,
			}).done(function(rec){
				if(rec.status==1){
					swal(rec.title,rec.content,"success");
					console.log(qid);
					getQuestionAnswer(qid);
				}else{
					swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
				}
			}).error(function(data){
				swal("ระบบมีปัญหา","กรุณาติดต่อผู้ดูแล","error");
			});
		}
	});
});
$('#FormEdit').validate({
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {
		free_form: {
			required: true,
		},
		text: {
			required: true,
		},
		status: {
			required: true,
		},
	},
	messages: {

		text: {
			required: "กรุณาระบุ",
		},
		free_form: {
			required: "กรุณาระบุ",
		},
		status: {
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
			url : url_gb+"/admin/QuestionInit/"+id,
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
				url : url_gb+"/admin/QuestionInit/Delete/"+id,
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
