@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 5%;">

        {{ Form::open(array('url' => 'admin/repcasetracker','method'=>'post','id'=>'clients')) }}
        <div class="top-links clearfix clientselect">
            Manufacturers:- {{Form::select('manufacture',$manufacture,$getmanufacture,array('class' => 'clientname dataclient','id'=>'manufacture'))}} &nbsp;
            Category:- {{Form::select('category',$category,$getcategory, array('class' => 'clientname dataclient','id'=>'category'))}} &nbsp;
            Purchase Type:-{{Form::select('purchase',array(''=>'All Purchase Type','Bulk'=>'Bulk', 'Consignment'=>'Consignment'),$getpurchase, array('class' => 'clientname dataclient','id'=>'purchase'))}}

        </div>
        {{ Form::close()}}
        <div class="top-links clearfix">
            <ul class="add-links">

                <li><a title="Add Device" href="{{ URL::to('admin/repcasetracker/add') }}" data-toggle="modal">Add
                        Case</a></li>

                <li><a title="Add Device" href="#" id="itemexport" class="itemexport">Export</a></li>

                <li>
                    {{Form::open(array('url'=>'admin/repcasetracker','method'=>'get','id'=>'sort_form','style'=>'display:inline-block;'))}}
                    {{Form::select('sortvalue', array(''=>'Sort By','1' => 'Procedure Date','2' => 'Physician Name','3' => 'Hospital Name'),$sortby,array('id'=>'sort','onchange' => 'this.form.submit()'))}}

                    {{Form::close()}}
                </li>

                <li><a title="Add Device" href="{{ URL::to('admin/repcasetracker/addnewdevice') }}" data-toggle="modal">New Device Request</a></li>



            </ul>
            <ul class="add-links pull-right">
                <li><a  href="{{ URL::to('admin/app/view') }}">Import View</a></li>

                <li><a href="#" id="deviceimport">Import</a>
                    {{Form::open(array('url'=>'admin/app/import','method'=>'post','id'=>'import_form','files'=>true))}}

                    <input type="file" id="theFile" name="device_import" style="display:none;"/>
                    {{Form::close()}}
                </li>

                <li><a  href="{{ URL::to('admin/app/import_app_value') }}">Sample Download APP</a></li>
            </ul>
        </div>

        <div class="table">
            <table>
                <thead>
                <tr>

                    <th></th>

                    <th>Procedure Date</th>
                    <th>Case Id</th>
                    <th>Rep User</th>
                    <th>Manufacturers</th>
                    <th>Category</th>
                    <th>Supply Item Description</th>
                    <th>Hospital Part#</th>
                    <th>Manuf Part#</th>
                    {{--<th>Qty.</th>--}}
                    <th>Physician Name</th>
                    <th>Hospital</th>
                    <th>Purchase Type</th>
                    {{--<th>Order Id</th>--}}
                    <th>Serial Number</th>
                    <th>P.O. Number</th>
                    <th>Swap Date</th>
                    <th>Device Status</th>
                    <th>Reason</th>
                    <th>Swap Status</th>
                    <th>Action</th>

                </tr>

                <tr>

                    <td><input type="checkbox" id="checkmain"/></td>

                    <td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;"
                               name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;"
                               name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;"
                               name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;"
                               name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.client_name' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.street_address' name="search[]"/>
                    </td>
                    <td><input type='text' class='search_text' data-field='clients.city' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='state.state_name' name="search[]"/></td>
                    {{--<td style="width:75px;"></td>--}}
                    <td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;"
                               name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.client_name' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.street_address' name="search[]"/>
                    </td>
                    {{--<td><input type='text' class='search_text' data-field='clients.street_address' name="search[]"/>--}}
                    {{--</td>--}}
                    <td><input type='text' class='search_text' data-field='clients.city' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='state.state_name' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='state.state_name' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='state.state_name' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='clients.item_no' style="width:95px;"
                               name="search[]"/></td>

                    <td><input type='text' class='search_text' data-field='clients.swapType' style="width:95px;"
                               name="search[]"/></td>
                    <td style="width:75px;"></td>

                </tr>
                </thead>

                <tbody id="order_result">
                <div style="display: none;">{{$caseId = ""}}</div>

                @foreach($itemdetails as $row)
                    @if(!empty($row->swappedId) && !empty($row->swapDate))
                        <tr style="color: red;">
                    @else
                        <tr>
                    @endif
                            @if($caseId != $row->repcaseID)

                                <td><input type="checkbox" class='chk_rep' name="chk_rep[]"
                                           value="{{$row->itemMainId}}"/></td>

                            @else
                                <td></td>
                            @endif
                            @if($caseId != $row->repcaseID)

                                <td>{{Carbon\Carbon::parse($row->itemfilename->produceDate)->format('m-d-Y')}}</td>

                            @else
                                <td></td>
                            @endif
                            @if($caseId != $row->repcaseID)
                                <td>{{$row->repcaseID}}</td>
                            @else
                                <td></td>
                            @endif
                            @if($caseId != $row->repcaseID)

                                <td>{{$row->itemfilename->users['name']}}</td>

                            @else
                                <td></td>
                            @endif
                            <td>{{$row->manufacturer}}</td>
                            <td>{{$row->category}}</td>
                            <td>{{$row->supplyItem}}</td>
                            <td>{{$row->hospitalPart}}</td>
                            <td>{{$row->mfgPartNumber}}</td>
                            {{--<td>{{$row->quantity}}</td>--}}
                            @if($caseId != $row->repcaseID)
                                <td>{{$row->itemfilename->physician}}</td>
                            @else
                                <td></td>
                            @endif
                            @if($caseId != $row->repcaseID)
                                <td>{{$row->itemfilename->client['client_name']}}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{$row->purchaseType}}</td>
                            {{--<td>{{$row->orderId == ''? '-' :$row->orderId}}</td>--}}
                            <td>{{$row->serialNumber}}</td>
                            <td>{{$row->poNumber}}</td>
                            <td>{{$row->swapDate = $row->swapDate== ""?"": Carbon\Carbon::parse($row->swapDate)->format('m-d-Y')}}</td>
                            <td>{{$row->isImplanted}}</td>
                            <td>{{$row->unusedReason == '' ? '-' : $row->unusedReason}}</td>
                            <td>{{$row->swapType = $row->swapType== ''?'-' : $row->swapType}}</td>


                            @if($caseId != $row->repcaseID)
                                <td><a href="{{ URL::to('admin/repcasetracker/edit/'.$row->itemMainId) }}"
                                       data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    &nbsp;<a
                                            href="{{ URL::to('admin/repcasetracker/swapdevice/'.$row->itemMainId) }}"><i
                                                class="fa fa-exchange" aria-hidden="true"></i></a>
                                    &nbsp; <a href="{{ URL::to('admin/repcasetracker/remove/'.$row->itemMainId) }}"
                                              onclick="return confirm('Are you sure you want to delete rep case entry?');"><i
                                                class="fa fa-close"></i></a></td>
                            @else
                                <td></td>
                            @endif

                        </tr>
                        <div style="display: none;">{{$caseId = $row->repcaseID}}</div>

                        @endforeach
                </tbody>
            </table>
        </div>
        <div class="bottom-count clearfix">
            {{$itemdetails->count()}} of {{$count}} displayed
            {{Form::open(array('url'=>'admin/repcasetracker','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
            {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
            {{Form::hidden('sortvalue',$sortby)}}
            {{Form::hidden('manufacture',$getmanufacture)}}
            {{Form::hidden('category',$getcategory)}}
            {{Form::hidden('purchase',$getpurchase)}}
            {{Form::close()}}
        </div>


    </div>
    <script>
        $(document).ready(function () {

            $("#checkmain").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });

            /*submit client id form*/
            $(".dataclient").change(function(){

                $("#clients").submit();
                return true;
            });

            $(document).on("click", ".itemexport", function (event) {

                if ($(".chk_rep:checked").length == 0) {

                    alert("Please select record and export");
                    return false;
                }
                else {

                    var ck_rep = new Array();
                    $.each($("input[name='chk_rep[]']:checked"), function () {
                        var ck_reps = $(this).val();

                        ck_rep.push(ck_reps);
                    });

                    var sortby = $('#sort').val();
                    var manufacture = $('#manufacture').val();
                    var category = $('#category').val();
                    var purchase = $('#purchase').val();

                    $.ajax({
                        url: "{{URL::to('admin/repcasetracker/export')}}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ck_rep: ck_rep,
                            sortby: sortby,
                            manufacture : manufacture,
                            category :category,
                            purchase: purchase
                        },
                        type: "POST",
                        success: function (response, textStatus, request) {
                            var a = document.createElement("a");
                            a.href = response.file;
                            a.download = response.name;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                        }
                    });
                }
            });

            $(".search_text").keyup(function () {

                var search = new Array();
                $.each($("input[name='search[]']"), function () {
                    var ck_reps = $(this).val();

                    search.push(ck_reps);
                });

                var sortby = $('#sort').val();
                var manufacture = $('#manufacture').val();
                var category = $('#category').val();
                var purchase = $('#purchase').val();

                $.ajax({
                    url: "{{ URL::to('admin/repcasetracker/search')}}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: search,
                        sortby: sortby,
                        manufacture : manufacture,
                        category :category,
                        purchase: purchase
                    },
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        var html_data = '';
                        var caseId = ""
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                if (caseId != item.repcaseID) {
                                    var check = "<input type='checkbox' class='chk_rep' name='chk_rep[]'' value=" + item.itemMainId + "/>";
                                } else {
                                    var check = " ";
                                }

                                if (caseId != item.repcaseID) {
                                    var produceDate = item.produceDate;
                                } else {
                                    var produceDate = " ";
                                }

                                if (caseId != item.repcaseID) {
                                    var repUser = item.repUser;
                                } else {
                                    var repUser = " ";
                                }

                                if (caseId != item.repcaseID) {
                                    var repcaseID = item.repcaseID;
                                } else {
                                    var repcaseID = " ";
                                }


                                var swapType = item.swapType == null ? '-' : item.swapType;


                                if (caseId != item.repcaseID) {
                                    var physician = item.physician;
                                } else {
                                    var physician = " ";
                                }

                                if (caseId != item.repcaseID) {
                                    var client_name = item.client_name;
                                } else {
                                    var client_name = " ";
                                }

                                if (caseId != item.repcaseID) {
                                    var action = "<a href='repcasetracker/edit/" + item.itemMainId + "' data-toggle='modal' ><i class='fa fa-edit'></i></a>&nbsp;<a href='repcasetracker/swapdevice/" + item.itemMainId + "' ><i class='fa fa-exchange' aria-hidden='true'></i></a> &nbsp; <a href='repcasetracker/remove/" + item.itemMainId + "' onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;Rep&nbsp;case&nbsp;Entry?'); ><i class='fa fa-close'></i></a>";
                                } else {
                                    var action = "";
                                }

                                if(item.swapDate != null){
                                    var swap = "<tr style='color: red;'>";
                                } else {
                                    var swap = "<tr>";
                                }

//                                var order = (item.orderId == null) ? '-' : item.orderId;

                                var swapDate = (item.swapDate == null) ? '' : item.swapDate;

                                var reason = (item.unusedReason == null) ? '-': item.unusedReason;

                                html_data += swap + "<td>" + check + "</td><td>" + produceDate + "</td><td>" + repcaseID + "</td><td>" + repUser + "</td><td>" + item.manufacturer + "</td><td>" + item.category + "</td><td>" + item.supplyItem + "</td><td>" + item.hospitalPart + "</td><td>" + item.mfgPartNumber + "</td><td>" + physician + "</td><td>" + client_name + "</td><td>" + item.purchaseType + "</td><td>" + item.serialNumber + "</td><td>" + item.poNumber + "</td><td>" + swapDate + "</td><td>" + item.isImplanted + "</td><td>" + reason + "</td><td>" + swapType + "</td><td>" + action + "</td><td></tr>";

                                caseId = item.repcaseID;
                            });

                        } else {
                            html_data = "<tr> <td colspan='20' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        $("#order_result").html(html_data);


                    }

                });

            });

        });

        $("#deviceimport").click(function () {
            if (confirm(' Are you sure you want to import Old Year APP Data?')) {
                $("#theFile").click();
                document.getElementById("theFile").onchange = function () {
                    document.getElementById("import_form").submit();
                };

            }

        });
    </script>
@stop       