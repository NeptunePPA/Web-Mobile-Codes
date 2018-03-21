@extends('layouts.repcase')
@section('content')
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
        <div class="add-case-details-form">
            <center>
                <h4 class="rap-case-title">Case Details</h4>
                {{ Form::open(array('url' => 'repcasetracker/createcase','method'=>'POST','files'=>'true','id'=>'target')) }}
                <ul>
                    @foreach($errors->all() as $error)

                        <li style="color:red; margin:5px;">{{ $error }}</li>

                    @endforeach
                </ul>
                <h5 class="details-title text-left">Procedure Date:</h5>
                <div class="form-group input-type-format">
                    <div class='input-group date' id='datetimepicker1'>
                        {{Form::text('procedure_date',Carbon\Carbon::now()->format('m-d-Y'),array('class'=>'form-control','placeholder'=>'10-06-2017','required'=>'true'))}}
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                </div>
                {{Form::text('repcaseID','',array('placeholder'=>'Case Id','readonly'=>'true','class'=>'form-control input-type-format'))}}
                <br>
                {{ Form::select('hospital',$clients,'', array('id'=>'hospital','class'=>'form-control input-type-format','required'=>'true')) }}
                <br>
                {{--{{ Form::select('repUser',$repuser,'', array('id'=>'repuser','class'=>'form-control input-type-format')) }}--}}
                {{--<br>--}}
                {{ Form::select('projectId',$project,'', array('id'=>'project','class'=>'form-control input-type-format','required'=>'true')) }}
                <br>
                {{ Form::select('physician',$physician,'',array('id'=>'physician','class'=>'form-control input-type-format','required'=>'true')) }}
                <br>
                {{ Form::select('phyEmail',$phyEmail,'',array('id'=>'physicianEmail','class'=>'form-control input-type-format','required'=>'true')) }}
                <br>
                <hr>
                <h5><b>Item File Entry</b></h5><br>
                <div class="item-file-entry swapdiv" id="add-more" data-id="IF1">
                    <h5 class="details-title text-left items"  data-id="IF1">Item #1:</h5>
                    <br>
                    {{ Form::select('category[]',$category,'',array('id'=>'category-IF1','class'=>'form-control input-type-format category','data-id'=>'IF1')) }}
                    <br>
                    {{ Form::select('manufacturer[]',$company,'',array('id'=>'manufacturer-IF1','class'=>'form-control input-type-format manufacturer','data-id'=>'IF1')) }}
                    <br>
                    {{ Form::select('supplyItem[]',array('' => 'Supply Item'),'',array('class'=>'form-control input-type-format supplyItem','id'=>'supplyItem-IF1','data-id'=>'IF1')) }}
                    <br>
                    {{ Form::text('hospitalPart[]',null,array('class'=>'form-control input-type-format hospitalPart','placeholder'=>'Hospital Part #','data-id'=>'IF1','id'=>'hospitalPart-IF1','readonly'=>'true'))}}
                    <br>
                    {{ Form::text('mfgPartNumber[]',null,array('placeholder'=>'Manuf Part #','class'=>'form-control input-type-format mfgPartNumber','data-id'=>'IF1','readonly'=>'true','id'=>'mfgPartNumber-IF1'))}}
                    <br>
                    {{--{{ Form::text('quantity[]','1',array('class'=>'form-control input-type-format quantity','data-id'=>'IF1','readonly'=>'true')) }}--}}
                    {{--<br>--}}
                    {{ Form::select('purchaseType[]',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),'',array('class'=>'form-control input-type-format purchaseType','data-id'=>'IF1')) }}
                    <br>

                    {{ Form::text('serialNumber[]',null,array('placeholder'=>'Serial Number','class'=>'form-control input-type-format serialNumber','data-id'=>'IF-text1','id'=>'serial-textIF1',))}}

                    <span id="serial-drop-box-IF1" style="display: none;">
                        {{ Form::select('',array(''=>'Select serial no.'),'',array('class'=>'js-example-basic-single  serialnumberdropdown','id'=>'serial-dropIF1','data-id'=>'IF-drop1')) }}
                    </span>
                    <br>
                    <br>
                    {{ Form::select('isImplanted[]',array('Implanted'=>'Implanted','Not Implanted'=>'Not Implanted'),'',array('class'=>'form-control input-type-format implanted','data-id'=>'IF1')) }}
                    <br>
{{--                    {{ Form::select('type[]',array('Main'=>'Main','Sub'=>'Sub'),'',array('class'=>'form-control input-type-format type','data-id'=>'IF1')) }}--}}
                    <br>
                    {{ Form::select('unusedReason[]',array(''=>'Select Reason','Dropped'=>'Dropped','Wrong Device'=>'Wrong Device','Rep Error' => 'Rep Error','Doctor Error' => 'Doctor Error','Damaged Packaging' => 'Damaged Packaging'),'',array('class'=>'form-control input-type-format implanted-device','data-id'=>'IF1')) }}
                    <br>
                    {{ Form::text('poNumber[]',null,array('placeholder'=>'P.O. Number','class'=>'form-control input-type-format poNumber','data-id'=>'IF1'))}}
                    <br>
{{--                    {{ Form::number('order[]',null,array('placeholder'=>'Order Id','class'=>'form-control input-type-format order','data-id'=>'IF1'))}}--}}
                    <br>
                    {{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In','Swap Out'=>'Swap Out'),'',array('class'=>'form-control input-type-format swap','id'=>'swap-IF1','data-id'=>'IF1')) }}
                    <br>
                    <span>{{Form::checkbox('cco[]', 'True','', array('class' => 'form-control input-type-format cco' ,'data-id'=>'IF1'))}} CCO </span>
                    {{Form::hidden('cco_check[]','False',array('class'=>'ccocheck','data-id'=>'IF1'))}}
                    <br>

                    <span>{{Form::checkbox('repless[]', 'True','', array('class' => 'form-control input-type-format repless' ,'data-id'=>'IF1'))}} Repless </span>
                    <br>
                    {{Form::hidden('repless_check[]','False',array('class'=>'replesscheck','data-id'=>'IF1'))}}

                    {{Form::hidden('dataid[]','IF1')}}

                    {{Form::hidden('status[]','itemfile')}}
                </div>
                <a href="javascript:void(0);" class="plus-icon add-item">Add another item +</a>
                <br>
                {{--<hr>--}}
                {{--<h5><b>Manual Item Entry</b></h5><br>--}}
                <div class="manual-item swapdiv" id="new-add-more-item" data-id="MI1">
                    {{--<h5 class="details-title text-left items"  data-id="MI1">Item #1:</h5>--}}
                    {{--<br>--}}
                    {{--{{ Form::select('category[]',$category,'',array('id'=>'category-MI1','class'=>'form-control input-type-format category','data-id'=>'MI1')) }}--}}
                    {{--<br>--}}
                    {{--{{ Form::select('manufacturer[]',$company,'',array('id'=>'manufacturer-MI1','class'=>'form-control input-type-format manufacturer','data-id'=>'MI1')) }}--}}
                    {{--<br>--}}

                    {{--{{Form::text('supplyItem[]',null,array('class'=>'form-control input-type-format supplyItem','placeholder'=>'Supply Item','id'=>'fieldnames','data-id'=>'MI1'))}}--}}
                    {{--<br>--}}
                    {{--{{ Form::text('hospitalPart[]',null,array('class'=>'form-control input-type-format hospitalPart','placeholder'=>'Hospital Part #','data-id'=>'MI1'))}}--}}
                    {{--<br>--}}
                    {{--{{ Form::text('mfgPartNumber[]',null,array('placeholder'=>'Manuf Part #','class'=>'form-control input-type-format mfgPartNumber','data-id'=>'MI1'))}}--}}
                    {{--<br>--}}
                    {{--{{ Form::select('quantity[]',array('' => 'Quantity','1'=>'1'),'',array('class'=>'form-control input-type-format quantity','data-id'=>'MI1')) }}--}}
                    {{--<br>--}}
                    {{--{{ Form::select('purchaseType[]',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),'',array('class'=>'form-control input-type-format purchaseType','data-id'=>'MI1')) }}--}}
                    {{--<br>--}}
                    {{--{{ Form::number('order[]',null,array('placeholder'=>'Order Id','class'=>'form-control input-type-format order','data-id'=>'MI1'))}}--}}
                    {{--<br>--}}
                    {{--{{ Form::text('serialNumber[]',null,array('placeholder'=>'Serial Number','class'=>'form-control input-type-format serialNumber','data-id'=>'MI-text1','id'=>'serial-textMI1',))}}--}}

                    {{--<span id="serial-drop-box-MI1" style="display: none;">--}}
                        {{--{{ Form::select('',array(''=>'Select serial no.'),'',array('class'=>'js-example-basic-single serialnumberdropdown','id'=>'serial-dropMI1','data-id'=>'MI-drop1')) }}--}}
                    {{--</span>--}}

                    {{--<br>--}}
                    {{--{{ Form::text('poNumber[]',null,array('placeholder'=>'P.O. Number','class'=>'form-control input-type-format poNumber','data-id'=>'MI1'))}}--}}
                    {{--<br>--}}
                    {{--{{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In','Swap Out'=>'Swap Out'),'',array('class'=>'form-control input-type-format swaps','id'=>'swap-MI1','data-id'=>'MI1')) }}--}}

                    {{--{{Form::hidden('dataid[]','MI1')}}--}}

                    {{--{{Form::hidden('status[]','manual')}}--}}
                </div>
                {{--<a href="javascript:void(0);" class="plus-icons add-items">Add another item +</a>--}}
                {{--<br>--}}
                <br>
                <div class="bottom-btn-block">
                    <button type="submit" class="btn btn-primary view-edit-details-btn" style="width: 70%" id="submit">
                        SUBMIT CASE
                    </button>

                    <a href="{{URL::to('repcasetracker')}}" class="btn btn-danger view-edit-details-btn">CANCEL</a>
                </div>
                {{ Form::close() }}
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
        $(document).ready(function () {

            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: 'MM-DD-YYYY'
                });
            });

            $('.swap').hide();
            $('.swaps').hide();
            $('.implanted-device').hide();
        });


    </script>
    <script type="text/javascript">
          $(document).on('click','#submit',function(event){

             $("#target").submit();
         });
    </script>

    <script type="text/javascript">
        var max_fields = 5; //maximum input boxes allowed
        var wrapper = $("#add-more"); //Fields wrapper
        var add_button = $(".plus-icon"); //Add button ID

        var x = 1; //initlal text box count

        $(add_button).click(function (e) { //on add input button click
            var hospitalPart = $(".hospitalPart[data-id=IF" + x + "]").val();


            if (hospitalPart == "") {
                alert("Please enter Above Fileds!!");
            }
            else {
                e.preventDefault();

                var hospital = $("#hospital").val();
                var project = $("#project").val();
                var category = $("#category").val();
                var manufacturer = $("#manufacturer").val();
//
//                alert(hospital);

                if (hospital != "" && physician != "" && category != "" && manufacturer != "") {

                    if (x < max_fields) { //max input box allowed
                        x++;
                        $.ajax({
                            url: "{{URL::to('admin/repcasetracker/getcategory')}}",
                            data: {
                                hospital: hospital,
                                project: project,
                                category: category
                            },

                            success: function (data) {
                                var html_data = '';
                                var swapoption = '';
                                if (data.status) {
                                    console.log(data);
                                    html_data += "<option value=''>Select Category</option>";
                                    $.each(data.value, function (i, item) {

                                        html_data += "<option value='" + item.category + "'>" + item.category + "</option>";
                                    });
                                } else {
                                    html_data = "<option value=''>Select Category</option>";
                                }
                                swapoption += "<option value=''>Swap</option><option value='Swap In'>Swap In</option><option value='Swap Out'>Swap Out</option>";

                                $(wrapper).append("<div class='item-file-entry append-div' id='add-more'>" +
                                    "<div class='swapdiv' data-id='IF" + x + "'><h5 class='details-title text-left items' data-id='IF" + x + "'>Item #" + x + ":</h5>" +
                                    "<select class='form-control input-type-format category' data-id=IF" + x + " id='category-IF" + x + "' name='category[]'>" + html_data + "</select>" +
                                    "<br><select class='form-control input-type-format manufacturer' data-id=IF" + x + " id='manufacturer-IF" + x + "' name='manufacturer[]'><option value=''>Select Company</option></select><br> " +
                                    "<select class='form-control input-type-format supplyItem' data-id='IF" + x + "' id='supplyItem-IF" + x + "' name='supplyItem[]'><option value=''>Select Supply Item</option></select>" +
                                    "<br><input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='form-control input-type-format hospitalPart' data-id=IF" + x + " readonly id='hospitalPart-IF" + x + "'><br>" +
                                    "<input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='form-control input-type-format mfgPartNumber' id='mfgPartNumber-IF" + x + "' readonly data-id=IF" + x + "><br>" +
                                    // "<input class='form-control input-type-format quantity' name='quantity[]' type='text' data-id=IF" + x + " value='1'><br>" +
                                    "<select class='form-control input-type-format purchaseType' name='purchaseType[]' data-id=IF" + x + "><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'  >Consignment</option></select><br>" +
                                    "<input type='text' name='serialNumber[]' placeholder='Serial Number' class='form-control input-type-format serialNumber' data-id='IF-text" + x +"' id='serial-textIF"+x+"'>" +
                                    "<span style='display: none;' id='serial-drop-box-IF"+x+"'><select class='js-example-basic-single serialnumberdropdown' id='serial-dropIF"+x+"' data-id='IF-drop"+x+"'><option value=''>Select serial No.</option></select> </span><br>" +
                                    "<br><select name='isImplanted[]' data-id='IF" + x + "' class='form-control input-type-format implanted' ><option value='Implanted'>Implanted</option><option value='Not Implanted'>Not implanted</option></select><br> " +
//                                    "<select name='type[]' class='form-control input-type-format type' data-id='IF" + x + "'><option value='Main'>Main</option><option value='Sub'>Sub</option></select><br>" +
                                    "<select name='unusedReason[]' data-id='IF" + x + "' class='form-control input-type-format implanted-device' style='display: none;' ><option value=''>Select Reason</option><option value='Dropped'>Dropped</option><option value='Wrong Device'>Wrong Device</option><option value='Rep Error'>Rep Error</option><option value='Doctor Error'>Doctor Error</option><option value='Damaged Packaging'>Damaged Packaging</option></select>" +
                                    "<br><input type='text' name='poNumber[]' placeholder='P.O. Number' class='form-control input-type-format poNumber' data-id=IF" + x + "><br>" +
//                                    "<input type='number' name='order[]' placeholder='Order Id' class='form-control input-type-format order' data-id=IF" + x + "><br>" +
                                    "<input type='hidden' name='status[]' value='itemfile'><select class='form-control input-type-format swap' data-id=IF" + x + " id='swap-IF" + x + "' name='swap[]' style='display: none;'>" + swapoption + "</select>" +
                                    "<br><input type='checkbox' name='cco[]' value='Yes' class='form-control input-type-format cco' data-id='IF" + x +"'> CCO"+
                                    "<input type='hidden' name='cco_check[]' value='False' class='ccocheck' data-id='IF" + x + "'>"+
                                    "<br><input type='checkbox' name='repless[]' value='Yes' class='form-control input-type-format repless' data-id='IF" + x + "'> Repless"+
                                    "<input type='hidden' name='repless_check[]' value='False' class='replesscheck' data-id='IF" + x + "'>"+
                                    "<input type='hidden' name='dataid[]' value='IF" + x + "'><a href='javascript:void(0);' class='minus-icon remove_field'>Remove Item -</a></div></div>");
                                runscript();
                            }

                        });
                    } else {
                        alert('You can add maximum 4 item file');
                    }


                }
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text

            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });

        /*Manual Fields Append start*/
        var max_fields = 5; //maximum input boxes allowed
        var wrappers = $("#new-add-more-item"); //Fields wrapper
        var add_button = $(".plus-icons"); //Add button ID

        var y = 1; //initlal text box count

        $(add_button).click(function (e) { //on add input button click

            var supplyItem = $(".supplyItem[data-id=MI" + y + "]").val();
            console.log(supplyItem);
            // var fieldname = document.getElementById('fieldnames').value;

            if (supplyItem == "") {
                alert("Please enter Above Fileds!!");
            }
            else {
                e.preventDefault();

                var hospital = $("#hospital").val();
                var project = $("#project").val();
                var category = $("#category").val();
                var manufacturer = $("#manufacturer").val();
                if (y < max_fields) { //max input box allowed
                    y++;
                    $.ajax({
                        url: "{{URL::to('admin/repcasetracker/getcategory')}}",
                        data: {
                            hospital: hospital,
                            project: project,
                            category: category
                        },

                        success: function (data) {
                            var html_data = '';
                            var swapoption ='';
                            if (data.status) {
                                html_data += "<option value=''>Select Category</option>";
                                $.each(data.value, function (i, item) {

                                    html_data += "<option value='" + item.category + "'>" + item.category + "</option>";
                                });
                            } else {
                                html_data = "<option value=''>Select Category</option>";
                            }

                            swapoption += "<option value=''>Swap</option><option value='Swap In'>Swap In</option><option value='Swap Out'>Swap Out</option>";

                            $(wrappers).append("<div class='item-file-entry append-div' id='add-more-item'><div class='swapdiv' data-id='MI" + y + "'><h5 class='details-title text-left items' data-id='MI" + y + "'>Item #" + y + ":</h5><select class='form-control input-type-format category' data-id=MI" + y + " id='category-MI" + y + "' name='category[]'>" + html_data + "</select> <br><select class='form-control input-type-format manufacturer' data-id=MI" + y + " id='manufacturer-MI" + y + "' name='manufacturer[]'><option value=''>Select Company</option></select><br> <input type='text' name='supplyItem[]' placeholder='Supply Item' class='form-control input-type-format supplyItem' data-id=MI" + y + "><br><input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='form-control input-type-format hospitalPart' data-id=MI" + y + "><br><input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='form-control input-type-format mfgPartNumber' data-id=MI" + y + "><br><select class='form-control input-type-format quantity' name='quantity[]' data-id=MI" + y + "><option value=''>Quantity</option><option value='1'>1</option></select><br><select class='form-control input-type-format purchaseType' name='purchaseType[]' data-id=MI" + y + "><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select><br><input type='text' name='serialNumber[]' placeholder='Serial Number' class='form-control input-type-format serialNumber' data-id='MI-text" + y +"' id='serial-textMI" + y + "'><span style='display: none;' id='serial-drop-box-MI"+y+"'><select class='js-example-basic-single form-control input-type-format serialnumberdropdown' id='serial-dropMI"+y+"' data-id='MI-drop"+y+"'><option value=''>Select serial No.</option></select> </span><br><br><input type='text' name='poNumber[]' placeholder='P.O. Number' class='form-control input-type-format poNumber' data-id=MI" + y + "><br><input type='hidden' name='status[]' value='manual'><select class='repbox-input swaps' data-id=MI" + y + " id='swap-MI" + y + "' name='swap[]'  style='display: none;'>" + swapoption + "</select><input type='hidden' name='dataid[]' value='MI" + y + "'><a href='javascript:void(0);' class='minus-icon remove_fields'>Remove Item -</a><br></div></div>");
                            runscript();
                        }
                    });
                } else {
                    alert('You can add maximum 4 item file');
                }
            }
        });

        $(wrappers).on("click", ".remove_fields", function (e) { //user click on remove text

            e.preventDefault();
            $(this).parent('div').remove();
            y--;
        })
        /*Manual Fields Append end*/

    </script>
    <script type="text/javascript">
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

            /**/
            var newi = id[id.length -1];
            var newd =id.substring(0, 2);

            if(currentserialnumber != ''){
                if(newd == 'IF'){
                    var swapid = 'IF'+newi;
                    $('.swap[data-id='+swapid+']').show();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if(newd == 'MI'){

                    var swapid = 'MI'+newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id='+swapid+']').show();
                }

            }  else {
                if(newd == 'IF'){
                    var swapid = 'IF'+newi;
                    $('.swap[data-id='+swapid+']').hide();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if(newd == 'MI'){
                    var swapid = 'MI'+newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id='+swapid+']').hide();
                }
            }
            
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

            /**/
            var newi = id[id.length -1];
            var newd =id.substring(0, 2);

            if(currentserialnumber != ''){

                if(newd == 'IF'){
                    var swapid = 'IF'+newi;
                    $('.swap[data-id='+swapid+']').show();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if(newd == 'MI'){
                    var swapid = 'MI'+newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id='+swapid+']').show();
                }

            }  else {
                if(newd == 'IF'){
                    var swapid = 'IF'+newi;
                    $('.swap[data-id='+swapid+']').hide();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if(newd == 'MI'){
                    var swapid = 'MI'+newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id='+swapid+']').hide();
                }
            }



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
                        $('#select2-'+dropdownid+'-container').text("");

                    }

                    //  }
                }


            });
        });

        /*Quantity Validatation End*/

        /*Project name get Start*/
        $(document).on("change", "#hospital", function (event) {

            var hospital = $("#hospital").val();
//            var repuser = $("#repuser").val();

            $.ajax({
                url: "{{ URL::to('admin/repcasetracker/getproject')}}",
                data: {
                    hospital: hospital,
//                    repuser : repuser
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
        });
        /*Project name get End*/
        /*physician name get start*/

        $(document).on("change", "#project", function (event) {

            var hospital = $("#hospital").val();
            var project = $("#project").val();

            $.ajax({
                url: "{{ URL::to('admin/repcasetracker/getphysician')}}",
                data: {
                    hospital: hospital,
                    project: project
                },

                success: function (data) {
                    var html_data = '';
                    if (data.status) {
                        html_data += "<option value=''>Select Physician</option>";
                        $.each(data.value, function (i, item) {
                            if (item.doctors != '') {
                                html_data += "<option value='" + item.doctors + "' name ='" + item.doctors + "'>" + item.doctors + "</option>";
                            }

                        });
                    } else {
                        html_data = "<option value=''>Select Physician</option>";
                    }

                    $("#physician").html(html_data);

                }

            });
        });
        /*physician name get end*/

        /**
         *physician Email ID Start
         **/
        $(document).on('change','#physician',function (event) {
            var phy = "#physician";
            var physician =   $(phy + " option:selected").text();

            if (physician != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getphyemail')}}",
                    data: {
                        physician: physician,
                    },

                    success: function (data) {
                        console.log(data);
                        var html_data = '';
                        if (data.status) {
                            html_data += "<option value=''>Select Physician Email</option>";
                            $.each(data.value, function (i, item) {

                                html_data += "<option value='" + item.email + "'>" + item.email + "</option>";
                            });
                        } else {
                            html_data = "<option value=''>Select Physician Email</option>";
                        }

                        $("#physicianEmail").html(html_data);

                    }

                });
            }

        });

        /**
         *physician Email ID End
         **/


        /*category name get start*/
        $(document).on("change", "#physician", function (event) {

            var hospital = $("#hospital").val();
            var project = $("#project").val();

            if (hospital != "" && project != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getcategory')}}",
                    data: {
                        hospital: hospital,
                        project: project
                    },

                    success: function (data) {
                        var html_data = '';
                        if (data.status) {
                            html_data += "<option value=''>Select Category</option>";
                            $.each(data.value, function (i, item) {

                                html_data += "<option value='" + item.category + "'>" + item.category + "</option>";
                            });
                        } else {
                            html_data = "<option value=''>Select Category</option>";
                        }

                        $(".category").html(html_data);

                    }

                });
            }

        });
        /*category name get end*/




        /*company name get start*/
        $(document).on("change", ".category", function (event) {

            var id = $(this).attr("data-id");

            var hospital = $("#hospital").val();
            var char = "#category-" + id;
            var category = $(char).val();

            var project = $("#project").val();

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
            var hospital = $("#hospital").val();

            var char = "#category-" + id;
            var category = $(char + " option:selected").text();

            var man = "#manufacturer-" + id;
            var manufacturer = $(man + " option:selected").text();

            var project = $("#project").val();

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
                $(".implanted[data-id=" + id + "]").attr("required", "true");
                $(".type[data-id=" + id + "]").attr("required", "true");


//                $("#serial-drop" + id).attr("required", "true");
            } else {
                $(".quantity[data-id=" + id + "]").removeAttr("required");
                $(".purchaseType[data-id=" + id + "]").removeAttr("required");
                $(".serialNumber[data-id=" + id + "]").removeAttr("required");
                $("#serial-text" + id).removeAttr("required");
                $(".implanted[data-id=" + id + "]").removeAttr("required");
                $(".type[data-id=" + id + "]").removeAttr("required");

//                $("#serial-drop" + id).removeAttr("required");
            }


            var currentserialnumber = $('.serialNumber[data-id=' + id + ']').val();

            var currentsuplyitem = $(this).val();

            $('input[name^="serialNumber"]').each(function () {

                var dtid = $(this).attr('data-id');
                console.log(dtid);
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
            var hospital = $("#hospital").val();
            var physician = $("#physician").val();
            var category = $("#category").val();
            var manufacturer = $("#manufacturer").val();
            var project = $("#project").val();


            if (hospital != "" && physician != "" && category != "" && manufacturer != "" && project != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getitemfile')}}",
                    data: {
                        supplyItem: supplyItem,
                        hospital: hospital,
                        project : project,
                    },

                    success: function (data) {

                        console.log(id);
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

//                        $('.quantity[data-id=' + id +']').val('');
                        $('.purchaseType[data-id=' + id +']').val('');
                        $('#serial-text'+ id).val('');
                        $('#serial-drop' +id).val('');

                        $('#serial-drop' + id).empty();


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
                $(".quantity[data-id=" + id + "]").attr("required", "true");
                $(".purchaseType[data-id=" + id + "]").attr("required", "true");
                $(".serialNumber[data-id=" + id + "]").attr("required", "true");
                $("#serial-text" + id).attr("required", "true");
                $(".implanted[data-id=" + id + "]").attr("required", "true");
                $(".type[data-id=" + id + "]").attr("required", "true");
//                $("#serial-drop" + id).attr("required", "true");
            } else {
                $(".quantity[data-id=" + id + "]").removeAttr("required");
                $(".purchaseType[data-id=" + id + "]").removeAttr("required");
                $(".serialNumber[data-id=" + id + "]").removeAttr("required");
                $("#serial-text" + id).removeAttr("required");
                $(".implanted[data-id=" + id + "]").removeAttr("required");
                $(".type[data-id=" + id + "]").removeAttr("required");
//                $("#serial-drop" + id).removeAttr("required");
            }
        });

        $(document).on('change', '.supplyItem', function (event) {
            var timer, delay = 1000;
            var id = $(this).attr("data-id");
            var client = $("#hospital").val();

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

            var client = $("#hospital").val();
            var supplyItem = $(".supplyItem[data-id=" + id + "]").val();
            var mfgPartNumber = $(".mfgPartNumber[data-id=" + id + "]").val();


//var html_data='';
            if (value == 'Bulk') {
                $('#serial-text'+id).removeAttr('name');
                $('#serial-drop'+id).attr('name','serialNumber[]');

                $('#serial-text'+id).removeClass('sf');
                $('#serial-drop'+id).addClass('sf');

                $('#serial-text'+id).hide();
                $('#serial-drop-box-'+id).show();
                $('#serial-drop' +id).val('');
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

                                $("#serial-drop"+id).append("<option value='"+item.serialNumber+"'>"+item.serialNumber+"</option>");
                            });

                        }
                    }


                });
            } else {


                $('#serial-text'+id).attr('name','serialNumber[]');
                $('#serial-drop'+id).removeAttr('name');

                $('#serial-text'+id).addClass('sf');
                $('#serial-drop'+id).removeClass('sf');

                $('#serial-text'+id).show();
                $('#serial-drop-box-'+id).hide();
                $('#serial-text'+ id).val('');
                $("#serial-drop" + id).removeAttr("required");
                $("#serial-text" + id).attr("required", "true");

            }


        });

        $(document).on('change', '.swap', function (event) {

            var id = $(this).attr("data-id");
            //solved by keval
            // alert('hi'); 
            var value = $(this).val();
            var items = $(".items[data-id=" + id + "]").text();
            var purchasedata = $("#purchasetype-" + id).val();
            var serialnumberdata = $('#serial-drop' + id).val();

            if (value != '') {

                if (purchasedata == "Bulk") {
                // alert(serialnumberdata);
                    $.ajax({
                        url: "{{URL::to('admin/repcasetracker/getdiscount')}}",
                        data: {
                            serialnumber: serialnumberdata,
                            value: value,
                        },
                        dataType: "json",

                        success: function (data) {
                            console.log(data.value.discount);
                            $('#price-' + id).val(data.value.total);
                            $('#discount-' + id).val(data.value.discount);
                        }
                    });
                }

                var hospital = $("#hospital").val();
                var project = $("#project").val();
                var category = $("#category").val();
                var manufacturer = $("#manufacturer").val();

                $.ajax({
                    url: "{{URL::to('admin/repcasetracker/getcategory')}}",
                    data: {
                        hospital: hospital,
                        project: project,
                        category: category
                    },

                    success: function (data) {
                        var html_data = '';
                        var swapoption = '';
                        var swapoptions = '';
                        if (data.status) {
                            html_data += "<option value=''>Select Category</option>";
                            $.each(data.value, function (i, item) {

                                html_data += "<option value='" + item.category + "'>" + item.category + "</option>";
                            });
                        } else {
                            html_data = "<option value=''>Select Category</option>";
                        }

                        if (value == "Swap In") {
                            swapoption += "<option value=''>Swap</option><option value='Swap Out' selected>Swap Out</option>";
                        } else if (value == 'Swap Out') {
                            swapoption += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option>";
                        }
                        // $(".supplyItem").html(html_data);

                        $(".swapdiv[data-id=" + id + "]").append("<div class='item-file-entry append-div'>" +
                            "<h5 class='details-title text-left items' data-id='S"+ id + "'> "+ items + "</h5><br>" +
                            "<select class='form-control input-type-format category' data-id=S" + id + " id='category-S" + id + "' name='category[]'>" + html_data + "</select> " +
                            "<br><select class='form-control input-type-format manufacturer' data-id=S" + id + " id='manufacturer-S" + id + "' name='manufacturer[]'><option value=''>Select Comapny</option></select><br>" +
                            "<select class='form-control input-type-format supplyItem' data-id=S" + id + " id='supplyItem-S" + id + "' name='supplyItem[]'><option value=''>Select Supply Item</option></select><br>" +
                            "<input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='form-control input-type-format hospitalPart' data-id=S" + id + "><br>" +
                            "<input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='form-control input-type-format mfgPartNumber' data-id=S" + id + "><br>" +
                            "<select class='form-control input-type-format quantity' name='quantity[]' data-id=S" + id + "><option value=''>Quantity</option><option value='1'>1</option></select><br>" +
                            "<select class='form-control input-type-format purchaseType' name='purchaseType[]' data-id=S" + id + " id = 'purchasetype-S" + id + "' ><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select><br>" +
                            "<input type='text' name='serialNumber[]' placeholder='Serial Number' class='form-control input-type-format serialNumber' data-id=S-text" + id + " id='serial-textS" + id + "'>" +
                            "<span style='display: none;' id='serial-drop-box-S" + id + "'> " +
                            "<select class='js-example-basic-single repbox-input serialnumberdropdown' id='serial-dropS" + id + "' data-id='S-drop" + id + "'><option value=''>Select serial No.</option></select> </span>" +
                            "<br><select name='isImplanted[]' data-id='IF" + x + "' class='form-control input-type-format implanted' ><option value='yes'>implanted</option><option value='no'>Not implanted</option></select><br> " +
//                                    "<select name='type[]' class='form-control input-type-format type' data-id='IF" + x + "'><option value='Main'>Main</option><option value='Sub'>Sub</option></select><br>" +
                            "<select name='unusedReason[]' data-id='IF" + x + "' class='form-control input-type-format implanted-device' style='display: none;' ><option value=''>Select Reason</option><option value='Dropped'>Dropped</option><option value='Wrong Device'>Wrong Device</option><option value='Rep Error'>Rep Error</option><option value='Doctor Error'>Doctor Error</option><option value='Damaged Packaging'>Damaged Packaging</option></select>" +
                            "<input type='text' name='poNumber[]' placeholder='P.O. Number' class='form-control input-type-format poNumber' data-id=S" + id + "><br>" +
                            "<input type='hidden' name='status[]' value='itemfile'>" +
                            "<select class='form-control input-type-format swap' data-id=S" + id + " id='swap-S" + id + "' name='swap[]'>" + swapoption + "</select>" +
                            "<input type='hidden' name='status[]' value='itemfile'><select class='form-control input-type-format swap' data-id=IF" + x + " id='swap-IF" + x + "' name='swap[]' style='display: none;'>" + swapoption + "</select>" +
                            "<br><input type='checkbox' name='cco[]' value='Yes' class='form-control input-type-format cco' data-id='S" + id + "'> CCO"+
                            "<input type='hidden' name='cco_check[]' value='False' class='ccocheck' data-id='S" + id + "'>"+
                            "<br><input type='checkbox' name='repless[]' value='Yes' class='form-control input-type-format repless' data-id='S" + id + "'> Repless"+
                            "<input type='hidden' name='repless_check[]' value='False' class='replesscheck' data-id='S" + id + "'>"+
                            "<input type='hidden' name='discount[]' value='' class='discount' id='discount-'S" + id + "' data-id='S" + id + "'>" +
                            "<input type='hidden' name='price[]' value='' class='price' id='price-S'" + id + "' data-id='S" + id + "'>" +
                            "<input type='hidden' name='dataid[]' value='" + id + "'></div>");
                        runscript();

                        if (value == "Swap In") {
                            swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option>";
                        } else if (value == 'Swap Out') {
                            swapoptions += "<option value=''>Swap</option><option value='Swap Out' selected>Swap Out</option>";
                        }

                        $(".swap[data-id=" + id + "]").html(swapoptions);
                        $(".swap[data-id=" + id + "]").removeClass("swap");
                    }
                });

            }
            else {
//                e.preventDefault();
                var x = id;
                var st = x.charAt(0);
                var ids = id.slice(1);
                var swapoptions = '';

                if (st == 'S') {
                    var values = $("#swap-" + ids).val();

                    if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option><option value='Swap Out'>Swap Out</option>";
                    }else  if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }

                    $("#swap-"+ids).addClass("swap");
                    $(".swap[data-id=" + ids + "]").html(swapoptions);

                } else if (st == 'I') {
                    var values = $("#swap-" + id).val();

                    if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option><option value='Swap Out'>Swap Out</option>";
                    }else  if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }
                    $("#swap-"+ids).addClass("swap");
                    $(".swap[data-id=" + id + "]").html(swapoptions);
                }
                $(this).parent('div').remove();
            }
        });

        $(document).on('change', '.swaps', function (event) {

            var id = $(this).attr("data-id");

            var value = $(this).val();
            var items = $(".items[data-id=" + id + "]").text();
            var purchasedata = $("#purchasetype-" + id).val();
            var serialnumberdata = $('#serial-drop' + id).val();

            if (value != '') {

                if (purchasedata == "Bulk") {
//                    alert(serialnumberdata);
                    $.ajax({
                        url: "{{URL::to('admin/repcasetracker/getdiscount')}}",
                        data: {
                            serialnumber: serialnumberdata,
                            value: value,
                        },
                        dataType: "json",

                        success: function (data) {
                            console.log(data.value.discount);
                            $('#price-' + id).val(data.value.total);
                            $('#discount-' + id).val(data.value.discount);
                        }
                    });
                }

                var hospital = $("#hospital").val();
                var project = $("#project").val();
                var category = $("#category").val();
                var manufacturer = $("#manufacturer").val();

                $.ajax({
                    url: "{{URL::to('admin/repcasetracker/getcategory')}}",
                    data: {
                        hospital: hospital,
                        project: project,
                        category: category
                    },

                    success: function (data) {
                        var html_data = '';
                        var swapoption = '';
                        if (data.status) {
                            html_data += "<option value=''>Select Category</option>";
                            $.each(data.value, function (i, item) {

                                html_data += "<option value='" + item.category + "'>" + item.category + "</option>";
                            });
                        } else {
                            html_data = "<option value=''>Select Category</option>";
                        }

                        if (value == "Swap In") {
                            swapoption += "<option value=''>Swap</option><option value='Swap Out' selected>Swap Out</option>";
                        } else if (value == 'Swap Out') {
                            swapoption += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option>";
                        }
                        // $(".supplyItem").html(html_data);
                        $(".swapdiv[data-id=" + id + "]").append("<div class='item-file-entry append-div'><br>" +
                            "<h5 class='details-title text-left items' data-id='S"+ id + "'> "+ items + "</h5><br>" +
                            "<select class='form-control input-type-format category' data-id=S" + id + " id='category-S" + id + "' name='category[]'>" + html_data + "</select> <br>" +
                            "<select class='form-control input-type-format manufacturer' data-id=S" + id + " id='manufacturer-S" + id + "' name='manufacturer[]'><option value=''>Select Comapny</option></select><br>  " +
                            "<input type='text' name='supplyItem[]' placeholder='Supply Item' class='form-control input-type-format supplyItem'  data-id=S" + id + "><br>" +
                            "<input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='form-control input-type-format hospitalPart' data-id=S" + id + "><br>" +
                            "<input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='form-control input-type-format mfgPartNumber' data-id=S" + id + "><br>" +
                            "<input class='form-control input-type-format quantity' name='quantity[]' type='text' value='1' readonly data-id=S" + id + "><br>" +
                            "<select class='form-control input-type-format purchaseType' name='purchaseType[]' data-id=S" + id + " id = 'purchasetype-S" + id + "' ><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select><br>" +
                            "<input type='text' name='serialNumber[]' placeholder='Serial Number' class='form-control input-type-format serialNumber' data-id=S-text" + id + " id='serial-textS" + id + "'>" +
                            "<span style='display: none;' id='serial-drop-box-S" + id + "'> <select class='js-example-basic-single repbox-input serialnumberdropdown' id='serial-dropS" + id + "' data-id='S-drop" + id + "'><option value=''>Select serial No.</option></select> </span><br>" +
                            "<input type='text' name='poNumber[]' placeholder='P.O. Number' class='form-control input-type-format poNumber' data-id=S" + id + "><br>" +
                            "<input type='hidden' name='status[]' value='itemfile'>" +
                            "<select class='form-control input-type-format swaps' data-id=S" + id + " id='swap-S" + id + "' name='swap[]'>" + swapoption + "</select>" +
                            "<input type='hidden' name='discount[]' value='' class='discount' id='discount-'S" + id + "' data-id='S" + id + "'>" +
                            "<input type='hidden' name='price[]' value='' class='price' id='price-S'" + id + "' data-id='S" + id + "'>" +
                            "<input type='hidden' name='dataid[]' value='" + id + "'></div>");
                        runscript();

                        $(".swaps[data-id=" + id + "]").removeClass("swaps");
                    }
                });

            }
            else {

                var x = id;
                var st = x.charAt(0);
                var ids = id.slice(1);
                var swapoptions = '';

                if (st == 'S') {
                    var values = $("#swap-" + ids).val();
                    if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option><option value='Swap Out'>Swap Out</option>";
                    }else  if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }

                    $("#swap-"+ids).addClass("swaps");
                    $(".swaps[data-id=" + ids + "]").html(swapoptions);

                } else if (st == 'I') {
                    var values = $("#swap-" + id).val();

                    if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option><option value='Swap Out'>Swap Out</option>";
                    }else  if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }
                    $("#swap-"+ids).addClass("swapss");
                    $(".swaps[data-id=" + id + "]").html(swapoptions);
                }
                $(this).parent('div').remove();
            }


        });

        /**
         *implanted on change append or remove dropdown
         */
        $(document).on('change', '.implanted', function (event) {
            var id = $(this).attr("data-id");
            var value = $(this).val();

            if (value == 'no') {

                $(".implanted-device[data-id=" + id + "]").show();
                $(".implanted-device[data-id=" + id + "]").attr("required", "true");
            } else {
                $(".implanted-device[data-id=" + id + "]").hide();
                $(".implanted-device[data-id=" + id + "]").removeAttr("required");
            }
        });

        /**
         * Check Box Values
         */
        $(document).on('click','.cco',function (event) {
            var id = $(this).attr('data-id');

            if( $(".cco[data-id=" + id + "]").is(':checked')) {
                $(".ccocheck[data-id=" + id + "]").val('True');

            } else {
                $(".ccocheck[data-id=" + id + "]").val('False');

            }
        });
        $(document).on('click','.repless',function (event) {
            var id = $(this).attr('data-id');

            if( $(".repless[data-id=" + id + "]").is(':checked')) {
                $(".replesscheck[data-id=" + id + "]").val('True');

            } else {
                $(".replesscheck[data-id=" + id + "]").val('False');

            }
        });




    </script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/black-tie/jquery-ui.css"
          media="screen"/>
@endsection