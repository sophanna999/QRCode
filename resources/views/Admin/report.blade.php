@extends('Admin.layouts.layout')
@section('css_bottom')
<style>
  	.widget svg text, .widget .nvd3 text {
    	fill: #000;
	}
</style>
@endsection
@section('body')
<div class="col-lg-12">
	<h2 class="page-title">
		{{$title_page or '' }}
		<div class="pull-right">
			<!-- <button class="btn btn-success btn-add">
				+เพิ่ม{{$title_page or '' }}
			</button> -->
		</div>
	</h2>

	<section class="widget widhget-min-hight">
        <div class="row">
            <div class="form-group col-md-3 col-md-offset-3">
                <label for="add_activity_name">วันเริ่มต้น</label>
                <input type="text" class="date form-control" name="start" id="start"  placeholder="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}">
            </div>
            <div class="col-md-3 form-group">
                <label for="add_activity_name">วันสิ้นสุด</label>
            <input type="text" class="date form-control" name="end" id="end"  placeholder="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}">
            </div>
        </div>
		<div class="body no-margin table-responsive chart">
            <!-- <div class="col-md-6">
                <canvas id="myChart"></canvas>
            </div> -->
		</div>
	</section>
</div>
@endsection
@section('js_bottom')
<script>
    $(".date").datetimepicker({
      minView: 2,
      'showTimepicker': false,
      format: 'yyyy-mm-dd'
    });
    var arr = [];
    // var ctx = document.getElementById('myChart').getContext('2d');
    // var chart = new Chart(ctx, {
    //     // The type of chart we want to create
    //     type: 'bar',
    //
    //     // The data for our dataset
    //     data: {
    //         labels: ['s','a','b'],
    //         datasets: [{
    //             label: "คำถาม ",
    //             backgroundColor: 'rgb(255, 99, 132)',
    //             borderColor: 'rgb(255, 99, 132)',
    //             data: [15,20,30],
    //         }]
    //     },
    //
    //     // Configuration options go here
    //     options: {}
    // });

    $(function() {
        getChart();
    });
    $('#start,#end').change(function() {
        getChart();
    });
    function getChart() {
        $.ajax({
            url: url_gb+'/admin/ActivityRewardUser/report/'+$('#start').val()+'/'+$('#end').val(),
            method: "get",
            dataType : 'json',
        }).done(function(rec) {
            var color = [
                'rgb(255, 99, 132)',
                'rgb(156, 156, 156)',
                'rgb(255, 204, 204)',
                'rgb(204, 255, 230)',
                'rgb(242, 255, 204)',
                'rgb(255, 204, 204)',
                'rgb(230, 0, 230)',
                'rgb(255, 204, 204)',
                'rgb(255, 217, 204)',
                'rgb(242, 255, 204)',
                'rgb(204, 255, 217)',
                'rgb(204, 255, 255)',
                'rgb(255, 204, 230)',
            ];
            var id = '';
            var num = 0;
            var index = 0;
            arr.lenght = 0;
            $.each(rec.data, function(k,v) {
                if(v.q_id!=id) {
                    $('.chart').append(`
                        <div class="col-md-6">
                        <canvas id="myChart_`+(num+1)+`"></canvas>
                        </div>
                    `);
                    index = 0;
                    num++;
                    id = v.q_id;
                    arr[num] = [];
                    arr[num]['text'] = [];
                    arr[num]['data'] = [];
                }
                arr[num]['label'] = $(v.q_text).text();
                arr[num]['text'][index] = v.a_text;
                arr[num]['data'][index] = (v.ans_count!=null)?v.ans_count:"0";
                index++;
            });
            for(var i=1;i<=arr.length;i++) {
                var rand = color[Math.floor(Math.random() * color.length)];
                var ctx = document.getElementById('myChart_'+i).getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',

                    // The data for our dataset
                    data: {
                        labels: arr[i].text,
                        datasets: [{
                            label: "คำถาม "+arr[i].label,
                            backgroundColor: rand,
                            borderColor: rand,
                            data: arr[i].data,
                        }]
                    },

                    // Configuration options go here
                    options: {}
                });
            }
        });
    }
</script>
@endsection
