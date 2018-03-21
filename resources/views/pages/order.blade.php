@extends ('layout.default')
@section ('content')

	<div class="content-area clearfix">
	{{ Form::open(array('url' => 'admin/orders/updateall','id'=>'form1')) }}
		<div class="top-links clearfix">
			<ul class="add-links">
				<li><a href="#" id="exportorder" >Export</a></li>
				<li><a href="#" title=""  onclick="archive();">Archive</a></li>
				<li><a href="{{ URL::to('admin/orders/viewarchive') }}" title="">View Archived</a></li>
			</ul>
			<div  style="float:right;">
			<a href="#" id="submit"><button class="btn_add_new" style="width:100px; height: 35px;">EDIT / SAVE</button>
				
			</a>
		</div>
		</div>
		<div class="table">
			<table>
				<thead>
				<tr>
					<th width="30">&nbsp;  </th>
					<th>ID</th>
					<th>Client Name</th>
					<th>Manufacturer</th>
					<th>Device Name</th>
					<th>Model No.</th>
					<th>Unit Cost</th>
					<th>System Cost</th>
					<th>CCO</th>
					<th>REIMB</th>
					<th>Order date</th>
					<th>Ordered By</th>
					<th>Rep</th>
					<th>Sent to</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<tr>
				
					<td><input type="checkbox" id="checkmain"/></td>
					<td><input type="text" class='search_text' data-field='orders.id' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='clients.client_name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='manufacturers.manufacturer_name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.model_name' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.model_no' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.unit_cost' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.system_cost' name="search[]" /></td>				
					<td><input type="text" class='search_text' data-field='orders.cco' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.reimbrusement' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='orders.order_date' name="search[]" /></td>
					<td><input type="text" class='search_text' data-field='ob.name'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='users.name'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='orders.sent_to'  name="search[]"/></td>
					<td><input type="text" class='search_text' data-field='orders.status' name="search[]" /></td>
					<td style="width:75px;"></td>

				
				</tr>
				</thead>
				
				<tbody id="order_result">
					@foreach($orders as $order)
					<tr>
					<td><input type="checkbox" name="order_check[]" value="{{$order->id}}" class="chk_orders" /></td>
					<td>{{$order->id}}</td>
					<td>{{$order->client_name}}</td>
					<td>{{$order->manufacturer_name}}</td>
					<td>{{$order->devicename['device_name']}}</td>
					<td>{{$order->devicename['model_name']}}</td>
					<td>{{$order->unit_cost == 0 ? "-" : "$".$order->unit_cost}}</td>
					<td>{{$order->system_cost == 0 ? "-" : "$".$order->system_cost}}</td>
					<td>{{$order->cco == 0 ? "-" : "$".$order->cco}}</td>
                    <td>{{$order->reimbrusement == 0 ? "-" : "$".$order->reimbrusement}}</td>				
					<td>{{$order->order_date}}</td>
					<td>{{$order->ob_name }}</td>
					<td>{{$order->name}}</td>
					<td>{{$order->sent_to}}</td>
					<td>{{ Form:: hidden('hiddenid[]',$order->id)}}{{ Form::select('status[]',array('Complete' => 'Complete', 'Pending' => 'Pending', 'New' => 'New','Cancelled' => 'Cancelled'),$order->status) }}</td>				
					<td>
						<a href="{{ URL::to('admin/orders/edit/'.$order->id) }}"><i class="fa fa-edit"></i></a>
						&nbsp;
						@if(Auth::user()->roll != 4)
						<a href="{{ URL::to('admin/schedule/create/'.$order->id) }}"><i class="fa fa-calendar" aria-hidden="true"></i></a>
						@endif
						&nbsp; <a href="{{ URL::to('admin/orders/remove/'.$order->id) }}" onclick="return confirm(' Are you sure you want to delete order?');"><i class="fa fa-close"></i></a>
					</td>
					</tr>
					@endforeach
				</tbody>
				
			</table>
		</div>
		{{ Form::close() }}
		<div class="bottom-count clearfix">
			{{$orders->count()}} of {{$count}} displayed 
				{{Form::open(array('url'=>'admin/orders','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
					{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
				{{Form::close()}}
		</div>
	</div>


<script>
$(document).ready(function(){

$("#checkmain").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
		$(".search_text").keyup(function () {
          
			 var search = new Array();
             $.each($("input[name='search[]']"), function() {
            var ck_reps = $(this).val();

            search.push(ck_reps);
             });


            $.ajax({
                url: "{{ URL::to('admin/search_order')}}",
                data: {
						 _token: "{{ csrf_token() }}",
                        search: search,
					},
                success: function (data) {
					
                    var html_data = '';
                    if (data.status) {
                        $.each(data.value, function (i, item) {
							var complete_selected = (item.status == "Complete") ? "selected":"";
							var pending_selected = (item.status == "Pending") ? "selected":"";
							var new_selected = (item.status == "New") ? "selected":"";
							var cancel_selected = (item.status == "Cancelled") ? "selected":"";
							var unit_cost = (item.unit_cost == 0) ? "-" : "$" + item.unit_cost;
							var system_cost = (item.system_cost == 0) ? "-" : "$" + item.system_cost;
							var cco = (item.cco == 0) ? "-" : "$" + item.cco;
							var reimbrusement = (item.reimbursement == 0) ? "-" : "$" + item.reimbrusement;
							var repname = (item.name == null) ? "" : item.name; 
							var client_name = (item.client_name == null) ? "" : item.client_name; 
							if({{Auth::user()->roll != 4}}){

								var action = "<a href=orders/edit/"+item.id+"><i class='fa fa-edit'></i></a>&nbsp;<a href=schedule/create/"+item.id+"><i class='fa fa-calendar' aria-hidden='true'></i></a>&nbsp; <a href=orders/remove/"+item.id+" onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;order?');><i class='fa fa-close'></i></a>";
							} else{
								var action = "<a href=orders/edit/"+item.id+"><i class='fa fa-edit'></i></a>&nbsp;<a href=orders/remove/"+item.id+" onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;order?');><i class='fa fa-close'></i></a>";
							}
							
                          html_data += "<tr><td><input type='checkbox' name='order_check[]' value=" + item.id + " class='chk_orders'/></td><td>"+item.id+"</td><td>" + client_name + "</td><td>"+item.manufacturer_name+"</td><td>"+item.device+"</td><td>"+item.model+"</td><td>"+unit_cost+"</td><td>"+system_cost+"</td><td>"+cco+"</td><td>"+reimbrusement+"</td><td>"+item.order_date+"</td><td>"+item.ob_name+"</td><td>"+repname+"</td><td>"+item.sent_to+"</td><td><input type='hidden' value='"+item.id+"' name='hiddenid[]' /><select name='status[]'><option value='0'>Status</option><option value='Complete' "+complete_selected+">Complete</option><option value='Pending' "+pending_selected+">Pending</option><option value='New' "+new_selected+">New</option><option value='Cancelled' "+cancel_selected+">Cancelled</option></select></td><td>"+ action +"</td></tr>";

                        });
                    } else {
                        html_data = "<tr> <td colspan='15' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    $("#order_result").html(html_data);

                }

            });

        });
	
	
	$("#exportorder").click(function(){
		if($(".chk_orders:checked").length == 0)
		{
			alert("Please select record and export");
			return false;
		}
		else
		{
			
		    $("#form1").attr("action","orders/export").attr("method","POST").submit();
			return true;
		}
		
	});
	
	$("#submit").click(function(){
        
            $("#form1").submit();
            return true;
    });
	
});
function archive()
	{
		var fields = $("input[name='order_check[]']").serializeArray(); 
    if (fields.length == 0) 
    { 
        alert('Please Select Record'); 
        // cancel submit
        return false;
    } 
    else 
    { 
        $("#form1").attr("action", "orders/archive").attr("method","post").submit();
    }
		
	}
</script>
@stop 