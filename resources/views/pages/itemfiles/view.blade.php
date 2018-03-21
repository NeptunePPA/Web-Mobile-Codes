@extends ('layout.default')
@section ('content')

<div class="content-area clearfix" style="margin:0 10%;">

	<div class="top-links clearfix" align="center"><h2 class="pull-left">Client ItemFile : {{$itemFile->clientname->client_name}}</h2>
		<h2 class="pull-right">Project: {{$itemFile->projectname->project_name}}</h2>
	</div>


	<div class="top-links clearfix">
		<ul class="add-links">
			<li>
				<a title="Edit" href="{{URL::to('admin/itemfiles/edit/'.$fileid)}}" data-toggle="modal"> Edit </a> |
				<a title="Import" href="#" id="import"> Import </a> |
				<a title="Export" href="{{URL::to('admin/itemfiles/export/'.$fileid)}}" data-toggle="modal">Export</a> |
				<a title="Export" href="#" data-toggle="modal" class="remove">Remove</a>
			</li>
		</ul>
		<ul class="add-links pull-right">
			<li>
				<a title="view" href="{{URL::to('admin/itemfiles')}}" > Close </a>
			</li>
		</ul>

	</div>


	<div class="table" >
		<table>
			<thead>
				<tr>
					<th><input type="checkbox" class='chk_rep' id="checkmain" value=""/></th>
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
				@if(count($itemfiledetails))
				@foreach($itemfiledetails as $row)
				<tr>
					<td><input type="checkbox" class='chk_rep' name="chk_rep[]" value="{{$row->id}}"/></td>
					<td>{{$row->company}}</td>
					<td>{{$row->category}}</td>
					<td>{{$row->supplyItem}}</td>
					<td>{{$row->mfgPartNumber}}</td>
					<td>{{$row->hospitalNumber}}</td>
					<td>{{$row->doctors}}</td>
					<td>{{$row->email}}</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan='6' style='text-align:center;'> No Records Found </td>
				</tr>
				@endif
			</tbody>


		</table>

	</div>
	
	
</div>
<script type="text/javascript">
	
	$('#import').click(function(){

				var daa = {{$fileid}};
                var url = '{{URL::to("admin/itemfiles/import")}}' ;
                var path = url +"/"+daa;
                // console.log(path);
                window.location.href = path;
	});

	$("#checkmain").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});

	$(document).on("click",".remove",function (event) {
        
        if($(".chk_rep:checked").length == 0)
        {
            
            alert("Please select record and Remove");
            return false;
        }
        else
        {
  			
  			if(confirm(' Are you sure you want to delete Itemfile Details?')){
  					var ck_rep = new Array();

		             $.each($("input[name='chk_rep[]']:checked"), function() {
		            var ck_reps = $(this).val();

		            ck_rep.push(ck_reps);
		             });
		             var id = {{$fileid}}
		          
		            $.ajax({
		            url: "{{URL::to('admin/itemfiles/removedata/')}}/" + id,
		            data: {
		                        _token: "{{ csrf_token() }}",
		                       ck_rep:ck_rep
		                    },
		            type: "POST",
		            success: function (response, textStatus, request) {
		               location.reload();
		            }
		        });
  			}	
            
            
        }
    });
</script>

@stop       