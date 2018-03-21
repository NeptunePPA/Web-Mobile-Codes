@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="add_new_box">
		
        <div class="col-md-12 col-lg-12 modal-box">
        <a title="Close Form" href="{{ URL::to('admin/clients/category/sort/'.$id) }}" class="pull-right" data-toggle="modal">X</a>    
            <h4> Sort Category </h4>
            {{ Form::open(array('url' => 'admin/clients/category/sort/store','method'=>'post')) }}
           
            <ul style="color:red; margin:5px; text-align:left; width:210px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <div class="input1">
                {{Form::hidden('client_name',$id)}}
                {{ Form::select('sort_number',$items) }}
            </div>
            <div class="input1">
                {{ Form::select('category_name',$category) }}
            </div>


            <div>
                {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>		

@stop       