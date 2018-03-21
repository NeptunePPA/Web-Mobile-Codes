@extends ('layout.default')
@section ('content')
<div class="content-area clearfix" style="margin:0 18%;">
		<div class="top-links clearfix">
			<ul class="add-links">
				@if(Auth::user()->roll == 1)
				<li><a title="Add Categories" href="{{ URL('admin/category/add') }}" data-toggle="modal">Add Categories</a></li>
				@endif
				<li><a title="Category Sort" href="{{ URL('admin/clients/category/sort') }}" data-toggle="modal">Category Sort</a></li>
				<li><a title="Category Sort" href="{{ URL('admin/category-group') }}" data-toggle="modal">Category Group</a></li>

			</ul>
		</div>
		<div class="table" >
			<table id='category_table'>
				
				<thead>
				<tr>
					<th>Category Name</th>
					<th>Project Name</th>
					<th>Category Type</th>
					<th>Category Image</th>
					@if(Auth::user()->roll == 1)
					<th>No.Of Clients</th>
					<th>Action</th>
					@endif
				</tr>
				<tr>
				{{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}
					<td><input type='text' class='search_text' data-field='category.category_name' name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='projects.project_name' name="search[]" /></td>
					<td><input type='text' class='search_text' data-field='projects.categorytype' name="search[]" /></td>
					<td></td>
					@if(Auth::user()->roll == 1)
					<td></td>
					<td style="width:100px;"></td>
					@endif

				{{form::close()}}
				</tr>
				</thead>
				<tbody id="category_result">
				
				@foreach($categories as $category)
					<tr data-id='{{ $category->id}}'>
						<td>{{ $category->category_name}}</td>
						<td>{{ $category->project_name == "" ? '-' : $category->project_name}}</td>
						<td>{{ $category->type == "" ? '-' : $category->type}}</td>
						<td><img src="{{$category->image}}" width="50px" height="50px"> </td>
						@if(Auth::user()->roll == 1)
						<td>{{ $category->client_count}}</td>
						<td><a href="{{ URL('admin/category/viewclient/'.$category->prname)}}" title="View Clients"><i class="fa fa-eye">  </i></a> &nbsp; <a href="{{ URL::to('admin/category/edit/'.$category->id) }}"><i class="fa fa-edit"></i></a> &nbsp; <a href="{{ URL::to('admin/category/remove/'.$category->id) }}" onclick="return confirm(' Are you sure you want to delete category?');"><i class="fa fa-close"></i></a></td>
						@endif
					</tr>
				@endforeach
				</tbody>
		 </table>
			
			
		</div>
		<div class="bottom-count clearfix">
				{{$categories->count()}} of {{$count}} displayed 
				{{Form::open(array('url'=>'admin/category','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
					{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
				{{Form::close()}}
		</div>
	</div>
	<script>
	$(document).ready(function(){
			
			$(".search_text").keyup(function(){
				var userrole = {{Auth::user()->roll}};
				var data = $('#ajax_data').serialize();
				
				if(userrole == 1)
				{
					$.ajax({
						
						url : "{{ URL::to('admin/search_category') }}",
						dataType: "json",
						data:$('#ajax_data').serialize(),
						success:function(data){
							var html_data = '';
							console.log(data);
							if(data.status)
							{
							    console.log(data);
								$.each(data.value, function (i,item){
									var project = (item.project_name != null) ? item.project_name : '-';

									var types = (item.type)
									
									html_data += "<tr data-id="+item.id+"><td>"+item.category_name+"</td><td>"+project+"</td><td>"+item.type+"</td><td><img src='"+item.image+"' width='50px' height='50px'> </td><td>"+item.client_count+"</td><td><a href=category/viewclient/"+item.prname+" title=View&nbsp;Clients><i class='fa fa-eye'></i></a> &nbsp; <a href=category/edit/"+item.id+"><i class='fa fa-edit'></i></a> &nbsp; <a href=category/remove/"+item.id+" onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;category?');><i class='fa fa-close'></i></a></td></tr>";
								});
							}
							else
							{
								html_data = "<tr><td colspan='6' style='text-align:center;'>"+data.value+"</td></tr>" 
							}
							$("#category_result").html(html_data);
						}
						
					});
					
				}
				else
				{
					$.ajax({
						
						url : "{{ URL::to('admin/search_category') }}",
						dataType: "json",
						data:$('#ajax_data').serialize(),
						success:function(data){
							var html_data = '';
                            console.log(data);
							if(data.status)
							{
								$.each(data.value, function (i,item){
									var project = (item.project_name != null) ? item.project_name : '-';
									
									html_data += "<tr data-id="+item.id+"><td>"+item.category_name+"</td><td>"+project+"</td><td>"+item.type+"</td></tr>";
								});
							}
							else
							{
								html_data = "<tr><td colspan='6' style='text-align:center;'>"+data.value+"</td></tr>" 
							}
							$("#category_result").html(html_data);
						}
						
					});
				}
				
			});
			
		});
		</script>
@stop
