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
                                {{ Form::open(array('url' => 'admin/repcasetracker/swapdevice/update/'.$id,'method'=>'POST','files'=>true)) }}
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
                                        <div class="modal-box" align="center"><label>Swap Item File Entry - Serial
                                                Number only</label></div>
                                        <div style="display: none;">{{$i = 1}}</div>
                                        @foreach($itemdetails as $row)
                                            @if(empty($row->swapDate))

                                                <div class="input1 item-input item">
                                                    <label>Item #{{$i}}:</label>
                                                    {{ Form::text('category[]',$row['category'],array('class'=>'repbox-input category','id'=>'category-IF'.$i,'readonly'=>'true','data-id'=>'IF'.$i)) }}

                                                    {{ Form::text('manufacturer[]',$row['manufacturer'],array('class'=>'repbox-input manufacturer','id'=>'manufacturer-IF'.$i,'readonly'=>'true','data-id'=>'IF'.$i)) }}

                                                    {{ Form::text('supplyItem[]',$row['supplyItem'],array('class'=>'repbox-input supplyItem','id'=>'supplyItem-IF'.$i,'readonly'=>'true','data-id'=>'IF'.$i)) }}

                                                    {{ Form::text('hospitalPart[]',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','readonly'=>'true','data-id'=>'IF'.$i,'id'=>'hospitalPart-IF'.$i,'readonly'=>'true'))}}

                                                    {{ Form::text('mfgPartNumber[]',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','id'=>'mfgPartNumber-IF'.$i,'class'=>'repbox-input mfgPartNumber','data-id'=>'IF'.$i,'readonly'=>'true'))}}

{{--                                                    {{ Form::text('quantity[]',$row['quantity'],array('placeholder'=>'Quantity #','class'=>'repbox-input quantity','data-id'=>'IF'.$i,'readonly'=>'true'))}}--}}

                                                    {{ Form::text('purchaseType[]',$row['purchaseType'],array('placeholder'=>'purchaseType #','class'=>'repbox-input purchaseType','id'=>'purchaseType-IF'.$i,'data-id'=>'IF'.$i,'readonly'=>'true'))}}

                                                    {{ Form::text('',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber ','data-id'=>'IF-text'.$i,'id'=>'serial-textIF'.$i,))}}

                                                    <span id="serial-drop-box-IF{{$i}}" style="display: none;">
                                            {{ Form::select('',array(''=>'Select serial no.'),$row['serialNumber'],array('class'=>'js-example-basic-single repbox-input serialnumberdropdown','id'=>'serial-dropIF'.$i,'data-id'=>'IF-drop'.$i)) }}
                                            </span>

                                                    {{ Form::text('poNumber[]',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','readonly'=>'true','data-id'=>'IF'.$i))}}

{{--                                                    {{ Form::number('order[]',$row['orderId'],array('placeholder'=>'Order Id','class'=>'repbox-input order','readonly'=>'true','data-id'=>'IF'.$i))}}--}}

                                                    {{Form::hidden('status[]',$row['status'])}}
                                                    {{Form::hidden('serialId[]',$row['id'])}}
                                                    {{Form::hidden('serial',$row['serialNumber'],array('id'=>'serialNumber-IF'.$i))}}
                                                    <div style="display: none;">{{$i++}}</div>
                                                </div>
                                            @else
                                                <div class="input1 item-input item swapData">
                                                    <label style="color: red;">Item #:</label>
                                                    {{ Form::text('categorys',$row['category'],array('class'=>'repbox-input category','readonly'=>'true')) }}

                                                    {{ Form::text('manufacturers',$row['manufacturer'],array('class'=>'repbox-input manufacturer','readonly'=>'true')) }}

                                                    {{ Form::text('supplyItems',$row['supplyItem'],array('class'=>'repbox-input supplyItem','readonly'=>'true')) }}

                                                    {{ Form::text('hospitalParts',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','readonly'=>'true'))}}

                                                    {{ Form::text('mfgPartNumbers',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber','readonly'=>'true'))}}

{{--                                                    {{ Form::text('quantitys',$row['quantity'],array('placeholder'=>'Quantity #','class'=>'repbox-input quantity','readonly'=>'true'))}}--}}

                                                    {{ Form::text('purchaseTypes',$row['purchaseType'],array('placeholder'=>'purchaseType #','class'=>'repbox-input purchaseType','readonly'=>'true'))}}

                                                    {{ Form::text('serials',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber ','readonly'=>'true'))}}

                                                    {{ Form::text('poNumbers',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','readonly'=>'true'))}}

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
                var category = $("#category-IF" + j).val();

                categories.push(category);

                var man = $('#manufacturer-IF' + j).val();

                manuf.push(man);

                var physician = $('#physician').val();

                var dId = $('#category-IF' + j).attr("data-id");

                datid.push(dId);

                var supply = $('#supplyItem-IF' + j).val();
                supplyitem.push(supply);

                var manufs = $('#mfgPartNumber-IF' + j).val();

                manufacture.push(manufs);

                var pur = $("#purchaseType-IF" + j).val();
                purchase.push(pur);

                var serial = $("#serialNumber-IF" + j).val();
                serialNumber.push(serial);


            }

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

        });
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


    </script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/black-tie/jquery-ui.css"
          media="screen"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/datepicker.js') }}"></script>


@stop