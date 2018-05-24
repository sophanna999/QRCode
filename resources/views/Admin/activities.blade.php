@extends('Admin.layouts.layout')
@section('css_bottom')
@endsection
@section('body')
<div class="col-lg-12">
	<h2 class="page-title">
		{{$title_page or '' }}
		<div class="pull-right">
			<button class="btn btn-success btn-add">
				+เพิ่ม{{$title_page or '' }}
			</button>
		</div>
	</h2>

	<section class="widget widhget-min-hight">
		<div class="body no-margin table-responsive">
			<table class="table table-bordered table-hover  table-sm" id="TableList">
				<col width="5%">
				<col width="20%">
				<col width="5%">
				<col width="12%">
				<col width="12%">
				<col width="16%">
				<col width="10%">
				<col width="20%">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<th class="text-center">ชื่อกิจกรรม</th>
						<!-- <th>QR Code</th> -->
						<th class="text-center">ลิงค์</th>
						<th class="text-center">เริ่มต้น</th>
						<th class="text-center">สิ้นสุด</th>
						<th class="text-center">วันที่สร้าง</th>
						<th class="text-center">สถานะ</th>
						<th class="text-center"></th>
					</tr>
				</thead>
			</table>
		</div>
	</section>
</div>
<!-- Modal Add -->
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
						<label for="add_activity_name">ชื่อกิจกรรม</label>
						<input type="text" class="form-control" name="activity_name" id="add_activity_name"  placeholder="activity_name">
					</div>
					<div class="form-group">
						<label for="add_working_time_start">เวลาเริ่ม</label>
						<input type="text" class="form-control" name="working_time_start" id="add_working_time_start" placeholder="Start Time">
					</div>
					<div class="form-group">
						<label for="add_working_time_end">เวลาสิ้นสุด</label>
						<input type="text" class="form-control" name="working_time_end" id="add_working_time_end" placeholder="End Time">
					</div>
					<!-- <div class="checkbox checkbox-primary">
					<input type="checkbox" class="" name="status" id="add_status"  value="T">
					<label for="add_status">
					status
				</label>
			</div> -->
			<!-- <label class="checkbox-inline"><input type="radio" name="status" value="F">ไม่เปิดใช้งาน</label> -->
			<div class="form-group">
				<label for="status">สถานะ</label>
				<div class="radio radio-primary">
					<input type="radio" name="status" id="add_status1" value="T">
					<label for="add_status1"> เปิดใช้งาน </label>
				</div>
				<div class="radio radio-primary">
					<input type="radio" name="status" id="add_status2" value="F" checked>
					<label for="add_status2"> ปิดใช้งาน </label>
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

<div class="modal fade" id="ModalAddQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<input type="hidden" name="activity_id" id="activity_id">
			<form id="FormAddQuestion">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">จัดการคำถาม</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="limit_random">จำนวนคำถามสำหรับสุ่ม</label>
								<input type="text" class="form-control" name="limit_random" id="limit_random"  placeholder="limit question random">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="text-center">
								<h3>คำถาม</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center" style="color:black;">ลำดับ</th>
										<th class="text-center" style="color:black;">คำถาม</th>
										<th class="text-center" style="color:black;">เลือก</th>
									</tr>
								</thead>
								<tbody id="allQuestion">

								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="text-center">
								<h3>เลือก</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center" style="color:black;">ลำดับ</th>
										<th class="text-center" style="color:black;">คำถาม</th>
										<th class="text-center" style="color:black;">ลบ</th>
									</tr>
								</thead>
								<tbody id="allSelect">

								</tbody>
							</table>
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
<!-- Modal Special Question -->
<div class="modal fade" id="ModalAddInitQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<input type="hidden" name="activity_id" id="activity_id">
			<form id="FormAddSpecialQuestion">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">จัดการคำถาม</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="limit_random">จำนวนคำถามสำหรับสุ่ม</label>
								<input type="text" class="form-control" name="limit_random" id="limit_random"  placeholder="limit question random">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="text-center">
								<h3>คำถาม</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center" style="color:black;">ลำดับ</th>
										<th class="text-center" style="color:black;">คำถาม</th>
										<th class="text-center" style="color:black;">เลือก</th>
									</tr>
								</thead>
								<tbody id="SpecialQuestion">

								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="text-center">
								<h3>เลือก</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center" style="color:black;">ลำดับ</th>
										<th class="text-center" style="color:black;">คำถาม</th>
										<th class="text-center" style="color:black;">ลบ</th>
									</tr>
								</thead>
								<tbody id="SpecialSelect">

								</tbody>
							</table>
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
<div class="modal fade" id="ModalStaff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<input type="hidden" name="activity_id" id="activity_id">
			<form id="FormStaff">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">จัดการผู้ใช้งาน</h4>
				</div>
				<div class="modal-body">
					<div class="col-md-6">
						<div class="row">
							<div class="text-center">
								<h3>ผู้ใช้งาน</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center" style="color:black;">ลำดับ</th>
										<th class="text-center" style="color:black;">ผู้ใช้งาน</th>
										<th class="text-center" style="color:black;">เลือก</th>
									</tr>
								</thead>
								<tbody id="staff">

								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="text-center">
								<h3>เลือก</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center" style="color:black;">ลำดับ</th>
										<th class="text-center" style="color:black;">ผู้ใช้งาน</th>
										<th class="text-center" style="color:black;">ลบ</th>
									</tr>
								</thead>
								<tbody id="addStaff">

								</tbody>
							</table>
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

<!-- Modal Edit -->
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
						<label for="add_activity_name">ชื่อกิจกรรม</label>
						<input type="text" class="form-control" name="activity_name" id="edit_activity_name"  placeholder="activity_name">
					</div>
					<div class="form-group">
						<label for="edit_working_time_start">เวลาเริ่ม</label>
						<input type="text" class="form-control" name="working_time_start" id="edit_working_time_start" placeholder="Start Time">
					</div>
					<div class="form-group">
						<label for="edit_working_time_end">เวลาสิ้นสุด</label>
						<input type="text" class="form-control" name="working_time_end" id="edit_working_time_end" placeholder="End Time">
					</div>
					<div class="form-group">
						<label for="status">สถานะ</label>
						<div class="radio radio-primary">
							<input class="radio-danger" type="radio" name="status" id="edit_status" value="T">
							<label class="form-check-label" for="inlineRadio1">เปิดใช้งาน</label>
						</div>
						<div class="radio radio-primary">
							<input class="radio-danger" type="radio" name="status" id="edit_status" value="F">
							<label class="form-check-label" for="inlineRadio2">ปิดใช้งาน</label>
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
<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<input type="hidden" name="id" id="edit_user_id">
			<form id="FormDetail">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">รายละเอียดข้อมูล {{$title_page}}</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="add_activity_name">ชื่อกิจกรรม</label>
						<input type="text" class="form-control" name="activity_name" id="detail_activity_name"  placeholder="activity_name" readonly>
					</div>
					<div class="form-group">
						<label for="edit_working_time_start">เวลาเริ่ม</label>
						<input type="text" class="form-control" name="working_time_start" id="detail_working_time_start" placeholder="Start Time" readonly>
					</div>
					<div class="form-group">
						<label for="edit_working_time_end">เวลาสิ้นสุด</label>
						<input type="text" class="form-control" name="working_time_end" id="detail_working_time_end" placeholder="End Time" readonly>
					</div>
					<div class="form-group">
						<label for="status">สถานะ</label>
						<div class="radio radio-primary">
							<input class="radio-danger" type="radio" name="status" id="detail_status" value="T" readonly>
							<label class="form-check-label" for="inlineRadio1">เปิดใช้งาน</label>
						</div>
						<div class="radio radio-primary">
							<input class="radio-danger" type="radio" name="status" id="edit_status" value="F" readonly>
							<label class="form-check-label" for="inlineRadio2">ปิดใช้งาน</label>
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
<div class="modal fade" id="ModalReward" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="FormReward">
				<input type="hidden" name="activity_id" id="activity_id">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูล {{$title_page or 'ข้อมูลใหม่'}}</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="body no-margin">
								<table class="table table-bordered table-hover" id="RewardList">
									<thead>
										<tr>
											<th style="color:#000;">รหัส</th>
											<th style="color:#000;">เลือก</th>
											<th style="color:#000;">ชื่อของรางวัล</th>
											<th style="color:#000;">คงเหลือ</th>
											<th style="color:#000;">รางวัลสำหรับการตอบคำถาม</th>
											<th></th>
										</tr>
									</thead>
								</table>
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
<div class="modal fade" id="ModalDownload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-maximize" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">ดาวน์โหลด {{$title_page or 'ข้อมูลใหม่'}}</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 downloadQrcode" align="center">

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
			</div>
		</div>
	</div>
</div>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> บันทึก</button>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js_bottom')
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>
var arr_reward_t = [];
var arr_reward_f = [];
var amount = [];
var reward_id = [];
var add_index = 0;
var add_check = [];
var staff_index = 0;
var staff_check = [];
var datetimenow = new Date();
var datenow = datetimenow.getFullYear() + "-" + (datetimenow.getMonth()+1) + "-" + datetimenow.getDate();
$('#add_working_time_start').datetimepicker({
	'pickTime': false,
});
$('#add_working_time_end').datetimepicker({
	'pickTime': false
});
$('#edit_working_time_start').datetimepicker({
	'pickTime': false
});
$('#edit_working_time_end').datetimepicker({
	'pickTime': false
});
$('body').on('click','.btn-import',function(e){
    e.preventDefault();
    var btn = $(this);
    var id = btn.data('id');
    $('#import_user_id').val(id);
	$('#import_qty').val('');
	$('#ModalReward').removeClass('in');
    ShowModal('ModalImport');
});
$('body').on('click','.btn-export',function(e){
	$('#export_qty').val('');
    e.preventDefault();
    var btn = $(this);
    var id = btn.data('id');
    $('#export_user_id').val(id);
	$('#ModalReward').removeClass('in');
    ShowModal('ModalExport');
});
var TableList = $('#TableList').dataTable({
	"ajax": {
		"url": url_gb+"/admin/Activities/Lists",
		"data": function ( d ) {
			// d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{ "data": "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
		{"data" : "activity_name"},
		// {"data" : "qr_code","searchable":false,"orderable":false},
		{"data" : "activity_url","searchable":false,"orderable":false,"className":"text-center"},
		{"data" : "working_time_start","className":"text-center"},
		{"data" : "working_time_end","className":"text-center"},
		{"data" : "created_at","className":"text-center"},
		{"data" : "status","searchable":false,"orderable":false,"className":"text-center"},
		{ "data": "action","className":"action text-center","searchable":false ,"orderable":false}
	]
});
var RewardList = $('#RewardList').dataTable({
	"ajax": {
		"url": url_gb+"/admin/Activities/RewardLists",
		"data": function ( d ) {
			// d.myKey = "myValue";
			// d.custom = $('#myInput').val();
			// etc
		}
	},
	"columns": [
		{"data" : "id"},
		{"data" : "reward","searchable": false,"orderable": false},
		{"data" : "name"},
		{"data" : "amount","className":"text-center","searchable": false,"orderable": false },
		{ "data": "check","className":"check text-center","searchable": false,"orderable": false },
		{ "data": "action","className":"action text-center","searchable": false,"orderable": false },
	],
	responsive: true,
	"drawCallback": function (settings) {
		putvalue();
		info = RewardList.api().page.info();
	},
	initComplete: function () {
		//alert('a');
		putvalue();
	}
});
$('body').on('click','.checkbox[name*="reward_id"]',function() {
	if($(this).prop('checked')==false) {
		$(this).closest('tr').find('.checkbox[name*="status_t"]').prop('checked',false);
		$(this).closest('tr').find('.checkbox[name*="status_f"]').prop('checked',false);
	}
});
$('body').on('click','.checkbox[name*="status_f"]',function() {
	checked_checkbox($(this),'t')
});
$('body').on('click','.checkbox[name*="status_t"]',function() {
	checked_checkbox($(this),'f')
});
function checked_checkbox(this_check,find_check) {
	if(this_check.prop('checked')==true) {
		this_check.closest('tr').find('td:first').next().children().prop('checked',true);
	} else {
		if(this_check.closest('tr').find('.checkbox[name*="status_'+find_check+'"]').prop('checked')==true) {
			this_check.closest('tr').find('td:first').next().children().prop('checked',true);
		} else {
			this_check.closest('tr').find('td:first').next().children().prop('checked',false);
		}
	}
}
$('body').on('click','.btn-add-init-question', function(data){
	console.log($(this).data('id'));
	var str = "";
	add_index = 0;
	add_check.length = 0;
	var id = $(this).data('id');
	$.ajax({
		method : "GET",
		"url": url_gb+"/admin/Activities/AllSpeQues/"+id,
		dataType : 'json'
	}).done(function(rec){
		var str = '';
		$.each(rec, function(i,val){
			str +=
			`<tr>
			<td>`+(i+1)+`</td>
			<td>(`+val.id+`) `+val.text+`</td>
			<td style="vertical-align:middle;text-align:center;"><button value="`+val.id+`" class="btn btn-sm btn-primary addSpeQue">เลือก</button></td>
			</tr>`;
		});
		$('#SpecialQuestion').html(str);
		$('#SpecialSelect').html('');
		$('#activity_id').val(id);
		$.ajax({
			method : "GET",
			"url": url_gb+"/admin/Activities/GetSpecQuestion/"+id,
			dataType : 'json'
		}).done(function(result){
			var str = '';
			$.each(result[0],function(k,v) {
				add_index = k+1;
				add_check[k] = v;
				str +=
				`<tr>
				<td></td>
				<td>`+$('#SpecialQuestion').find('button[value="'+v+'"]').closest('td').prev().text()+`</td>
				<td style="vertical-align:middle;text-align:center;"><button value="`+v+`" class="btn btn-sm btn-danger removeSpeQue">ลบ</button></td>
				</tr>`;
				$('#SpecialQuestion').find('button[value="'+v+'"]').closest('tr').remove();
			});
			$('#SpecialSelect').append(str);
			$.each($('#SpecialQuestion').find('tr'),function(k,v){
				$(v).find('td:first').text((k+1));
			});
			$.each($('#SpecialSelect').find('tr'),function(k,v){
				$(v).find('td:first').text((k+1));
			});
			$('#ModalAddInitQuestion').find('input#limit_random').val(result.limit_random);
		});
		ShowModal('ModalAddInitQuestion');
	});
});

$('body').on('click','.btn-staff', function(data){
	var str = "";
	staff_index = 0;
	staff_check.length = 0;
	var id = $(this).data('id');
	$.ajax({
		method : "GET",
		"url": url_gb+"/admin/Activities/staff/"+id,
		dataType : 'json'
	}).done(function(rec){
		var str = '';
		$.each(rec, function(i,val){
			str +=
			`<tr>
			<td>`+(i+1)+`</td>
			<td>(`+val.id+`) `+val.firstname+` `+val.lastname+`</td>
			<td style="vertical-align:middle;text-align:center;"><button value="`+val.id+`" class="btn btn-sm btn-primary addStaff">เลือก</button></td>
			</tr>`;
		});
		$('#staff').html(str);
		$('#addStaff').html('');
		$('#activity_id').val(id);
		$.ajax({
			method : "GET",
			"url": url_gb+"/admin/Activities/getStaff/"+id,
			dataType : 'json'
		}).done(function(result){
			var str = '';
			$.each(result[0],function(k,v) {
				staff_index = k+1;
				staff_check[k] = v;
				str +=
				`<tr>
				<td></td>
				<td>`+$('#staff').find('button[value="'+v+'"]').closest('td').prev().text()+`</td>
				<td style="vertical-align:middle;text-align:center;"><button value="`+v+`" class="btn btn-sm btn-danger removeStaff">ลบ</button></td>
				</tr>`;
				$('#staff').find('button[value="'+v+'"]').closest('tr').remove();
			});
			$('#addStaff').append(str);
			$.each($('#staff').find('tr'),function(k,v){
				$(v).find('td:first').text((k+1));
			});
			$.each($('#addStaff').find('tr'),function(k,v){
				$(v).find('td:first').text((k+1));
			});
		});
	});
	ShowModal('ModalStaff');
});

$('body').on('click','.btn-add-question',function(data){
	var str = "";
	add_index = 0;
	add_check.length = 0;
	var id = $(this).data('id');
	$.ajax({
		method : "GET",
		"url": url_gb+"/admin/Questionall",
		dataType : 'json'
	}).done(function(rec){
		var str = '';
		$.each(rec, function(i,val){
			str +=
			`<tr>
			<td>`+(i+1)+`</td>
			<td>(`+val.id+`) `+val.text+`</td>
			<td style="vertical-align:middle;text-align:center;"><button value="`+val.id+`" class="btn btn-sm btn-primary addQue">เลือก</button></td>
			</tr>`;
		});
		$('#allQuestion').html(str);
		$('#allSelect').html('');
		$('#activity_id').val(id);
		$('#allQuestion').find('img').remove();
		$.ajax({
			method : "GET",
			"url": url_gb+"/admin/Activities/getActivityQuestion/"+id,
			dataType : 'json'
		}).done(function(result){
			var str = '';
			$('#limit_random').val(result.limit_random);
			$.each(result.question[0],function(k,v) {
				if($('#allQuestion').find('button[value="'+v+'"]').closest('td').prev().text()!='') {
					add_index = k+1;
					add_check[k] = v;
					str +=
					`<tr>
					<td></td>
					<td>`+$('#allQuestion').find('button[value="'+v+'"]').closest('td').prev().text()+`</td>
					<td style="vertical-align:middle;text-align:center;"><button value="`+v+`" class="btn btn-sm btn-danger removeQue">ลบ</button></td>
					</tr>`;
				}
			});
			$('#allSelect').append(str);
			$.each($('#allSelect').find('tr'),function(k,v){
				$(v).find('td:first').text((k+1));
			});
		});
		ShowModal('ModalAddQuestion');
	});
});

$('body').on('click','.btn-add',function(data){
	ShowModal('ModalAdd');
});
function putvalue() {
	for (i = 0; i < arr_reward_f.length; i++) {
		$('#ModalReward').find('tbody').find('input:checkbox[value="'+arr_reward_f[i]+'"]').prop('checked',true);
		$('#ModalReward').find('tbody').find('input:checkbox[value="'+arr_reward_f[i]+'"]').closest('tr').find('input:checkbox[name*="status_f"]').prop('checked',true);
	}
	for (i = 0; i < arr_reward_t.length; i++) {
		$('#ModalReward').find('tbody').find('input:checkbox[value="'+arr_reward_t[i]+'"]').prop('checked',true);
		$('#ModalReward').find('tbody').find('input:checkbox[value="'+arr_reward_t[i]+'"]').closest('tr').find('input:checkbox[name*="status_t"]').prop('checked',true);
	}
	for (i = 0; i < reward_id.length; i++) {
		$('#ModalReward').find('tbody').find('input[name="amount['+reward_id[i]+']"]').val(amount[i]);
	}
}
$('body').on('click','.btn-reward',function(data){
	var btn = $(this);
	amount.length = 0;
	reward_id.length = 0;
	btn.button('loading');
	var id = $(this).data('id');
	arr_reward_f.length = 0;
	arr_reward_t.length = 0;
	$('#ModalReward').find('#activity_id').val(id);
	btn.button("reset");
	$.ajax({
		method : "GET",
		url : url_gb+"/admin/Activities/getReward/"+id,
		dataType : 'json'
	}).done(function(rec){
		if(rec['F']) {
			$.each(rec['F'],function(k,v) {
				arr_reward_f[k] = v;
			});
		}
		if(rec['T']) {
			$.each(rec['T'],function(k,v) {
				arr_reward_t[k] = v;
			});
		}
		RewardList.api().ajax.reload();
		$.each(rec.amount,function(k,v) {
			reward_id[k] = v.reward_id;
			amount[k] = v.amount;
		});
	});
	ShowModal('ModalReward');
});
$('body').on('click','.btn-qrcode',function(data){
	var btn = $(this);
	btn.button('loading');
	var id = $(this).data('id');
	btn.button("reset");
	$.ajax({
		method : "GET",
		url : url_gb+"/admin/Activities/getDownloadQrcode/"+id,
		dataType : 'html'
	}).done(function(rec){
		$('.downloadQrcode').html(rec);
	});
	ShowModal('ModalDownload');
});
$('body').on('click','img.download',function() {
	// $(this).prop('download',true);
	$(this).wrap('<a href="' + $(this).attr('src') + '" download="'+$(this).attr('name')+'" />');
});

$('body').on('click','.addQue',function(e){
	e.preventDefault();
	add_check[add_index] = $(this).val();
	add_index++;
	var i = 1;
	var str =
	`<tr>
	<td></td>
	<td>`+$(this).closest('td').prev().text()+`</td>
	<td style="vertical-align:middle;text-align:center;"><button value="`+$(this).val()+`" class="btn btn-sm btn-danger removeQue">ลบ</button></td>
	</tr>`;
	$('#allSelect').append(str);
	$.each($('#allSelect').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
});

$('body').on('click','.removeQue',function(e){
	e.preventDefault();
	$(this).closest('tr').remove();
	add_check.splice(parseInt($(this).closest('tr').find('td:first').text())-1,1);
	$.each($('#allSelect').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	add_index--;
});

$('body').on('click','.addStaff',function(e){
	e.preventDefault();
	staff_check[staff_index] = $(this).val();
	staff_index++;
	var i = 1;
	var str =
	`<tr>
	<td></td>
	<td>`+$(this).closest('td').prev().text()+`</td>
	<td style="vertical-align:middle;text-align:center;"><button value="`+$(this).val()+`" class="btn btn-sm btn-danger removeStaff">ลบ</button></td>
	</tr>`;
	$('#addStaff').append(str);
	$('#staff').find('button[value="'+$(this).val()+'"]').closest('tr').remove();
	$.each($('#staff').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	$.each($('#addStaff').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
});
$('body').on('click','.addSpeQue',function(e){
	e.preventDefault();
	add_check[add_index] = $(this).val();
	add_index++;
	var i = 1;
	var str =
	`<tr>
	<td></td>
	<td>`+$(this).closest('td').prev().text()+`</td>
	<td style="vertical-align:middle;text-align:center;"><button value="`+$(this).val()+`" class="btn btn-sm btn-danger removeSpeQue">ลบ</button></td>
	</tr>`;
	$('#SpecialSelect').append(str);
	$('#SpecialQuestion').find('button[value="'+$(this).val()+'"]').closest('tr').remove();
	$.each($('#SpecialQuestion').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	$.each($('#SpecialSelect').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
});
$('body').on('click','.removeSpeQue',function(e){
	e.preventDefault();
	$(this).closest('tr').remove();
	add_check.splice(parseInt($(this).closest('tr').find('td:first').text())-1,1);
	var str =
	`<tr>
	<td></td>
	<td>`+$(this).closest('td').prev().text()+`</td>
	<td style="vertical-align:middle;text-align:center;"><button value="`+$(this).val()+`" class="btn btn-sm btn-primary addSpeQue">เลือก</button></td>
	</tr>`;
	$('#SpecialQuestion').append(str);
	$.each($('#SpecialQuestion').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	$.each($('#SpecialSelect').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	add_index--;
});

$('body').on('click','.removeStaff',function(e){
	e.preventDefault();
	$(this).closest('tr').remove();
	staff_check.splice(parseInt($(this).closest('tr').find('td:first').text())-1,1);
	var str =
	`<tr>
	<td></td>
	<td>`+$(this).closest('td').prev().text()+`</td>
	<td style="vertical-align:middle;text-align:center;"><button value="`+$(this).val()+`" class="btn btn-sm btn-primary addStaff">เลือก</button></td>
	</tr>`;
	$('#staff').append(str);
	$.each($('#staff').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	$.each($('#addStaff').find('tr'),function(k,v){
		$(v).find('td:first').text((k+1));
	});
	staff_index--;
});

$('body').on('click','.btn-edit',function(data){
	var btn = $(this);
	btn.button('loading');
	var id = $(this).data('id');
	$('#edit_user_id').val(id);
	$.ajax({
		method : "GET",
		url : url_gb+"/admin/Activities/"+id,
		dataType : 'json'
	}).done(function(rec){
		$('#edit_activity_name').val(rec.activity_name);
		$('#edit_status').val(rec.status);
		$('#edit_working_time_start').val(rec.working_time_start);
		$('#edit_working_time_end').val(rec.working_time_end);
		$('#edit_activity_url').val(rec.activity_url);
		$('input[value="'+rec.status+'"]').prop('checked',true);

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

		var btn = $(form).find('[type="submit"]');
		var data_ar = removePriceFormat(form,$(form).serializeArray());
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/Activities",
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
			url : url_gb+"/admin/Activities/"+id,
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
$('#FormAddQuestion').validate({
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {
		limit_random : {
			required:true,
			number: true,
		},
	},
	messages: {
		limit_random : {
			required:"กรุณาระบุ",
			number: "ตัวเลลขเท่านั้น",
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
		var data_ar = removePriceFormat(form,$(form).serializeArray());
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/Activities/AddQuestion/"+$('#activity_id').val(),
			dataType : 'json',
			data : {
				question_group_id : add_check,
				limit_random : $('#ModalAddQuestion').find('#limit_random').val(),
			},
		}).done(function(rec){
			btn.button("reset");
			if(rec.status==1){
				TableList.api().ajax.reload();
				resetFormCustom(form);
				swal(rec.title,rec.content,"success");
				$('#ModalAddQuestion').modal('hide');
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
$('#FormStaff').validate({
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
			url : url_gb+"/admin/Activities/AddStaff/"+$('#activity_id').val(),
			dataType : 'json',
			data : {
				staff_id : staff_check,
			},
		}).done(function(rec){
			btn.button("reset");
			if(rec.status==1){
				TableList.api().ajax.reload();
				resetFormCustom(form);
				swal(rec.title,rec.content,"success");
				$('#ModalStaff').modal('hide');
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
$('#FormAddSpecialQuestion').validate({
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
			url : url_gb+"/admin/Activities/AddSpecialQuestion/"+$('#activity_id').val(),
			dataType : 'json',
			data : {
				question_group_id : add_check,
				limit_random : $('#ModalAddInitQuestion').find('#limit_random').val(),
			},
		}).done(function(rec){
			btn.button("reset");
			if(rec.status==1){
				TableList.api().ajax.reload();
				resetFormCustom(form);
				swal(rec.title,rec.content,"success");
				$('#ModalAddInitQuestion').modal('hide');
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
$('#FormReward').validate({
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
		btn.button("loading");
		$.ajax({
			method : "POST",
			url : url_gb+"/admin/Activities/RewardAccept",
			dataType : 'json',
			data : $(form).serialize()
		}).done(function(rec){
			btn.button("reset");
			if(rec.status==1){
				TableList.api().ajax.reload();
				// RewardList.api().ajax.reload();
				resetFormCustom(form);
				swal(rec.title,rec.content,"success");
				$('#ModalReward').modal('hide');
			}else{
				swal(rec.title,rec.content,"error");
			}
		}).error(function(){
			// swal("system.system_alert","system.system_error","error");
			swal("ผิดพลาด","กรุณาตรวจสอบข้อมูล","error");
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
		title: "คุณต้องการลบกิจกรรมนี้ใช่หรือไม่",
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
				url : url_gb+"/admin/Activities/Delete/"+id,
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
$('body').on('change','.status',function() {
	var id = $(this).data('id');
	$.ajax({
		method : "POST",
		url : url_gb+"/admin/Activities/updateStatus/"+id,
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
$("#import_qty, #export_qty").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
$('#FormImport').find('button.btn-primary').on('click',function(e) {
	sum_amount($('#import_user_id').val(),$('#import_qty').val(),'in');
	$('#ModalReward').addClass('in');
	$('#ModalImport').modal('hide');
});
$('#FormExport').find('button.btn-primary').on('click',function(e) {
	sum_amount($('#export_user_id').val(),$('#export_qty').val(),'out');
	$('#ModalReward').addClass('in');
	$('#ModalExport').modal('hide');
});

function sum_amount(reward_id, amount, type) {
	sum = parseInt($('#ModalReward').find('tbody').find('input[name="amount['+reward_id+']"]').val()?$('#ModalReward').find('tbody').find('input[name="amount['+reward_id+']"]').val():0);
	if(type=="in") {
		sum += parseInt(amount);
	} else {
		if(sum>amount) {
			sum -= amount;
		} else {
			sum = 0;
		}
	}
	$('#ModalReward').find('tbody').find('input[name="amount['+reward_id+']"]').val(sum);
}
$('#ModalImport, #ModalExport').find('.btn-default, .close').on('click',function() {
	$('#ModalReward').addClass('in');
});
// $('#FormExport').validate({
//     errorElement: 'div',
//     errorClass: 'invalid-feedback',
//     focusInvalid: false,
//     rules: {
//
//         qty: {
//             required: true,
//         },
//     },
//     messages: {
//
//         qty: {
//             required: "กรุณาระบุ",
//         },
//     },
//     highlight: function (e) {
//         validate_highlight(e);
//     },
//     success: function (e) {
//         validate_success(e);
//     },
//
//     errorPlacement: function (error, element) {
//         validate_errorplacement(error, element);
//     },
//     submitHandler: function (form) {
//
//         var btn = $(form).find('[type="submit"]');
//         btn.button("loading");
//         $.ajax({
//             method : "POST",
//             url : url_gb+"/admin/Reward/Export/"+$('#ModalReward').find('#activity_id').val(),
//             dataType : 'json',
//             data : $(form).serialize()
//         }).done(function(rec){
//             btn.button("reset");
//             if(rec.status==1){
//                 TableList.api().ajax.reload();
//                 resetFormCustom(form);
//                 swal(rec.title,rec.content,"success");
//                 $('#ModalExport').modal('hide');
//             }else{
//                 swal(rec.title,rec.content,"error");
//             }
//         }).error(function(){
//             swal("system.system_alert","system.system_error","error");
//             btn.button("reset");
//         });
// 		$('#ModalReward').addClass('in');
// 		RewardList.api().ajax.reload();
//     },
//     invalidHandler: function (form) {
//
//     }
// });
// $('#FormImport').validate({
//     errorElement: 'div',
//     errorClass: 'invalid-feedback',
//     focusInvalid: false,
//     rules: {
//
//         qty: {
//             required: true,
//         },
//     },
//     messages: {
//
//         qty: {
//             required: "กรุณาระบุ",
//         },
//     },
//     highlight: function (e) {
//         validate_highlight(e);
//     },
//     success: function (e) {
//         validate_success(e);
//     },
//
//     errorPlacement: function (error, element) {
//         validate_errorplacement(error, element);
//     },
//     submitHandler: function (form) {
//
//         var btn = $(form).find('[type="submit"]');
//         btn.button("loading");
//         $.ajax({
//             method : "POST",
//             url : url_gb+"/admin/Reward/Import/"+$('#ModalReward').find('#activity_id').val(),
//             dataType : 'json',
//             data : $(form).serialize()
//         }).done(function(rec){
//             btn.button("reset");
//             if(rec.status==1){
//                 TableList.api().ajax.reload();
//                 resetFormCustom(form);
//                 swal(rec.title,rec.content,"success");
//                 $('#ModalImport').modal('hide');
//             }else{
//                 swal(rec.title,rec.content,"error");
//             }
//         }).error(function(){
//             swal("system.system_alert","system.system_error","error");
//             btn.button("reset");
//         });
// 		$('#ModalReward').addClass('in');
// 		RewardList.api().ajax.reload();
//     },
//     invalidHandler: function (form) {
//
//     }
// });
// $('body').on('click','.btn-detail',function(data){
//         var btn = $(this);
//         btn.button('loading');
//         var id = $(this).data('id');
//         // $('#edit_user_id').val(id);
//         $.ajax({
//             method : "GET",
//             url : url_gb+"/admin/Activities/Detail/"+id,
//             dataType : 'json'
//         }).done(function(rec){
//             $('#detail_activity_name').val(rec.activity_name);
//             $('#detail_status').val(rec.status);
//             $('#detail_working_time_start').val(rec.working_time_start);
//             $('#detail_working_time_end').val(rec.working_time_end);
//             $('#detail_activity_url').val(rec.activity_url);
//             $('input[value="'+rec.status+'"]').prop('checked',true);

//             btn.button("reset");
//             ShowModal('ModalDetail');
//         }).error(function(){
//             swal("system.system_alert","system.system_error","error");
//             btn.button("reset");
//         });
//     });


</script>
@endsection
