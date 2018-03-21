@extends('layouts.repcase')
@section('content')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <style type="text/css">
      #serialNumber + .select2.select2-container.select2-container--default{
        float: right;
      }
  </style>
    <!-- <div style="margin:-25px 20px 0 0;">
    <a class="menuinfoicon" href="#" title="Info">Info</a>
</div> -->
    <div class="login-panel">
        <div class="header">
            <a class="menuicon" rel="popover" data-popover-content="#menu-popover" href="#"></a>

            <h1><img src="{{ URL::asset('/images/logo.jpg') }}"/></h1>
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
            <div class="container">
                <div class="row">
                    <center>
                        <h4 class="rap-case-title">Rep Case Tracker</h4>
                        {{ Form::open(array('url' => 'repcasetracker/clients/record/list','method'=>'POST','files'=>'true','id'=>'target') )}}

                        {{Form::hidden('project',$project)}}
                        {{ Form::text('client',$client_name,array('placeholder'=>'Client',"class"=>"form-control input-type-format",'readonly'=>'true')) }}
                        <br>
                        {{ Form::select('producedate',$producedate,'',array('id'=>'producedate','class'=>'form-control input-type-format')) }}
                        <br>
                        <p>or</p>
                        <br>

                        <div class="col-xs-6">
                            {{ Form::select('month',array(''=>"Select Month",'01'=>'Jan','02'=>'Feb','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'),'',array('id'=>'month','class'=>'form-control input-type-format pull-right')) }}
                        </div>
                        <div class="col-xs-6">
                            {{ Form::select('year',array(''=>"Select Year",'2011'=>'2011','2012'=>'2012','2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020'),'',array('id'=>'year','class'=>'form-control input-type-format pull-left  ')) }}
                        </div>


                        <div class="col-xs-12">
                            <br>
                            <p>or</p>
                            <br>
                        </div>

                        <div class="col-xs-6">
                            {{ Form::select('serialNumber',$serialnumbers,'',array('id'=>'month','class'=>'form-control input-type-format pull-right js-example-basic-single','id'=>'serialNumber')) }}
                            
                        </div>

                        <div class="col-xs-3">
                            <a href="#"
                               class="btn btn-danger view-edit-details-btn pull-left" id="find">Find</a>
                        </div>


                        <div class="col-xs-12">
                            <br>
                            <p>or</p>
                        </div>
                        {{ Form::select('caseid',$caseid,'',array('id'=>'caseid','class'=>'form-control input-type-format')) }}
                        <br>
                        <p>or</p>
                        <br>
                        <select class="form-control input-type-format" id="ponumber" name="ponumber">
                            <option value="">Select a PO#</option>
                            @foreach($ponumber as $row)
                                <option value="{{$row->poNumber}}">{{$row->poNumber}}</option>
                            @endforeach
                        </select>
                        <br>
                        <p>or</p>
                        {{ Form::select('doctor',$doctors,'',array('id'=>'doctorId','class'=>'form-control input-type-format')) }}
                        <br>
                        {{Form::close()}}
                        <br>
                        <div class="bottom-btn-block">
                            <a href="{{URL::to('repcasetracker/clients')}}"
                               class="btn btn-primary view-edit-details-btn">SELECT A NEW HOSPITAL</a>
                        </div>
                    </center>
                </div>
            </div>

        </div>
    </div>

  
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
 <script src="{{ URL::asset('js/edit_script.js') }}"></script>



    <script type="text/javascript">
        /*Produce date change event*/
        $(document).on('change', '#producedate', function (event) {

            var clientname = $('#producedate').val();

            if (clientname) {
                $("#target").submit();

            }
            else {
                alert('Please Select Produce Date..!');
            }

        });
        /*Case id change event*/
        $(document).on('change', '#caseid', function (event) {

            var clientname = $('#caseid').val();

            if (clientname) {
                $("#target").submit();

            }
            else {
                alert('Please Select Case Id..!');
            }

        });

        /*P.O. Number change event*/
        $(document).on('change', '#ponumber', function (event) {

            var clientname = $('#ponumber').val();

            if (clientname) {
                $("#target").submit();

            }
            else {
                alert('Please Select Po# Number..!');
            }

        });
        /*Doctor change event*/
        $(document).on('change', '#doctorId', function (event) {

            var doctorname = $('#doctorId').val();

            if (doctorname) {
                $("#target").submit();

            }
            else {
                alert('Please Select Doctor Name..!');
            }

        });
        /*Year month change event*/
        $(document).on('change', '#year', function (event) {

            var year = $('#year').val();

            var month = $('#month').val();

            if (year && month) {
                $("#target").submit();

            }
            else {
                alert('Please Select Month Or Year..!');
            }

        });

        /*Serial number click event*/
        $(document).on('click', '#find', function (event) {

            var serialNumer = $('#serialNumber').val();

            if (serialNumer) {
                $("#target").submit();

            }
            else {
                alert('Please Enter Serial Number.!');
            }

        });

    </script>
@endsection