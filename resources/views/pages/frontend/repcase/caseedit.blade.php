@extends('layouts.repcase')
@section('content')

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
        <div class="swap-case-details-form">
            <center>
                <h4 class="rap-case-title">Swap Case Details</h4>
                {{ Form::open(array('url' => 'repcasetracker/swapdevice/update/'.$data->id,'method'=>'POST','files'=>'true','id'=>'target') )}}

                {{Form::text('repcaseID',$data->repcaseID,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                <div class="form-group input-type-format">
                    <div class='input-group date' id='datetimepicker1'>
                        {{Form::text('produceDate',Carbon\Carbon::parse($data->itemfilename['produceDate'])->format('m/d/Y'),array('class'=>'form-control','placeholder'=>'10-06-2017','readonly'=>'true','required'=>'true'))}}
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                </div>

                {{Form::text('client',$data->itemfilename->client['client_name'],array('class'=>'form-control input-type-format client','readonly'=>'true'))}}
                {{Form::hidden('clientId',$data->itemfilename['clientId'],array('id'=>'clientId'))}}
                <br>
                {{Form::text('repUser',$data->itemfilename->users['name'],array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                {{Form::text('projectId',$data->itemfilename->projectname['project_name'],array('class'=>'form-control input-type-format projectId','readonly'=>'true'))}}
                {{Form::hidden('project',$data->itemfilename['projectId'],array('id'=>'project'))}}
                <br>
                {{Form::text('physician',$data->itemfilename->physician,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                {{Form::text('category',$data->category,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                {{Form::text('manufacturer',$data->manufacturer,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                {{Form::text('mfgPartNumber',$data->mfgPartNumber,array('class'=>'form-control input-type-format mfgPartNumber','readonly'=>'true'))}}
                <br>
                {{Form::text('hospitalPart',$data->hospitalPart,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                {{Form::text('supplyItem',$data->supplyItem,array('class'=>'form-control input-type-format supplyItem','readonly'=>'true'))}}
                <br>
                {{--{{Form::text('quantity',$data->quantity,array('class'=>'form-control input-type-format','readonly'=>'true'))}}--}}
                {{--<br>--}}
                {{Form::text('purchaseType',$data->purchaseType,array('class'=>'form-control input-type-format purchaseType','readonly'=>'true'))}}
                <br>

                {{ Form::text('',$data->serialNumber,array('placeholder'=>'Serial Number','class'=>'form-control input-type-format serialNumber ','data-id'=>'IF-text','id'=>'serial-text'))}}

                <span id="serial-drop-box" style="display: none;">
                    {{ Form::select('',array(''=>'Select serial no.'),$data->serialNumber,array('class'=>'js-example-basic-single form-control input-type-format serialnumberdropdown','id'=>'serial-drop','data-id'=>'IF-drop')) }}
                </span>

                <br>
                {{Form::text('poNumber',$data->poNumber,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                {{--<br>--}}
                {{--{{Form::text('order',$data->orderId,array('class'=>'form-control input-type-format','placeholder'=>'Order Id'))}}--}}

                {{Form::hidden('swapId',$data->id)}}
                {{Form::hidden('status',$data->status)}}
                <br> <br>
                <div class="bottom-btn-block">

                    <button type="submit" class="btn btn-primary view-edit-details-btn" style="width: 70%" id="submit">
                        SAVE
                    </button>
                    <!-- <a href="#" class="btn btn-large btn-primary view-edit-details-btn" id="submit">SAVE</a> -->
                    <br>
                    <a href="{{URL::to('repcasetracker')}}" class="btn btn-danger view-edit-details-btn">CANCEL</a>
                </div>
                {{Form::close()}}
            </center>
        </div>
    </div>


    <script src="{{ URL::asset('js/edit_script.js') }}"></script>
    <script type="text/javascript">
        function runscript()
        {
            $.getScript("{{ URL::asset('js/edit_script.js') }}", function(){

            });
        }
    </script>

    <script src="{{ URL::asset('frontend/js/moment-with-locales.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'MM/DD/YYYY',
            });
            function today(){
                var d = new Date();
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1;
                var curr_year = d.getFullYear();
                document.write(curr_date + "-" + curr_month + "-" + curr_year);
            }
        });

        $(document).ready(function () {

            var client = $('#clientId').val();
            var project = $('#project').val();
            var mfgPartNumber = $('.mfgPartNumber').val();
            var purchaseType = $('.purchaseType').val();
            var supplyItem = $('.supplyItem').val();
            var serialNumber = $('.serialNumber').val();

            console.log(client);
            console.log(mfgPartNumber);
            console.log(purchaseType);
            console.log(supplyItem);

            if (purchaseType == 'Bulk') {

                $('#serial-text').removeAttr('name');
                $('#serial-drop').attr('name', 'serialNumber');

                $('#serial-text').removeClass('sf');
                $('#serial-drop').addClass('sf');

                $('#serial-text').hide();
                $('#serial-drop-box').show();
                $("#serial-drop").attr("required", "true");
                $("#serial-text").removeAttr("required");

                $.ajax({
                    url: "{{ URL::to('repcasetracker/getserialnumbers')}}",
                    data: {
                        supplyItem: supplyItem,
                        mfgPartNumber: mfgPartNumber,
                        client: client,
                        purchaseType: purchaseType,
                        serialNumber :serialNumber

                    },


                    success: function (data) {
                        if (data.status) {
                            //$("#serialnumbers[data-id=" + id + "]").html(data.value);
                            $("#serial-drop").append("<option value='"+serialNumber+"' SELECTED>"+serialNumber+"</option>");

                            $.each(data.value, function (i, item) {

                                $("#serial-drop").append("<option value='"+item.serialNumber+"'>"+item.serialNumber+"</option>");
                            });

                        }
                    }


                });

            } else {


                $('#serial-text').attr('name','serialNumber');
                $('#serial-drop').removeAttr('name');

                $('#serial-text').addClass('sf');
                $('#serial-drop').removeClass('sf');

                $('#serial-text').show();
                $('#serial-drop-box').hide();
                $("#serial-text").attr("required", "true");
                $("#serial-drop").removeAttr("required");

            }

        });

        $(document).on("keyup", ".serialNumber", function (event) {
            var id = $(this).attr("data-id");
            var currentserialnumber = $(this).val();
            var client = $("#hospital").val();
            var currentsuplyitem = $('.supplyItem[data-id=' + id + ']').val();
            var mfgPartNumber = $(".mfgPartNumber[data-id=" + id + "]").val();

            $.ajax({
                url: "{{ URL::to('admin/repcasetracker/checkserial')}}",
                data: {
                    supplyItem: currentsuplyitem,
                    serialnumber: currentserialnumber,
                    mfgPartNumber: mfgPartNumber,
                    client: client,

                },

                success: function (data) {
                    if (data.status) {
                        if (data.value == "success") {
                            alert('This Serial Number is Already Avalilable For Bulk');
                            $('.serialNumber[data-id=' + id + ']').val('');
                        }
                    }
                }
            });
        });



    </script>





@endsection