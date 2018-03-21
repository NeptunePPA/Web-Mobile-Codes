@extends ('layout.default')
@section ('content')

<div class="content-area clearfix" style="margin:0 5%;">
	<div class="top-links clearfix">
		<ul class="add-links">
			@if(Auth::user()->roll == 1)
			<li><a title="Add Device" href="{{ URL::to('admin/clients/add') }}" data-toggle="modal">Add Client</a></li>
			@endif
		</ul>
	</div>
	<div class="table" >
		<table id='client_table'>
			<thead>
				<tr>
					<th>Item No.</th>
					<th>Client Name</th>
					<th>Street Address</th>
					<th>City</th>
					<th>State</th>
					<th>Image</th>
					<th>No. Of Projects</th>
					@if(Auth::user()->roll == "1")
					<th>Action</th>
					@endif
				</tr>
				<tr>
				{{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}
					<td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;" name="search[]"  /></td>
					<td><input type='text' class='search_text' data-field='clients.client_name' name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='clients.street_address' name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='clients.city' name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='state.state_name'  name="search[]"/></td>
					<td></td>
					<td></td>
					@if(Auth::user()->roll == 1)
					<td style="width:75px;"></td>
					@endif
					{{form::close()}}
				</tr>
			</thead>
			<tbody id='client_result'>
				@foreach($clients as $client)
				<tr data-id='{{ $client->id}}'>
					<td>{{ $client->item_no}}</td>
					<td>{{ $client->client_name}}</td>
					<td>{{ $client->street_address}}</td>
					<td>{{ $client->city}}</td>
					<td>{{ $client->statename->state_name}}</td>
					<td><img src="{{URL::to('public/'.$client->image)}}" width="200px" height="70px"></td>
					<td>{{$client->projectclients->count()}}</td>
					@if(Auth::user()->roll == 1)
					<td><a href="{{ URL::to('admin/clients/edit/'.$client->id) }}"><i class="fa fa-edit"></i></a> &nbsp; <a href="{{ URL::to('admin/clients/remove/'.$client->id) }}" onclick="return confirm(' Are you sure you want to delete client?');"><i class="fa fa-close"></i></a></td>
					@endif
				</tr>
				@endforeach
			</tbody>


		</table>

	</div>

	<div class="bottom-count clearfix">
		{{$clients->count()}} of {{$count}} displayed 
		{{Form::open(array('url'=>'admin/clients','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
		{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}

		{{Form::close()}}

	</div>
</div>
<script>
    $(document).ready(function () {

        $(".search_text").keyup(function () {
            // var fieldName = $(this).data('field');
            var data = $('#ajax_data').serialize();
            var value = $(this).val();
            var userrole = {{Auth::user()->roll}};
            var baseUrl = '{{URL::to('')}}';
            $.ajax({
                url: "{{ URL::to('admin/search_clients')}}",
                data:  $('#ajax_data').serialize(),
                success: function (data) {
                    var html_data = '';
                    if (data.status) {

                        $.each(data.value, function (i, item) {

                            var img = baseUrl + '/public/'+ item.image;

                            var image = "<img src= "+img+" width='50px' height='50px' >";


                            if(userrole == 1)
                            {
                              html_data += "<tr data-id=" + item.id + "><td>" + item.item_no + "</td><td>" + item.client_name + "</td><td>" + item.street_address + "</td><td>" + item.city + "</td><td>" + item.state_name + "</td><td>"+image+"</td><td>"+item.projectcount+"</td><td><a href=clients/edit/"+item.id+"><i class='fa fa-edit'></i></a> &nbsp; <a href=clients/remove/"+item.id+" onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;client?');><i class='fa fa-close'></i></a></td></tr>";
                            }
                            else{
                            	html_data += "<tr data-id=" + item.id + "><td>" + item.item_no + "</td><td>" + item.client_name + "</td><td>" + item.street_address + "</td><td>" + item.city + "</td><td>" + item.state_name + "</td><td>"+item.projectcount+"</td></tr>";
                            }


                        });
                    } else {
                        html_data = "<tr> <td colspan='7' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    $("#client_result").html(html_data);

                }

            });

        });

    });
</script>
@stop       