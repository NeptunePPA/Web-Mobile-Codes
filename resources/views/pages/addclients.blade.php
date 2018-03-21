@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="add_new_box">
		
        <div class="col-md-12 col-lg-12 modal-box">
        <a title="Add Device" href="{{ URL::to('admin/clients') }}" class="pull-right" data-toggle="modal">X</a>    
            <h4> Add Client </h4>
            {{ Form::open(array('url' => 'admin/clients/create','files'=>'true')) }}
            <p style="color:red; margin:5px; text-align:left; width:210px;">
                {{ $errors->first('item_no') }}
            </p>
            <p style="color:red; margin:5px; text-align:left; width:210px;">
                {{ $errors->first('client_name') }}
            </p>
            <p style="color:red; margin:5px; text-align:left; width:210px;">
                {{ $errors->first('street_address') }}
            </p>
            <p style="color:red; margin:5px; text-align:left; width:210px;">
                {{ $errors->first('city') }}
            </p>
            <p style="color:red; margin:5px; text-align:left; width:210px;">
                {{ $errors->first('state') }}
            </p>
            <div class="input1">
                {{ Form::text('item_no',null,array('placeholder'=>'Item Number','disabled'=>'true'))}}
            </div>
            <div class="input1">
                {{ Form::text('client_name',null,array('placeholder'=>'Client Name','maxlength'=>'40'))}}
            </div>
            <div class="input1">
                {{ Form::text('street_address',null,array('placeholder'=>'Street Address','maxlength'=>'40'))}}
            </div>
            <div class="input1">
                {{ Form::text('city',null,array('placeholder'=>'City Name','maxlength'=>'40'))}}
            </div>
            <div class="input1">
                {{ Form::select('state', $state) }}
            </div>
            <br>
            <div class="input1">
                <div class="input1 fileUpload">

                </div>
                <div class="file-upload btn btn-default">
                    <span>Upload Client Image</span>
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