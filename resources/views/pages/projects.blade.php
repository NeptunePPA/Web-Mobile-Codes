@extends ('layout.default')
@section ('content')
    <div class="content-area clearfix">
        <div class="top-links clearfix" style="margin-left:20px;">
            <ul class="add-links">
                @if(Auth::user()->roll == 1)
                    <li><a title="Add Device" href="{{ URL::to('admin/projects/add') }}">Add Project</a></li>
                @endif
            </ul>
        </div>
        <div class="project-acc {{ Auth::user()->roll == 1 ? 'master-login' : 'administration-login' }} col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="clearfix proj-head">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> Project Name</div>
                @if(Auth::user()->roll == 1)
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Client Name</div>
                @endif
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">No of Users</div>
                @if(Auth::user()->roll == 1)
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Action</div>
                @endif
            </div>
            {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}
            <div class="clearfix proj-head">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    @if(Auth::user()->roll == 1)
                        <input type="text" class="search_text" data-field="project_name" name="search[]"/>
                    @else
                        <input type="text" class="search_text" data-field="projects.project_name" name="search[]"/>
                    @endif
                </div>
                @if(Auth::user()->roll == 1)
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input type="text" class="search_text"
                                                                            data-field="clients.client_name"
                                                                            name="search[]"/></div>
                @endif
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <div style="border:none;padding:12px;"></div>
                </div>
                @if(Auth::user()->roll == 1)
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div style="border:none;padding:12px;"></div>
                    </div>
                @endif
            </div>
            {{form::close()}}
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div id="project_result">
                    @foreach($projects as $project)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading1">
                                <h4 class="panel-title">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> {{ $project->project_name}} </div>
                                    @if(Auth::user()->roll == 1)
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">TOTAL CLIENT
                                            : {{$project->clients_count}} </div>
                                    @endif
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><a name="faq1" role="button"
                                                                                        data-toggle="collapse"
                                                                                        data-parent="#accordion"
                                                                                        href="#collapse{{$project->id}}"
                                                                                        aria-expanded="true"
                                                                                        aria-controls="collapseOne">
                                            @if(Auth::user()->roll == 1)
                                                TOTAL USERS : {{$project->users_count}}
                                                <span class="glyphicon glyphicon-plus" aria-hidden="false"></span>
                                            @else
                                                {{$project->users_count}} Users
                                            @endif
                                        </a></div>
                                    @if(Auth::user()->roll == 1)
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <a href="{{ URL::to('admin/projects/edit/'.$project->id) }}"><i
                                                        class="fa fa-edit"></i></a> &nbsp; <a
                                                    href="{{ URL::to('admin/projects/remove/'.$project->id) }}"
                                                    onclick="return confirm(' Are you sure you want to delete project?');"><i
                                                        class="fa fa-close"></i></a>
                                        </div>
                                    @endif
                                </h4>
                            </div>
                            @if(Auth::user()->roll == 1)
                                <div id="collapse{{$project->id}}" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        @foreach($project->clients as $client)
                                            <div class="single-row">
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">&nbsp;</div>
                                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">{{$client->clientname['client_name']}}</div>
                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">{{$client->clients_user_count}}
                                                    Users
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-count clearfix {{ Auth::user()->roll == 1 ? 'master-login-btn' : 'administration-login-btn' }}"
         style="margin-left:45px;">
        {{$projects->count()}} of {{$count}} displayed
        {{Form::open(array('url'=>'admin/projects','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
        {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
        {{Form::close()}}
    </div>
    </div>
    <script>
        $(document).ready(function () {


            $(".search_text").keyup(function () {
                var userrole = {{Auth::user()->roll}};
                var data = $('#ajax_data').serialize();
                var value = $(this).val();

                if (userrole == 1) {
                    $.ajax({
                        url: "{{URL::to('admin/search_projects')}}",
                        data: $('#ajax_data').serialize(),
                        success: function (data) {
                            console.log(data);
                            var html_data = '';
                            if (data.status) {
                                $.each(data.value, function (i, item) {
                                    html_data += "<div class='panel panel-default'><div class='panel-heading' role='tab' id='heading1'><h4 class='panel-title'><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'> " + item.project_name + " </div><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>TOTAL CLIENT : " + item.clients_count + " </div><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><a name='faq1' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse" + item.id + "' aria-expanded='true' aria-controls='collapseOne'>TOTAL USERS : " + item.users_count + " <span class='glyphicon glyphicon-plus' aria-hidden='false'></span></a></div><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><a href='projects/edit/" + item.prid + "'><i class='fa fa-edit'></i></a> &nbsp; <a href='projects/remove/" + item.project_id + "' onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;project?');><i class='fa fa-close'></i></a></div></h4></div><div id='collapse" + item.id + "' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'><div class='panel-body'>";
                                    $.each(item.clients, function (i, item1) {

                                        html_data += "<div class='single-row'><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>&nbsp;</div><div class='col-xs-5 col-sm-5 col-md-5 col-lg-5'>" + item1.client_name + "</div><div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>" + item1.clients_user_count + " Users</div></div>";
                                    });
                                    html_data += "</div></div></div>";
                                });
                            }
                            else {
                                html_data = "<div class='panel panel-default'><div class='panel-heading' role='tab' id='heading1'><h4 class='panel-title' style='text-align:center;'>" + data.value + "</div></div>";
                            }
                            $("#project_result").html(html_data);


                        }
                    });
                }
                else {
                    $.ajax({
                        url: "{{URL::to('admin/search_projects')}}",
                        data: $('#ajax_data').serialize(),
                        success: function (data) {
                            console.log(data);
                            var html_data = '';
                            if (data.status) {
                                $.each(data.value, function (i, item) {
                                    html_data += "<div class='panel panel-default'>"
                                        + "<div class='panel-heading' role='tab' id='heading1'><h4 class='panel-title'><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'> " + item.project_name + " </div>"
                                        + "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><a name='faq1' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse" + item.id + "' aria-expanded='true' aria-controls='collapseOne'>" + item.users_count + " Users</a>"
                                        + "</div>";
                                    html_data += "</div> </div>";
                                });
                            }
                            else {
                                html_data = "<div class='panel panel-default'><div class='panel-heading' role='tab' id='heading1'><h4 class='panel-title' style='text-align:center;'>" + data.value + "</div></div>";
                            }
                            $("#project_result").html(html_data);


                        }
                    });
                }


            });
            $('.collapse').on('shown.bs.collapse', function () {
                $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
            }).on('hidden.bs.collapse', function () {
                $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
            });


        });
    </script>
@stop 