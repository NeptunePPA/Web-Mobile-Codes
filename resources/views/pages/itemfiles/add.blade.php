@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="add_new_box">
		
        <div class="col-md-12 col-lg-12 modal-box">
        <a title="Add Item File" href="{{URL::to('admin/itemfiles')}}" class="pull-right" data-toggle="modal">X</a>    
            <h4> Add Item File </h4>
            {{ Form::open(array('url' => 'admin/itemfiles/create','method'=>'POST','files'=>'true') )}}
            <ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
            <div class="input1">
                {{ Form::select('clientId',$clients,'',array('id'=>'clientname','required'=>'true')) }}
            </div>

            <div class="input1">
                {{ Form::select('projectId',array(''=>'Select Project'),'',array('id'=>'project','required'=>'true')) }}
            </div>
            &nbsp;
            <div class="input1">
                <div class="input1 fileUpload">
                 
                </div>
                <div class="file-upload btn btn-default">
                    <span>Upload</span>  
                
                     {{ Form::file('itemFile',array('id'=>'fp_upload','class'=>'upload form-control'))}} 
                </div>
            </div>

            <div>
                {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>	

    <script type="text/javascript">
        $(document).on("change","#clientname",function (event) {

            var clientname = $("#clientname").val();

            $.ajax({
                url: "{{ URL::to('admin/itemfiles/project')}}",
                data: {
                    clientname : clientname,
                    _token:"{{csrf_token()}}"
                },
                type: "POST",
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += "<option value=''>Select Project</option>";
                        $.each(data.value, function (i, item) {
                            if(item.doctors != ''){
                                html_data += "<option value='" + item.project_id + "' name ='"+ item.projectName +"'>" + item.projectName + "</option>";
                            }

                        });
                    } else
                    {
                        html_data = "<option value=''>Select Project</option>";
                    }

                    $("#project").html(html_data);

                }

            });
        });
    </script>


@stop       