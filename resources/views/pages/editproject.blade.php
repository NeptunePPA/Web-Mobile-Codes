@extends ('layout.default')
@section ('content')
<div class="add_new">
    <div class="add_new_box" style="margin-left:26%;">

        <div class="col-md-12 col-lg-12 modal-box">
            <a href="{{ URL::to('admin/projects') }}" class="pull-right" data-toggle="modal" >X</a>    
            <h4 style="text-align:center;"> Edit Project </h4>
            <ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
            {{ Form::model($projects,['method'=>'PATCH','action'=>['projects@update', $projects->id]]) }}
            <div class="input1">
                {{Form::label('label1', 'Project Name:')}}
                {{ Form::text('project_name',null,array('placeholder'=>'Project Name','maxlength'=>'40'))}}
            </div>

            <div class="input1" style="vertical-align:left;">
                {{Form::label('label2', 'Client Name:')}}
                {{ Form::select('client_name[]', $client_name,$selected,array('class'=>'js-example-basic-multiple','multiple'=>'multiple')) }}
            </div>


            <div class="input1">
                {{ Form::submit('UPDATE',array('class'=>'btn_add_new','style'=>'width:154px; float:left; margin-left:60px;')) }}

                <a href="{{ URL::to('admin/projects/remove/'.$projects->id) }}" onclick="return confirm(' Are you sure you want to delete project?');" style="padding:8px 50px; float:left; margin:0px 10px; border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop

@section ('footer')
 <script src="{{ URL::asset('js/edit_script.js') }}"></script>
@stop
