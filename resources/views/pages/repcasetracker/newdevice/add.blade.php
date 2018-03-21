@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="add_new_box">
		
        <div class="col-md-12 col-lg-12 modal-box">
        <a title="Add Device" href="{{ URL::to('admin/repcasetracker') }}" class="pull-right" data-toggle="modal">X</a>
            <h4> Request New Device </h4>
            {{ Form::open(array('url' => 'admin/repcasetracker/storenewdevice')) }}

            <div class="input1">
                {{ Form::select('projectName',$project,'',array('id'=>'project','required'=>'true'))}}
            </div>
            <div class="input1">
                {{ Form::select('categoryName',array(''=>'Category Name'),'',array('id'=>'category','required'=>'true'))}}
            </div>
            <div class="input1">
                {{ Form::text('deviceName',null,array('placeholder'=>'Device Name','required'=>'true'))}}
            </div>
            <div class="input1">
                {{ Form::textarea('message',null,array('placeholder'=>'Message','rows'=>'3','cols'=>'27','required'=>'true'))}}
            </div>


            <div>
                {{ Form::submit('SEND',array('class'=>'btn_add_new')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>		

@stop
@section ('footer')
    <script type="text/javascript">
        $(document).on("change", "#project", function (event) {

            var projectid = $(this).val();

            $.ajax({
                url: "{{ URL::to('admin/repcasetracker/getcategoryName')}}",
                data: {
                    projectid: projectid
                },
                success: function (data)
                {
                    var html_data = '';
                    console.log(data);
                    if (data.status) {
                        html_data += "<option value=''>Category Name</option>";
                        $.each(data.value, function (i, item) {
                            // console.log(item);
                            html_data += "<option value="+item.id+">"+item.category_name+"</option>";

                        });
                    }
                    else
                    {
                        html_data = "<option value=''>Category Name</option>";
                    }
                    // console.log(html_data);
                    $("#category").html(html_data);

                }
            });

        });
    </script>
@endsection