<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <title>Document</title> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}" />
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet"> -->
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap.min.css.map')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css.map')}}" />
	<link rel="stylesheet" href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/admin/css_main_process/custom.css')}}" />
</head>
<body>

    <div class="container override" style="border-style: solid;padding-bottom: 35px;border-width: 1px;">
       <div class="question-form">

          <div class="question-title-2">
              <h2>{{$activity->activity_name}} {{$userid}}</h2>
          </div>

        <br>

        @php $i=1; @endphp
        <form id="answer_history">
            {!! csrf_field() !!}
            <input type="hidden" name="activity_id" value="{{$activity->activity_id}}">
            <input type="hidden" name="user_id" value="{{$userid}}">
            @foreach($question as $qt)
            <div class="col-md-10 col-md-offset-1 padding-zero">
                <!-- <div class="card border-dark mb-3"> -->

                    <div class="card-body text-dark">
                    <h5 class="card-title card-title-font">คำถามข้อที่ {{$i}}</h5>
                      <p class="card-text">
                        <div class="table-responsive">

                          {!!$qt->text!!}

                        </div>
                      </p>
                    @if($qt->answer) <hr>
                    @endif
                    @php $j=1; @endphp
                    @foreach($qt->answer as $ans)
                        <div class="col-md-12">
                            <label class="checkbox-inline"><input type="radio" name="question_{{$ans->question_id}}" value="{{$ans->question_id}}|{{$ans->answer_id}}">&nbsp;&nbsp;{{$j}} . {{$ans->text}}</label>
                        </div>
                        @php $j++; @endphp
                    @endforeach
                    </div>
                <!-- </div> -->
            </div>
            @php $i++; @endphp
            @endforeach

            <div class="offset-md-1 col-md-12">
                <center>
                    <button type="submit" class="btn btn-custom btn-block" style="width: 17%;margin: auto;height: 45px;">ส่งคำตอบ</button>
                </center>
            </div>
        </form>
        <br>


    </div>
  </div>

</body>
<script src="{{asset('assets/admin/lib/jquery/dist/jquery.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.js')}}"></script>
<script>
    $('body').on('submit','#answer_history',function(e){
		e.preventDefault();
		$.ajax({
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
                method : "POST",
                url : "{{url('/AnswerHistory')}}",
                dataType : 'json',
                data :$(this).serialize()
            }).done(function(rec){
                if (rec.status == 1) {
					//var getUrl = '{{url("")}}/Activities/randomReward/'+rec.activity_id+'/'+rec.user_id+'/'+rec.result;
                    var getUrl = '{{url("")}}/Activities/randomReward/'+rec.code;
                	window.location = getUrl;
				} else {
                    swal({
                    	position: 'center',
                    	type: 'error',
                    	title: 'คุณเคยตอบคำถามแล้ว',
                    	text:  'error',
                    	showConfirmButton: true
                    },function(){
                        var getUrl = '{{url("")}}/Activities/randomReward/'+rec.code;
                        window.location = getUrl;
                    });
                }
            });
	});
</script>
</html>
