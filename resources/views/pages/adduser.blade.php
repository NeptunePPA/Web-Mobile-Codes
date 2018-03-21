@extends ('layout.default')
@section ('content')
<div class="add_new">
    <div class="add_new_box">
		
 
        <div class="col-md-12 col-lg-12 modal-box">
		<a title="" href="{{ URL::to('admin/users') }}" class="pull-right" data-toggle="modal" >X</a>
                       <h4> Add User </h4>
            <ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px; width:210px;">{{ $error }}</li>
                @endforeach
            </ul>

            {{ Form::open(array('url' => 'admin/users/create','files'=>'true')) }}
            <div class="input1">
                {{ Form::text('name',old('name'),array('placeholder'=>'Name'))}}
            </div>
            <div class="input1">
                {{ Form::text('email',old('email'),array('placeholder'=>'Email'))}}
            </div>

            <!-- Added By: Dhaval 02/04/2017 : start-->
            <div class="input1">
                {{ Form::text('mobile',old('mobile'),array('placeholder'=>'Mobile','id'=>'mobile'))}}
            </div>

            <div class="input1">
                {{ Form::text('title',old('title'),array('placeholder'=>'Title','id'=>'title'))}}
            </div>

            <div class="input1">
                {{Form::input('button','Browse','Upload Profile Image' ,array('style'=>' width:100%;','id'=>'browse'))}}
                {!! Form::file('profilePic',array('id'=>'fp_upload')) !!}
            </div>
            <!-- Added By: Dhaval 02/05/2017 : end-->

			@if(Auth::user()->roll == "1")
			<div class="input1">
                {{ Form::select('roll', array('0'=>'Role','1'=>'Master Admin','2'=>'Administrator','3'=>'Physician','4'=>'Orders','5'=>'Rep'),old('roll'),array('id'=>'roll_name')) }}
            </div>
			@else
			
            <div class="input1">
                {{ Form::select('roll', array('0'=>'Role','2'=>'Administrator','3'=>'Physician','4'=>'Orders'),old('roll'),array('id'=>'roll_name')) }}
            </div>
			@endif
            <!-- Added By: Dhaval 26/04/2017 : start-->
            <div class="input1"  id="multiclient">
                {{ Form::select('client_name[]', $clients,null,array('class'=>'js-example-basic-multiple','multiple'=>'multiple','id'=>'client_name')) }}
            </div>

            <div class="input1"  id="multiprojects">
                {{ Form::select('project_name[]', $projects,null,array('class'=>'js-example-basic-multiple2','multiple'=>'multiple','id'=>'project_name')) }}
            </div>

            <!-- Added By: Dhaval 26/04/2017 : end-->

            <div class="input1">
                {{ Form::select('clients', $clients,old('clients'),array('id'=>'clients'))}}
            </div>

            <div class="input1">
                {{ Form::select('manufacturer', $manufacturers,old('manufacturer'),array('id'=>'manufacturer')) }}
            </div>

            <div class="input1" id="project">
                {{ Form::select('projectname', $projects,old('projectname'),array('id'=>'projectname')) }}
            </div>

            <div class="input1">
                {{ Form::select('status',array('0' => 'Status','Enabled' => 'Enabled', 'Disabled' => 'Disabled'),old('status')) }}
            </div>

            <div class="input1">
                {{ Form::password('password',['placeholder'=>'Password'])}}
            </div>

            <div class="input1">
                {{ Form::password('password_confirmation',['placeholder'=>'Repeat Password'])}}
            </div>

            <div>
                {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>		
<script>
    $(document).ready(function () {

        /*profile pic option*/
        $('#fp_upload').hide(); 
         $("#browse").click(function(){
           $('#fp_upload').click();
           var file = document.getElementById("fp_upload");
           });
         $('#fp_upload').change(function() {
            $('#browse').val($(this).val());
        });

        var roleId = $('#roll_name').val();
        check_role(roleId);
        
        $("#roll_name").change(function () {
            check_role($(this).val());
        });
		
		
		$('#clients').change(function(){
			var clientid = $('#clients').val();
			$.ajax({
                url: "{{ URL::to('admin/getprojects')}}",
                data: {
					clientid:clientid,
                },
                success: function (data) 
				{
                    var html_data = '';
					 if (data.status) {
						 html_data += "<option value=0>Project Name</option>";
					$.each(data.value, function (i, item) {
						console.log(item);
                            html_data += "<option value="+item.id+">"+item.project_name+"</option>";

					});
					 }
					 else
					 {
						 html_data = "<option value=0>Select Project</option>";
					 }
					$("#projectname").html(html_data);

                }

            });
		});

        $('#client_name').change(function(){

            var clientid = $('#client_name').select2("val");

            $.ajax({
                url: "{{ URL::to('admin/getprojectnames')}}",
                data: {
                    clientid:clientid,
                },
                success: function (data)
                {
                    var html_data = '';
                     if (data.status) {
                         html_data += "<option value=0>Project Name</option>";
                    $.each(data.value, function (i, item) {
                        console.log(item);
                            html_data += "<option value="+item.id+">"+item.project_name+"</option>";

                    });
                     }
                     else
                     {
                         html_data = "<option value=0>Select Project</option>";
                     }
                    $("#projectname").html(html_data);
                    $("#project_name").html(html_data);

                }

            });
        });
		
		
    });
    
    function check_role(roleId) {
        console.log(roleId);
        var clientname = $('#clients');
        var manufacturername = $('#manufacturer');
		var projectname = $('#projectname');
        var multiclient = $("#multiclient");
        var multiprojects = $('#multiprojects');
        var mobile = $('#mobile');
        var title = $('#title');
        var propic = $('#browse');
        var project = $("#project");


        switch (roleId) {
            case '1':
			    projectname.hide();
                clientname.hide();
                manufacturername.hide();
                multiclient.hide();
                multiprojects.hide();

//                mobile.hide();
//                title.hide();
//                propic.hide();
                break;
            case '2':
				projectname.hide();
                clientname.hide();
                manufacturername.hide();
                multiclient.show();
                multiprojects.hide();
                project.show();
//                mobile.hide();
//                title.hide();
//                propic.hide();
                break;
            case '3':
				projectname.show();
                clientname.hide();
                manufacturername.hide();
                multiclient.show();
                multiprojects.hide();
                project.show();
//                mobile.hide();
//                title.hide();
//                propic.hide();
                break;
            case '4':
				projectname.hide();
                clientname.show();
                manufacturername.hide();
                multiclient.hide();
                multiprojects.hide();
                project.show();
//                mobile.hide();
//                title.hide();
//                propic.hide();
                break;
            case '5':
				projectname.show();
                clientname.hide();
                manufacturername.show();
                multiclient.show();
                multiprojects.show();
                project.hide();
                mobile.show();
                title.show();
                propic.show();
                break;
            default :
				projectname.show();
                clientname.hide();
                manufacturername.hide();
                multiclient.hide();
                multiprojects.hide();
//                mobile.hide();
//                title.hide();
//                propic.hide();
                break;
        }

    }
</script>
<script src="{{ URL::asset('js/edit_script.js') }}"></script>
@stop       