@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box">

            <div class="col-md-12 col-lg-12 modal-box">
                <a href="{{ URL::to('admin/category') }}" class="pull-right" data-toggle="modal">X</a>
                <h4> Add Category </h4>
                <p style="color:red; margin:5px; text-align:left; width:210px;">
                    {{ $errors->first('project_name') }}
                </p>
                <p style="color:red; margin:5px; text-align:left; width:210px;">
                    {{ $errors->first('category_name') }}
                </p>
                {{ Form::open(array('url' => 'admin/category/create','files'=>'true')) }}
                <div class="input1">
                    {{ Form::select('project_name', $projects) }}
                </div>
                <div class="input1">
                    {{ Form::text('category_name',null,array('placeholder'=>'Category Name','maxlength'=>'40'))}}
                </div>

                <div class="input1">
                    {{ Form::text('category_short_name',null,array('placeholder'=>'Category Short Name','maxlength'=>'40'))}}
                </div>

                <div class="input1">
                    {{ Form::select('type',array(''=>'Select Category Type','Devices'=>'Devices','Accessories'=>'Accessories'),null,array('maxlength'=>'40','required'=>'true'))}}
                </div>
                <br>
                <div class="input1">
                    <div class="input1 fileUpload">

                    </div>
                    <div class="file-upload btn btn-default">
                        <span>Upload Category Image</span>
                        {{ Form::file('image',array('id'=>'fp_upload','class'=>'upload form-control','accept'=>'image/x-png,image/gif,image/jpeg'))}}
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