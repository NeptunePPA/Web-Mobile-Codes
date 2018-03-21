@extends ('layout.default')
@section ('content')

<div class="content-area clearfix" style="margin:0 10%;">

	 <a title="Add Item File" href="{{URL::to('admin/itemfiles/view/'.$fileId)}}" class="pull-right" data-toggle="modal">X</a> 
	<div class="table" >
		<table>
			<thead>
				<tr>
					<th>Company</th>
					<th>Category</th>
					<th>Supply Item Description/Size</th>
					<th>MfgPartNumber</th>
					<th>Hospital Product Number</th>
					<th>Doctors</th>
					<th>Email</th>
				</tr>

				
			</thead>
			<tbody id='scorecardhtml'>

				@foreach($wrongdata as $row)
				<tr>
					<td>{{$row['company']}}</td>
					<td>{{$row['category']}}</td>
					<td>{{$row['supplyItem']}}</td>
					<td>{{$row['mfgPartNumber']}}</td>
					<td>{{$row['hospitalNumber']}}</td>
					<td>{{$row['doctors']}}</td>
					<td>{{$row['email']}}</td>
				</tr>
				@endforeach
			</tbody>


		</table>

	</div>
	
	
</div>


@stop       