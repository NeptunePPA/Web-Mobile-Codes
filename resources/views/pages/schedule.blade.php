@extends ('layout.default')
@section ('content')

	<div class="content-area clearfix">
	{{ Form::open(array('url' => 'admin/schedule/updateall','id'=>'formschedule')) }}
		<div class="top-links clearfix">
			<ul class="add-links">
				<li><a title="Add Device" href="{{ URL::to('admin/schedule/add') }}">Add Schedule Event</a></li>
				<li><a href="#" id="scheduleexport">Export</a></li>
			</ul>
			<div  style="float:right;">
			<!--{{ Form::submit('EDIT / SAVE',array('class'=>'btn_add_new','style'=>'width:100px; height:30px;')) }}-->
		</div>
		</div>
		<div class="table">
			<table>
				<thead>
				<tr>
					<th width="30">&nbsp;  </th>
					<th>ID</th>
					<th>Project</th>
					
					<th>Client Name</th>
					
					<th>Physician</th>
					<th>Patient ID</th>
					<th>Manufacturer</th>
					<th>Device Name</th>
					<th>Model #</th>
					<th>Rep Name</th>
					<th>Event date</th>
					<th>Start Time</th>
					<th>Action</th>
				</tr>
				<tr>
					<td><input type="checkbox" id="checkmain"/></td>
					<td><input type="text" class='search_text' data-field='schedule.id'  name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='projects.project_name'  name="search[]"/></td>
					
					<td><input type="text" class='search_text' data-field='clients.client_name'  name="search[]"/></td>
					
					<td><input type="text" class='search_text' data-field='users.name'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='schedule.patient_id'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='manufacturers.manufacturer_name'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='device.device_name'  name="search[]"/></td>				
					<td><input type="text" class='search_text' data-field='schedule.model_no'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='schedule.rep_name'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='schedule.event_date' style="width:80px;" name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='schedule.start_time' style="width:58px;" name="search[]"/></td>
					<td style="width:50px;"></td>

					
				</tr>
				</thead>
				
				<tbody id="schedule_result">
					@foreach($schedules as $schedule)
					{{ Form::hidden('hiddenid[]',$schedule->id)}}
					<tr>
					<td><input type="checkbox" name="schedule_chk[]" value="{{$schedule->id}}" class="schedule_chk"/></td>
					<td>{{ $schedule->id }}</td>
					<td>{{ $schedule->pro_name == "" ? '-' : $schedule->pro_name }}</td>
					
					<td>{{ $schedule->client_name == "" ? '-' : $schedule->client_name}}</td>
					
					<td>{{ $schedule->name == "" ? '-': $schedule->name }}</td>
					<td>{{ $schedule->patient_id }}</td>
					<td>{{ $schedule->manufacturer_name == "" ? '-' : $schedule->manufacturer_name }}</td>
					<td>{{ $schedule->device == "" ? '-' : $schedule->device}}</td>				
					<td>{{ $schedule->model_no == "" ? '-' : $schedule->model_no}}</td>
					<td>{{ $schedule->rep_name == "" ? '-' : $schedule->rep_name}}</td>
					<td>{{ $schedule->event_date }}</td>
					<td>{{$schedule->start_time }}</td>
					<td>
						<a href="{{ URL::to('admin/schedule/edit/'.$schedule->id) }}"><i class="fa fa-edit"></i></a>
						&nbsp; <a href="{{ URL::to('admin/schedule/remove/'.$schedule->id) }}" onclick="return confirm(' Are you sure you want to delete schedule?');"><i class="fa fa-close"></i></a>
					</td>
					</tr>
					@endforeach
				</tbody>
				{{ Form::close() }}			
			</table>
		</div>
		
		<div class="bottom-count clearfix">
			{{$schedules->count()}} of {{$count}} displayed 
				{{Form::open(array('url'=>'admin/schedule','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
					{{Form::select('pagesize', array('10' => 'Show 10','15'=>'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
				{{Form::close()}}
		</div>
	</div>


<script>
$(document).ready(function(){

		$("#checkmain").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
		$(".search_text").keyup(function () {
            var userrole = {{Auth::user()->roll}};
			
            var search = new Array();
             $.each($("input[name='search[]']"), function() {
            var ck_reps = $(this).val();

            search.push(ck_reps);
             });

			if(userrole == 1)
			{
			

				$.ajax({
					url: "{{ URL::to('admin/search_schedule')}}",
					data: {
						 _token: "{{ csrf_token() }}",
                        search: search,
					},
					success: function (data) {
						var html_data = '';
						if (data.status) {
							$.each(data.value, function (i, item) {
								var manufacturer = (item.manufacturer_name != null) ? item.manufacturer_name : '-';
								var project = (item.pro_name != null) ? item.pro_name : '-';
								var client = (item.client_name != null) ? item.client_name : '-';
								var physician = (item.name != null) ? item.name : '-';
								var device = (item.device != null) ? item.device : '-';
								var model_no = (item.model_no != null) ? item.model_no : '-';
								var rep_name = (item.rep_name != null) ? item.rep_name : '-';
								
								
								html_data += "<tr><td><input type='checkbox' name='schedule_chk[]' value="+ item.id +" class='schedule_chk' /></td><td>"+item.id+"</td><td>"+project+"</td><td>"+client+"</td><td>"+physician+"</td><td>"+item.patient_id+"</td><td>"+manufacturer+"</td><td>"+device+"</td><td>"+model_no+"</td><td>"+rep_name+"</td><td>"+item.event_date+"</td><td>"+ item.start_time+"</td><td><a href=schedule/edit/"+item.id+"><i class='fa fa-edit'></i></a>&nbsp; <a href=schedule/remove/"+item.id+" onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;schedule?');><i class='fa fa-close'></i></a></td></tr>";

							});
						} else {
							html_data = "<tr> <td colspan='13' style='text-align:center;'> " + data.value + " </td> </tr>"
						}

						$("#schedule_result").html(html_data);

					}

				});
			}
			else
			{
				$.ajax({
					url: "{{ URL::to('admin/search_schedule')}}",
					data: {
						 _token: "{{ csrf_token() }}",
                        search: search,
					},
					success: function (data) {
						var html_data = '';
						if (data.status) {
							$.each(data.value, function (i, item) {

								var manufacturer = (item.manufacturer_name != null) ? item.manufacturer_name : '-';
								var client = (item.client_name != null) ? item.client_name : '-';
								
								var project = (item.pro_name != null) ? item.pro_name : '-';
								var physician = (item.name != null) ? item.name : '-';
								var device = (item.device != null) ? item.device : '-';
								var model_no = (item.model_no != null) ? item.model_no : '-';
								var rep_name = (item.rep_name != null) ? item.rep_name : '-';


								html_data += "<tr><td><input type='checkbox' name='schedule_chk[]' value="+ item.id +" class='schedule_chk' /></td><td>"+item.id+"</td><td>" +project + "</td><td>"+client+"</td><td>" + physician + "</td><td>"+item.patient_id+"</td><td>" + manufacturer + "</td><td>" +device + "</td><td>" + model_no + "</td><td>" + rep_name + "</td><td>"+item.event_date+"</td><td>"+ item.start_time+"</td><td><a href=schedule/edit/"+item.id+"><i class='fa fa-edit'></i></a>&nbsp; <a href=schedule/remove/"+item.id+" onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;schedule?');><i class='fa fa-close'></i></a></td></tr>";

							});
						} else {
							html_data = "<tr> <td colspan='13' style='text-align:center;'> " + data.value + " </td> </tr>"
						}

						$("#schedule_result").html(html_data);

					}

				});
			}

        });
		
		
	$("#scheduleexport").click(function(){
		
		if($(".schedule_chk:checked").length == 0)
		{
			
			alert("Please select record and export");
			return false;
		}
		else
		{
			
		    $("#formschedule").attr("action","schedule/export").attr("method","POST").submit();
			return true;
		}
	});
});
</script>

@stop 