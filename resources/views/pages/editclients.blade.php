@extends ('layout.default')
@section ('content')
<div class="add_new">
		<div class="add_new_box" style="margin-left:26%;">
        
		<div class="col-md-12 col-lg-12 modal-box">
        <a href="{{ URL::to('admin/clients') }}" class="pull-right" data-toggle="modal" >X</a>    
            
            <h4 style="text-align:center;"> Edit Client </h4>
            <ul>
				@foreach($errors->all() as $error)
				<li style="color:red; margin:5px;">{{ $error }}</li>
				@endforeach
			</ul>
            {{ Form::model($clients,['method'=>'PATCH','action'=>['client@update', $clients->id],'files'=>'true']) }}

            <div  class="input1">
				{{Form::label('label1', 'Item Number:')}}
                {{ Form::text('item_no',null,array('placeholder'=>'Item Number','disabled'=>'true'))}}
            </div>
            <div class="input1">
				{{Form::label('label2', 'Client Name:')}}
                {{ Form::text('client_name',null,array('placeholder'=>'Client Name','maxlength'=>'40'))}}
            </div>
            <div class="input1">
				{{Form::label('label3', 'Street Address:')}}
                {{ Form::text('street_address',null,array('placeholder'=>'Street Address','maxlength'=>'40'))}}
            </div>
			<div class="input1">
				{{Form::label('label4', 'City:')}}
                {{ Form::text('city',null,array('placeholder'=>'City Name','maxlength'=>'40'))}}
            </div>
            <div class="input1">
				{{Form::label('label5', 'State:')}}
                {{ Form::select('state', $state) }}	
            </div>
            <br>
            <div class="input1">
                <div class="input1 fileUpload">

                </div>
                <div class="file-upload btn btn-default">
                    <span>Upload Client Image</span>
                    {{ Form::file('image',array('id'=>'fp_upload','class'=>'upload form-control'))}}
                </div>
                <img src="{{URL::to('public/'.$clients->image)}}" width="100px" height="100px">
            </div>


            <div class="input1">
                {{ Form::submit('UPDATE',array('class'=>'btn_add_new','style'=>'width:154px; float:left; margin-left:58px;')) }}
            	<a href="{{ URL::to('admin/clients/remove/'.$clients->id) }}" onclick="return confirm(' Are you sure you want to delete client?');" style="padding:8px 50px; float:left; margin:0px 10px; border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
			</div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop       
