@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box" style="margin-left:23%;">

            <div class="col-md-12 col-lg-12 modal-box">
                <a href="{{ URL::to('admin/category') }}" class="pull-right" data-toggle="modal">X</a>
                <h4 style="text-align:center;"> Edit Category </h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red; margin:5px;">{{ $error }}</li>
                    @endforeach
                </ul>
                {{ Form::model($category,['method'=>'PATCH','action'=>['categories@update',$category->id],'files'=>'true']) }}
                <div class="input1">
                    {{Form::label('label1', 'Project Name:')}}
                    {{ Form::select('project_name', $projects) }}
                </div>
                <div class="input1">
                    {{Form::label('label3', 'Category Name:')}}
                    {{ Form::text('category_name',null,array('placeholder'=>'Category Name','maxlength'=>'40'))}}
                </div>

                <div class="input1">
                    {{Form::label('label3', 'Category Short Name:')}}
                    {{ Form::text('category_short_name',$category->short_name,array('placeholder'=>'Category Short Name','maxlength'=>'40'))}}
                </div>

                <div class="input1">
                    {{Form::label('label3', 'Category Type:')}}
                    {{ Form::select('type',array('Devices'=>'Devices','Accessories'=>'Accessories'),null,array('maxlength'=>'40','required'=>'true'))}}
                </div>

                <br>
                <div class="input1">
                    <div class="input1 fileUpload">

                    </div>
                    <div class="file-upload btn btn-default">
                        <span>Upload Category Image</span>
                        {{ Form::file('image',array('id'=>'fp_upload','class'=>'upload form-control','accept'=>'image/x-png,image/gif,image/jpeg'))}}
                    </div>
                    <img src="{{URL::to('public/category/'.$category['image'])}}" height="100px" width="100px">
                </div>



                <div>
                    {{ Form::submit('UPDATE',array('class'=>'btn_add_new','style'=>'width:154px; float:left; margin-left:56px;')) }}
                </div>
                <div class="input1">
                    <a href="{{ URL::to('admin/category/remove/'.$category->id) }}"
                       onclick="return confirm(' Are you sure you want to delete category?');"
                       style="padding:8px 50px; float:left; margin:0px 10px; border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop