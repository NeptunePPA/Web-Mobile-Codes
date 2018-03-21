@extends ('layout.default')
@section ('content')
	<style>
		.customcc {
			margin-left: 125px;
		}
	</style>
<div class="add_new">
<div class="box-center1">
<div class="add_new_box" style="margin-left: 120px;">
		
<div class="col-md-12 col-lg-12 modal-box" style="margin-top:10px;">
 <a title="" href="{{ URL::to('admin/devices/view/'.$customContact['deviceId']) }}#3" class="pull-right" >X</a>
			<ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
            <h3>Edit Contacts</h3>
			{{ Form::open(array('url' => 'admin/devices/customcontact/update/'.$customContact['id'],'method'=>'PUT','files'=>true)) }}
			<div class="content-area clearfix"  style="padding:30px 0px 30px 0px;">
				<div class="col-md-12 col-lg-12 modal-box" align="center">
					<div class="input1">
						{{ Form::hidden('deviceId',$customContact['deviceId'])}}
					</div>
					<div class="input1" style="text-align: left;margin-left: -125px;">
						{{Form::label('label2', 'Select Client',array('class'=>'customcc'))}}
						{{ Form::select('clientId', $client_name,$customContact['clientId'],array('id'=>'clientname')) }}
					</div>
					<div class="input1">
						{{Form::label('label2', 'Order Email')}}
						{{ Form::select('order_email',$orderuser,$customContact['order_email'],array('id'=>'ordermail')) }}
						&nbsp;{{ Form::text('orderNumber',$customContact['orderNumber'],array('placeholder'=>'Order Phonenumber','readonly'=>'true','id'=>'orderphone'))}}
					</div>
					<br>
					<div class="input1">
						{{Form::label('label4', 'CC #1 Email')}}
						{{ Form::text('cc1',$customContact['cc1'],array('placeholder'=>'Email Address','id'=>'cc1'))}}
						&nbsp; {{ Form::text('cc1Number',$customContact['cc1Number'],array('placeholder'=>'cc1 Phonenumber','id'=>'cc1Number'))}}
					</div>
					<div class="input1">
						{{Form::label('label5', 'CC #2 Email')}}
						{{ Form::text('cc2',$customContact['cc2'],array('placeholder'=>'Email Address','id'=>'cc2'))}}
						&nbsp; {{ Form::text('cc2Number',$customContact['cc2Number'],array('placeholder'=>'cc1 Phonenumber','id'=>'cc2Number'))}}
					</div>
					<div class="input1">
						{{Form::label('label17', 'CC #3 Email')}}
						{{ Form::text('cc3',$customContact['cc3'],array('placeholder'=>'Email Address','id'=>'cc3'))}}
						&nbsp; {{ Form::text('cc3Number',$customContact['cc3Number'],array('placeholder'=>'cc1 Phonenumber','id'=>'cc3Number'))}}
					</div>
					<div class="input1">
						{{Form::label('label6', 'CC #4 Email')}}
						{{ Form::text('cc4',$customContact['cc4'],array('placeholder'=>'Email Address','id'=>'cc4'))}}
						&nbsp; {{ Form::text('cc4Number',$customContact['cc4Number'],array('placeholder'=>'cc1 Phonenumber','id'=>'cc4Number'))}}
					</div>
					<div class="input1">
						{{Form::label('label7', 'CC #5 Email')}}
						{{ Form::text('cc5',$customContact['cc5'],array('placeholder'=>'Email Address','id'=>'cc5'))}}
						&nbsp; {{ Form::text('cc5Number',$customContact['cc5Number'],array('placeholder'=>'cc1 Phonenumber','id'=>'cc5Number'))}}
					</div>
					<div class="input1">
						{{Form::label('label8', 'CC #6 Email')}}
						{{ Form::text('cc6',$customContact['cc6'],array('placeholder'=>'Email Address','id'=>'cc6'))}}
						&nbsp; {{ Form::text('cc6Number',$customContact['cc6Number'],array('placeholder'=>'cc1 Phonenumber','id'=>'cc6Number'))}}
					</div>

					<br>
					<div class="input1" style="text-align: left;margin-left: -125px;">
						{{Form::label('label7', 'Subject',array('class'=>'customcc'))}}
						{{ Form::text('subject',$customContact['subject'],array('placeholder'=>'Default Subject Line Editable '))}}
					</div>
					
				</div>
				
			</div>
			
				<div class="modal-btn clearfix">
					{{ Form::submit('UPDATE') }}
				   <a href="{{URL::to('admin/devices/customcontact/remove/'.$customContact['id'])}}"
                                 onclick="return confirm('Are you sure you want to delete contacts?');" style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
				</div>
			{{ Form::close() }}
		</div>
</div>
</div>
</div>
<script>
$(document).ready(function(){

	    $('#clientname').change(function () {
                var userId = document.getElementById("clientname").value;
               
                 $.ajax({
                    url: "{{ URL::to('admin/devices/customcontact/getordermail')}}",
                    type: "POST",
                    data: {
                    	 _token: "{{ csrf_token() }}",
                        userId: userId
                       
                    },
                    success: function (data)
                    {
                      
                        var html_data = '';
                        if (data.status) {
                            html_data += "<option value=''>Select Order Email</option>";
                            $.each(data.value, function (i, item) {
                                
                                html_data += "<option value=" + item.id + ">" + item.email + "</option>";

                            });
                        } else
                        {
                            html_data = "<option value=''>Select Order Email</option>";
                        }
                       
                        $("#ordermail").html(html_data);

                    }

        			});
        });

	/*Check Validation*/
    $(document).on('change','#ordermail',function(event){

        var ordermail = $('#ordermail').val();

        $.ajax({
            url: "{{ URL::to('admin/devices/customcontact/number')}}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                userId: ordermail

            },
            success: function (data)
            {
                var html_data = '';
                if (data.status) {
                    html_data += data.value;

                } else
                {
                    html_data = "";
                }

                $("#orderphone").val(html_data);

            }

        });

    });

    $(document).on('blur','#cc1',function(event){
        var cc1 = $('#cc1').val();
        if(cc1){
            $.ajax({
                url: "{{ URL::to('admin/device/customecontact/email')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cc: cc1
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += data.value;
                        $("#cc1Number").val(html_data);
                        $("#cc1Number").attr("readonly", "true");
                        $("#cc1Number").attr("required", "true");

                    } else
                    {
                        html_data = "";
                        $("#cc1Number").val(html_data);
                        $("#cc1Number").attr("required", "true");
                        $("#cc1Number").removeAttr("readonly", "true");
                    }
                }
            });
        } else {
            $("#cc1Number").removeAttr("required");
            return 0;
        }
    });
    $(document).on('blur','#cc1Number',function(event){
        var cc1 = $('#cc1Number').val();
        if(cc1){
            $("#cc1").attr("required", "true");
        } else {
            $("#cc1").removeAttr("required");
            return 0;
        }
    });

    $(document).on('blur','#cc2',function(event){
        var cc2 = $('#cc2').val();
        if(cc2){
            $.ajax({
                url: "{{ URL::to('admin/device/customecontact/email')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cc: cc2
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += data.value;
                        $("#cc2Number").val(html_data);
                        $("#cc2Number").attr("readonly", "true");
                        $("#cc2Number").attr("required", "true");

                    } else
                    {
                        html_data = "";
                        $("#cc2Number").val(html_data);
                        $("#cc2Number").attr("required", "true");
                        $("#cc2Number").removeAttr("readonly", "true");
                    }
                }
            });
        } else {
            $("#cc2Number").removeAttr("required");
            return 0;
        }
    });
    $(document).on('blur','#cc2Number',function(event){
        var cc2 = $('#cc2Number').val();
        if(cc2){
            $("#cc2").attr("required", "true");
        } else {
            $("#cc2").removeAttr("required");
            return 0;
        }
    });

    $(document).on('blur','#cc3',function(event){
        var cc3 = $('#cc3').val();
        if(cc3){
            $.ajax({
                url: "{{ URL::to('admin/device/customecontact/email')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cc: cc3
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += data.value;
                        $("#cc3Number").val(html_data);
                        $("#cc3Number").attr("readonly", "true");
                        $("#cc3Number").attr("required", "true");

                    } else
                    {
                        html_data = "";
                        $("#cc3Number").val(html_data);
                        $("#cc3Number").attr("required", "true");
                        $("#cc3Number").removeAttr("readonly", "true");
                    }
                }
            });
        } else {
            $("#cc3Number").removeAttr("required");
            return 0;
        }
    });
    $(document).on('blur','#cc3Number',function(event){
        var cc3 = $('#cc3Number').val();
        if(cc3){
            $("#cc3").attr("required", "true");
        } else {
            $("#cc3").removeAttr("required");
            return 0;
        }
    });

    $(document).on('blur','#cc4',function(event){
        var cc4 = $('#cc4').val();
        if(cc4){
            $.ajax({
                url: "{{ URL::to('admin/device/customecontact/email')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cc: cc4
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += data.value;
                        $("#cc4Number").val(html_data);
                        $("#cc4Number").attr("readonly", "true");
                        $("#cc4Number").attr("required", "true");

                    } else
                    {
                        html_data = "";
                        $("#cc4Number").val(html_data);
                        $("#cc4Number").attr("required", "true");
                        $("#cc4Number").removeAttr("readonly", "true");
                    }
                }
            });
        } else {
            $("#cc4Number").removeAttr("required");
            return 0;
        }
    });
    $(document).on('blur','#cc4Number',function(event){
        var cc4 = $('#cc4Number').val();
        if(cc4){
            $("#cc4").attr("required", "true");
        } else {
            $("#cc4").removeAttr("required");
            return 0;
        }
    });

    $(document).on('blur','#cc5',function(event){
        var cc5 = $('#cc5').val();
        if(cc5){
            $.ajax({
                url: "{{ URL::to('admin/device/customecontact/email')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cc: cc5
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += data.value;
                        $("#cc5Number").val(html_data);
                        $("#cc5Number").attr("readonly", "true");
                        $("#cc5Number").attr("required", "true");

                    } else
                    {
                        html_data = "";
                        $("#cc5Number").val(html_data);
                        $("#cc5Number").attr("required", "true");
                        $("#cc5Number").removeAttr("readonly", "true");
                    }
                }
            });
        } else {
            $("#cc5Number").removeAttr("required");
            return 0;
        }
    });
    $(document).on('blur','#cc5Number',function(event){
        var cc5 = $('#cc5Number').val();
        if(cc5){
            $("#cc5").attr("required", "true");
        } else {
            $("#cc5").removeAttr("required");
            return 0;
        }
    });


    $(document).on('blur','#cc6',function(event){
        var cc6 = $('#cc6').val();
        if(cc6){
            $.ajax({
                url: "{{ URL::to('admin/device/customecontact/email')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cc: cc6
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += data.value;
                        $("#cc6Number").val(html_data);
                        $("#cc6Number").attr("readonly", "true");
                        $("#cc6Number").attr("required", "true");

                    } else
                    {
                        html_data = "";
                        $("#cc6Number").val(html_data);
                        $("#cc6 Number").attr("required", "true");
                        $("#cc6Number").removeAttr("readonly", "true");
                    }
                }
            });
        } else {
            $("#cc6Number").removeAttr("required");
            return 0;
        }
    });
    $(document).on('blur','#cc6Number',function(event){
        var cc6 = $('#cc6Number').val();
        if(cc6){
            $("#cc6").attr("required", "true");
        } else {
            $("#cc6").removeAttr("required");
            return 0;
        }
    });


});
</script>

@stop

