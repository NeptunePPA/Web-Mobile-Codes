@extends ('layout.default')
@section ('content')

	<div class="content-area clearfix">
		<div class="top-links clearfix">
			<ul class="add-links">
				<li><a title="Add Device" href="{{ URL::to('admin/devices/add') }}">Add Device</a></li>
				<li><a href="#" title="">Import</a></li>
				<li><a href="#" title="">Export</a></li>
			</ul>
		</div>
		<div class="table">
			<table>
				<thead>
				<tr>
					<th width="30"> &nbsp; </th>
					<th>Client Name</th>
					<th>Unit Cost</th>
					<th>Dis. Unit Cost%</th>
					<th>Repless Disc.</th>
					<th>Repless Disc%</th>
					<th>System Cost</th>
					<th>Disc.Sys. Cost%</th>
					<th>CCO Disc. %</th>
					<th>Repless Disc.</th>
					<th>Repless Disc.%</th>
					<th>Bulk</th>
					<th>Reimb.</th>
					<th>Action</th>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td><input type="text" class='search_text' data-field='device.id' /></td>
					<td><input type="text" class='search_text' data-field='manufacturers.manufacturer_name' /></td>
					<td><input type="text" class='search_text' data-field='device.device_name' /></td>
					<td><input type="text" class='search_text' data-field='device.model_name' /></td>
					<td><input type="text" class='search_text' data-field='projects.project_name' /></td>
					<td><input type="text" class='search_text' data-field='category.category_name' /></td>				
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</thead>
				<tbody id="device_result">
				
				</tbody>
			</table>
		</div>
		<div class="bottom-count clearfix">
			
		</div>
	</div>


<script>
$(document).ready(function(){

		$(".search_text").keyup(function () {
            var fieldName = $(this).data('field');
            var value = $(this).val();

            $.ajax({
                url: "{{ URL::to('admin/search_device')}}",
                data: {
                    fieldName: fieldName,
                    value: value
                },
                success: function (data) {
					console.log(data);
                    var html_data = '';
                    if (data.status) {
                        $.each(data.value, function (i, item) {
                            console.log(item);
                            html_data += "<tr><td><input type='checkbox' /></td><td>"+item.id+"</td><td>"+item.manu_name+"</td><td>"+item.device_name+"</td><td>"+item.model_name+"</td><td>"+item.project_name+"</td><td>"+item.category_name+"</td><td>"+item.status+"</td><td><a href='devices/edit/'"+item.id+"><i class='fa fa-edit'></i></a></td></tr>";

                        });
                    } else {
                        html_data = "<tr> <td colspan='9'> " + data.value + " </td> </tr>"
                    }

                    console.log(html_data);
                    $("#device_result").html(html_data);

                }

            });

        });
});
</script>
@stop 