@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix">
        {{ Form::open(array('url' => 'admin/tracking/survey','method'=>'post','id'=>'clients')) }}
        <div class="top-links clearfix clientselect">
            Select
            Clients: {{Form::select('clients',$clients, $getclient, array('class' => 'name dataclient','id'=>'dataclient'))}}
            &nbsp;&nbsp;&nbsp;
            Select
            Physician: {{Form::select('doctor',$doctor,$getdoctor, array('class' => 'name dataPhysician','id'=>'dataPhysician'))}}
        </div>
        <div class="top-links clearfix" align="center">
            {{Form::select('category',$category,$getcategory, array('class' => 'name populardata','id'=>'populardata'))}}
        </div>
        {{ Form::close() }}
        {{ Form::open(array('url' => 'admin/orders/updateall','id'=>'form1')) }}
        <div class="top-links clearfix">
            <ul class="add-links">
                <li><a href="#" id="exportsurvey">Export Data</a></li>
            </ul>
        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <th width="30">&nbsp;</th>
                    <th>Hospital</th>
                    <th>Physician</th>
                    <th>Project</th>
                    {{--<th>Cost type</th>--}}
                    <th>Category</th>
                    <th>Level</th>
                    <th>Manuf</th>
                    <th>Device</th>
                    <th>Question</th>
                    <th>Yes</th>
                    <th>No</th>
                </tr>
                <tr>

                    <td><input type="checkbox" id="checkmain"/></td>
                    <td><input type="text" class='search_text' data-field='device' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='client.client_name' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='que_1' name="search[]"/></td>
                    {{--<td><input type="text" class='search_text' data-field='que_2' name="search[]"/></td>--}}
                    <td><input type="text" class='search_text' data-field='que_3' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='que_4' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='que_5' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='que_6' name="search[]"/></td>
                    <td><input type="text" class='search_text' data-field='que_7' name="search[]"/></td>
                    <td style="width:100px;"></td>
                    <td style="width:100px;"></td>


                </tr>
                </thead>

                <tbody id="order_result">
                @if(count($survey)==0)
                    <tr>
                        <td colspan="12"><center>No Data Found...!!</center></td>
                    </tr>
                @else
                    @foreach($survey as $key=>$row)
                        
                        <tr>
                            <td><input type="checkbox" name="survey_check[]" value="{{$row->id}}" class="chk_orders"/></td>
                            <td id="client">{{$row->client_name}}</td>
                            <td id ="name">{{$row->name}}</td>
                            <td id = "project">{{$row->project_name}}</td>
                            <td id = "category">{{$row->category_name}}</td>
                            <td id="level">{{$row->level_name}}</td>
                            <td id="manufacture">{{$row->manufacturer_name}}</td>
                            <td id="device">{{$row->device_name}}</td>
                            <td id="que">{{$row->question}}</td>
                            <td id="yes">{{$row->queanswer_yes}}</td>
                            <td id="no">{{$row->queanswer_no}}</td>
                        </tr>

                    @endforeach
                @endif
                </tbody>

            </table>
        </div>
        {{ Form::close() }}
        <div class="bottom-count clearfix">
            {{$survey->count()}} of {{$counts}} displayed
            {{Form::open(array('url'=>'admin/tracking/survey','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
            {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$counts=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
            {{Form::hidden('clients',$getclient)}}
            {{Form::hidden('doctor',$getdoctor)}}
            {{Form::hidden('category',$getcategory)}}
            {{Form::close()}}
        </div>
    </div>

    <script type="text/javascript">

        /*Select all checkbox*/
        $("#checkmain").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on("click", "#exportsurvey", function (event) {

            if ($(".chk_orders:checked").length == 0) {

                alert("Please select record and export");
                return false;
            }
            else {

                var ck_rep = new Array();
//
                $.each($("input[name='survey_check[]']:checked"), function () {
                    var ck_reps = $(this).val();

                    ck_rep.push(ck_reps);

                });

                $.ajax({
                    url: "{{URL::to('admin/tracking/survey/export')}}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ck_rep: ck_rep,

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

        /*submit client id form*/
        $(".dataclient").change(function () {

            $("#clients").submit();
            return true;
        });

        $(".dataPhysician").change(function () {

            $("#clients").submit();
            return true;
        });

        $(".populardata").change(function () {

            $("#clients").submit();
            return true;
        });



        /*Search Data*/

        $(".search_text").keyup(function () {

            var search = new Array();
            $.each($("input[name='search[]']"), function () {
                var ck_reps = $(this).val();

                search.push(ck_reps);
            });

            // console.log(search);

            var dataclient = $('#dataclient').val();
            var dataPhysician = $('#dataPhysician').val();
            var datacategory = $('#populardata').val();

            $.ajax({
                url: "{{ URL::to('admin/tracking/survey/search')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: search,
                    dataclient: dataclient,
                    datacategory: datacategory,
                    dataPhysician : dataPhysician

                },
                type: "POST",
                success: function (data) {

                    var html_data = '';

                    if (data.status) {
                        console.log(data);
                        $.each(data.value, function (i, item) {
                            var client_name = (item.client_name != null) ? item.client_name : '';
                            var name = (item.name != null) ? item.name : "";
                            var project_name = (item.project_name != null) ? item.project_name :'';
                            var category_name = (item.category_name != null) ? item.category_name :'';
                            var level_name = (item.level_name != null) ? item.level_name : '';
                            var manufacturer_name = (item.manufacturer_name != null) ? item.manufacturer_name :'';
                            var device_name = (item.device_name != null) ? item.device_name : '';
                            var question = (item.question != null) ? item.question : '';
                            var queanswer_yes = (item.queanswer_yes != null) ? item.queanswer_yes :'';
                            var queanswer_no = (item.queanswer_no != null) ? item.queanswer_no :'';

                            html_data += "<tr><td><input type='checkbox' name='survey_check[]' value=" + item.id + " class='chk_orders' /></td>" +
                                "<td>" + client_name + "</td><td>" + name + "</td><td>" + project_name + "</td><td>" + category_name + "</td>" +
                                "<td>" + level_name + "</td><td>" + manufacturer_name + "</td><td>" + device_name + "</td><td>" + question + "</td><td>" + queanswer_yes + "</td>" +
                                "<td>" + queanswer_no + "</td></tr>";
                        });
                    } else {
                        html_data = "<tr> <td colspan='12' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    $("#order_result").html(html_data);

                }

            });

        });

    </script>
@stop 