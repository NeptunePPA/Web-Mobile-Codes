@extends('layouts.repcase')
@section('content')
<!-- <div style="margin:-25px 20px 0 0;">
    <a class="menuinfoicon" href="#" title="Info">Info</a>
</div> -->
        <div class="login-panel">
            <div class="header">
                <a class="menuicon" rel="popover" data-popover-content="#menu-popover" href="#"></a>
                
                <h1><img src="{{ URL::asset('/images/logo.jpg') }}" /></h1>
            </div>
          
            <div id="menu-popover" class="hide menu-popover">
                <ul class="menu">
                    @if(Auth::user()->roll == '2')
                        <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Hospital</a></li>
                        <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Project</a></li>
                        <li class="menu-item"><a href="{{URL::to('menu')}}">Main Menu</a></li>

                        <li class="menu-item"><a href="{{URL::to('scorecard/physician')}}">Scorecards</a></li>
                        <li class="menu-item">
                            <a href="#">Repcasetracker</a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter case details</a></li>
                                <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">view / edit case details</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->roll == '5')
                        <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter Case Details</a></li>
                        <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">View/Edit Case Details</a></li>
                    @endif

                    <li class="menu-item"><a href="{{ URL::to('logout') }}">Log out</a></li>
                </ul>
            </div>
           
        </div>
         <div class="rap-case-tracker">
            <div class="select-hospital-form">
                <center>
                    <h4 class="rap-case-title">Rep Case Tracker</h4>
                    {{ Form::open(array('url' => 'repcasetracker/clients/record','method'=>'POST','files'=>'true','id'=>'target') )}}
                   {{ Form::select('clientId',$clients,'',array('id'=>'clientname','class'=>'form-control input-type-format')) }}
                    <br>
                    <p></p>
                    <br>
                    {{ Form::select('projectId',array(''=>"Select Project"),'',array('id'=>'project','class'=>'form-control input-type-format')) }}
                   {{ Form::close() }}
                    <div class="bottom-btn-block">
                        <a href="{{URL::to('repcasetracker')}}" class="btn btn-primary view-edit-details-btn">MAIN MENU</a>
                    </div>
                </center>
            </div>
        </div>

        <script type="text/javascript">
            $(document).on('change','#project',function(event){

            var clientname = $('#clientname').val();

            var project = $('#project').val();
            
            if(clientname && project)
            {
                $( "#target" ).submit();
            
            } 
            else 
            {
                    alert('Please Select Client Name..! Or Project Name');
            }
            
        });

            /*Project name get Start*/
            $(document).on("change", "#clientname", function (event) {

                var hospital = $("#clientname").val();
                var  repuser  = {{Auth::user()->id}};
                var roll = {{Auth::user()->roll}};
                if(roll == 5){
                    $.ajax({
                        url: "{{ URL::to('admin/repcasetracker/getproject')}}",
                        data: {
                            hospital: hospital,
                            repuser : repuser,
                        },

                        success: function (data) {
                            var html_data = '';
                            if (data.status) {
                                html_data += "<option value=''>Select Project</option>";
                                $.each(data.value, function (i, item) {
                                    if (item.doctors != '') {
                                        html_data += "<option value='" + item.id + "' name ='" + item.project_name + "'>" + item.project_name + "</option>";
                                    }

                                });
                            } else {
                                html_data = "<option value=''>Select Project</option>";
                            }

                            $("#project").html(html_data);

                        }

                    });
                } else {
                    $.ajax({
                        url: "{{ URL::to('admin/repcasetracker/getprojects')}}",
                        data: {
                            hospital: hospital
                        },

                        success: function (data) {
                            var html_data = '';
                            if (data.status) {
                                html_data += "<option value=''>Select Project</option>";
                                $.each(data.value, function (i, item) {
                                    if (item.doctors != '') {
                                        html_data += "<option value='" + item.id + "' name ='" + item.project_name + "'>" + item.project_name + "</option>";
                                    }

                                });
                            } else {
                                html_data = "<option value=''>Select Project</option>";
                            }

                            $("#project").html(html_data);

                        }

                    });
                }

            });
            /*Project name get End*/

        </script>
  @endsection