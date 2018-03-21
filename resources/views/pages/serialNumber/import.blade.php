@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box">

            <div class="col-md-12 col-lg-12 modal-box">
                <a title="Add Item File" href="{{URL::to('admin/devices/view/'.$serial['deviceId'])}}#6" class="pull-right">X</a>
                <h4> Import Serial Number </h4>
                {{ Form::open(array('url' => 'admin/devices/serialnumber/store/'.$serial['deviceId'],'method'=>'POST','files'=>'true') )}}
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red; margin:5px;">{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="input1">
                    {{ Form::select('clientId',$clients,'',array('id'=>'clientname','required'=>'true')) }}
                </div>
                &nbsp;
                <div class="input1">
                    <div class="input1 fileUpload">

                    </div>
                    <div class="file-upload btn btn-default">
                        <span>Upload</span>

                        {{ Form::file('serialFile',array('id'=>'fp_upload','class'=>'upload form-control'))}}
                    </div>
                </div>

                <div>
                    {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop