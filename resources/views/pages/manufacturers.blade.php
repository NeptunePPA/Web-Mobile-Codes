@extends ('layout.default')
@section ('content')
<div class="content-area clearfix" style="margin:0 26%;">
		<div class="top-links clearfix">
			<ul class="add-links">
				<li><a title="Add Manufacturer" href="{{ URL('admin/manufacturer/add') }}" data-toggle="modal">Add Manufacturer</a></li>
			</ul>
		</div>
		<div class="table" >
			<table id='manufacturer_table'>
				
				<thead>
				<tr>
					<th>Item No.</th>
					<th>Manufacturer Name</th>
					<th>Logo Image</th>
					<th>Action</th>
				</tr>
				<tr>
				{{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}
					<td><input type='text' class='search_text' data-field='item_no'  style="width:95px;" name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='manufacturer_name' style="width:120px;" name="search[]" /></td>
					<td></td>
					<td style="width:95px;"></td>
				{{form::close()}}
				</tr>
				</thead>
				<tbody id="manufacturer_result">
					@foreach($manufacturers as $manufacturer)
					<tr>
						<td>{{ $manufacturer->item_no }}</td>
						<td>{{ $manufacturer->manufacturer_name }}</td>
						<td><img src="{{URL::to('public/upload/' . $manufacturer->manufacturer_logo)}}" width="100" heigth="100" /></td>
						<td>
							<a href="{{ URL::to('admin/manufacturer/edit/'.$manufacturer->id) }}"><i class="fa fa-edit"></i></a>
							&nbsp; <a href="{{ URL::to('admin/manufacturer/remove/'.$manufacturer->id) }}" onclick="return confirm(' Are you sure you want to delete manufacturer?');"><i class="fa fa-close"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
		 </table>
			
			
		</div>
		<div class="bottom-count clearfix">
				{{$manufacturers->count()}} of {{$count}} displayed 
		{{Form::open(array('url'=>'admin/manufacturer','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
		{{Form::select('pagesize', array('10' => 'Show 10','15'=>'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}

		{{Form::close()}}
		</div>
	</div>
	
<script>
    $(document).ready(function () {

        $(".search_text").keyup(function () {
            var data = $('#ajax_data').serialize();

            $.ajax({
                url: "{{ URL::to('admin/search_manufacturer')}}",
                data: $('#ajax_data').serialize(),
                success: function (data) {
					console.log(data);
                    var html_data = '';
                    if (data.status) {
                        $.each(data.value, function (i, item) {
                            console.log(item);
                            html_data += "<tr><td>"+item.item_no+"</td><td>"+item.manufacturer_name+"</td><td><img src='../public/upload/"+item.manufacturer_logo+"' width='100' heigth='100' /></td><td><a href='manufacturer/edit/"+item.id+"'><i class='fa fa-edit'></i></a> &nbsp; <a href='manufacturer/remove/"+item.id+"' onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;manufacturer?');><i class='fa fa-close'></i></a></td></tr>";

                        });
                    } else {
                        html_data = "<tr> <td colspan='6' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    console.log(html_data);
                    $("#manufacturer_result").html(html_data);

                }

            });

        });

    });
</script>
@stop
