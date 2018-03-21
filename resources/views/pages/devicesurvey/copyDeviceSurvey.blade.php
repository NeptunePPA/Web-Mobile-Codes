    @extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="box-center1">
            <div class="add_new_box">

                <div class="col-md-12 col-lg-12 modal-box" style="margin-top:10px;">
                    <a title="" href="{{ URL::to('admin/devices/view/'.$deviceId) }}#4"
                       class="pull-right" >X</a>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color:red; margin:5px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <h3>Add Physician Preference</h3>
                    {{ Form::open(array('url' => 'admin/devices/devicesurvey/create','method'=>'POST','files'=>true)) }}
                    <div class="content-area clearfix" style="padding:30px 0px 30px 0px;">
                        <div class="col-md-12 col-lg-12 modal-box" align="center">
                            <div class="input1">
                                {{ Form::hidden('device_id',$deviceId)}}
                            </div>
                            <div class="input1">
                                {{Form::label('label2', 'Select Client',array('class'=>'surveyadd'))}}
                                {{ Form::select('clientId',$client_name,'',array('id'=>'clientname')) }}
                            </div>

                            <div style="display: none">{{$i = 1}}</div>
                            @foreach($data as $row)

                            <div class="input1">
                                {{Form::label('label3', 'Question'.$i)}}
                                {{ Form::text('que[]',$row['question'],array('placeholder'=>'Question 1','class'=>'que','data-id'=>$i))}}

                                @if($row['check'] == "True")
                                    {{Form::checkbox('que_check[]','True',true, array('class' => 'que_check','data-id'=>$i))}}
                                    {{Form::hidden('check[]','True',array('id'=>'check-'.$i))}}
                                @else
                                    {{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>$i))}}
                                    {{Form::hidden('check[]','False',array('id'=>'check-'.$i))}}
                                @endif
                                <div style="display: none">{{$i++}}</div>
                            </div>
                            @endforeach

                            <div class="input1">
                                {{Form::label('label7','Status',array('class'=>'surveyadd'))}}
                                {{Form::select('status', array(''=>'Status','True' => 'Active','False'=>'DeActive'),'', array('class' => 'name'))}}
                            </div>

                        </div>

                    </div>

                    <div class="modal-btn clearfix">
                        {{ Form::submit('SAVE') }}
                        <a href="{{ URL::to('admin/devices/view/'.$deviceId) }}#4"
                           style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">CANCEL</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $('input[class="chkbox"]').on('change', function (e) {
                e.preventDefault();
                var chkid = $(this).data('id');
                var isChecked = $(this).is(":checked");
                alert(isChecked);
                if (isChecked) {
                    var chkhidden = $('[data-id="chkhd' + chkid + '"]').val('True');

                } else {
                    var chkhidden = $('[data-id="chkhd' + chkid + '"]').val('False');

                }
            });

        });

        $(document).on("click", ".que_check", function (event) {
            var id = $(this).attr("data-id");

            var que = $(".que[data-id=" + id + "]").val();

//            alert(que);

            if(que != ""){
                if( $(".que_check[data-id=" + id + "]").is(':checked')) {
                    $("#check-"+ id).val('True');

                } else {
                    $("#check-"+ id).val('False');

                }

            } else {

                $(this).prop("checked",false);
            }


        });
    </script>

@stop
