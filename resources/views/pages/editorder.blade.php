@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="add_new_box" style="margin-left:28%;">
	        
	<div class="col-md-12 col-lg-12 modal-box">            
	<a title="" href="{{ URL::to('admin/orders') }}" class="pull-right" data-toggle="modal" >X</a>
	<h4 style="text-align:center;"> Order Details </h4>
          {{ Form::model($orders,['method'=>'PATCH','action'=>['orders@update', $orders->id]]) }}
            @if(Auth::user()->roll == 1)
			<div class="input1">
				{{Form::label('label1', 'Manufacturer Name:')}}
                {{ Form::text('manufacturer_name',$orders->manufacturer->manufacturer_name,array('readonly'=>'True')) }}
				{{Form::hidden('manufacture',$orders->manufacturer_name)}}
            </div>
			<div class="input1">
				{{Form::label('label2', 'Model Name:')}}
                {{ Form::text('model_name',null,array('placeholder'=>'Model Name','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label2', 'Model #:')}}
                {{ Form::text('model_no',null,array('placeholder'=>'Model No','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label3', 'Unit Cost:')}}
                {{ Form::text('unit_cost',null,array('placeholder'=>'Unit Cost','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label4', 'System Cost:')}}
                {{ Form::text('system_cost',null,array('placeholder'=>'System Cost','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label5', 'CCO:')}}
                {{ Form::text('cco',null,array('placeholder'=>'CCO','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label6', 'Reimbursement:')}}
                {{ Form::text('reimbrusement',null,array('placeholder'=>'Reimbursement','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label7', 'Order Date:')}}
                {{ Form::text('order_date',null,array('placeholder'=>'Order Date','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label8', 'Order By:')}}
                {{ Form::text('orderby',$orders->obname,array('placeholder'=>'Order By','readonly'=>'True'))}}
				{{Form::hidden('orderbyuser',$orders->orderby)}}
            </div>
			<div class="input1">
				{{Form::label('label9', 'Rep:')}}
                {{ Form::text('rep',$orders->name,array('placeholder'=>'Rep','readonly'=>'True'))}}
				{{Form::hidden('repuser',$orders->rep)}}
            </div>
			<div class="input1">
				{{Form::label('label10', 'Sent to:')}}
                {{ Form::text('sent_to',null,array('placeholder'=>'Email','readonly'=>'True'))}}
            </div>
			<div class="input1">
				{{Form::label('label11', 'Status:')}}
                {{ Form::select('status',array('0' => 'Status','Complete' => 'Complete', 'Pending' => 'Pending', 'New' => 'New', 'Cancelled' => 'Cancelled')) }}
            </div>
		
			@else
				
			<div class="input1">
				{{Form::label('label1', 'Manufacturer Name:')}}
                {{ Form::text('manufacturer_name',$orders->manufacturer_name,array('readonly'=>'true')) }}
            </div>
			<div class="input1">
				{{Form::label('label2', 'Model Name:')}}
                {{ Form::text('model_name',null,array('placeholder'=>'Model Name','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label2', 'Model #:')}}
                {{ Form::text('model_no',null,array('placeholder'=>'Model No','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label3', 'Unit Cost:')}}
                {{ Form::text('unit_cost',null,array('placeholder'=>'Unit Cost','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label4', 'System Cost:')}}
                {{ Form::text('system_cost',null,array('placeholder'=>'System Cost','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label5', 'CCO:')}}
                {{ Form::text('cco',null,array('placeholder'=>'CCO','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label6', 'Reimbursement:')}}
                {{ Form::text('reimbrusement',null,array('placeholder'=>'Reimbursement','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label7', 'Order Date:')}}
                {{ Form::text('order_date',null,array('placeholder'=>'Order Date','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label8', 'Order By:')}}
                {{ Form::text('orderby',$orders->obname,array('placeholder'=>'Order By','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label9', 'Rep:')}}
                {{ Form::text('rep',$orders->name,array('placeholder'=>'Rep','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label10', 'Sent to:')}}
                {{ Form::text('sent_to',null,array('placeholder'=>'Email','readonly'=>'true'))}}
            </div>
			<div class="input1">
				{{Form::label('label11', 'Status:')}}
                {{ Form::select('status',array('0' => 'Status','Complete' => 'Complete', 'Pending' => 'Pending', 'New' => 'New', 'Cancelled' => 'Cancelled'),$orders->status) }}
            </div>
			@endif
            <div>
                {{ Form::submit('UPDATE',array('class'=>'btn_add_new','style'=>'width:154px; float:left; margin-left:56px; ')) }}
            </div>
			<div class="input1">
				<a href="{{ URL::to('admin/orders/remove/'.$orders->id) }}" onclick="return confirm(' Are you sure you want to delete order?');" style="padding:8px 50px; float:left; margin:0px 10px; border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
			</div>
            {{ Form::close() }}
        </div>
    </div>
</div>		
<script>
	$(document).ready(function(){
		var clientname = document.getElementById('client_name');
		var manufacturername = document.getElementById('manufacturer_name');
//		clientname.style.display = "none";
//		manufacturername.style.display = "none";
		
		$("#roll_name").change(function(){
				var rollname = document.getElementById('roll_name').value;
				if(rollname == 1)
				{
					clientname.style.display = "none";
					manufacturername.style.display = "none";
				}
				else if(rollname ==  2)
				{
					clientname.style.display = "none";
					manufacturername.style.display = "none";
				}
				else if(rollname ==  3)
				{
					clientname.style.display = "block";
					manufacturername.style.display = "none";
				}
				else if(rollname ==  4)
				{
					clientname.style.display = "block";
					manufacturername.style.display = "none";
				}
				else if(rollname ==  5)
				{
					clientname.style.display = "none";
					manufacturername.style.display = "block";
				}
				else
				{
					
				}
		
		});
		
	});	
</script>
@stop       