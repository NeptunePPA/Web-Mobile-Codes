@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix">

        <a title="" href="{{ URL::to('admin/devices/view/'.$deviceId) }}#4" class="pull-right">X</a>

        <div class="tab-pane" id="Survey">
            <div class="content-area clearfix" style="margin:0 30%;">
                <div class="top-links clearfix">
                    <h1 class="pull-left">Client:{{$client}}</h1>
                    <h2 class="pull-right">Device:{{$device}}</h2>
                </div>
                <div class="top-links clearfix">
                    <ul class="add-links">
                        <li>
                            <a title="Edit" href="{{URL::to('admin/devices/devicesurvey/edit/'.$id.'/'.$deviceId)}}" data-toggle="modal"> Edit </a>
                            {{--<a title="Import" href="#" id="import"> Import </a> |--}}
                            {{--<a title="Export" href="{{URL::to('admin/itemfiles/export/')}}" data-toggle="modal">Export</a> |--}}
                            {{--<a title="Export" href="#" data-toggle="modal" class="remove">Remove</a>--}}
                        </li>
                    </ul>
                    <ul class="add-links pull-right">
                        <li>
                            <a title="view" href="{{ URL::to('admin/devices/view/'.$deviceId) }}#4" > Close </a>
                        </li>
                    </ul>

                </div>

                <div class="table">
                    <table>
                        <thead>
                        <tr>

                            <th>Question</th>
                            <th>Status</th>

                        </tr>
                        @if (count($survey)>0)

                            <tr>

                            </tr>
                        </thead>
                        {{ Form::open(array('url' => 'admin/devices/devicesurvey/copysurvey','method'=>'post','files'=>true,'id'=>'surveyForm')) }}
                        <tbody id="device_survey_result">
                        @foreach($survey as $row)
                            <tr>
                                <td>{{$row->question}}</td>
                                <td>{{$row->check}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                        {{ Form::close() }}
                        @else
                            <tr> <td colspan='10' style='text-align:center;'>No Records Found.</td> </tr>

                        @endif
                    </table>
                </div>
                <div class="bottom-count clearfix">

                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {

//            Device Survey
            $(".dssearch_text").keyup(function () {
                var data = $('#ajax_data').serialize();
                // console.log(data);
                $.ajax({
                    url: "{{URL::to('admin/devices/devicesurveyanswer/search')}}",
                    data: $('#ajax_data').serialize(),
                    type: "POST",
                    success: function (data) {
                        // console.log(data);
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                var que_1 = item.que_1_check =='True' ?(item.que_1_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_2 = item.que_2_check =='True' ?(item.que_2_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_3 = item.que_3_check =='True' ?(item.que_3_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_4 = item.que_4_check =='True' ?(item.que_4_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_5 = item.que_5_check =='True' ?(item.que_5_answer =='True' ?  '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_6 = item.que_6_check =='True' ?(item.que_6_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_7 = item.que_7_check =='True' ?(item.que_7_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';
                                var que_8 = item.que_8_check =='True' ?(item.que_8_answer =='True' ? '<i class="fa fa-check" style="color: green" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: red" aria-hidden="true"></i>'):'';


                                html_data += "<tr><td>" + item.name + "</td><td>" + item.que_1 +"&nbsp;"+que_1 + "</td><td>" + item.que_2 +"&nbsp;"+que_2 + "</td><td>" + item.que_3+"&nbsp;"+ que_3 + "</td><td>" + item.que_4+"&nbsp;"+ que_4 + "</td><td>" + item.que_5 +"&nbsp;"+ que_5 + "</td><td>" + item.que_6 +"&nbsp;"+ que_6 + "</td><td>" + item.que_7 +"&nbsp;"+ que_7 + "</td><td>" + item.que_8 +"&nbsp;"+ que_8 + "</td><td>&nbsp; <a href=../devicefeatures/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;survey?');><i class='fa fa-close'></i></a></td></tr>";

                            });
                        } else {
                            html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        console.log(html_data);
                        $("#device_survey_result").html(html_data);

                    }
                });



            });
        });
    </script>



@stop