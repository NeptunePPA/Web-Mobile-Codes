@extends ('layout.default')
@section ('content')

<div class="content-area clearfix">
	{{ Form::open(array('url' => 'admin/tracking/users','method'=>'post','id'=>'clients')) }}
	<div class="top-links clearfix clientselect">
		Select Clients: {{Form::select('clients',$clients, $getclient, array('class' => 'name','id'=>'dataclient'))}}
	&nbsp;
		Select Physician: {{Form::select('doctor',$physician, $getdoctor, array('class' => 'doctor','id'=>'datadoctor'))}}
		&nbsp;
		Select Project: {{Form::select('project',$project, $getproject, array('class' => 'project','id'=>'dataproject'))}}
	</div>
	{{ Form::close() }}
	{{ Form::open(array('url' => 'admin/orders/updateall','id'=>'form1')) }}
	<div class="top-links clearfix">
		<ul class="add-links">
			<li><a href="#" id="exportuser" >Export Data</a></li>	
		</ul>
	</div>
	<div class="table">
		<table>
			<thead>
				<tr>
					<th width="30">&nbsp;  </th>
					<th>Username</th>
					<th>Email</th>
					<th>Org.</th>
					<th>Role</th>
					<th>Projects</th>
					<th>#Total Logins</th>
					<th>#Total Orders</th>
					<th>Action</th>
				</tr>
				<tr>

					<td><input type="checkbox" id="checkmain" name="check_users" /></td>
					<td><input type="text" class='search_text' data-field='users.name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='users.email' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='users.client' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='users.roll' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='users.project' name="search[]" /></td>
					<td style="width:75px;"></td>
					<td style="width:75px;"></td>		
					<td style="width:75px;"></td>


				</tr>
			</thead>

			<tbody id="order_result">
			@if(count($users) > 0)
				@foreach($users as $row)
				<tr>
					<td><input type="checkbox" name="order_check[]" value="{{$row->id}}" class="chk_orders" /></td>
					<td>{{$row->name}}</td>
					<td>{{$row->email}}</td>
					<?php 
					$resultstr = array(); 
					foreach ($row->userclients as $row1) {
						$resultstr[] = $row1->clientname['client_name'];
					}

					?>
					<td>{{ implode(",",$resultstr)}}</td>
					<td>{{$row->role->roll_name}}</td>
					<td>{{$row->project_name}}</td>
					<td>{{$row->login()->count()}}</td>
					<td>{{$row->orders()->count()}}</td>

					<td>
						<a href="{{ URL::to('admin/tracking/users/view/'.$row->id) }}">View</a>
						
					</td>
				</tr>
				@endforeach
			@else
				<tr> <td colspan='15' style='text-align:center;'>No result found</td> </tr>
			@endif
			</tbody>

		</table>
	</div>
	{{ Form::close() }}
	<div class="bottom-count clearfix">
		{{$users->count()}} of {{$counts}} displayed 
		{{Form::open(array('url'=>'admin/tracking/users','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
		{{Form::hidden('clients',$getclient)}}
		{{Form::hidden('doctor',$getdoctor)}}
		{{Form::hidden('project',$getproject)}}
		{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$counts=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
		{{Form::close()}}
	</div>
</div>

<script type="text/javascript">

	/*Select all checkbox*/
	$("#checkmain").change(function () {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});

	$(document).on("click","#exportuser",function (event) {
        
        if($(".chk_orders:checked").length == 0)
        {
            
            alert("Please select record and export");
            return false;
        }
        else
        {
  
            var ck_rep = new Array();
             $.each($("input[name='order_check[]']:checked"), function() {
            var ck_reps = $(this).val();

            ck_rep.push(ck_reps);
             });

             var getclient = $('#dataclient').val();
             var getdoctor = $("#datadoctor").val();
             var getproject = $("#dataproject").val();

            $.ajax({
            url: "{{URL::to('admin/tracking/users/export')}}",
            data: {
                        _token: "{{ csrf_token() }}",
                        ck_rep:ck_rep,
                        getclient:getclient,
                		getdoctor : getdoctor,
                		getproject :getproject
                    },
            type: "POST",
            success: function (response, textStatus, request) {
                var a = document.createElement("a");
                a.href = response.file; 
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }
        });
        }
    });


	/*submit client id form*/
	$("#dataclient").change(function(){

		$("#clients").submit();
		return true;
	});

    $("#datadoctor").change(function(){

        $("#clients").submit();
        return true;
    });

    $("#dataproject").change(function(){

        $("#clients").submit();
        return true;
    });

    /*Search Data*/

	$(".search_text").keyup(function () {
		
		var search = new Array();
		$.each($("input[name='search[]']"), function() {
			var ck_reps = $(this).val();

			search.push(ck_reps);
		});

		// console.log(search);

        var getclient = $('#dataclient').val();
        var getdoctor = $("#datadoctor").val();
        var getproject = $("#dataproject").val();

		$.ajax({
			url: "{{ URL::to('admin/tracking/users/search')}}",
			data: {
				_token: "{{ csrf_token() }}",
				search: search,
                getclient:getclient,
                getdoctor : getdoctor,
                getproject :getproject
			},
			type: "POST",
			success: function (data) {
				
				var html_data = '';

				if (data.status) {
					$.each(data.value, function (i, item) {
						 			var project = (item.project_name != null) ? item.project_name : '';
                                    var manufacturer = (item.manufacturer != null) ? item.manufacturer : '';

                                    html_data +="<tr><td><input type='checkbox' name='order_check[]' value=' " + item.id + "' class='chk_orders' /></td><td>"+item.name+"</td><td>"+item.email+ "</td><td>"+item.clientarr+"</td><td>"+ item.roll_name +"</td><td>"+project+"</td><td>"+item.login+"</td><td>"+item.orders+"</td><td><a href=../tracking/users/view/"+item.id+">view</a></td></tr>";
                                });
				} else {
					html_data = "<tr> <td colspan='15' style='text-align:center;'> " + data.value + " </td> </tr>"
				}

				$("#order_result").html(html_data);

			}

		});

	});
	
</script>
@stop 