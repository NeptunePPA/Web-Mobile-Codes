@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box" style="margin-left:35%;">

            <div class="col-md-12 col-lg-12 modal-box">
                <a title="" href="{{ URL::to('admin/users') }}" class="pull-right" data-toggle="modal">X</a>
                <h4 style="text-align:center;"> Manage User </h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red; margin:5px; ">{{ $error }}</li>
                    @endforeach
                </ul>

                {{ Form::model($users,['method'=>'PATCH','action'=>['users@update',$users->id],'files'=>'true']) }}
                <div class="input1">
                    {{Form::label('label1', 'Name:')}}
                    {{ Form::text('name',null,array('placeholder'=>'Name'))}}
                </div>
                <div class="input1">
                    {{Form::label('label2', 'Email:')}}
                    {{ Form::text('email',null,array('placeholder'=>'Email'))}}
                </div>

                <!-- Added By: Dhaval 03/05/2017 : start-->
                <div class="input1" id="mobile">
                    {{Form::label('label20', 'Mobile:')}}
                    {{ Form::text('mobile',$users->mobile,array('placeholder'=>'Mobile'))}}
                </div>

                <div class="input1" id="title">
                    {{Form::label('label21', 'Title:')}}
                    {{ Form::text('title',$users->title,array('placeholder'=>'Title'))}}
                </div>

                <div class="input1" id="profilepic">
                    {{Form::label('label22', 'Profile Pic:')}}
                    <img src="{{URL::to('public/upload/user/'.$users->profilePic)}}" width="150" height="100"
                         style="margin:10px;"/>
                    {{Form::input('button','Browse','Upload Profile Image' ,array('style'=>' width:80%;','id'=>'browse'))}}
                    {!! Form::file('profilePic',array('id'=>'fp_upload')) !!}
                </div>
                <!-- Added By: Dhaval 03/05/2017 : end-->

                @if(Auth::user()->roll == "1")
                    <div class="input1">
                        {{Form::label('label3', 'Role:')}}
                        {{ Form::select('roll', array('1'=>'Master Admin','2'=>'Administrator','3'=>'Physician','4'=>'Orders','5'=>'Rep'),$users->roll,array('id'=>'roll_name')) }}
                    </div>
                @else
                    <div class="input1">
                        {{Form::label('label3', 'Role:')}}
                        {{ Form::select('roll', array('2'=>'Administrator','3'=>'Physician','4'=>'Orders'),$users->roll,array('id'=>'roll_name')) }}
                    </div>
                @endif

            <!-- Added By: Dhaval 03/05/2017 : start-->
                <div class="input1" id="multiclient">
                    {{Form::label('label23', 'Client Name:')}}
                    {{ Form::select('client_name[]', $clients,$selectedclients,array('class'=>'js-example-basic-multiple','multiple'=>'multiple','id'=>'client_name')) }}
                </div>

                {{--@if($users->roll == 5)--}}
                <div class="input1" id="multiproject">
                    {{Form::label('label22', 'Project Name:')}}
                    {{ Form::select('project_name[]', $projects,$selectedprojects,array('class'=>'js-example-basic-multiple2','multiple'=>'multiple','id'=>'project_name')) }}
                </div>
                {{--@endif--}}
                <!-- Added By: Dhaval 03/05/2017 : end-->
                <!-- modify By: Punit 18/08/2017 : end-->

                <div class="input1" id="clients">
                    {{Form::label('label10', 'Organization:')}}
                    {{ Form::select('clients', $clients,$users->organization,array('id'=>'clientname'))}}
                </div>

                <div class="input1" id="manufacturer">
                    {{Form::label('label11', 'Organization:')}}
                    {{ Form::select('manufacturer', $manufacturers,$users->organization) }}
                </div>
                <div class="input1" id="projectname">
                    {{Form::label('label6', 'Project Name:')}}
                    {{ Form::select('projectname', $projects,$selectproject,array('id'=>'projectvalue')) }}
                </div>
                <div class="input1">
                    {{Form::label('label7', 'Status:')}}
                    {{ Form::select('status',array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}
                </div>
                <div class="input1">
                    {{Form::label('label8', 'Password:')}}
                    {{ Form::password('password',['placeholder'=>'Password'])}}
                </div>
                <div class="input1">
                    {{Form::label('label9', 'Repeat Password:')}}
                    {{ Form::password('password_confirmation',['placeholder'=>'Repeat Password'])}}
                </div>


                <div class="input1">
                    {{ Form::submit('UPDATE',array('class'=>'btn_add_new','style'=>'width:154px; float:left; margin-left:67px;')) }}

                    {{ Form::close() }}
                    {{ Form::model($users,['method'=>'post','action'=>['users@remove',$users->id]]) }}
                    {{ Form::submit('DELETE',array('class'=>'btn_add_new','style'=>'background:red;width:154px; float:left; margin-left:10px;','onclick'=>'return confirm("Are you sure you want to delete?");')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            /*profile pic option*/
            $('#fp_upload').hide();
            $("#browse").click(function () {
                $('#fp_upload').click();
                var file = document.getElementById("fp_upload");
            });
            $('#fp_upload').change(function () {
                $('#browse').val($(this).val());
            });


            var roleId = $('#roll_name').val();
            check_role(roleId);


            var client_name = $('#client_name').select2("val");

        });


        $("#roll_name").change(function () {
            check_role($(this).val());
//            alert($(this).val());
            var rollid = $('#roll_name').val();
            if (rollid == 5) {
                var clientid = "";
                $.ajax({
                    url: "{{ URL::to('admin/getprojects')}}",
                    data: {
                        clientid: clientid,
                    },
                    success: function (data) {
                        var projectid = $('#projectvalue').val();
                        var html_data = '';
                        if (data.status) {
                            html_data += "<option value=0>Project Name</option>";
                            $.each(data.value, function (i, item) {
                                var is_selected = (item.id == projectid) ? "selected" : "";
                                html_data += "<option value=" + item.id + " " + is_selected + ">" + item.project_name + "</option>";

                            });
                        }
                        else {
                            html_data = "<option value=0>Select Project</option>";
                        }
                        $("#projectvalue").html(html_data);

                    }

                });
            }
        });

        /*03/05/2017 : start*/
        $('#client_name').change(function () {

            var clientid = $('#client_name').select2("val");
            var roll_name = $('#roll_name').val();
//        alert(roll_name);
            $.ajax({
                url: "{{ URL::to('admin/getprojectnames')}}",
                data: {
                    clientid: clientid,
                },
                success: function (data) {
                    var html_data = '';
                    if (data.status) {
                        html_data += "<option value=0>Project Name</option>";
                        $.each(data.value, function (i, item) {
                            console.log(item);
                            html_data += "<option value=" + item.id + ">" + item.project_name + "</option>";

                        });
                    }
                    else {
                        html_data = "<option value=0>Select Project</option>";
                    }
                    if (roll_name == 3) {
                        $("#projectvalue").html(html_data);
                    } else if (roll_name == 5) {
                        $("#project_name").html(html_data);
                    }
                }

            });
        });
        /*03/05/2017 : end */

        $('#clientname').change(function () {
            var clientid = $('#clientname').val();
            $.ajax({
                url: "{{ URL::to('admin/getprojects')}}",
                data: {
                    clientid: clientid,
                },
                success: function (data) {
                    var html_data = '';
                    if (data.status) {
                        html_data += "<option value=0>Project Name</option>";
                        $.each(data.value, function (i, item) {
                            html_data += "<option value=" + item.id + ">" + item.project_name + "</option>";

                        });
                    }
                    else {
                        html_data = "<option value=0>Select Project</option>";
                    }
                    $("#projectvalue").html(html_data);

                }

            });
        });


        function check_role(roleId) {
            console.log(roleId);
            var clientname = $('#clients');
            var manufacturername = $('#manufacturer');
            var projectname = $('#projectname');
            var multiclient = $("#multiclient");
            var multiprojects = $('#multiproject');
            var mobile = $('#mobile');
            var title = $('#title');
            var propic = $('#browse');
            var project = $("#projectname");


            switch (roleId) {
                case '1':
                    projectname.hide();
                    clientname.hide();
                    manufacturername.hide();
                    multiclient.hide();
                    multiprojects.hide();

                    // mobile.hide();
                    // title.hide();
                    propic.hide();
                    break;
                case '2':
                    projectname.hide();
                    clientname.hide();
                    manufacturername.hide();
                    multiclient.show();
                    multiprojects.hide();
                    project.hide();
//                    mobile.hide();
//                    title.hide();
//                    propic.hide();
                    break;
                case '3':
                    projectname.show();
                    clientname.hide();
                    manufacturername.hide();
                    multiclient.show();
                    multiprojects.hide();
                    project.show();
//                    mobile.hide();
//                    title.hide();
//                    propic.hide();
                    break;
                case '4':
                    projectname.hide();
                    clientname.show();
                    manufacturername.hide();
                    multiclient.hide();
                    multiprojects.hide();
                    project.hide();
//                    mobile.hide();
//                    title.hide();
//                    propic.hide();
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
                    projectname.hide();
                    clientname.hide();
                    manufacturername.hide();
                    multiclient.hide();
                    multiprojects.hide();
//                    mobile.hide();
//                    title.hide();
//                    propic.hide();
                    break;
            }

        }
    </script>
    <script src="{{ URL::asset('js/edit_script.js') }}"></script>
@stop       