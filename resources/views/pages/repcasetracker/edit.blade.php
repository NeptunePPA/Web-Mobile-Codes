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
                                {{ Form::open(array('url' => 'admin/repcasetracker/update/'.$itemMain['id'],'method'=>'POST','files'=>true)) }}
                                <div class="modal-body clearfix">
                                    <a href="{{ URL::to('admin/repcasetracker') }}" class="pull-right">X</a>
                                    <h3 align="center">Edit RepCase Details</h3>

                                    <div class="modal-border clearfix">
                                        <div class="modal-box" align="center">
                                            <div class="input1">

                                                {{ Form::text('repcaseID',$itemMain['repcaseID'],array('placeholder'=>'Case Id','readonly'=>'true')) }}
                                            </div>
                                            <label>Procedure Date:</label>
                                            <div class="input1">
                                                {!! Form::text('procedure_date',Carbon\Carbon::parse($itemMain['produceDate'])->format('m-d-Y'), array('id' => 'datepicker','placeholder'=>'03-06-2017')) !!}
                                            </div>
                                            <div class="input1">
                                                {{ Form::select('hospital',$clients,$itemMain['clientId'], array('id'=>'hospital')) }}
                                                {{Form::hidden('client',$itemMain['clientId'],array('id'=>'client'))}}
                                            </div>

                                            <div class="input1">
                                                {{ Form::select('project',$project,$itemMain['projectId'], array('id'=>'project')) }}
                                                {{Form::hidden('projectId',$itemMain['projectId'],array('id'=>'projectId'))}}
                                            </div>

                                            <div class="input1">
                                                {{ Form::select('physician',$physician,$itemMain['physician'],array('id'=>'physician')) }}
                                            </div>

                                            <div class="input1">
                                                {{ Form::select('phyEmail',$phyEmail,$itemMain['phyEmail'],array('id'=>'physicianEmail','required'=>'true')) }}
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="modal-box" align="center"><label>Item File Entry</label></div>
                                        <div style="display: none;">{{$i=1}}</div>
                                        <div style="display: none;">{{$j=1}}</div>
                                        <div style="display: none;">{{$datas=''}}</div>
                                        @foreach($itemdetails as $row)
                                            @if($row->status == 'itemfile' && $row->swapDate == NULL)
                                                @if($datas == $row->dataId)

                                                    <div class="input1 item-input append-div item swapdiv" data-id="ED{{$row->id}}">
                                                        <label>Item #{{$j}}:</label>

                                                        {{ Form::select('category[]',$category,$row['category'],array('class'=>'repbox-input category','id'=>'category-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}

                                                        <select name="manufacturer[]" class='repbox-input manufacturer'
                                                                id='manufacturer-ED{{$row->id}}'
                                                                data-id='ED{{$row->id}}'>
                                                            <option value="">Select Manufacture</option>
                                                            <option value="{{$row['manufacturer']}}"
                                                                    selected>{{$row['manufacturer']}}</option>
                                                        </select>

                                                        <select name="supplyItem[]"
                                                                class='repbox-input supplyItem'
                                                                id='supplyItem-ED{{$row->id}}' data-id='ED{{$row->id}}'>
                                                            <option value="">Select Supply Item</option>
                                                            <option value="{{$row['supplyItem']}}"
                                                                    selected>{{$row['supplyItem']}}</option>
                                                        </select>

                                                        {{ Form::text('hospitalPart[]',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','data-id'=>'ED'.$row->id,'id'=>'hospitalPart-ED'.$row->id,'readonly'=>'true'))}}

                                                        {{ Form::text('mfgPartNumber[]',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber','data-id'=>'ED'.$row->id,'readonly'=>'true'))}}

{{--                                                        {{ Form::text('quantity[]',$row['quantity'],array('class'=>'repbox-input quantity','data-id'=>'ED'.$row->id,'readonly'=>'true')) }}--}}

                                                        {{ Form::select('purchaseType[]',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),$row['purchaseType'],array('class'=>'repbox-input purchaseType','data-id'=>'ED'.$row->id,'required'=>'true')) }}

                                                        {{ Form::text('',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber','data-id'=>'ED-text'.$row->id,'id'=>'serial-textED'.$row->id,))}}

                                                        <span id="serial-drop-box-ED{{$row->id}}"
                                                              style="display: none;">
                                                        {{ Form::select('',array(''=>'Select serial no.'),$row['serialNumber'],array('class'=>'js-example-basic-single repbox-input serialnumberdropdown','id'=>'serial-dropED'.$row->id,'data-id'=>'ED-drop'.$row->id)) }}
                                                    </span>
                                                        {{ Form::select('isImplanted[]',array('Implanted'=>'Implanted','Not Implanted'=>'Not Implanted'),$row['isImplanted'],array('class'=>'repbox-input implanted','data-id'=>'ED'.$row->id)) }}

                                                        {{--                                                        {{ Form::select('type[]',array('Main'=>'Main','Sub'=>'Sub'),$row['type'],array('class'=>'repbox-input type','data-id'=>'ED'.$row->id)) }}--}}

                                                        @if($row->unusedReason != "")
                                                            {{ Form::select('unusedReason[]',array(''=>'Select Reason','Dropped'=>'Dropped','Wrong Device'=>'Wrong Device','Rep Error' => 'Rep Error','Doctor Error' => 'Doctor Error','Damaged Packaging' => 'Damaged Packaging'),$row['unusedReason'],array('class'=>'repbox-input implanted-device','style'=>'display:inline-block','data-id'=>'ED'.$row->id)) }}
                                                        @else
                                                            {{ Form::select('unusedReason[]',array(''=>'Select Reason','Dropped'=>'Dropped','Wrong Device'=>'Wrong Device','Rep Error' => 'Rep Error','Doctor Error' => 'Doctor Error','Damaged Packaging' => 'Damaged Packaging'),'',array('class'=>'repbox-input implanted-device','style'=>'display:none','data-id'=>'ED'.$row->id)) }}
                                                        @endif

                                                        {{ Form::text('poNumber[]',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','data-id'=>'ED'.$row->id))}}

                                                        {{--                                                        {{ Form::number('order[]',$row['orderId'],array('placeholder'=>'Order Id','class'=>'repbox-input order','data-id'=>'ED'.$row->id))}}--}}

                                                        @if($row->swapType == "Swap Out")
                                                            {{ Form::select('swap[]',array(''=>'Swap','Swap Out'=>'Swap Out'),$row->swapType,array('class'=>'repbox-input swap','id'=>'swap-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}
                                                        @elseif($row->swapType == "Swap In")
                                                            {{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In'),$row->swapType,array('class'=>'repbox-input swap','id'=>'swap-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}
                                                        @else
                                                            {{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In','Swap Out'=>'Swap Out'),$row->swapType,array('class'=>'repbox-input swap','id'=>'swap-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}
                                                        @endif

                                                        {{Form::checkbox('cco[]', 'True',$row->cco_check =='True' ? true : '', array('class' => 'custom-control-input  cco' ,'data-id'=>'ED'.$row->id))}} CCO

                                                        {{Form::hidden('cco_check[]',$row->cco_check =='True' ? 'True' : 'False',array('class'=>'ccocheck','data-id'=>'ED'.$row->id))}}

                                                        {{Form::checkbox('repless[]', 'True',$row->repless_check =='True' ? true : '', array('class' => 'custom-control-input repless' ,'data-id'=>'ED'.$row->id))}} Repless

                                                        {{Form::hidden('repless_check[]',$row->repless_check =='True' ? 'True' : 'False',array('class'=>'replesscheck','data-id'=>'ED'.$row->id))}}

                                                        {{Form::hidden('status[]','itemfile')}}
                                                        {{Form::hidden('dataid[]','E'.$row->dataId)}}
                                                        {{Form::hidden('oldId[]',$row['id'])}}
                                                        {{Form::hidden('oldPurchaseType[]',$row['purchaseType'])}}
                                                        {{Form::hidden('oldswapDate[]',$row['newSwapDate'])}}
                                                        {{Form::hidden('swapId[]',$row['swapId'])}}
                                                        {{Form::hidden('completeNew[]',$row['completeNew'])}}
                                                        {{Form::hidden('supply',$row['supplyItem'],array('class'=>'repbox-input supply','readonly'=>'true','id'=>'supply-ED'.$row->id,'data-id'=>'ED'.$row->id))}}
                                                        {{Form::hidden('manuf',$row['manufacturer'],array('class'=>'repbox-input manuf','readonly'=>'true','id'=>'manuf-ED'.$row->id,'data-id'=>'ED'.$row->id))}}
                                                        {{Form::hidden('manufpart',$row['mfgPartNumber'],array('class'=>'repbox-input manufpart','readonly'=>'true','id'=>'manufpart-ED'.$row->id,'data-id'=>'ED'.$row->id))}}

                                                        {{Form::hidden('purch',$row['purchaseType'],array('class'=>'repbox-input purch','readonly'=>'true','id'=>'purch-ED'.$row->id,'data-id'=>'ED'.$row->id))}}
                                                        {{Form::hidden('swapDate',$row['swapDate'])}}
                                                        {{Form::hidden('serial',$row['serialNumber'],array('id'=>'serialNumber-ED'.$row->id))}}
                                                        {{--<a href="javascript:void(0);"--}}
                                                        {{--class='minus-icon remove_field'><img--}}
                                                        {{--src="../../../images/minus.jpg"/></a>--}}
                                                    </div>
                                                @else
                                                    <div class="input1 item-input append-div item swapdiv" data-id="ED{{$row->id}}">
                                                        <label>Item #{{$i}}:</label>

                                                        {{ Form::select('category[]',$category,$row['category'],array('class'=>'repbox-input category','id'=>'category-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}

                                                        <select name="manufacturer[]" class='repbox-input manufacturer'
                                                                id='manufacturer-ED{{$row->id}}'
                                                                data-id='ED{{$row->id}}'>
                                                            <option value="">Select Manufacture</option>
                                                            <option value="{{$row['manufacturer']}}"
                                                                    selected>{{$row['manufacturer']}}</option>
                                                        </select>

                                                        <select name="supplyItem[]"
                                                                class='repbox-input supplyItem'
                                                                id='supplyItem-ED{{$row->id}}' data-id='ED{{$row->id}}'>
                                                            <option value="">Select Supply Item</option>
                                                            <option value="{{$row['supplyItem']}}"
                                                                    selected>{{$row['supplyItem']}}</option>
                                                        </select>

                                                        {{ Form::text('hospitalPart[]',$row['hospitalPart'],array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','data-id'=>'ED'.$row->id,'id'=>'hospitalPart-ED'.$row->id,'readonly'=>'true'))}}

                                                        {{ Form::text('mfgPartNumber[]',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber','data-id'=>'ED'.$row->id,'readonly'=>'true'))}}

{{--                                                        {{ Form::text('quantity[]',$row['quantity'],array('class'=>'repbox-input quantity','data-id'=>'ED'.$row->id,'readonly'=>'true')) }}--}}

                                                        {{ Form::select('purchaseType[]',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),$row['purchaseType'],array('class'=>'repbox-input purchaseType','data-id'=>'ED'.$row->id,'required'=>'true')) }}

                                                        {{ Form::text('',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber','data-id'=>'ED-text'.$row->id,'id'=>'serial-textED'.$row->id,))}}

                                                        <span id="serial-drop-box-ED{{$row->id}}"
                                                              style="display: none;">
                                                        {{ Form::select('',array(''=>'Select serial no.'),$row['serialNumber'],array('class'=>'js-example-basic-single repbox-input serialnumberdropdown','id'=>'serial-dropED'.$row->id,'data-id'=>'ED-drop'.$row->id)) }}
                                                    </span>
                                                        {{ Form::select('isImplanted[]',array('Implanted'=>'Implanted','Not Implanted'=>'Not Implanted'),$row['isImplanted'],array('class'=>'repbox-input implanted','data-id'=>'ED'.$row->id)) }}

                                                        {{--                                                        {{ Form::select('type[]',array('Main'=>'Main','Sub'=>'Sub'),$row['type'],array('class'=>'repbox-input type','data-id'=>'ED'.$row->id)) }}--}}
                                                        @if($row->unusedReason != "")
                                                            {{ Form::select('unusedReason[]',array(''=>'Select Reason','Dropped'=>'Dropped','Wrong Device'=>'Wrong Device','Rep Error' => 'Rep Error','Doctor Error' => 'Doctor Error','Damaged Packaging' => 'Damaged Packaging'),$row['unusedReason'],array('class'=>'repbox-input implanted-device','style'=>'display:inline-block','data-id'=>'ED'.$row->id)) }}
                                                        @else
                                                            {{ Form::select('unusedReason[]',array(''=>'Select Reason','Dropped'=>'Dropped','Wrong Device'=>'Wrong Device','Rep Error' => 'Rep Error','Doctor Error' => 'Doctor Error','Damaged Packaging' => 'Damaged Packaging'),'',array('class'=>'repbox-input implanted-device','style'=>'display:none','data-id'=>'ED'.$row->id)) }}
                                                        @endif
                                                        {{ Form::text('poNumber[]',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','data-id'=>'ED'.$row->id))}}

                                                        {{--                                                        {{ Form::number('order[]',$row['orderId'],array('placeholder'=>'Order Id','class'=>'repbox-input order','data-id'=>'ED'.$row->id))}}--}}

                                                        @if($row->swapType == "Swap Out")
                                                            {{ Form::select('swap[]',array(''=>'Swap','Swap Out'=>'Swap Out'),$row->swapType,array('class'=>'repbox-input swap','id'=>'swap-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}
                                                        @elseif($row->swapType == "Swap In")
                                                            {{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In'),$row->swapType,array('class'=>'repbox-input swap','id'=>'swap-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}
                                                        @else
                                                            {{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In','Swap Out'=>'Swap Out'),$row->swapType,array('class'=>'repbox-input swap','id'=>'swap-ED'.$row->id,'data-id'=>'ED'.$row->id)) }}
                                                        @endif

                                                        {{Form::checkbox('cco[]', 'True',$row->cco_check =='True' ? true : '', array('class' => 'custom-control-input  cco' ,'data-id'=>'ED'.$row->id))}} CCO

                                                        {{Form::hidden('cco_check[]',$row->cco_check =='True' ? 'True' : 'False',array('class'=>'ccocheck','data-id'=>'ED'.$row->id))}}

                                                        {{Form::checkbox('repless[]', 'True',$row->repless_check =='True' ? true : '', array('class' => 'custom-control-input repless' ,'data-id'=>'ED'.$row->id))}} Repless

                                                        {{Form::hidden('repless_check[]',$row->repless_check =='True' ? 'True' : 'False',array('class'=>'replesscheck','data-id'=>'ED'.$row->id))}}

                                                        {{Form::hidden('status[]','itemfile')}}
                                                        {{Form::hidden('dataid[]','E'.$row->dataId)}}
                                                        {{Form::hidden('oldId[]',$row['id'])}}
                                                        {{Form::hidden('oldPurchaseType[]',$row['purchaseType'])}}
                                                        {{Form::hidden('oldswapDate[]',$row['newSwapDate'])}}
                                                        {{Form::hidden('swapId[]',$row['swapId'])}}
                                                        {{Form::hidden('completeNew[]',$row['completeNew'])}}
                                                        {{Form::hidden('supply',$row['supplyItem'],array('class'=>'repbox-input supply','readonly'=>'true','id'=>'supply-ED'.$row->id,'data-id'=>'ED'.$row->id))}}
                                                        {{Form::hidden('manuf',$row['manufacturer'],array('class'=>'repbox-input manuf','readonly'=>'true','id'=>'manuf-ED'.$row->id,'data-id'=>'ED'.$row->id))}}
                                                        {{Form::hidden('manufpart',$row['mfgPartNumber'],array('class'=>'repbox-input manufpart','readonly'=>'true','id'=>'manufpart-ED'.$row->id,'data-id'=>'ED'.$row->id))}}

                                                        {{Form::hidden('purch',$row['purchaseType'],array('class'=>'repbox-input purch','readonly'=>'true','id'=>'purch-ED'.$row->id,'data-id'=>'ED'.$row->id))}}
                                                        {{Form::hidden('swapDate',$row['swapDate'])}}
                                                        {{Form::hidden('serial',$row['serialNumber'],array('id'=>'serialNumber-ED'.$row->id))}}
                                                        <a href="javascript:void(0);"
                                                           class='minus-icon remove_field'><img
                                                                    src="../../../images/minus.jpg"/></a>
                                                    </div>
                                                @endif
                                            @elseif(!empty($row->swapDate) && $row->status == 'itemfile')
                                                <div class="input1 item-input item swapData">
                                                    <label style="color: red">Swap</label>

                                                    {{ Form::text('categoryold',$row['category'],array('class'=>'repbox-input','readonly'=>'true')) }}

                                                    {{ Form::text('manufacturerold',$row['manufacturer'],array('class'=>'repbox-input','readonly'=>'true')) }}

                                                    {{ Form::text('supplyItemold',$row['supplyItem'],array('class'=>'repbox-input','readonly'=>'true')) }}

                                                    {{ Form::text('hospitalPartold',$row['hospitalPart'],array('class'=>'repbox-input','placeholder'=>'Hospital Part #','readonly'=>'true'))}}

                                                    {{ Form::text('mfgPartNumberold',$row['mfgPartNumber'],array('placeholder'=>'Manuf Part #','class'=>'repbox-input','readonly'=>'true'))}}

{{--                                                    {{ Form::text('quantityold',$row['quantity'],array('class'=>'repbox-input','readonly'=>'true')) }}--}}

                                                    {{ Form::text('purchaseTypeold',$row['purchaseType'],array('class'=>'repbox-input','readonly'=>'true')) }}

                                                    {{ Form::text('serialNumberold',$row['serialNumber'],array('placeholder'=>'Serial Number','class'=>'repbox-input','readonly'=>'true'))}}

                                                    {{ Form::text('isImplantedold',$row['isImplanted'],array('placeholder'=>'Is Implanted','class'=>'repbox-input','readonly'=>'true'))}}

                                                    {{--                                                    {{ Form::text('typeold',$row['type'],array('placeholder'=>'Type','class'=>'repbox-input','readonly'=>'true'))}}--}}
                                                    @if($row->unusedReason != "")
                                                        {{ Form::text('unusedReasonold',$row['unusedReason'],array('placeholder'=>'Unused Reason','class'=>'repbox-input','readonly'=>'true'))}}
                                                    @else
                                                        {{ Form::text('unusedReasonold',$row['unusedReason'],array('placeholder'=>'Unused Reason','style'=>'display:none','class'=>'repbox-input','readonly'=>'true'))}}
                                                    @endif
                                                    {{ Form::text('poNumberold',$row['poNumber'],array('placeholder'=>'P.O. Number','class'=>'repbox-input','readonly'=>'true'))}}

                                                    {{--                                                    {{ Form::text('orderIdold',$row['orderId'],array('placeholder'=>'Order Id','class'=>'repbox-input','readonly'=>'true'))}}--}}

                                                    {{ Form::text('swaptypeold',$row['swapType'],array('placeholder'=>'Swap Type','class'=>'repbox-input','readonly'=>'true'))}}
                                                </div>
                                            @endif

                                            <div style="display: none;">{{$j=$i}}</div>
                                            <div style="display: none;">{{$i++}}</div>
                                            <div style="display: none;">{{$datas=$row['dataId']}}</div>

                                        @endforeach
                                        <div class="input1 item-input" id="add-more" data-id="IF0">
                                            <!-- <div> -->
                                            <div class="swapdiv" data-id="IF0">
                                                <label class="items" data-id="IF0">Item #{{$i}}:</label>

                                                {{ Form::select('category[]',$category,'',array('class'=>'repbox-input category','id'=>'category-IF0','data-id'=>'IF0')) }}

                                                {{ Form::select('manufacturer[]',$company,'',array('class'=>'repbox-input manufacturer','id'=>'manufacturer-IF0','data-id'=>'IF0')) }}

                                                {{ Form::select('supplyItem[]',array('' => 'Supply Item'),'',array('class'=>'repbox-input supplyItem','id'=>'supplyItem-IF0','data-id'=>'IF0')) }}

                                                {{ Form::text('hospitalPart[]',null,array('class'=>'repbox-input hospitalPart','placeholder'=>'Hospital Part #','data-id'=>'IF0','id'=>'hospitalPart-IF0','readonly'=>'true'))}}

                                                {{ Form::text('mfgPartNumber[]',null,array('placeholder'=>'Manuf Part #','class'=>'repbox-input mfgPartNumber','data-id'=>'IF0','readonly'=>'true'))}}

{{--                                                {{ Form::text('quantity[]','1',array('class'=>'repbox-input quantity','data-id'=>'IF0','readonly'=>'true')) }}--}}

                                                {{ Form::select('purchaseType[]',array('' => 'Purchase Type','Bulk'=>'Bulk','Consignment'=>'Consignment'),'',array('class'=>'repbox-input purchaseType','data-id'=>'IF0')) }}

                                                {{ Form::text('serialNumber[]',null,array('placeholder'=>'Serial Number','class'=>'repbox-input serialNumber','data-id'=>'IF-text0','id'=>'serial-textIF0',))}}

                                                <span id="serial-drop-box-IF0" style="display: none;">
                                            {{ Form::select('',array(''=>'Select serial no.'),'',array('class'=>'js-example-basic-single repbox-input serialnumberdropdown','id'=>'serial-dropIF0','data-id'=>'IF-drop0')) }}
                                            </span>

                                                {{ Form::select('isImplanted[]',array('Implanted'=>'Implanted','Not Implanted'=>'Not Implanted'),'',array('class'=>'repbox-input implanted','data-id'=>'IF0')) }}

                                                {{--                                                {{ Form::select('type[]',array('Main'=>'Main','Sub'=>'Sub'),'',array('class'=>'repbox-input type','data-id'=>'IF0')) }}--}}

                                                {{ Form::select('unusedReason[]',array(''=>'Select Reason','Dropped'=>'Dropped','Wrong Device'=>'Wrong Device','Rep Error' => 'Rep Error','Doctor Error' => 'Doctor Error','Damaged Packaging' => 'Damaged Packaging'),'',array('class'=>'repbox-input implanted-device','style'=>'display:none','data-id'=>'IF0')) }}

                                                {{ Form::text('poNumber[]',null,array('placeholder'=>'P.O. Number','class'=>'repbox-input poNumber','data-id'=>'IF0'))}}

                                                {{--                                                {{ Form::number('order[]',null,array('placeholder'=>'Order Id','class'=>'repbox-input order','data-id'=>'IF0'))}}--}}

                                                {{ Form::select('swap[]',array(''=>'Swap','Swap In'=>'Swap In','Swap Out'=>'Swap Out'),'',array('class'=>'repbox-input swap','id'=>'swap-IF0','data-id'=>'IF0')) }}

                                                {{Form::checkbox('cco[]', 'True','', array('class' => 'custom-control-input  cco' ,'data-id'=>'ED'.$row->id))}} CCO

                                                {{Form::hidden('cco_check[]','False',array('class'=>'ccocheck','data-id'=>'ED'.$row->id))}}

                                                {{Form::checkbox('repless[]', 'True','', array('class' => 'custom-control-input repless' ,'data-id'=>'ED'.$row->id))}} Repless

                                                {{Form::hidden('repless_check[]','False',array('class'=>'replesscheck','data-id'=>'ED'.$row->id))}}

                                                {{Form::hidden('dataid[]','IF0')}}

                                                {{Form::hidden('status[]','itemfile')}}
                                                {{Form::hidden('oldId[]','')}}
                                                {{Form::hidden('oldPurchaseType[]','')}}
                                                {{Form::hidden('oldswapDate[]','')}}
                                                {{Form::hidden('swapId[]','')}}
                                                {{Form::hidden('completeNew[]','')}}
                                                <a href="javascript:void(0);" class="plus-icon"><img
                                                            src="../../../images/plus.jpg"/></a>
                                            </div>

                                        </div>

                                        {{--<hr>--}}
                                        {{--<div class="modal-box" align="center"><label>Manual Item Entry</label></div>--}}

                                        <div style="display: none;">{{$z =1}}</div>
                                        <div style="display: none;">{{$q=1}}</div>
                                        <div style="display: none;">{{$datam=''}}</div>


                                    </div>
                                    <div class="modal-btn clearfix">
                                        {{ Form::submit('UPDATE') }}
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


    <script>

        $(document).ready(function () {

            $(function () {

                $('#datepicker').datepicker({
                    numberOfMonths: 1,
                    dateFormat: 'mm-dd-yy',


                });
            });

            $('.swap').hide();
            $('.swaps').hide();
//            $('.implanted-device').hide();


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


                    @for($p = 0 ; $p<count($dataid); $p++)


            var hospital = $("#client").val();
            var project = $("#projectId").val();

            var dId = $('#category-ED' + '{!! $dataid[$p] !!}').attr("data-id");
            datid.push(dId);

            var char = "#category-" + dId;
            var category = $(char + " option:selected").text();

            categories.push(category);

            var man = $('#manuf-' + dId).val();

            manuf.push(man);

            var physician = $('#physician').val();

            var physician_email = '{{$itemMain['phyEmail']}}';


            var supply = $('#supply-' + dId).val();
            supplyitem.push(supply);

            var manufs = $('#manufpart-' + dId).val();

            manufacture.push(manufs);

            var pur = $("#purch-" + dId).val();
            purchase.push(pur);

            var serial = $("#serialNumber-" + dId).val();
            serialNumber.push(serial);

            $("#swap-" + dId).show();


            @endfor

            /**
             *physician Email ID Start
             **/

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
                                if (item.email == physician_email) {
                                    html_data += "<option value='" + item.email + "' selected>" + item.email + "</option>";
                                } else {

                                    html_data += "<option value='" + item.email + "'>" + item.email + "</option>";
                                }
                            });
                        } else {
                            html_data = "<option value=''>Select Physician Email</option>";
                        }

                        $("#physicianEmail").html(html_data);

                    }

                });
            }


            /**
             *physician Email ID End
             **/

            if (hospital != "" && category != "" && manuf != "") {
                /*get company start*/
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

                                $("#manufacturer-" + item.dataid).html(html_data);
                                html_data = "";
                                q++;
                            });
                        } else {
                            html_data = "<option value=''>Supply Company</option>";
                        }

                    }

                });
                /*get compnay end*/
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

                                $("#supplyItem-" + item.dataid).html(html_data);
                                html_data = "";
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

                                        $('.purchaseType[data-id=' + item.dataid + ']').html(html_data);
                                    } else if (purchase == 'Consignment') {
                                        html_data += "<option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment' SELECTED>Consignment</option>";

                                        $('.purchaseType[data-id=' + item.dataid + ']').html(html_data);
                                    }

                                } else if (check == "False") {
                                    if (purchase == "Consignment") {

                                        html_data += "<option value=''>Purchase Type</option><option value='Consignment' SELECTED>Consignment</option>";

                                        $('.purchaseType[data-id=' + item.dataid + ']').html(html_data);
                                    } else {
                                        html_data += "<option value=''>Purchase Type</option><option value='Consignment'>Consignment</option>";

                                        $('.purchaseType[data-id=' + item.dataid + ']').html(html_data);
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

        var max_fields = 4; //maximum input boxes allowed
        var wrapper = $("#add-more"); //Fields wrapper
        var add_button = $(".plus-icon"); //Add button ID

        var x ={{$j}}; //initlal text box count
        var j = 2;
        $(add_button).click(function (e) { //on add input button click
            var hospitalPart = $(".hospitalPart[data-id=IF" + x + "]").val();


            if (hospitalPart == "") {
                alert("Please enter Above Fileds!!");
            }
            else {
                e.preventDefault();

                var hospital = $("#hospital").val();
                var project = $("#projectId").val();
                var category = $("#category").val();

                if (hospital != "") {

                    if (x < max_fields) { //max input box allowed
                        x++; //text box increment
                        j++;


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
                                console.log(data);
                                if (data.status) {
                                    html_data += "<option value=''>Select Category</option>";
                                    $.each(data.value, function (i, item) {

                                        html_data += "<option value='" + item.category + "'>" + item.category + "</option>";
                                    });
                                } else {
                                    html_data = "<option value=''>Select Category</option>";
                                }

                                swapoption += "<option value=''>Swap</option><option value='Swap In'>Swap In</option><option value='Swap Out'>Swap Out</option>";
                                // $(".supplyItem").html(html_data);

                                $(wrapper).append("<div class='input1 item-input append-div' id='add-more' >" +
                                    "<div class='swapdiv' data-id='IF" + x + "'><label class='items' data-id='IF" + x + "'>Item #" + j + ":</label>" +
                                    "<select class='repbox-input category' data-id=IF" + x + " id='category-IF" + x + "' name='category[]'>" + html_data + "</select> " +
                                    "<select class='repbox-input manufacturer' data-id=IF" + x + " id='manufacturer-IF" + x + "' name='manufacturer[]'><option value=''>Select Comapny</option></select> " +
                                    "<select class='repbox-input supplyItem' data-id=IF" + x + " id='supplyItem-IF" + x + "' name='supplyItem[]'><option value=''>Select Suplly Item</option></select> " +
                                    "<input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='repbox-input hospitalPart' data-id=IF" + x + " readonly id='hospitalPart-IF" + x + "'>" +
                                    "<input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='repbox-input mfgPartNumber' readonly data-id=IF" + x + ">" +
                                    // "<input type='text' class='repbox-input quantity' name='quantity[]' data-id=IF" + x + " value='1' readonly>" +
                                    "<select class='repbox-input purchaseType' name='purchaseType[]' data-id=IF" + x + "><option value='' >Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select>" +
                                    "<input type='text' placeholder='Serial Number' class='repbox-input serialNumber' data-id=IF-text" + x + " id='serial-textIF" + x + "'>" +
                                    "<span style='display: none;' id='serial-drop-box-IF" + x + "'> <select class='js-example-basic-single repbox-input serialnumberdropdown' id='serial-dropIF" + x + "' data-id='IF-drop" + x + "'><option value=''>Select serial No.</option></select> </span>" +
                                    "<select name='isImplanted[]' data-id='IF" + x + "' class='repbox-input implanted' ><option value='Implanted'>Implanted</option><option value='Not Implanted'>Not Implanted</option></select> " +
                                    //                                    "<select name='type[]' class='repbox-input type' data-id='IF" + x + "'><option value='Main'>Main</option><option value='Sub'>Sub</option></select>" +
                                    "<select name='unusedReason[]' data-id='IF" + x + "' class='repbox-input implanted-device' style='display: none;' ><option value=''>Select Reason</option><option value='Dropped'>Dropped</option><option value='Wrong Device'>Wrong Device</option><option value='Rep Error'>Rep Error</option><option value='Doctor Error'>Doctor Error</option><option value='Damaged Packaging'>Damaged Packaging</option></select> " +
                                    "<input type='text' name='poNumber[]' placeholder='P.O. Number' class='repbox-input poNumber' data-id=IF" + x + ">" +
                                    //                                    "<input type='number' name='order[]' placeholder='Order Id' class='repbox-input order' data-id=IF" + x + ">" +
                                    "<input type='hidden' name='status[]' value='itemfile'>" +
                                    "<select class='repbox-input swap' data-id=IF" + x + " id='swap-IF" + x + "' name='swap[]' style='display: none;'>" + swapoption + "</select>" +
                                    "<input type='checkbox' name='cco[]' value='Yes' class='custom-control-input cco' data-id='IF" + x +"'> CCO"+
                                    "<input type='hidden' name='cco_check[]' value='False' class='ccocheck' data-id='IF" + x + "'>"+
                                    "<input type='checkbox' name='repless[]' value='Yes' class='custom-control-input repless' data-id='IF" + x + "'> Repless"+
                                    "<input type='hidden' name='repless_check[]' value='False' class='replesscheck' data-id='IF" + x + "'>"+
                                    "<input type='hidden' name='dataid[]' value='IF" + x + "'>" +
                                    "<input type='hidden' name='oldPurchaseType[]' value=''>" +
                                    "<a href='javascript:void(0);' class='minus-icon remove_field'><img src='../../../images/minus.jpg' /></a></div>");

                            }

                        });
                    } else {
                        alert('You can add maximum 3 item file');
                    }


                }
            }
        });

        //        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        //
        //
        //        });

        $(document).on("click", ".remove_field", function (e) {

            e.preventDefault();
            console.log($(this).parent('div'));
            $(this).parent('div').remove();
            x--;
            j--;
        });


        /*manual file entry start*/

        var max_field = 4; //maximum input boxes allowed
        var wrappers = $("#new-add-more-item"); //Fields wrapper
        var add_button = $(".plus-icons"); //Add button ID

        var y =  {{$z}}; //initlal text box count
        var z = 1;

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
                var project = $("#projectId").val();
                var category = $("#category").val();

                if (hospital != "") {
                    if (y < max_field) { //max input box allowed
                        y++;
                        z++;

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
                                swapoption += "<option value=''>Swap</option><option value='Swap In'>Swap In</option><option value='Swap Out'>Swap Out</option>";
                                // $(".supplyItem").html(html_data);
                                $(wrappers).append("<div class='input1 item-input append-div' id='add-more-item' ><label >Item #" + z + ":</label> <select class='repbox-input category' data-id=MI" + y + " id='category-MI" + y + "' name='category[]'>" + html_data + "</select> <select class='repbox-input manufacturer' data-id=MI" + y + " id='manufacturer-MI" + y + "' name='manufacturer[]'><option value=''>Select Comapny</option></select> <input type='text' name='supplyItem[]' placeholder='Supply Item' class='repbox-input supplyItem'  data-id=MI" + y + "><input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='repbox-input' data-id=MI" + y + "><input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='repbox-input' data-id=MI" + y + "><select class='repbox-input quantity' name='quantity[]' data-id=MI" + y + "><option value=''>Quantity</option><option value='1'>1</option></select><select class='repbox-input purchaseType' name='purchaseType[]' data-id=MI" + y + "><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select><input type='text' name='serialNumber[]' placeholder='Serial Number' class='repbox-input serialNumber' data-id=MI-text" + x + " id='serial-textMI" + x + "'><span style='display: none;' id='serial-drop-box-MI" + x + "'> <select class='js-example-basic-single repbox-input serialnumberdropdown' id='serial-dropMI" + x + "' data-id='MI-drop" + x + "'><option value=''>Select serial No.</option></select> </span><input type='text' name='poNumber[]' placeholder='P.O. Number' class='repbox-input' data-id=MI" + y + "><input type='number' name='order[]' placeholder='Order Id' class='repbox-input order' data-id=MI" + x + "><input type='hidden' name='status[]' value='manual'><select class='repbox-input swaps' data-id=MI" + x + " id='swap-MI" + x + "' name='swap[]' style='display: none;'>" + swapoption + "</select><input type='hidden' name='dataid[]' value='MI" + x + "'><a href='javascript:void(0);' class='minus-icon remove_field'><img src='../../../images/minus.jpg' /></a></div>");

                            }

                        });


                    } else {
                        alert('You can add maximum 3 item file');
                    }
                }
            }
        });

        //                $(wrappers).on("click", ".remove_fields", function (e) { //user click on remove text
        //
        //                    e.preventDefault();
        //                    $(this).parent('div').remove();
        //                    y--;
        //                    z--;
        //                })

        $(document).on("click", ".remove_fields", function (e) {

            e.preventDefault();
            console.log($(this).parent('div'));
            $(this).parent('div').remove();
            x--;
            j--;
        });

        /*manual file entry end*/

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
            var newi = id[id.length - 1];
            var newd = id.substring(0, 2);

            if (currentserialnumber != '') {

                if (newd == 'IF') {
                    var swapid = 'IF' + newi;
                    $('.swap[data-id=' + swapid + ']').show();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if (newd == 'MI') {
                    var swapid = 'MI' + newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id=' + swapid + ']').show();
                }

            } else {
                if (newd == 'IF') {
                    var swapid = 'IF' + newi;
                    $('.swap[data-id=' + swapid + ']').hide();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if (newd == 'MI') {
                    var swapid = 'MI' + newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id=' + swapid + ']').hide();
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

            /**/
            var newi = id[id.length - 1];
            var newd = id.substring(0, 2);

            if (currentserialnumber != '') {

                if (newd == 'IF') {
                    var swapid = 'IF' + newi;
                    $('.swap[data-id=' + swapid + ']').show();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if (newd == 'MI') {
                    var swapid = 'MI' + newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id=' + swapid + ']').show();
                }

            } else {
                if (newd == 'IF') {
                    var swapid = 'IF' + newi;
                    $('.swap[data-id=' + swapid + ']').hide();
//                    $('.swaps[data-id=' + id + ']').show();
                } else if (newd == 'MI') {
                    var swapid = 'MI' + newi;
//                    $('.swap[data-id='+swapid+']').show();
                    $('.swaps[data-id=' + swapid + ']').hide();
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
                        $('#select2-' + dropdownid + '-container').text("");

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
//                    repuser: repuser
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
        $(document).on('change', '#physician', function (event) {
            var phy = "#physician";
            var physician = $(phy + " option:selected").text();

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
            var category = $(char + " option:selected").text();

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
            // alert('hii');
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
            var project = $("#projectId").val();


            if (hospital != "" && project != "") {
                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/getitemfile')}}",
                    data: {
                        supplyItem: supplyItem,
                        hospital: hospital,
                        project: project,
                    },

                    success: function (data) {


                        if (data.status) {
                            var html_data = '';
                            var item = data.value;

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
//                $(".type[data-id=" + id + "]").attr("required", "true");
//                $("#serial-drop" + id).attr("required", "true");
            } else {
                $(".quantity[data-id=" + id + "]").removeAttr("required");
                $(".purchaseType[data-id=" + id + "]").removeAttr("required");
                $(".serialNumber[data-id=" + id + "]").removeAttr("required");
                $("#serial-text" + id).removeAttr("required");
                $(".implanted[data-id=" + id + "]").removeAttr("required");
//                $(".type[data-id=" + id + "]").removeAttr("required");
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

//                            $(".serialNumber[data-id=" + id + "]").removeAttr("required");
//                            $(".serialNumber[data-id=" + id + "]").attr("readonly", "true");
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
                $("#serial-text" + id).attr("required", "true");
                $("#serial-drop" + id).removeAttr("required");

            }


        });

        /******/
        /*Add New Button Swap Concept 14/11/2017 12:30 P.M.*/
        /******/
        $(document).on('change', '.swap', function (event) {

            var id = $(this).attr("data-id");
            var value = $(this).val();
            var items = $(".items[data-id=" + id + "]").text();
            var purchasedata = $("#purchasetype-" + id).val();
            var serialnumberdata = $('#serial-drop' + id).val();
            var order = $(".order[data-id=" + id + "]").val();

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
                        $(".swapdiv[data-id=" + id + "]").append("<div class='input1 item-input append-div' >" +
                            "<label class='items' data-id ='S" + id + "' >" + items + "</label> " +
                            "<select class='repbox-input category' data-id=S" + id + " id='category-S" + id + "' name='category[]'>" + html_data + "</select> " +
                            "<select class='repbox-input manufacturer' data-id=S" + id + " id='manufacturer-S" + id + "' name='manufacturer[]'><option value=''>Select Comapny</option></select> " +
                            "<select class='repbox-input supplyItem' data-id=S" + id + " id='supplyItem-S" + id + "' name='supplyItem[]'><option value=''>Select Supply Item</option></select>" +
                            "<input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='repbox-input hospitalPart' data-id=S" + id + ">" +
                            "<input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='repbox-input mfgPartNumber' data-id=S" + id + ">" +
                            "<select class='repbox-input quantity' name='quantity[]' data-id=S" + id + "><option value=''>Quantity</option><option value='1'>1</option></select>" +
                            "<select class='repbox-input purchaseType' name='purchaseType[]' data-id=S" + id + " id = 'purchasetype-S" + id + "' ><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select>" +
                            "<input type='text' name='serialNumber[]' placeholder='Serial Number' class='repbox-input serialNumber' data-id=S-text" + id + " id='serial-textS" + id + "'>" +
                            "<span style='display: none;' id='serial-drop-box-S" + id + "'> <select class='js-example-basic-single repbox-input serialnumberdropdown' id='serial-dropS" + id + "' data-id='S-drop" + id + "'><option value=''>Select serial No.</option></select> </span>" +
                            "<select data-id='S" + id + "' class='repbox-input implanted' name='isImplanted[]' ><option value='Implanted'>Implanted</option><option value='Not Implanted'>Not Implanted</option></select>    " +
                            //                            "<select name='type[]' class='repbox-input'><option value='Main'>Main</option><option value='Sub'>Sub</option></select>   " +
                            "<select name='unusedReason[]' data-id='S" + id + "' class='repbox-input implanted-device' style='display: none;' ><option value=''>Select Reason</option><option value='Dropped'>Dropped</option><option value='Wrong Device'>Wrong Device</option><option value='Rep Error'>Rep Error</option><option value='Doctor Error'>Doctor Error</option><option value='Damaged Packaging'>Damaged Packaging</option></select> " +
                            "<input type='text' name='poNumber[]' placeholder='P.O. Number' class='repbox-input' data-id=S" + id + ">" +
                            //                            "<input type='number' name='order[]' placeholder='Order Id' value='" + order + "' readonly class='repbox-input order' data-id=S" + id + ">" +
                            "<input type='hidden' name='status[]' value='itemfile'>" +
                            "<select class='repbox-input swap' data-id=S" + id + " id='swap-S" + id + "' name='swap[]'>" + swapoption + "</select>" +
                            "<input type='checkbox' name='cco[]' value='Yes' class='custom-control-input cco' data-id=S" + id + "'> CCO"+
                            "<input type='hidden' name='cco_check[]' value='False' class='ccocheck' data-id=S" + id + "'>"+
                            "<input type='checkbox' name='repless[]' value='Yes' class='custom-control-input repless' data-id=S" + id + "'> Repless"+
                            "<input type='hidden' name='repless_check[]' value='False' class='replesscheck' data-id=S" + id + "'>"+
                            "<input type='hidden' name='discount[]' value='' class='discount' id='discount-'S" + id + "' data-id='S" + id + "'>" +
                            "<input type='hidden' name='price[]' value='' class='price' id='price-S'" + id + "' data-id='S" + id + "'>" +
                            "<input type='hidden' name='dataid[]' value='" + id + "'></div>");
                        // runscript();

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
                    } else if (values == "Swap Out") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }

                    $("#swap-" + ids).addClass("swap");
                    $(".swap[data-id=" + ids + "]").html(swapoptions);

                } else if (st == 'I') {
                    var values = $("#swap-" + id).val();

                    if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option><option value='Swap Out'>Swap Out</option>";
                    } else if (values == "Swap Out") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }
                    $("#swap-" + ids).addClass("swap");
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
            var order = $(".order[data-id=" + id + "]").val();

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
                        $(".swapdiv[data-id=" + id + "]").append("<div class='input1 item-input append-div' ><label class='items' data-id ='S" + id + "' >" + items + "</label> <select class='repbox-input category' data-id=S" + id + " id='category-S" + id + "' name='category[]'>" + html_data + "</select> <select class='repbox-input manufacturer' data-id=S" + id + " id='manufacturer-S" + id + "' name='manufacturer[]'><option value=''>Select Comapny</option></select> <input type='text' name='supplyItem[]' placeholder='Supply Item' class='repbox-input supplyItem'  data-id=S" + id + "><input type='text' name='hospitalPart[]' placeholder='Hospital Part #' class='repbox-input hospitalPart' data-id=S" + id + "><input type='text' name='mfgPartNumber[]' placeholder='Manuf Part #' class='repbox-input mfgPartNumber' data-id=S" + id + "><select class='repbox-input quantity' name='quantity[]' data-id=S" + id + "><option value=''>Quantity</option><option value='1'>1</option></select><select class='repbox-input purchaseType' name='purchaseType[]' data-id=S" + id + " id = 'purchasetype-S" + id + "' ><option value=''>Purchase Type</option><option value='Bulk'>Bulk</option><option value='Consignment'>Consignment</option></select><input type='text' name='serialNumber[]' placeholder='Serial Number' class='repbox-input serialNumber' data-id=S-text" + id + " id='serial-textS" + id + "'><span style='display: none;' id='serial-drop-box-S" + id + "'> <select class='js-example-basic-single repbox-input serialnumberdropdown' id='serial-dropS" + id + "' data-id='S-drop" + id + "'><option value=''>Select serial No.</option></select> </span><input type='text' name='poNumber[]' placeholder='P.O. Number' class='repbox-input' data-id=S" + id + "><input type='number' name='order[]' placeholder='Order Id' value='" + order + "' readonly class='repbox-input order' data-id=S" + id + "><input type='hidden' name='status[]' value='itemfile'><select class='repbox-input swaps' data-id=S" + id + " id='swap-S" + id + "' name='swap[]'>" + swapoption + "</select><input type='hidden' name='discount[]' value='' class='discount' id='discount-'S" + id + "' data-id='S" + id + "'><input type='hidden' name='price[]' value='' class='price' id='price-S'" + id + "' data-id='S" + id + "'><input type='hidden' name='dataid[]' value='" + id + "'></div>");
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
                    } else if (values == "Swap Out") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }

                    $("#swap-" + ids).addClass("swaps");
                    $(".swaps[data-id=" + ids + "]").html(swapoptions);

                } else if (st == 'I') {
                    var values = $("#swap-" + id).val();

                    if (values == "Swap In") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' selected>Swap In</option><option value='Swap Out'>Swap Out</option>";
                    } else if (values == "Swap Out") {
                        swapoptions += "<option value=''>Swap</option><option value='Swap In' >Swap In</option><option value='Swap Out' selected>Swap Out</option>";
                    }
                    $("#swap-" + ids).addClass("swapss");
                    $(".swaps[data-id=" + id + "]").html(swapoptions);
                }
                $(this).parent('div').remove();
            }


        });
        /******/
        /*Swap discount*/
        $(document).on('change', '.serialnumberdropdown', function (event) {
            var id = $(this).attr("data-id");
            var value = $(this).val();

            var newi = id[id.length - 1];
            var newd = id.substring(0, 1);
            if (newd == 'S') {
                var newis = id.substr(id.length - 3);
                var swap = $("#swap-" + newis).val();

                if (swap == 'Swap Out') {
                    var serialnumber = $("#serial-drop" + newis).val();
//                    alert(serialnumber);
                }

            }
        });

        /**
         *implanted on change append or remove dropdown
         */
        $(document).on('change', '.implanted', function (event) {
            var id = $(this).attr("data-id");
            var value = $(this).val();

            if (value == 'Not Implanted') {

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
    <script type="text/javascript">
        function runscript() {
            $.getScript("{{ URL::asset('js/edit_script.js') }}", function () {

            });
        }
    </script>
    <script src="{{ URL::asset('js/edit_script.js') }}"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/black-tie/jquery-ui.css"
          media="screen"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>



@stop