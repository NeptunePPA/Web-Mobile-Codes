@extends ('layout.default')
@section ('content')

<div class="add_new">
    <div class="add_new_box">
       
		<div class="col-md-12 col-lg-12 modal-box">
		 <a href="{{ URL::to('admin/projects') }}" class="pull-right" data-toggle="modal" >X</a>
            
            <h4> Add project </h4>
			<ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px; width:210px;">{{ $error }}</li>
                @endforeach
            </ul>
            {{ Form::open(array('url' => 'admin/projects/create')) }}
            <div class="input1">
                {{ Form::text('project_name',null,array('placeholder'=>'Project Name','maxlength'=>'40'))}}
            </div>

            <div class="input1" style="text-align:left;">

                {{ Form::select('client_name[]', $clients,null,array('class'=>'js-example-basic-multiple','multiple'=>'multiple')) }}
            </div>


            <div>
                {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop     


@section ('footer')
 <script src="{{ URL::asset('js/edit_script.js') }}"></script>
@stop
