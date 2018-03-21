@extends ('layout.default')
@section ('content')
<div class="content-area clearfix" style="margin:0 28%;">
		<div class="top-links clearfix">
			<ul class="add-links">
				<li><a title="Export Marketshare" href="{{ URL::to('admin/marketshare/export') }}" onclick="return confirm(' Are you sure you want to export records?');">Exports</a></li>
			</ul>
		</div>
		<div class="table" >
			<table>
				
				<thead>
				<tr>
					<th>Manufacturer</th>
					<th>Marketshare</th>
					<th>No.Of Orders</th>
				</tr>
				<tr>
					<td><input type='text' class='search_text' data-field='manufacturers.manufacturer_name' /></td>
					<td></td>
					<td></td>
					
				</tr>
				</thead>
				<tbody id="marketshare_result">
				@foreach($marketshares as $marketshare)
					<tr>
						<td>{{$marketshare->manufacturer_name}}</td>
						@if($marketshare->percentage == "100.0000")
						<td>{{number_format($marketshare->percentage)}}%</td>
						@else
						<td>{{number_format($marketshare->percentage,2)}}%</td>
						@endif
						<td>{{$marketshare->no_of_order}}</td>
					</tr>
				@endforeach
				
				</tbody>
		 </table>
			
			
		</div>
		<div class="bottom-count clearfix">
		{{$marketshares->count()}} of {{$count}} displayed 
				{{Form::open(array('url'=>'admin/marketshare','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
					{{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
		{{Form::close()}}
		</div>
	</div>
	<script>
	$(document).ready(function(){
			
			$(".search_text").keyup(function(){
				var fieldName = $(this).data('field');
				var value = $(this).val();
					$.ajax({
						
						url : "{{ URL::to('admin/search_marketshare') }}",
						dataType: "json",
						data:{
							fieldName:fieldName,
							value:value
						},
						success:function(data){
							var html_data = '';
							if(data.status)
							{
								$.each(data.value, function (i,item){
									console.log(item);
									var per = parseFloat(item.percentage);
									var per = per.toFixed(2);
									if(per == 100.00)
									{
										var per = 100;
									}
									html_data += "<tr><td>"+item.manufacturer_name+"</td><td>"+per+"%</td><td>"+item.no_of_order+"</td></tr>";
								});
							}
							else
							{
								html_data = "<tr><td colspan='6' style='text-align:center;'>"+data.value+"</td></tr>" 
							}
							console.log(html_data);
							$("#marketshare_result").html(html_data);
						}
						
					});
				
			});
			
		});
		</script>
@stop
