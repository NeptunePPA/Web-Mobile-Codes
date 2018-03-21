@extends ('layout.default')
@section ('content')

<div class="content-area clearfix">

    <a title="" href="{{ URL::to('admin/devices/view/'.$survey['deviceId']) }}#4" class="pull-right">X</a>
    
    <div class="tab-pane" id="Survey">
        <div class="content-area clearfix" style="padding:30px 30px 30px;">
                <h1 class="pull-left"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;{{$survey->client->client_name}}</h1>
                <h2 class="pull-right"><i class="fa fa-assistive-listening-systems" aria-hidden="true"></i> &nbsp; {{$survey->device->device_name}}</h2>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            
                            <th>User Name</th>
                            <th>Question 1</th>
                            <th>Question 2</th>
                            <th>Question 3</th>
                            <th>Question 4</th>
                            <th>Question 5</th>
                            <th>Question 6</th>
                            <th>Question 7</th>
                            <th>Question 8</th>
                            @if(Auth::user()->roll == 1)
                            <th>Action</th>
                            @endif
                        </tr>
                        @if (count($device_survey)>0)

                        <tr>
                            {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}

                           
                            {{ Form::hidden('device_id',$survey['deviceId'])}}
                            {{Form::hidden('surveyId',$survey['id'])}}
                            <td><input type="text" class='dssearch_text' name="search[]"
                                data-field='users.name'/></td>
                                <td><input type="text" class='dssearch_text' name="search[]"
                                    data-field='survey.que_1'/></td>
                                <td><input type="text" class='dssearch_text' name="search[]" data-field='survey.que_2'/>
                                </td>
                                <td><input type="text" class='dssearch_text' name="search[]" data-field='survey.que_3'/>
                                </td>
                                <td><input type="text" class='dssearch_text' name="search[]"
                                     data-field='survey.que_4'/>
                                </td>
                                <td><input type="text" class='dssearch_text' name="search[]" data-field='survey.que_5'/></td>
                                <td><input type="text" class='dssearch_text' name="search[]" data-field='survey.que_6'/></td>
                                <td><input type="text" class='dssearch_text' name="search[]" data-field='survey.que_7'/></td>
                                <td><input type="text" class='dssearch_text' name="search[]" data-field='survey.que_8'/></td>
                                 @if(Auth::user()->roll == 1)
                                 <td style="width:100px;"></td>
                                 @endif
                                 {{ Form::close()}}
                             </tr>
                             </thead>
                             {{ Form::open(array('url' => 'admin/devices/devicesurvey/copysurvey','method'=>'post','files'=>true,'id'=>'surveyForm')) }}
                             <tbody id="device_survey_result">
                                @foreach($device_survey as $row)
                                <tr>
                                   

                                     <td>{{$row->user->name}}</td>
                                     <td>{{$row->que_1}} &nbsp;
                                     @if($row->que_1_check == "True")
                                        @if($row->que_1_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_2}}&nbsp;
                                    @if($row->que_2_check == "True")
                                        @if($row->que_2_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_3}}&nbsp;
                                    @if($row->que_3_check == "True")
                                    @if($row->que_3_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_4}}&nbsp;
                                    @if($row->que_4_check == "True")
                                        @if($row->que_4_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_5}}&nbsp;
                                    @if($row->que_5_check == "True")
                                        @if($row->que_5_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_6}}&nbsp;
                                    @if($row->que_6_check == "True")
                                        @if($row->que_6_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_7}}&nbsp;
                                    @if($row->que_7_check == "True")
                                        @if($row->que_7_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{$row->que_8}}&nbsp;
                                    @if($row->que_8_check == "True")
                                        @if($row->que_8_answer == "True")
                                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    </td>
                                    @if(Auth::user()->roll == 1)
                                    <td>
                                        <!-- <a href="{{ URL::to('admin/devices/devicesurvey/view/'.$row->id) }}"
                                         data-toggle="modal"><i class="fa fa-eye"></i></a>
                                         &nbsp;
                                         <a href="{{ URL::to('admin/devices/devicesurvey/edit/'.$row->id) }}"
                                             data-toggle="modal"><i class="fa fa-edit"></i></a> -->
                                             &nbsp; <a
                                             href="{{ URL::to('admin/devices/devicesurvey/answerRemove/'.$row->id) }}"
                                             onclick="return confirm(' Are you sure you want to delete device Survey?');"><i
                                             class="fa fa-close"></i></a>
                                         </td>
                                         @endif
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
                            {{$device_survey->count()}} of {{$count}} displayed 
                            {{Form::open(array('url'=>'admin/devices/devicesurvey/view/'.$survey['id'],'method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
                            {{Form::select('repPageSize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}

                            {{Form::close()}}
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