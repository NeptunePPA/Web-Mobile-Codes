@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box">

            <div class="col-md-12 col-lg-12 modal-box">
                <a title="Add Scorecard" href="{{ URL::to('admin/users/scorecard/'.$user['id']) }}" class="pull-right"
                   data-toggle="modal">X</a>
                <h4> Add Scorecard </h4>
                {{ Form::open(array('url' => 'admin/users/scorecard/store/'.$user['id'],'method'=>'POST','files'=>'true') )}}
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red; margin:5px;">{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="input1">
                    {{Form::select('monthId',$month, '', array('class' => 'name'))}}
                </div>
                <div class="input1">
                    {{ Form::selectYear('year', 2010, 2030)}}
                </div>
                &nbsp;
                <div class="input1">
                    <div class="input1 fileUpload">

                    </div>
                    <div class="file-upload btn btn-default">
                        <span>Upload</span>

                        {{ Form::file('scorecardImage[]',array('id'=>'fp_upload','multiple'=>'true','class'=>'upload form-control','accept' => 'image/*'))}}
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