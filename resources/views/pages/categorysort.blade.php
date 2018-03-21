@extends ('layout.default')
@section ('content')

<div class="content-area clearfix" style="margin:0 5%;">
	<h2>Category Sort List</h2>
	<ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
	
	        
	<div class="top-links clearfix">
		<ul class="add-links">
			<li>{{ Form::select('clientname',$clients,'',array('id'=>'clientname')) }}</li>
			<li>{{ Form::submit('Save',array('class'=>'btn_add_new','id'=>'addnew')) }}</li>
		</ul>
	</div>
	<div class="table" >
			<a href="{{ URL::to('admin/category') }}" class="pull-right" data-toggle="modal" style="padding-left:20px;">X</a>
		
		<table id='client_table'>
			<thead>
				<tr>
					<th>Sort Number</th>
					<th>Category Name</th>
					<th>Project Name</th>
					<th>Action</th>
				</tr>
				
			</thead>
			<tbody id='client_result'>
				
			</tbody>


		</table>

	</div>

	       
	

</div>
<script>
$(document).ready(function(){
		$('#addnew').prop('disabled', true );
		$('#clientname').change(function () {
            $('#addnew').prop('disabled',false);
            var clientid = $(this).val();

            $.ajax({
                    url: "{{ URL::to('admin/category/sort/getcategoryname')}}",
                    data: {
                        clientid: clientid
                    },
                    success: function (data)
                    {
                        var html_data = '';
                        if (data.status) {
                            var i = 1;
                            $.each(data.value, function (i, item) {
                                i++;

                                html_data += "<tr><td>" + i + "</td><td>" + item.category_name + "</td><td>"+item.project_name+"</td><td><a href='#' class='up'><i class='fa fa-arrow-circle-up' aria-hidden='true'></i></a> &nbsp; &nbsp;<a href='#' class='down'><i class='fa fa-arrow-circle-down' aria-hidden='true'></i></a></td>";

                            });

                        } else
                        {
                            html_data = "<tr><td colspan='4' style='text-align:center;'>Category Not Available</td></tr>";
                        }
                        $("#client_result").html(html_data);

                    }

                });
		});
		$('#addnew').click(function(){


            var clientid = $('#clientname').val();
			var table = $('#client_table');
			 var snumber = [];
			 var cname = [];
			 i=0;
			 table.find('tr').each(function (i, el) {

	        	 var $tds = $(this).find('td'),
		            sortnumber = $tds.eq(0).text(),
		            categoryname = $tds.eq(1).text();
					snumber[i++] = sortnumber;	
					cname[i++] = categoryname;
					
	   			
				 
			});


			    $.ajax({
	            	type : 'POST',
	            	url  : "{{ URL::to('admin/clients/category/sort/store')}}",
	            	data: { 
	            			'_token': '{{ csrf_token() }}',
	            			'sortnumber' : snumber,
	            			'categoryname' : cname,
	            			'clientid' : clientid
	            		},
	                    success: function (data) {
	                    	if (data.status)
	                        {
	                        	$('#clientname').prop('selectedIndex',0);
	                        	html_data = "<tr><td colspan='4' style='text-align:center;'>"+data.value+"</td></tr>";
			                    $("#client_result").html(html_data);
    					    }
	                    }


	            });


			});
		

        $("#client_table").on("click",".up,.down",function(e){
        	e.preventDefault();
        	var row = $(this).parents("tr:first");
	        if ($(this).is(".up")) {
	            row.insertBefore(row.prev());
	        } else {
	            row.insertAfter(row.next());
	        }

        });

});
</script>
@stop       