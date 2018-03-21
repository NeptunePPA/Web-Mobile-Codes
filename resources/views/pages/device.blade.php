@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix">
        <div class="top-links clearfix">
            <ul class="add-links">
                @if(Auth::user()->roll == 1)
                    <li><a title="Add Device" href="{{ URL::to('admin/devices/add') }}">Add Device</a></li>

                    <li><a href="#" id="deviceimport">Import</a>
                        {{Form::open(array('url'=>'admin/devices/import','method'=>'post','id'=>'import_form','files'=>true))}}

                        <input type="file" id="theFile" name="device_import" style="display:none;"/>
                        {{Form::close()}}
                    </li>
                    <li><a href="#" id="serialimport">Import Serial Number</a>
                        {{Form::open(array('url'=>'admin/devices/serialnumber/imports','method'=>'post','id'=>'serialimport_form','files'=>true))}}

                        <input type="file" id="theFiles" name="serial_import" style="display:none;"/>
                        {{Form::close()}}
                    </li>
                    <li><a title="Export" href="#" id="deviceexport">Export</a></li>

                    <li class="pull-left"><a title="Sample Download" href="{{URL::to('admin/orders/sampledownload')}}">Sample Download</a></li>
                    <li class="pull-left">
                        <a title="Serial Number Template" href="{{URL::to('admin/devices/serialnumber/serial-numbers')}}"
                           data-toggle="modal">Serial Number Template</a>
                    </li>
                    <li class="pull-left">
                        <a title="Features Image" href="{{URL::to('admin/devices/features/image')}}"
                           data-toggle="modal">Features Image</a>
                    </li>
                @elseif(Auth::user()->roll == 2)
                    <li><a href="#" id="deviceexport">Export</a></li>
                @endif

                <li>
                    {{Form::open(array('url'=>'admin/devices','method'=>'get','id'=>'sort_form','style'=>'display:inline-block;'))}}
                    {{Form::select('sortvalue', array(''=>'Sort By','manufacturers.manufacturer_name' => 'Manufacturer Name','projects.project_name' => 'Project Name','category.category_name' => 'Category Name'),$sort,array('id'=>'sort','onchange' => 'this.form.submit()'))}}

                    {{Form::close()}}
                </li>
                <li style="margin-top: -4px;">
                    {{ Form::select('serialnumber',$serialnumbers,null,array('class'=>'js-example-basic-single2','id'=>'serialNumber','placeholder'=>'Select Serial Number')) }}
                </li>
            </ul>
        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    {{--@if(Auth::user()->roll == 1)--}}
                    <th width="30">&nbsp;</th>
                    {{--@endif--}}
                    <th>ID</th>
                    <th>Manufacturer</th>
                    <th>Device Name</th>
                    <th>Model No.</th>
                    <th>Project Name</th>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}

                    {{--@if(Auth::user()->roll == 1)--}}
                    <td><input type="checkbox" id="checkmain"/></td>
                    {{--@endif--}}

                    <td><input type="text" class='search_text' data-field='device.id' style="width:80px;"
                               name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='manufacturers.manufacturer_name'
                               name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='device.device_name' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='device.model_name' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='projects.project_name' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='category.category_name' name="search[]"/>
                    </td>
                    <td><input type="text" class='search_text' data-field='device.status' name="search[]"/></td>
                    <td style="width:100px;"></td>
                    {{form::close()}}

                </tr>
                </thead>

                <tbody id="device_result">
                @foreach($device_view as $device)
                    <tr>
                        {{--@if(Auth::user()->roll == 1)--}}
                        <td><input type="checkbox" class='chk_device' name="chk_device[]" value="{{$device->id}}"/></td>
                        {{--@endif--}}
                        <td>{{$device->id}}</td>
                        <td>{{$device->manu_name == "" ? '-' : $device->manu_name}}</td>
                        <td>{{$device->device_name}}</td>
                        <td>{{$device->model_name}}</td>
                        <td>{{$device->project_name == "" ? '-' : $device->project_name}}</td>
                        <td>{{$device->category_name == "" ? '-' : $device->category_name}}</td>
                        <td>{{$device->status }}</td>

                        <td>
                            <a href="{{ URL::to('admin/devices/view/'.$device->id) }}"><i class="fa fa-eye"></i></a>
                            @if(Auth::user()->roll == 1)
                                &nbsp;<a href="{{ URL::to('admin/devices/edit/'.$device->id) }}" data-toggle="modal"><i
                                            class="fa fa-edit"></i></a>
                                &nbsp; <a href="{{ URL::to('admin/devices/remove/'.$device->id) }}"
                                          onclick="return confirm(' Are you sure you want to delete device?');"><i
                                            class="fa fa-close"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <div class="bottom-count clearfix">
            {{$device_view->count()}} of {{$count}} displayed
            {{Form::open(array('url'=>'admin/devices','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
            {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
            {{Form::hidden('sortvalue',$sort)}}
            {{Form::close()}}
        </div>
    </div>


    <script>
        $(document).ready(function () {

            $("#checkmain").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });

            $(".search_text").keyup(function () {
                var userrole = {{Auth::user()->roll}};
                var data = $('#ajax_data').serialize();

                if (userrole == 1) {

                    $.ajax({
                        url: "{{ URL::to('admin/search_device')}}",
                        data: $('#ajax_data').serialize(),
                        success: function (data) {
                            // console.log(data);
                            var html_data = '';
                            if (data.status) {
                                $.each(data.value, function (i, item) {

                                    var manufacturer = (item.manu_name != null) ? item.manu_name : '-';
                                    var project = (item.project_name != null) ? item.project_name : '-';
                                    var category = (item.category_name != null) ? item.category_name : '-';


                                    html_data += "<tr><td><input type='checkbox' class='chk_device' name='chk_device[]' value=" + item.id + " /></td><td>" + item.id + "</td><td>" + manufacturer + "</td><td>" + item.device_name + "</td><td>" + item.model_name + "</td><td>" + project + "</td><td>" + category + "</td><td>" + item.status + "</td><td><a href=devices/view/" + item.id + "><i class='fa fa-eye'></i></a> &nbsp; <a href=devices/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; <a href=devices/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;device?');><i class='fa fa-close'></i></a></td></tr>";

                                });
                            } else {
                                html_data = "<tr> <td colspan='9' style='text-align:center;'> " + data.value + " </td> </tr>"
                            }

                            console.log(html_data);
                            $("#device_result").html(html_data);

                        }

                    });
                }
                else {

                    $.ajax({
                        url: "{{ URL::to('admin/search_device')}}",
                        data: $('#ajax_data').serialize(),
                        success: function (data) {
                            // console.log(data);
                            var html_data = '';
                            if (data.status) {
                                $.each(data.value, function (i, item) {
                                    var manufacturer = (item.manu_name != null) ? item.manu_name : '-';
                                    var project = (item.project_name != null) ? item.project_name : '-';
                                    var category = (item.category_name != null) ? item.category_name : '-';


                                    html_data += "<tr><td><input type='checkbox' class='chk_device' name='chk_device[]' value=" + item.id + " /></td><td>" + item.id + "</td><td>" + manufacturer + "</td><td>" + item.device_name + "</td><td>" + item.model_name + "</td><td>" + project + "</td><td>" + category + "</td><td>" + item.status + "</td><td><a href=devices/view/" + item.id + "><i class='fa fa-eye'></i></a></td></tr>";

                                });
                            } else {
                                html_data = "<tr> <td colspan='9' style='text-align:center;'> " + data.value + " </td> </tr>"
                            }

                            $("#device_result").html(html_data);

                        }

                    });
                }

            });

            $("#deviceexport").click(function () {

                if ($(".chk_device:checked").length == 0) {

                    alert("Please select record and export");
                    return false;
                }
                else {
                    var chk_device = new Array();
                    $.each($("input[name='chk_device[]']:checked"), function () {
                        var chk_devices = $(this).val();

                        chk_device.push(chk_devices);
                    });
                    console.log(chk_device);
                    $.ajax({
                        url: "{{URL::to('admin/devices/export')}}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            chk_device: chk_device
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

            $("#deviceimport").click(function () {
                if (confirm(' Are you sure you want to import device?')) {
                    $("#theFile").click();
                    document.getElementById("theFile").onchange = function () {
                        document.getElementById("import_form").submit();
                    };

                }

            });

            $("#serialimport").click(function () {
                if (confirm(' Are you sure you want to import Serial Number?')) {
                    $("#theFiles").click();
                    document.getElementById("theFiles").onchange = function () {
                        document.getElementById("serialimport_form").submit();
                    };

                }

            });


        });

        $(document).on("change", "#serialNumber", function (event) {
           var serial = $(this).val();

            $.ajax({
                url: "{{ URL::to('admin/devices/serialnumberdevice')}}",
                data: {
                    serial: serial,
                },

                success: function (data) {
//                    console.log(data);
                    var html_data = '';
                    if (data.status) {

                        $.each(data.value, function (i, item) {

                            var manufacturer = (item.manu_name != null) ? item.manu_name : '-';
                            var project = (item.project_name != null) ? item.project_name : '-';
                            var category = (item.category_name != null) ? item.category_name : '-';


                            html_data += "<tr><td><input type='checkbox' class='chk_device' name='chk_device[]' value=" + item.id + " /></td><td>" + item.id + "</td><td>" + manufacturer + "</td><td>" + item.device_name + "</td><td>" + item.model_name + "</td><td>" + project + "</td><td>" + category + "</td><td>" + item.status + "</td><td><a href=devices/view/" + item.id + "><i class='fa fa-eye'></i></a> &nbsp; <a href=devices/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; <a href=devices/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;device?');><i class='fa fa-close'></i></a></td></tr>";

                        });
                    } else {
                        html_data = "<tr> <td colspan='9' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }
//                    console.log(html_data);

                    $("#device_result").html(html_data);

                }
            });
        });

    </script>
    <script src="{{ URL::asset('js/edit_script.js') }}"></script>
@stop