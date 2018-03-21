@extends ('layout.default')
@section ('content')

<div class="content-area clearfix">
	{{ Form::open(array('url' => 'admin/tracking/organization','method'=>'post','id'=>'clients')) }}
	<div class="top-links clearfix clientselect">
		Select Clients: {{Form::select('clients',$clients, $getclient, array('class' => 'name','id'=>'dataclient'))}}
	</div>
	{{ Form::close() }}
	{{ Form::open(array('url' => 'admin/orders/updateall','id'=>'form1')) }}
	<div class="top-links clearfix">
		<ul class="add-links">
			<li><a href="#" id="exportorder" >Export Data</a></li>	
		</ul>
	</div>
	<div class="table">
		<table>
			<thead>
				<tr>
					<th width="30">&nbsp;  </th>
					<th>Client</th>
					<th># of Users</th>
					<th># of Logins</th>
					<th># of Projects</th>
					<th># of Orders</th>
					<th>Action</th>
				</tr>
				<tr>

					<td><input type="checkbox" id="checkmain"/></td>
					<td><input type="text" class='search_text' data-field='clients.client_name' name="search[]" /></td>
					<td style="width:155px;"></td>
					<td style="width:155px;"></td>
					<td style="width:155px;"></td>
					<td style="width:155px;"></td>
					<td style="width:155px;"></td>


				</tr>
			</thead>

			<tbody id="order_result">
			@if(count($organizations)> 0)
				@foreach($organizations as $row)
				<tr>
					<td><input type="checkbox" name="order_check[]" value="{{$row->id}}" class="chk_orders" /></td>
					<td>{{$row->client_name}}</td>
					<td>{{$row->user}}</td>
					<td>{{$row->login}}</td>
					<td>{{$row->projectclients->count()}}</td>
					<td>{{$row->clientorders->count()}}</td>
					<td><a href="{{URL::to('admin/tracking/organization/view/'.$row->id)}}">View</a></td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan='15' style='text-align:center;'> No Result Found</td>
				</tr>
			@endif
			</tbody>

		</table>
	</div>
	{{ Form::close() }}
	<div class="bottom-count clearfix">
		{{$organizations->count()}} of {{$counts}}  displayed 
		{{Form::open(array('url'=>'admin/tracking/organization','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
		{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$counts=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
		{{Form::hidden('clients',$getclient)}}
		{{Form::close()}}
	</div>
</div>

<script type="text/javascript">

	/*Select all checkbox*/
	$("#checkmain").change(function () {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});

	$(document).on("click","#exportorder",function (event) {
        
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

             var getclient = document.getElementById('dataclient').value;

            $.ajax({
            url: "{{URL::to('admin/tracking/organization/export')}}",
            data: {
                        _token: "{{ csrf_token() }}",
                        ck_rep:ck_rep,
                        getclient:getclient
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

	/*Search Data*/

	$(".search_text").keyup(function () {
		
		var search = new Array();
		$.each($("input[name='search[]']"), function() {
			var ck_reps = $(this).val();

			search.push(ck_reps);
		});

		// console.log(search);

		var dataclient = document.getElementById('dataclient').value;

		$.ajax({
			url: "{{ URL::to('admin/tracking/organization/search')}}",
			data: {
				_token: "{{ csrf_token() }}",
				search: search,
				dataclient : dataclient,
			},
			
			success: function (data) {
				console.log(data);
				var html_data = '';

				if (data.status) {
					$.each(data.value, function (i, item) {
					 			
					 			html_data +="<tr><td><input type='checkbox' name='order_check[]' value='"+item.id+"' class='chk_orders' /></td><td>"+item.client_name+"</td><td>"+item.userscount+ "</td><td>"+ item.userlogin.login + "</td><td>"+ item.projectscount +"</td><td>"+item.ordercount+"</td><td><a href=../tracking/organization/view/"+item.id+">view</a></td></tr>";
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