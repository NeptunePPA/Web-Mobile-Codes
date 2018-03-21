@extends ('layout.default')
@section ('content')
<div class="content-area clearfix">
	{{ Form::open(array('url' => 'admin/tracking/orders','method'=>'post','id'=>'clients')) }}
	<div class="top-links clearfix clientselect">
		{{Form::select('clientname',$clients,$getclient,array('class' => 'clientname dataclient','id'=>'clientname'))}}
		{{Form::select('physicianname',$physician,$getphysician, array('class' => 'clientname dataclient','id'=>'physicianname'))}}
		{{Form::select('items',$devices,$getdevice, array('class' => 'clientname dataclient','id'=>'items'))}}
		{{Form::select('status',array(''=>'All','New'=>'New', 'Complete'=>'Complete','Cancelled'=>'Cancelled'),$getstatus, array('class' => 'clientname dataclient','id'=>'status'))}}
		
	</div>
	{{ Form::close()}}
	
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
					<th>Client Name</th>
					<th>Physician</th>
					<th>Manufacturer</th>
					<th>Device Name</th>
					<th>Model No.</th>
					<th>Order Date</th>
					<th>No Of Logins</th>
					<th>Login Date</th>
					<th>Status</th>
					<th>Completion Date</th>
					<th>Cancellation Date</th>

				</tr>
				<tr>

					<td><input type="checkbox" id="checkmain"/></td>
					<td><input type="text" class='search_text' data-field='clients.client_name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.orderby' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='manufacturers.manufacturer_name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='device.model_name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='device.model_no' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.order_date' name="search[]" /></td>
					<td style="width: 30px;"></td>
					<td><input type="text" class='search_text' data-field='orders.login_date' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.status' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.complete' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.cancelled' name="search[]" /></td>					
				</tr>
			</thead>

			<tbody id="order_result">

			@if(count($orderlist)> 0)
				@foreach($orderlist as $row)
				<tr>
					<td><input type="checkbox" name="order_check[]" value="{{$row->id}}" class="chk_orders" /></td>
					<td>{{$row->orderclients['client_name']}}</td>
					<td>{{$row->user['name']}}</td>
					<td>{{$row->manufacturer['manufacturer_name']}}</td>
					<td>{{$row->devicename['device_name']}}</td>
					<td>{{$row->devicename['model_name']}}</td>
					<td>{{$row->order_date}}</td>
					<td>{{$row->login}}</td>
					<td>{{$row->order_date}}</td>
					<td>{{$row->status}}</td>
					@if($row->status == "Complete")
						<td>{{$row->updated_at == '' ? '-' : Carbon\Carbon::parse($row->updated_at)->format('Y-m-d') }}</td>	
					@else
						<td>-</td>
					@endif

					@if($row->status == "Cancelled")
						<td>{{$row->updated_at == '' ? '-' : Carbon\Carbon::parse($row->updated_at)->format('Y-m-d') }}</td>	
					@else
						<td>-</td>
					@endif
					
				</tr>
				@endforeach
			@else 
			<tr> <td colspan='15' style='text-align:center;'> No Result Found </td> </tr>
			@endif
			</tbody>

		</table>
	</div>
	<div class="bottom-count clearfix">
		{{$orderlist->count()}} of {{$counts}}  displayed 
		{{Form::open(array('url'=>'admin/tracking/orders','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
		{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$counts=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
		{{Form::hidden('clientname',$getclient)}}
		{{Form::hidden('physicianname',$getphysician)}}
		{{Form::hidden('items',$getdevice)}}
		{{Form::hidden('status',$getstatus)}}
		
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

             
            $.ajax({
            url: "{{URL::to('admin/tracking/orders/export')}}",
            data: {
                        _token: "{{ csrf_token() }}",
                        ck_rep:ck_rep,
                       
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
	$(".dataclient").change(function(){

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

		var clientname = $("#clientname").val();
		var physicianname = $("#physicianname").val();
		var items = $("#items").val();
		var status = $("#status").val();
		

		$.ajax({
			url: "{{ URL::to('admin/tracking/orders/search')}}",
			data: {
				_token: "{{ csrf_token() }}",
				search: search,
				clientname:clientname,
				physicianname:physicianname,
				items:items,
				status:status
			},
			type: "POST",
			success: function (data) {

				var html_data = '';

				if (data.status) {

									$.each(data.value, function (i, item) {	
							 			
							 			var client = item.cname == null ? '' : item.cname;
							 			var manufacturer = item.mname == null ? '' : item.mname;
							 			var device_name = item.dname == null ? '' : item.dname;
							 			var model_name = item.dmodel == null ? '' : item.dmodel;
							 			var oby = item.oby == null ? '' : item.oby;	
							 			var status = item.status;
							 			var update = item.updated_date;

							 			
							 			if(status == "Complete"){
							 				var complete = update
							 			} else {
							 				var complete = "-";
							 			}


							 			if(status == "Cancelled"){
							 				var cancelled = update
							 			} else {
							 				var cancelled = "-";
							 			}


	                                    html_data +="<tr><td><input type='checkbox' name='order_check[]' value='"+ item.id +"' class='chk_orders' /></td><td>"+client+"</td><td>"+oby+"</td><td>"+manufacturer+ "</td><td>"+device_name+"</td><td>"+ model_name +"</td><td>"+item.order_date+"</td><td>"+item.login+"</td><td>"+item.order_date+"</td><td>"+item.status+"</td><td>"+complete+"</td><td>"+cancelled+"</td></tr>";
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