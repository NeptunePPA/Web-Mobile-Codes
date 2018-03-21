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
                            <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter case details</a>
                            </li>
                            <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">view / edit case
                                    details</a></li>
                        </ul>
                    </li>
                @elseif(Auth::user()->roll == '5')
                    <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter Case Details</a></li>
                    <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">View/Edit Case Details</a>
                    </li>
                @endif

                <li class="menu-item"><a href="{{ URL::to('logout') }}">Log out</a></li>
            </ul>
        </div>

    </div>
    <div class="rap-case-tracker">
        <div class="swap-case-details-form">
            <center>
                <h4 class="rap-case-title">Swap Case Details</h4>
                {{ Form::open(array('url' => 'repcasetracker/swapdevice/new/updates/'.$data->id,'method'=>'POST','files'=>'true','id'=>'target') )}}
                <ul>
                    @foreach($errors->all() as $error)

                        <li style="color:red; margin:5px;">{{ $error }}</li>

                    @endforeach
                </ul>
                <br>
                {{Form::text('repcaseID',$data->repcaseID,array('class'=>'form-control input-type-format','readonly'=>'true'))}}
                <br>
                <div class="form-group input-type-format">
                    <div class='input-group date' id='datetimepicker1'>
                        {{Form::text('produceDate',Carbon\Carbon::parse($data->itemfilename['produceDate'])->format('m/d/Y'),array('class'=>'form-control','placeholder'=>'10-06-2017','required'=>'true','readonly'=>'true'))}}
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                </div>

                {{Form::text('client',$data->itemfilename->client['client_name'],array('class'=>'form-control input-type-format','readonly'=>'true','id'=>'client'))}}
                {{Form::hidden('clientId',$data->itemfilename->client['id'],array('id'=>'clientId'))}}
                <br>
                {{Form::text('project',$data->itemfilename->projectname['project_name'],array('class'=>'form-control input-type-format','readonly'=>'true','id'=>'client'))}}
                {{Form::hidden('projectId',$data->projectId,array('id'=>'projectId'))}}
                <br>
                {{Form::text('repUser',$data->itemfilename->users['name'],array('class'=>'form-control input-type-format','readonly'=>'true','id'=>'repUser'))}}
                <br>
                {{Form::text('physician',$data->itemfilename->physician,array('class'=>'form-control input-type-format','readonly'=>'true','id'=>'physician'))}}
                <br>
                {{ Form::select('category',$category,$data->category,array('class'=>'form-control input-type-format category','required'=>'true','id'=>'category','data-id'=>'IF'.$data->id)) }}
                <br>
                {{ Form::select('manufacturer',$manufacture,$data->manufacturer,array('class'=>'form-control input-type-format manufacturer','required'=>'true','id'=>'manufacturer','data-id'=>'IF'.$data->id)) }}
                <br>
                @if($data['status'] == 'itemfile')
                    {{ Form::select('supplyItem',$supplyItem,$data->supplyItem,array('class'=>'form-control input-type-format supplyItem','required'=>'true','id'=>'supplyItem','data-id'=>'IF'.$data->id)) }}
                    <br>
                    {{Form::text('mfgPartNumber',$data->mfgPartNumber,array('class'=>'form-control input-type-format mfgPartNumber','placeholder'=>'Manuf Part #','id'=>'mfgPartNumber','data-id'=>'IF'.$data->id))}}
                    <br>
                    {{Form::text('hospitalPart',$data->hospitalPart,array('class'=>'form-control input-type-format','placeholder'=>'Hospital Part #','id'=>'hospitalPart','data-id'=>'IF'.$data->id))}}
                    <br>
                @else
                    {{ Form::text('supplyItem',$data->supplyItem,array('class'=>'form-control input-type-format supplyItem','required'=>'true','id'=>'supplyItem','data-id'=>'IF'.$data->id)) }}
                    <br>
                    {{Form::text('mfgPartNumber',$data->mfgPartNumber,array('class'=>'form-control input-type-format mfgPartNumber','placeholder'=>'Manuf Part #','id'=>'mfgPartNumber','data-id'=>'IF'.$data->id))}}
                    <br>
                    {{Form::text('hospitalPart',$data->hospitalPart,array('class'=>'form-control input-type-format','placeholder'=>'Hospital Part #','id'=>'hospitalPart','data-id'=>'IF'.$data->id))}}
                    <br>
                @endif
                {{--{{ Form::text('quantity',$data->quantity,array('class'=>'form-control input-type-format quantity','required'=>'true','data-id'=>'IF'.$data->id,'readonly'=>'true')) }}--}}
                {{--<br>--}}
                {{ Form::select('purchaseType',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),$data->purchaseType,array('class'=>'form-control input-type-format purchaseType','required'=>'true','data-id'=>'IF'.$data->id)) }}
                <br>

                {{ Form::text('',$data->serialNumber,array('placeholder'=>'Serial Number','class'=>'form-control input-type-format serialNumber','data-id'=>'IF-text'.$data->id,'id'=>'serial-text'))}}
                <br>
                <span id="serial-drop-box" style="display: none;">
                    {{ Form::select('',array(''=>'Select serial no.'),'',array('class'=>'js-example-basic-single form-control input-type-format serialnumberdropdown','id'=>'serial-drop','data-id'=>'IF-drop'.$data->id)) }}

                </span>

                <br>

                {{Form::text('poNumber',$data->poNumber,array('class'=>'form-control input-type-format','readonly'=>'true','data-id'=>'IF'.$data->id,'placeholder'=>'P.O. Number'))}}

                {{--<br>--}}
                {{--{{Form::text('order',$data->orderId,array('class'=>'form-control input-type-format','placeholder'=>'Order Id'))}}--}}

                {{Form::hidden('status',$data->status)}}
                {{Form::hidden('swapId',$data->id)}}
                <br>
                <div class="bottom-btn-block">
                    <button type="submit" class="btn btn-primary view-edit-details-btn" style="width: 70%" id="submit">
                        SAVE
                    </button>

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
                format: 'MM/DD/YYYY'
            });
            function today() {
                var d = new Date();
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1;
                var curr_year = d.getFullYear();
                document.write(curr_date + "-" + curr_month + "-" + curr_year);
            }

        });

        $(document).ready(function () {
            var id = $(this).attr("data-id");
            var client = $("#clientId").val();
            var supplyItem = "{{$data->supplyItem}}";
            var hospitalPart = "{!! $data->hospitalPart !!}";
            var mfgPartNumber = "{!! $data->mfgPartNumber !!}";
            var serialNumber = "{!! $data->serialNumber !!}";
            var purchaseType = "{!! $data->purchaseType !!}";

            $.ajax({
                url: "{{ URL::to('admin/repcasetracker/getdevicedata')}}",
                data: {
                    supplyItem: supplyItem,
                    hospitalPart: hospitalPart,
                    mfgPartNumber: mfgPartNumber,
                    client: client,

                },

                success: function (data) {
                    console.log(data);
                    if (data.status) {
                        var html_data = '';

                        var check = data.value;

                        if (check == 'True') {
                            if (purchaseType == "Bulk") {
                                html_data += "<option value=''>Purchase Type</option><option value='Bulk' SELECTED>Bulk</option><option value='Consignment'>Consignment</option>";
                            } else if (purchaseType == "Consignment") {
                                html_data += "<option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment' SELECTED>Consignment</option>";
                            } else {
                                html_data += "<option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option>";
                            }
                            $('.purchaseType').html(html_data);


                        } else {

                            if (purchaseType == "Consignment") {
                                html_data += "<option value=''>Purchase Type</option><option value='Consignment' SELECTED>Consignment</option>";
                            } else {
                                html_data += "<option value=''>Purchase Type</option><option value='Consignment'>Consignment</option>";
                            }
                            $('.purchaseType').html(html_data);

                        }


                    }
                }

            });

            if (purchaseType == 'Bulk') {

                $('#serial-text').removeAttr('name');
                $('#serial-drop').attr('name', 'serialNumber');

                $('#serial-text').removeClass('sf');
                $('#serial-drop').addClass('sf');

                $('#serial-text').hide();
                $('#serial-drop-box').show();

                $.ajax({
                    url: "{{ URL::to('repcasetracker/getserialnumbers')}}",
                    data: {
                        supplyItem: supplyItem,
                        mfgPartNumber: mfgPartNumber,
                        client: client,
                        purchaseType: purchaseType,
                        serialNumber: serialNumber

                    },


                    success: function (data) {
                        if (data.status) {

                            //$("#serialnumbers[data-id=" + id + "]").html(data.value);
                            $("#serial-drop").append("<option value='" + serialNumber + "' SELECTED>" + serialNumber + "</option>");

                            $.each(data.value, function (i, item) {

                                $("#serial-drop").append("<option value='" + item.serialNumber + "'>" + item.serialNumber + "</option>");
                            });

                        }
                    }


                });

            } else {


                $('#serial-text').attr('name', 'serialNumber');
                $('#serial-drop').removeAttr('name');

                $('#serial-text').addClass('sf');
                $('#serial-drop').removeClass('sf');

                $('#serial-text').show();
                $('#serial-drop-box').hide();

            }

        });

        /*Serial No Valodattion start*/
        $(document).on("keyup", ".serialNumber", function (event) {

            var id = $(this).attr("data-id");

            var currentserialnumber = $(this).val();
            var currentsuplyitem = $('.supplyItem[data-id=' + id + ']').val();


            $('.sf').each(function () {

                var dtid = $(this).attr('data-id');
                //      var supplyitemvalue = $('.supplyItem[data-id=' + dtid + ']').val();
                var serialnumbervalue = $(this).val();


                if (id != dtid) {
                    //    if (currentsuplyitem == supplyitemvalue) {
                    if (serialnumbervalue == currentserialnumber) {

                        $('.serialNumber[data-id=' + id + ']').val('');
                        $('.serialnumberdropdown[data-id=' + id + ']').val();
                        $("'.serialnumberdropdown[data-id=' + id + ']' > option").removeAttr("selected");
                        $('.serialnumberdropdown[data-id=' + id + ']').trigger('change');
                    }

                    //  }
                }


            });
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
                        if(data.value == "success"){
                            alert('This Serial Number is Already Avalilable For Bulk');
                            $('.serialNumber[data-id=' + id + ']').val('');
                        }
                    }
                }
            });

        });

        /*Serial No Dropdown Valodattion start*/
        $(document).on("change", ".serialnumberdropdown", function (event) {


            var id = $(this).attr("data-id");


            var currentserialnumber = $(this).val();
            var currentsuplyitem = $('.supplyItem[data-id=' + id + ']').val();


            $('.sf').each(function () {

                var dtid = $(this).attr('data-id');
                //  var supplyitemvalue = $('.supplyItem[data-id=' + dtid + ']').val();
                var serialnumbervalue = $(this).val();


                if (id != dtid) {
                    //    if (currentsuplyitem == supplyitemvalue) {
                    if (serialnumbervalue == currentserialnumber) {
                        $('.serialNumber[data-id=' + id + ']').val('');
                        $('.serialnumberdropdown[data-id=' + id + ']').val([""]);
                        var dropdownid = $('.serialnumberdropdown[data-id=' + id + ']').attr('id');
                        $('#select2-' + dropdownid + '-container').text("");

                    }

                    //  }
                }


            });
        });

        /*Quantity Validatation End*/

        /*company name get start*/
        $(document).on("change", "#category", function (event) {

            var hospital = $("#clientId").val();
            var project = {{$data->projectId}};
            var category = $("#category").val();
//            alert(category);
            if (hospital != "" && physician != "" && category != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getcompany')}}",
                    data: {
                        hospital: hospital,
                        project: project,
                        category: category
                    },

                    success: function (data) {
                        var html_data = '';
                        if (data.status) {
                            html_data += "<option value=''>Select Company</option>";
                            $.each(data.value, function (i, item) {

                                html_data += "<option value='" + item.company + "'>" + item.company + "</option>";
                            });
                        } else {
                            html_data = "<option value=''>Select Company</option>";
                        }

                        $("#manufacturer").html(html_data);

                    }

                });
            }

        });
        /*company name get end*/
        /*Supply Item data start*/
        $(document).on("change", "#manufacturer", function (event) {

            var hospital = $("#clientId").val();
            var project = {{$data->projectId}};
            var category = $("#category").val();
            var manufacturer = $("#manufacturer").val();


            if (hospital != "" && physician != "" && category != "" && manufacturer != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getsupplyitem')}}",
                    data: {
                        hospital: hospital,
                        project: project,
                        category: category,
                        manufacturer: manufacturer
                    },

                    success: function (data) {
                        var html_data = '';
                        if (data.status) {
                            html_data += "<option value=''>Supply Item</option>";
                            $.each(data.value, function (i, item) {

                                html_data += "<option value='" + item.supplyItem + "'>" + item.supplyItem + "</option>";
                            });
                        } else {
                            html_data = "<option value=''>Supply Item</option>";
                        }

                        $(".supplyItem").html(html_data);

                    }

                });
            }

        });

        /*Suplly item data end*/
        /*Get Item File Data Start*/
        $(document).on("change", ".supplyItem", function (event) {

            var id = $(this).attr("data-id");

            // var check = $(".supplyItem[data-id="+id+"]").val();
            $(".quantity[data-id=" + id + "]").attr("required", "true");

            if ($(".supplyItem[data-id=" + id + "]").val() != "") {
                $(".quantity[data-id=" + id + "]").attr("required", "true");
                $(".purchaseType[data-id=" + id + "]").attr("required", "true");
                $(".serialNumber[data-id=" + id + "]").attr("required", "true");
                $("#serial-text" + id).attr("required", "true");
//                $("#serial-drop" + id).attr("required", "true");
            } else {
                $(".quantity[data-id=" + id + "]").removeAttr("required");
                $(".purchaseType[data-id=" + id + "]").removeAttr("required");
                $(".serialNumber[data-id=" + id + "]").removeAttr("required");
                $("#serial-text" + id).removeAttr("required");
//                $("#serial-drop" + id).removeAttr("required");
            }


            var currentserialnumber = $('.serialNumber[data-id=' + id + ']').val();
            var currentsuplyitem = $(this).val();

            $('input[name^="serialNumber"]').each(function () {

                var dtid = $(this).attr('data-id');
                var supplyitemvalue = $('.supplyItem[data-id=' + dtid + ']').val();

                var serialnumbervalue = $('.serialNumber[data-id=' + dtid + ']').val();
                if (id != dtid) {
                    if (currentsuplyitem == supplyitemvalue) {
                        if (serialnumbervalue == currentserialnumber) {
                            $('.serialNumber[data-id=' + id + ']').val('');

                        }

                    }
                }


            });

            var supplyItem = $("#supplyItem").val();
            var hospital = $("#clientId").val();
            var physician = $("#physician").val();
            var category = $("#category").val();
            var manufacturer = $("#manufacturer").val();
            var project = $("#projectId").val();

            if (hospital != "" && physician != "" && category != "" && manufacturer != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getitemfile')}}",
                    data: {
                        supplyItem: supplyItem,
                        hospital: hospital,
                        project : project,
                    },

                    success: function (data) {

                        if (data.status) {
                            var item = data.value;

                            $('#hospitalPart').val(item.hospitalNumber);
                            $('#mfgPartNumber').val(item.mfgPartNumber);

                            // $('.mfgPartNumber[data-id='+id+']').text('something');
                        } else {
                            $('#hospitalPart').val('');
                            $('#mfgPartNumber').val('');

                        }

//                        $('.quantity[data-id=' + id + ']').val('');
                        $('.purchaseType[data-id=' + id + ']').val('');
                        $('.serialNumber[data-id=' + id + ']').val('');
                        $('#serial-text'+ id).val('');
                        $('#serial-drop' +id).val('');
                        $('#serial-drop' + id).empty();
//                        $('.poNumber[data-id=' + id +']').val('');

                    }

                });
            }

        });
        /*Get Item File Data End*/

        $(document).on("keyup", ".supplyItem", function (event) {

            var id = $(this).attr("data-id");

            // var check = $(".supplyItem[data-id="+id+"]").val();
            $(".quantity[data-id=" + id + "]").attr("required", "true");

            if ($(".supplyItem[data-id=" + id + "]").val() != "") {
                $(".quantity[data-id=" + id + "]").attr("required");
                $(".purchaseType[data-id=" + id + "]").attr("required", "true");
                $(".serialNumber[data-id=" + id + "]").attr("required", "true");
                $("#serial-text" + id).attr("required", "true");
//                $("#serial-drop" + id).attr("required", "true");
            } else {
                $(".quantity[data-id=" + id + "]").removeAttr("required");
                $(".purchaseType[data-id=" + id + "]").removeAttr("required");
                $(".serialNumber[data-id=" + id + "]").removeAttr("required");
                $("#serial-text" + id).removeAttr("required");
//                $("#serial-drop" + id).removeAttr("required");

            }
        });

        $(document).on('change', '.supplyItem', function (event) {
            var timer, delay = 1000;
            var id = $(this).attr("data-id");
            var client = $("#clientId").val();

            timer = setInterval(function () {

            var supplyItem = $("#supplyItem").val();
            var hospitalPart = $("#hospitalPart").val();
            var mfgPartNumber = $("#mfgPartNumber").val();

            clearInterval(timer);

            $.ajax({
                url: "{{ URL::to('admin/repcasetracker/getdevicedata')}}",
                data: {
                    supplyItem: supplyItem,
                    hospitalPart: hospitalPart,
                    mfgPartNumber: mfgPartNumber,
                    client: client,

                },

                success: function (data) {

                    if (data.status) {
                        var html_data = '';

                        var check = data.value;

                        if (check == 'True') {
                            html_data += "<option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option>";
                            $('.purchaseType').html(html_data);

                        } else {
                            html_data += "<option value=''>Purchase Type</option><option value='Consignment'>Consignment</option>";

                            $('.purchaseType').html(html_data);

                        }


                    }
                }

            });
            }, delay);
        });

        $(document).on('change', '.purchaseType', function (event) {

            var id = $(this).attr("data-id");
            var value = $(this).val();
            var client = $("#clientId").val();
            var supplyItem = $(".supplyItem[data-id=" + id + "]").val();
            var mfgPartNumber = $(".mfgPartNumber[data-id=" + id + "]").val();

            if (value == 'Bulk') {
                $('#serial-text').removeAttr('name');
                $('#serial-drop').attr('name', 'serialNumber');

                $('#serial-text').removeClass('sf');
                $('#serial-drop').addClass('sf');

                $('#serial-text').hide();
                $('#serial-drop-box').show();
                $('#serial-drop').val('');

                $('#serial-drop').empty();
                $("#serial-drop" + id).attr("required", "true");
                $("#serial-text" + id).removeAttr("required");

                $.ajax({
                    url: "{{ URL::to('repcasetracker/getserialnumbers')}}",
                    data: {
                        supplyItem: supplyItem,
                        mfgPartNumber: mfgPartNumber,
                        client: client,
                        value: value,
                        id: id,

                    },
                    success: function (data) {

                        if (data.status) {
                            //$("#serialnumbers[data-id=" + id + "]").html(data.value);
                            $("#serial-drop").append("<option value=''>Select Serial Number</option>");
                            $.each(data.value, function (i, item) {

                                $("#serial-drop").append("<option value='" + item.serialNumber + "'>" + item.serialNumber + "</option>");
                            });

                        }
                    }
                });
            } else {


                $('#serial-text').attr('name', 'serialNumber');
                $('#serial-drop').removeAttr('name');

                $('#serial-text').addClass('sf');
                $('#serial-drop').removeClass('sf');

                $('#serial-text').show();
                $('#serial-text').val('');
                $('#serial-drop-box').hide();
                $("#serial-text" + id).attr("required", "true");
                $("#serial-drop" + id).removeAttr("required");

            }

        });


    </script>


@endsection