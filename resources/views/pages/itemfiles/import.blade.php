@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="add_new_box">
		
        <div class="col-md-12 col-lg-12 modal-box">
        <a title="Add Item File" href="{{URL::to('admin/itemfiles')}}" class="pull-right" data-toggle="modal">X</a>    
            <h4> Import Item File </h4>
            {{ Form::open(array('url' => 'admin/itemfiles/create','method'=>'POST','files'=>'true') )}}
            <ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
            <div class="input1">
                {{ Form::select('clientId',$clients,$itemFile['clientId'],array('id'=>'clientname')) }}
            </div>

            <div class="input1">
                {{ Form::select('projectId',$projects,$itemFile['projectId'],array('id'=>'project','required'=>'true')) }}
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



@stop       