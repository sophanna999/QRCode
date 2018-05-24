<!DOCTYPE html>
<style>
.container{
	padding-left: 0 !important;
	padding-right: 0 !important;
	max-width: 100%;
}

.padding-0{
	padding:0;
}
</style>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap.min.css.map')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css.map')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/admin/css_main_process/custom.css')}}" />
	<!-- <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet"> -->
</head>
<body>
	@if($check_amount_reward && $check_reward && $activity->status=="T" && date('Y-m-d H:i:s') >= $activity->working_time_start && date('Y-m-d H:i:s') <= $activity->working_time_end)
	<div class="row">
		<div class="col-md-4 col-md-offset-4 logo-margin">
			<img src="{{asset('uploads/logo original.JPG')}}" class="img-responsive center-block respon" alt="Yout Logo Here">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-success phone-form" style="margin-top: 41px;">
				<div class="panel-heading">
					<h3 class="panel-title custom-panel-title">กรอกข้อมูลเบอร์โทรศัพท์</h3>
				</div>
				<div class="panel-body">
					<form class="form-inline" id="FormAdd">
						<div class="form-group">
							<input type="hidden" name="activity_id" value="{{$activity->activity_id}}">
							<label for="add_phone" class="custom-add-phone">เบอร์โทรศัพท์ : </label>
							<input type="text" class="form-control" name="phone" id="add_phone" placeholder="กรอกข้อมูลเบอร์โทรศัพท์">
						</div>
						<div class="form-group">
							<label for="add_branch" class="custom-add-branch" style="font-size:18px;">สาขา : </label>
							<input type="text" class="form-control" name="branch" id="add_branch" placeholder="กรอกสาขา">
						</div>
						<button type="submit" class="btn btn-custom">บันทึกข้อมูล</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endif
</body>
</html>
<script src="{{asset('assets/admin/lib/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.js')}}"></script>

<script type="text/javascript">
@if(!$check_amount_reward || !$check_question || !$check_reward)
swal({
	position: 'center',
	type: 'error',
	title: 'กิจกรรมยังไม่พร้อมใช้งาน',
	text:  'error',
	showConfirmButton: true
},function(){
	var getUrl = '{{url("")}}/admin/Activities';
	window.location = getUrl;
});
@endif
@if($activity->status=='F')
swal({
	position: 'center',
	type: 'error',
	title: 'ไม่พบกิจกรรมนี้',
	text:  'error',
	showConfirmButton: true
},function(){
	var getUrl = '{{url("")}}/admin/Activities';
	window.location = getUrl;
});
@endif
@if(date('Y-m-d H:i:s') > $activity->working_time_end)
swal({
	position: 'center',
	type: 'error',
	title: 'หมดเวลากิจกรรม',
	text:  'error',
	showConfirmButton: true
},function(){
	var getUrl = '{{url("")}}/admin/Activities';
	window.location = getUrl;
});
@endif
@if(date('Y-m-d H:i:s') < $activity->working_time_start)
swal({
	position: 'center',
	type: 'error',
	title: 'หมดเวลากิจกรรม',
	text:  'error',
	showConfirmButton: true
},function(){
	var getUrl = '{{url("")}}/admin/Activities';
	window.location = getUrl;
});
@endif
</script>
<script>
$('body').on('submit','#FormAdd',function(e){
	e.preventDefault();
	if ($.isNumeric($('#add_phone').val()) && $('#add_phone').val().length >=9 && $('#add_phone').val().length <= 10) {
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			method : "POST",
			url : "{{url('/QRCODE')}}",
			dataType : 'json',
			data :$(this).serialize()
		}).done(function(rec){
			if(rec.status==1){
				// var getUrl = '{{url("")}}/admin/Activities/{{$activity->code}}/'+rec.user_id+'/getSpecialQuestion';
				var getUrl = '{{url("")}}/Activities/{{$activity->code}}/'+rec.user_id+'/getQuestion';
				window.location = getUrl;
			}else{
				swal({
					position: 'center',
					type: 'error',
					title: rec.title,
					text:  rec.content,
					showConfirmButton: true
				},function(){
					$('#add_phone').val('');
				});
			}
		}).error(function(){

		});
	}else{
		if(!$.isNumeric($('#add_phone').val())) {
			swal({
				position: 'center',
				type: 'error',
				title: 'ผิดพลาด',
				text:  'ตัวเลขเท่านั้น',
				showConfirmButton: true
			});
		} else {
			swal({
				position: 'center',
				type: 'error',
				title: 'ผิดพลาด',
				text:  '9-10 ตัวอักษรเท่านั้น',
				showConfirmButton: true
			});
		}
	}
});
$('#add_phone').keypress(function(e){
	if (this.value.length == 0 && e.which != 48 ){
		return false;
	}
	if (this.value.length == 1 && e.which == 48 ){
		return false;
	}
});
</script>
