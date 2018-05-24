@extends('Admin.layouts.layout')

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
				<col width="10%">
				<col width="45%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
				<thead>
					<tr>
						<th class="text-center">id</th>
						<th class="text-center">คำถาม</th>
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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="FormAdd">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">เพิ่ม {{$title_page or 'ข้อมูลใหม่'}}</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<!-- <label for="add_text">text</label> -->
						<textarea class="form-control text_question" name="text" required="" placeholder="text"></textarea>
					</div>

					<div class="form-inline">
						<label class="checkbox-inline"><input type="radio" name="status" value="T" checked>เปิดใช้งาน</label>
						<label class="checkbox-inline"><input type="radio" name="status" value="F">ไม่เปิดใช้งาน</label>
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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<input type="hidden" name="id" id="edit_user_id">
			<form id="FormEdit">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title_page or 'ข้อมูลใหม่'}}</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<textarea class="form-control editor" name="text" id="edit_text" required=""></textarea>
					</div>

					<div class="form-inline">
						<label class="checkbox-inline"><input type="radio" name="status" value="T">เปิดใช้งาน</label>
						<label class="checkbox-inline"><input type="radio" name="status" value="F">ไม่เปิดใช้งาน</label>
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
									<th class="text-center" style="color:black;">เฉลย</th>
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
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				<button type="submit" class="btn btn-primary save_answer"><i class="fa fa-save"></i> บันทึก</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('css_bottom')

@endsection

@section('js_bottom')
<!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->
<script src="{{asset('assets/global/plugins/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>
$('.save_answer').click(function() {
	$('form#FormSaveAnswer').submit();
});
var TableList = $('#TableList').dataTable({
	"ajax": {
		"url": url_gb+"/admin/Question/Lists",
		"data": function ( d ) {
			//d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{ "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
		// {"data" : "id","searchable":false,"orderable":false},
		{"data" : "text"},
		{"data" : "status","searchable":false,"orderable":false,"className":"text-center"},
		{"data" : "created_at","className":"text-center"},
		{ "data": "action","className":"action text-center","searchable":false,"orderable":false }
	]
});
$('body').on('click','.btn-add',function(data){
	tinymce.EditorManager.execCommand('mceRemoveEditor',true, "textarea.text_question");
	var editor_config = {
		path_absolute : "",
		selector: "textarea.text_question",
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
		relative_urls: false,
		file_browser_callback : function(field_name, url, type, win) {
			var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
			var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

			var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
			if(type == 'image'){
				cmsURL = cmsURL + "&type=Images";
			}else{
				cmsURL = cmsURL + "&type=Files";
			}

			tinyMCE.activeEditor.windowManager.open({
				file : cmsURL,
				title : 'Filemanager',
				width : x * 0.8,
				height : y * 0.8,
				resizable : "yes",
				close_previous : "no"
			});
		},
		height : 400,
		init_instance_callback: function(editor){
			editor.on('NodeChange', function (e){
				editor.save();
				$("textarea.text_question").val( $("textarea.text_question").val() );
				console.log($("textarea.text_question").val());
			});
		},
	};
	tinymce.init(editor_config);
	ShowModal('ModalAdd');
});
$('body').on('click','.btn-edit',function(data){
	$(this).trigger('dblclick');
	$(this).trigger('dblclick');
}).on('dblclick','.btn-edit',function(data){
	tinymce.triggerSave();
	tinymce.EditorManager.execCommand('mceRemoveEditor',true, "#ModalEdit #edit_text");
	var btn = $(this);
	btn.button('loading');
	var id = $(this).data('id');
	$('#edit_user_id').val(id);
	$.ajax({
		method : "GET",
		url : url_gb+"/admin/Question/"+id,
		dataType : 'json'
	}).done(function(rec){
		btn.button("reset");
		// console.log(rec.text);
		//tinyMCE.remove()
		var edit_config = {
			path_absolute : "",
			selector: "#ModalEdit #edit_text",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
			relative_urls: false,
			file_browser_callback : function(field_name, url, type, win) {
				var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
				var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

				var cmsURL = edit_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
				if(type == 'image'){
					cmsURL = cmsURL + "&type=Images";
				}else{
					cmsURL = cmsURL + "&type=Files";
				}
				tinyMCE.activeEditor.windowManager.open({
					file : cmsURL,
					title : 'Filemanager',
					width : x * 0.8,
					height : y * 0.8,
					resizable : "yes",
					close_previous : "no"
				});
			},

			height : 400,
			init_instance_callback: function(editor){
				editor.on('NodeChange', function (e){
					editor.save();
					$("textarea#edit_text").val( $("textarea#edit_text").val() );
					// console.log($("textarea#edit_text").val());
				});
			},
		};
		tinyMCE.init(edit_config);
		// console.log(rec.text);

		if(rec.text==null){
			tinyMCE.activeEditor.setContent('<p></p>');
		}else{
			// tinyMCE.activeEditor.setContent(rec.text);
			setTimeout(function(){
				// tinyMCE.activeEditor.setContent(rec.text);
				// tinyMCE.activeEditor.setContent(rec.text);
				// tinymce.activeEditor.setContent(rec.text, {format: 'raw'});
				tinymce.get('edit_text').setContent(rec.text);
				// tinymce.activeEditor.setContent(rec.remark.remark, {format: 'bbcode'});
				tinymce.get('edit_text').focus();
				tinymce.get('edit_text').selection.select(tinymce.get('edit_text').getBody(), true);
				tinymce.get('edit_text').selection.collapse(false);
			},100);
		}

		if(rec.status==null){

		}else{
			$("#FormEdit input[value='"+rec.status+"']").prop('checked',true);
		}
		ShowModal('ModalEdit');
		$('body').find('body#tinynce').trigger('focus');
	}).error(function(){
		swal("system.system_alert","system.system_error","error");
		btn.button("reset");
	});
});
$('body').on('click','.btn-add-answer',function(){
	$(this).trigger('dblclick');
	$(this).trigger('dblclick');
}).on('dblclick','.btn-add-answer',function(){
	var question_id = $(this).data('id');
	$('#idQuestion').val(question_id);
	getQuestionAnswer(question_id);
	// ShowModal('ModalAnswer');
});

function getQuestionAnswer(id){
	$.ajax({
		method : "GET",
		url : url_gb+"/admin/showAnswerQuestion/"+id,
		dataType : 'json',
	}).done(function(rec){
		tinymce.triggerSave();
		tinymce.EditorManager.execCommand('mceRemoveEditor',true, "#ModalAnswer textarea#description");
		var str = '';
		var check = '';
		// console.log(rec.remark.remark);
		// if(rec.remark){
		//     tinyMCE.activeEditor.setContent(rec.remark);
		// }else{
		//     tinyMCE.activeEditor.setContent("<p></p>");
		// }

		var right_config = {
			path_absolute : "",
			selector: "#ModalAnswer textarea#description",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
			relative_urls: false,
			file_browser_callback : function(field_name, url, type, win) {
				var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
				var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

				var cmsURL = right_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
				if(type == 'image'){
					cmsURL = cmsURL + "&type=Images";
				}else{
					cmsURL = cmsURL + "&type=Files";
				}

				tinyMCE.activeEditor.windowManager.open({
					file : cmsURL,
					title : 'Filemanager',
					width : x * 0.8,
					height : y * 0.8,
					resizable : "yes",
					close_previous : "no"
				});
			},
			height : 400,
			init_instance_callback: function(editor){
				editor.on('NodeChange', function (e){
					editor.save();
					$("textarea#description").val( $("textarea#description").val() );
					console.log($("textarea#description").val());
				});
			},

		};
		tinymce.init(right_config);
		console.log(rec.remark.length);
		if(rec.remark.length==0){
			tinyMCE.activeEditor.setContent('<p></p>');
		}else{
			setTimeout(function(){
				console.log(rec.remark[0].remark);
				// tinyMCE.activeEditor.setContent(rec.remark.remark);
				// tinymce.activeEditor.setContent(rec.remark.remark, {format: 'raw'});
				tinymce.get('description').setContent(rec.remark[0].remark);
				// tinymce.activeEditor.setContent(rec.remark.remark, {format: 'bbcode'});
				tinymce.get('description').focus();
				tinymce.get('description').selection.select(tinymce.get('description').getBody(), true);
				tinymce.get('description').selection.collapse(false);
			},100);
		}

		$.each(rec.listAnswer, function(i,val){
			if(val.ansID!=null) {
				check = val.ansID;
				//tinymce.init(right_config);
				//$("#edit_text").val( rec.text );
				//tinyMCE.activeEditor.setContent(rec.remark);
			}
			str +=
			`<tr>
			<td>
			<label class="checkbox-inline"><input type="radio" name="status" value="`+val.answer_id+`" `+check+`>
			</label>
			</td>
			<td>`+val.text+`</td>
			<td><center><button class="btn btn-sm btn-danger btn-delete-answer" data-id="`+val.answer_id+`" data-qid="`+val.question_id+`">ลบ</button></center></td>
			</tr>`;
		});
		$('#listAnswer').html(str);
		//console.log(check);
		if(check != '') {
			$('#ModalAnswer').find('input:radio[value="'+check+'"]').prop('checked',true);
		}
		$('#question_id').val(id);
		$('#textAnswer').removeClass('is-invalid');
		ShowModal('ModalAnswer');
	});
}
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
			url : url_gb+"/admin/Answer",
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

$('#FormAdd').validate({
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {

		text: {
			required: true,
		},
	},
	messages: {

		text: {
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
			url : url_gb+"/admin/Question",
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

		text: {
			required: true,
		},
	},
	messages: {

		text: {
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
			url : url_gb+"/admin/Question/"+id,
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
$('#FormSaveAnswer').validate({
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {

		text: {
			required: true,
		},
	},
	messages: {

		text: {
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
		var id = $('#question_id').val();
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/Question/AnswerRight/"+id,
			dataType : 'json',
			data : $(form).serialize()
		}).done(function(rec){
			btn.button("reset");
			if(rec.status==1){
				TableList.api().ajax.reload();
				resetFormCustom(form);
				swal(rec.title,rec.content,"success");
				$('#ModalAnswer').modal('hide');
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
				url : url_gb+"/admin/Answer/deleteAnswer/"+id,
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


$('body').on('click','.btn-delete',function(e){
	e.preventDefault();
	var btn = $(this);
	var id = btn.data('id');
	swal({
		title: "คุณต้องการลบคำถามใช่หรือไม่",
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
				url : url_gb+"/admin/Question/Delete/"+id,
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
<!-- <script src="{{asset('assets/global/plugins/tinymce/js/tinymce/tinymce.min.js')}}"></script> -->
<script>
// var editor_config = {
//     path_absolute : "",
//     selector: "textarea.text_question",
//     plugins: [
//         "advlist autolink lists link image charmap print preview hr anchor pagebreak",
//         "searchreplace wordcount visualblocks visualchars code fullscreen",
//         "insertdatetime media nonbreaking save table contextmenu directionality",
//         "emoticons template paste textcolor colorpicker textpattern"
//     ],
//     toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
//     relative_urls: false,
//     file_browser_callback : function(field_name, url, type, win) {
//         var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
//         var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

//         var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
//         if(type == 'image'){
//             cmsURL = cmsURL + "&type=Images";
//         }else{
//             cmsURL = cmsURL + "&type=Files";
//         }

//         tinyMCE.activeEditor.windowManager.open({
//             file : cmsURL,
//             title : 'Filemanager',
//             width : x * 0.8,
//             height : y * 0.8,
//             resizable : "yes",
//             close_previous : "no"
//         });
//     },
//     height : 400,
//     init_instance_callback: function(editor){
//         editor.on('NodeChange', function (e){
//             editor.save();
//             $("textarea.text_question").val( $("textarea.text_question").val() );
//             console.log($("textarea.text_question").val());
//         });
//     },

// };
// tinymce.init(editor_config);

// var edit_config = {
//     path_absolute : "",
//     selector: "#ModalEdit #edit_text",
//     plugins: [
//         "advlist autolink lists link image charmap print preview hr anchor pagebreak",
//         "searchreplace wordcount visualblocks visualchars code fullscreen",
//         "insertdatetime media nonbreaking save table contextmenu directionality",
//         "emoticons template paste textcolor colorpicker textpattern"
//     ],
//     toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
//     relative_urls: false,
//     file_browser_callback : function(field_name, url, type, win) {
//         var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
//         var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

//         var cmsURL = edit_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
//         if(type == 'image'){
//             cmsURL = cmsURL + "&type=Images";
//         }else{
//             cmsURL = cmsURL + "&type=Files";
//         }

//         tinyMCE.activeEditor.windowManager.open({
//             file : cmsURL,
//             title : 'Filemanager',
//             width : x * 0.8,
//             height : y * 0.8,
//             resizable : "yes",
//             close_previous : "no"
//         });
//     },
//     height : 400,
//     init_instance_callback: function(editor){
//         editor.on('NodeChange', function (e){
//             editor.save();
//             $("textarea#edit_text").val( $("textarea#edit_text").val() );
//             console.log($("textarea#edit_text").val());
//         });
//     },
// };
//tinymce.init(edit_config);

// var right_config = {
//     path_absolute : "",
//     selector: "textarea#description",
//     plugins: [
//         "advlist autolink lists link image charmap print preview hr anchor pagebreak",
//         "searchreplace wordcount visualblocks visualchars code fullscreen",
//         "insertdatetime media nonbreaking save table contextmenu directionality",
//         "emoticons template paste textcolor colorpicker textpattern"
//     ],
//     toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
//     relative_urls: false,
//     file_browser_callback : function(field_name, url, type, win) {
//         var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
//         var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

//         var cmsURL = right_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
//         if(type == 'image'){
//             cmsURL = cmsURL + "&type=Images";
//         }else{
//             cmsURL = cmsURL + "&type=Files";
//         }

//         tinyMCE.activeEditor.windowManager.open({
//             file : cmsURL,
//             title : 'Filemanager',
//             width : x * 0.8,
//             height : y * 0.8,
//             resizable : "yes",
//             close_previous : "no"
//         });
//     },
//     height : 400,
//     init_instance_callback: function(editor){
//         editor.on('NodeChange', function (e){
//             editor.save();
//             $("textarea.text_question").val( $("textarea.text_question").val() );
//             console.log($("textarea.text_question").val());
//         });
//     },

// };
// tinymce.init(right_config);
$('body').on('change','.status',function() {
	var id = $(this).data('id');
	$.ajax({
		method : "POST",
		url : url_gb+"/admin/Question/updateStatus/"+id,
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
</script>
@endsection
