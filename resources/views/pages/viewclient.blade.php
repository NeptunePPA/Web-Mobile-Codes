@extends ('layout.default')
@section ('content')

<div class="content-area clearfix" style="margin:0 10%;">
	<h2>Client List</h2>
	<div class="table" >
		
	
		
			<a href="{{ URL::to('admin/category') }}" class="pull-right" data-toggle="modal" style="padding-left:20px;">X</a>
		<table id='client_table'>
			<thead>
				<tr>
					<th>Item No.</th>
					<th>Client Name</th>
					<th>Street Address</th>
					<th>City</th>
					<th>State</th>
				</tr>
				<tr>
				{{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}

					{{form::hidden('projectId',$id)}}

					<td><input type='text' class='search_text' data-field='clients.item_no' name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='clients.client_name'  name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='clients.street_address' name="search[]"  /></td>
					<td><input type='text' class='search_text' data-field='city.cityname' name="search[]"  /></td>
					<td><input type='text' class='search_text' data-field='state.state_name'  name="search[]" /></td>

				{{ Form::close()}}
				</tr>
			</thead>
			<tbody id='client_result'>
				@foreach($viewclients as $client)
				<tr data-id='{{ $client->id}}'>
					<td>{{ $client->item_no}}</td>
					<td>{{ $client->client_name}}</td>
					<td>{{ $client->street_address}}</td>
					<td>{{ $client->city }}</td>
					<td>{{ $client->state_name }}</td>
				</tr>
				@endforeach
			</tbody>


		</table>

	</div>

	<div class="bottom-count clearfix">
		

	</div>
</div>
<script>
    $(document).ready(function () {

		var pathname = window.location.pathname;
		var prid = pathname.substring(pathname.lastIndexOf('/') + 1);
		
		
        $(".search_text").keyup(function () {
			var data = $('#ajax_data').serialize();

            $.ajax({
                url: "{{ URL::to('admin/viewclientsearch') }}",
                data:$('#ajax_data').serialize(),
                success: function (data) {
                    var html_data = '';
                    if (data.status) {
                        $.each(data.value, function (i, item) {
                            console.log(item);
                            html_data += "<tr data-id=" + item.id + "><td>" + item.item_no + "</td><td>" + item.client_name + "</td><td>" + item.street_address + "</td><td>" + item.city + "</td><td>" + item.state_name + "</td></tr>";

                        });
                    } else {
                        html_data = "<tr> <td colspan='6' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    console.log(html_data);
                    $("#client_result").html(html_data);

                }

            });

        });

    });
</script>
@stop       