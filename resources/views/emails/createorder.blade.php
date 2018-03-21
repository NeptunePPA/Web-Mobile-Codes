Your order details.
<br/>
<b>Manufacturer:</b>{{$manufacturer_name}}<br/>
<b>Device Name:</b>{{$model_name}}<br/>
<b>Model Name:</b>{{$model_no}}<br/>
<b>Order Date:</b>{{$order_date}}<br/>
<b>Order By:</b>{{$orderby}}<br/>
<b>Rep:</b>@foreach($rep_email as $rep)
			{{	$rep->email }}
			@endforeach
		   <br/>
<b>Sent To:</b>{{$sent_to}}<br/>
