@extends ('layout.default')
@section ('content')

	<div class="content-area clearfix">
		<div class="top-links clearfix">
			
		</div>
		<div class="table">
			<table>
				<thead>
				<tr>
                	<th width="30">&nbsp;  </th>
                    <th>ID</th>
					<th>Manufacturer</th>
					<th>Device Name</th>
					<th>Model No.</th>
					<th>Project Name</th>
					<th>Category Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<tr>
					
		
                    
                    <td><input type="text" class='search_text' data-field='device.id' style="width:80px;"/></td>
					<td><input type="text" class='search_text' data-field='manufacturers.manufacturer_name' /></td>
					<td><input type="text" class='search_text' data-field='device.device_name' /></td>
					<td><input type="text" class='search_text' data-field='device.model_name' /></td>
					<td><input type="text" class='search_text' data-field='projects.project_name' /></td>
					<td><input type="text" class='search_text' data-field='category.category_name' /></td>				
					<td><input type="text" class='search_text' data-field='device.status' /></td>
					<td style="width:100px;"></td>
					
				</tr>
				</thead>
				<tbody id="device_result">
				<tr>
                	@foreach($wrongdata as $device)
                    {{$device->level_name}}
                    @endforeach
					<td>{{count($wrongdata) }}</td>
					
				</tr>
				</tbody>
                    
			</table>
		</div>
	</div>

@stop 