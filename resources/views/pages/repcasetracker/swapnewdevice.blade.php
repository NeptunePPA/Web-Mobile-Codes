@extends ('layout.default')
@section ('content')
    <style type="text/css">
        .modal-box .input1.swapData input[type='text'] {
            color: red;
        }
    </style>

    <div class="add_new" align="center">
        <div class="boxrepcase">
            <center>
                <div class="add_new_boxrepcase">
                    <div class="col-md-16 col-lg-16 modal-box" align="center">
                        <div class="content-area clearfix" style="padding:10px;">
                            <div class="adddevice-modal addclient-price">
                                <ul>
                                    @foreach($errors->all() as $error)

                                        <li style="color:red; margin:5px;">{{ $error }}</li>

                                    @endforeach
                                </ul>
                                {{ Form::open(array('url' => 'admin/repcasetracker/swapdevice/updates/'.$id,'method'=>'POST','files'=>true)) }}
                                <div class="modal-body clearfix">
                                    <a href="{{ URL::to('admin/repcasetracker') }}" class="pull-right">X</a>
                                    <h3 align="center"> Case Details</h3>

                                    <div class="modal-border clearfix">
                                        <div class="modal-box" align="center">
                                            <div class="input1">

                                                {{ Form::text('repcaseID',$itemMain['repcaseID'],array('placeholder'=>'Case Id','readonly'=>'true')) }}
                                            </div>
                                            <label>Procedure Date:</label>
                                            <div class="input1">
                                                {!! Form::text('procedure_date',Carbon\Carbon::parse($itemMain['produceDate'])->format('m-d-Y'), array('id' => 'datepicker11','placeholder'=>'03-06-2017','readonly'=>'true')) !!}

                                            </div>
                                            <div class="input1">
                                                {{ Form::text('hospital',$itemMain->client['client_name'],array('placeholder'=>'hospital','readonly'=>'true','id'=>'hospital')) }}
                                                {{Form::hidden('client',$itemMain['clientId'],array('id'=>'client'))}}
                                            </div>

                                            <div class="input1">
                                                {{ Form::text('repuser',$itemMain->users['name'],array('placeholder'=>'repUser','readonly'=>'true','id'=>'repUser')) }}
                                            </div>

                                            <div class="input1">
                                                {{ Form::text('project',$itemMain->projectname['project_name'],array('placeholder'=>'project','readonly'=>'true','id'=>'project')) }}
                                                {{Form::hidden('projectId',$itemMain['projectId'],array('id'=>'projectId'))}}
                                            </div>

                                            <div class="input1">
                                                {{ Form::text('physician',$itemMain['physician'] ,array('placeholder'=>'physician','readonly'=>'true','id'=>'physician')) }}
                                            </div>

                                        </div>
                                        <hr>
                                        {{--<div class="modal-box" align="center"><label>Swap Item File Entry - Serial--}}
                                        {{--Number only</label></div>--}}
                                        <div style="display: none;">{{$i = 1}}</div>
                                        @foreach($itemdetails as $row)
                                            @if(empty($row->swapDate))
                                                <div class="input1 item-input item">
                                                    <label>Item #{{$i}}:</label>

                                                    {{ Form::select('category[]',$category,$row['category'],array('class'=>'repbox-input category','id'=>'category-IF'.$i,'data-id'=>'IF'.$i)) }}

                                                    {{ Form::select('manufacturer[]',array('' => 'Manufacture'),$row['manufacturer'],array('class'=>'repbox-input manufacturer','id'=>'manufacturer-IF'.$i,'data-id'=>'IF'.$i)) }}

                                                    @if($row['status'] == 'itemfile')
                                                        {{ Form::select('supplyItem[]',array('' => 'Supply Item'),$row['supplyItem'],array('class'=>'repbox-input supplyItem','id'=>'supplyItem-IF'.$i ,'data-id'=>'IF'.$i)) }}

                                                        {{ Form::text('hospitalPart[]',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','readonly'=>'true','data-id'=>'IF'.$i,'id'=>'hospitalPart-IF'.$i,'readonly'=>'true'))}}

                                                        {{ Form::text('mfgPartNumber[]',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber  ','data-id'=>'IF'.$i,'readonly'=>'true'))}}
                                                    @else
                                                        {{ Form::text('supplyItem[]',$row['supplyItem'],array('class'=>'repbox-input supplyItem','id'=>'supplyItem-MI'.$i ,'data-id'=>'MI'.$i)) }}

                                                        {{ Form::text('hospitalPart[]',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','data-id'=>'MI'.$i,'id'=>'hospitalPart-MI'.$i,'readonly'=>'true'))}}

                                                        {{ Form::text('mfgPartNumber[]',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber','data-id'=>'MI'.$i))}}

                                                    @endif
                                                    {{--{{ Form::text('quantity[]',$row['quantity'],array('class'=>'repbox-input quantity','data-id'=>'IF'.$i,'readonly'=>'true')) }}--}}

                                                    {{ Form::select('purchaseType[]',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),$row['purchaseType'],array('class'=>'repbox-input purchaseType','data-id'=>'IF'.$i)) }}

                                                    {{ Form::text('',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber ','data-id'=>'IF-text'.$i,'id'=>'serial-textIF'.$i,))}}

                                                    <span id="serial-drop-box-IF{{$i}}" style="display: none;">
                                            {{ Form::select('',array(''=>'Select serial no.'),$row['serialNumber'],array('class'=>'js-example-basic-single repbox-input serialnumberdropdown','id'=>'serial-dropIF'.$i,'data-id'=>'IF-drop'.$i)) }}
                                            </span>

                                                    {{ Form::text('poNumber[]',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','readonly'=>'true','data-id'=>'IF'.$i))}}

{{--                                                    {{ Form::number('order[]',$row['orderId'],array('placeholder'=>'Order Id','class'=>'repbox-input order','readonly'=>'true','data-id'=>'IF'.$i))}}--}}

                                                    {{Form::hidden('status[]',$row['status'])}}
                                                    {{Form::hidden('serialId[]',$row['id'])}}
                                                    {{Form::hidden('supply',$row['supplyItem'],array('class'=>'repbox-input supply','readonly'=>'true','id'=>'supply-IF'.$i,'data-id'=>'IF'.$i))}}
                                                    {{Form::hidden('manuf',$row['manufacturer'],array('class'=>'repbox-input manuf','readonly'=>'true','id'=>'manuf-IF'.$i,'data-id'=>'IF'.$i))}}
                                                    {{Form::hidden('manufpart',$row['mfgPartNumber'],array('class'=>'repbox-input manufpart','readonly'=>'true','id'=>'manufpart-IF'.$i,'data-id'=>'IF'.$i))}}
                                                    {{Form::hidden('purch',$row['purchaseType'],array('class'=>'repbox-input purch','readonly'=>'true','id'=>'purch-IF'.$i,'data-id'=>'IF'.$i))}}
                                                    {{Form::hidden('serial',$row['serialNumber'],array('id'=>'serialNumber-IF'.$i))}}
                                                    <div style="display: none;">{{$i++}}</div>
                                                </div>
                                            @else
                                                <div class="input1 item-input item swapData">
                                                    <label style="color: red;">Item #:</label>

                                                    {{ Form::text('categorys',$row['category'],array('class'=>'repbox-input category','readonly'=>'true')) }}

                                                    {{ Form::text('manufacturesr',$row['manufacturer'],array('class'=>'repbox-input manufacturer','readonly'=>'true')) }}


                                                    {{ Form::text('supplyItems',$row['supplyItem'],array('class'=>'repbox-input supplyItem','readonly'=>'true')) }}

                                                    {{ Form::text('hospitalParts',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','readonly'=>'true'))}}

                                                    {{ Form::text('mfgPartNumbers',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber','readonly'=>'true'))}}

                                                    {{--{{ Form::text('quantitys',$row['quantity'],array('class'=>'repbox-input quantity','readonly'=>'true')) }}--}}

                                                    {{ Form::text('purchaseTypes',$row['purchaseType'],array('class'=>'repbox-input purchaseType','readonly'=>'true')) }}

                                                    {{ Form::text('serails',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber ','readonly'=>'true'))}}

                                                    {{ Form::text('poNumbers',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','readonly'=>'true','readonly'=>'true'))}}

{{--                                                    {{ Form::number('order[]',$row['orderId'],array('placeholder'=>'Order Id','class'=>'repbox-input order','readonly'=>'true','data-id'=>'IF'.$i))}}--}}
                                                </div>

                                            @endif
                                        @endforeach

                                    </div>
                                    <div class="modal-btn clearfix">
                                        {{ Form::submit('SAVE') }}
                                        <a href="{{ URL::to('admin/repcasetracker') }}"
                                           style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">CANCEL</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>
    <script src="{{ URL::asset('js/edit_script.js') }}"></script>


    <script type="text/javascript">
        function runscript() {
            $.getScript("{{ URL::asset('js/edit_script.js') }}", function () {

            });
        }
    </script>
    <script>

        $(document).ready(function () {

            $(function () {
                $('#datepicker').datepicker({
                    numberOfMonths: 1,
                    dateFormat: 'mm-dd-yy',
                });
            });

            var id ={{$i}};

            /*Supply Item data start*/

            var j;
            var z = 1;
            var categories = new Array();
            var manuf = new Array();
            var si = new Array();
            var datid = new Array();
            var supplyitem = new Array()
            var manufacture = new Array();
            var purchase = new Array();
            var serialNumber = new Array();

            for (j = 1; j < id; j++) {

                var hospital = $("#client").val();
                var project = $("#projectId").val();


                var char = "#category-IF" + j;
                var category = $(char + " option:selected").text();

                categories.push(category);

                var man = $('#manuf-IF' + j).val();

                manuf.push(man);

                var physician = $('#physician').val();

                var dId = $('#category-IF' + j).attr("data-id");

                datid.push(dId);

                var supply = $('#supply-IF' + j).val();
                supplyitem.push(supply);

                var manufs = $('#manufpart-IF' + j).val();

                manufacture.push(manufs);

                var pur = $("#purch-IF" + j).val();
                purchase.push(pur);

                var serial = $("#serialNumber-IF" + j).val();
                serialNumber.push(serial);

            }

            if (hospital != "" && category != "" && manuf != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getcompanies')}}",
                    data: {
                        hospital: hospital,
                        category: categories,
                        project: project,
                        dataid: datid,
                        manufacturer: manuf,

                    },

                    success: function (data) {
                        var html_data = '';
                        var q = 1;
                        if (data.status) {


                            $.each(data.value, function (i, item) {

                                html_data += "<option value=''>Select Company</option>";


                                $.each(item.data, function (i, items) {
                                    if (item.manufacturer == items.company) {

                                        html_data += "<option value='" + items.company + "' SELECTED>" + items.company + "</option>";
                                    } else {

                                        html_data += "<option value='" + items.company + "'>" + items.company + "</option>";
                                    }

                                });

                                $("#manufacturer-IF" + q).html(html_data);
                                html_data = "";
                                q++;
                            });
                        } else {
                            html_data = "<option value=''>Supply Company</option>";
                        }

                    }

                });
//            }

//            if (hospital != "" && category != "" && manufacturer != "") {

                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getsupplyitems')}}",
                    data: {
                        hospital: hospital,
                        category: categories,
                        manufacturer: manuf,
                        project: project,
                        physician: physician,
                        dataid: datid,
                        supplyitem: supplyitem
                    },

                    success: function (data) {
                        var html_data = '';
                        var q = 1;
                        if (data.status) {


                            $.each(data.value, function (i, item) {

                                html_data += "<option value=''>Select Supply Item</option>";


                                $.each(item.data, function (i, items) {
                                    if (item.supply == items.supplyItem) {

                                        html_data += "<option value='" + items.supplyItem + "' SELECTED>" + items.supplyItem + "</option>";
                                    } else {

                                        html_data += "<option value='" + items.supplyItem + "'>" + items.supplyItem + "</option>";
                                    }

                                });

                                $("#supplyItem-IF" + q).html(html_data);
                                html_data = "";
                                q++;
                            });
                        } else {
                            html_data = "<option value=''>Supply Item</option>";
                        }

                    }

                });

                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getdevicedatas')}}",
                    data: {
                        hospital: hospital,
                        category: categories,
                        manufacturer: manuf,
                        project: project,
                        physician: physician,
                        dataid: datid,
                        supplyitem: supplyitem,
                        manufacturepart: manufacture,
                        purchase: purchase
                    },

                    success: function (data) {
                        var html_data = '';
                        var q = 1;
                        if (data.status) {


                            $.each(data.value, function (i, item) {

                                var check = item.data;
                                var purchase = item.purchase;

                                if (check == 'True') {
                                    if (purchase == "Bulk") {
                                        html_data += "<option value=''>Purchase Type</option><option value='Bulk' SELECTED>Bulk</option><option value='Consignment'>Consignment</option>";

                                        $('.purchaseType[data-id=IF' + q + ']').html(html_data);
                                    } else if (purchase == 'Consignment') {
                                        html_data += "<option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment' SELECTED>Consignment</option>";

                                        $('.purchaseType[data-id=IF' + q + ']').html(html_data);
                                    }

                                } else if (check == "False") {
                                    if (purchase == "Consignment") {

                                        html_data += "<option value=''>Purchase Type</option><option value='Consignment' SELECTED>Consignment</option>";

                                        $('.purchaseType[data-id=IF' + q + ']').html(html_data);
                                    } else {
                                        html_data += "<option value=''>Purchase Type</option><option value='Consignment'>Consignment</option>";

                                        $('.purchaseType[data-id=IF' + q + ']').html(html_data);
                                    }
                                }

                                html_data = "";
                                q++;
                            });
                        } else {
                            html_data = "<option value=''>Supply Item</option>";
                        }

                    }

                });

                /*Get Serial Number onload Start*/

                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getserialnumbers')}}",
                    data: {
                        hospital: hospital,
                        category: categories,
                        manufacturer: manuf,
                        project: project,
                        physician: physician,
                        dataid: datid,
                        supplyItem: supplyitem,
                        manufacturepart: manufacture,
                        purchase: purchase,
                        serialNumber: serialNumber

                    },


                    success: function (data) {

                        $.each(data.value, function (i, item) {
                            if (item.datas.length > 0) {

                                $('#serial-text' + item.dataid).removeAttr('name');
                                $('#serial-drop' + item.dataid).attr('name', 'serialNumber[]');

                                $('#serial-text' + item.dataid).removeClass('sf');
                                $('#serial-drop' + item.dataid).addClass('sf');

                                $('#serial-text' + item.dataid).hide();
                                $('#serial-drop-box-' + item.dataid).show();


                                $("#serial-drop" + item.dataid).append("<option value='" + item.serial + "' SELECTED>" + item.serial + "</option>");

                                $.each(item.datas, function (i, it) {

                                    $("#serial-drop" + item.dataid).append("<option value='" + it.serialNumber + "'>" + it.serialNumber + "</option>");


                                });
                            } else {
                                $('#serial-text' + item.dataid).attr('name', 'serialNumber[]');
                                $('#serial-drop' + item.dataid).removeAttr('name');

                                $('#serial-text' + item.dataid).addClass('sf');
                                $('#serial-drop' + item.dataid).removeClass('sf');

                                $('#serial-text' + item.dataid).show();
                                $('#serial-drop-box-' + item.dataid).hide();
                            }

                        });

                    }


                });
                /*Get Serial Number onload End*/

            }

        });

        /*Supllay Item Chnages Start*/

        /*company name get start*/
        $(document).on("change", ".category", function (event) {

            var id = $(this).attr("data-id");

            var hospital = $("#client").val();
            var char = "#category-" + id;
            var category = $(char + " option:selected").text();

            var project = $("#projectId").val();

            if (hospital != "" && category != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getcompany')}}",
                    data: {
                        hospital: hospital,
                        category: category,
                        project: project
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

                        $("#manufacturer-" + id).html(html_data);

                    }

                });
            }

        });
        /*company name get end*/

        /*Supply Item data start*/
        $(document).on("change", ".manufacturer", function (event) {

            var id = $(this).attr("data-id");

            var hospital = $("#client").val();
            var project = $("#projectId").val();

            var char = "#category-" + id;
            var category = $(char + " option:selected").text();

            var man = "#manufacturer-" + id;
            var manufacturer = $(man).val();

            if (hospital != "" && category != "" && manufacturer != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getsupplyitem')}}",
                    data: {
                        hospital: hospital,
                        category: category,
                        manufacturer: manufacturer,
                        project: project
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

                        $("#supplyItem-" + id).html(html_data);

                    }

                });
            }

        });

        /*Supply item data end*/

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

            var supplyItem = $(".supplyItem[data-id=" + id + "]").val();
            var hospital = $("#client").val();
            var physician = $("#physician").val();
            var category = $("#category").val();
            var manufacturer = $("#manufacturer").val();
            var project = $("#projectId").val();

            if (hospital != "" && physician != "" && category != "" && manufacturer != "" && project != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getitemfile')}}",
                    data: {
                        supplyItem: supplyItem,
                        hospital: hospital,
                        project: project,
                    },

                    success: function (data) {

                        if (data.status) {

                            var item = data.value;
                            console.log(item);
                            $('.hospitalPart[data-id=' + id + ']').val(item.hospitalNumber);
                            $('.mfgPartNumber[data-id=' + id + ']').val(item.mfgPartNumber);

                            // $('.mfgPartNumber[data-id='+id+']').text('something');
                        } else {
                            $('.hospitalPart[data-id=' + id + ']').val('');
                            $('.mfgPartNumber[data-id=' + id + ']').val('');

                        }

//                        $('.quantity[data-id=' + id + ']').val('');
                        $('.purchaseType[data-id=' + id + ']').val('');
                        $('#serial-text' + id).val('');
                        $('#serial-drop' + id).val('');
                        $('#serial-drop' + id).val('');

                        $('#serial-drop' + id).empty();
                    }

                });
            }

        });
        /*Get Item File Data End*/

        /*Supply Item Chnages End*/

        /*Serial No Valodattion start*/
        $(document).on("keyup", ".serialNumber", function (event) {
            var id = $(this).attr("data-id");

            var currentserialnumber = $(this).val();
            var currentsuplyitem = $('.supplyItem[data-id=' + id + ']').val();
            // alert(id);
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


        $(document).on('change', '.supplyItem', function (event) {
            var timer, delay = 1000;
            var id = $(this).attr("data-id");

            var client = $("#client").val();

            timer = setInterval(function () {

                var supplyItem = $(".supplyItem[data-id=" + id + "]").val();
                var hospitalPart = $(".hospitalPart[data-id=" + id + "]").val();
                var mfgPartNumber = $(".mfgPartNumber[data-id=" + id + "]").val();

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
                                $('.purchaseType[data-id=' + id + ']').html(html_data);

                            } else {
                                html_data += "<option value=''>Purchase Type</option><option value='Consignment'>Consignment</option>";

                                $('.purchaseType[data-id=' + id + ']').html(html_data);
                            }
                        }


                    }

                });
            }, delay);
        });

        $(document).on('change', '.purchaseType', function (event) {

            var id = $(this).attr("data-id");
            var value = $(this).val();

            var client = $("#client").val();
            var supplyItem = $(".supplyItem[data-id=" + id + "]").val();
            var mfgPartNumber = $(".mfgPartNumber[data-id=" + id + "]").val();


//var html_data='';
            if (value == 'Bulk') {
                $('#serial-text' + id).removeAttr('name');
                $('#serial-drop' + id).attr('name', 'serialNumber[]');

                $('#serial-text' + id).removeClass('sf');
                $('#serial-drop' + id).addClass('sf');

                $('#serial-text' + id).hide();
                $('#serial-drop-box-' + id).show();

                $('#serial-drop' + id).val('');

                $('#serial-drop' + id).empty();
                $("#serial-drop" + id).attr("required", "true");
                $("#serial-text" + id).removeAttr("required");


                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getserialnumber')}}",
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
                            $("#serial-drop" + id).append("<option value=''>Select Serial Number</option>");
                            $.each(data.value, function (i, item) {

                                $("#serial-drop" + id).append("<option value='" + item.serialNumber + "'>" + item.serialNumber + "</option>");
                            });
                        }
                    }


                });
            } else {


                $('#serial-text' + id).attr('name', 'serialNumber[]');
                $('#serial-drop' + id).removeAttr('name');

                $('#serial-text' + id).addClass('sf');
                $('#serial-drop' + id).removeClass('sf');

                $('#serial-text' + id).show();
                $('#serial-drop-box-' + id).hide();
                $('#serial-text' + id).val('');
                $("#serial-text" + id).attr("required", "true");
                $("#serial-drop" + id).removeAttr("required");

            }


        });

    </script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/black-tie/jquery-ui.css"
          media="screen"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/datepicker.js') }}"></script>

@stop