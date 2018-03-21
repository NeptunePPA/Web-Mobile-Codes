@extends ('layout.default')
@section ('content')
<div class="add_new">
	<div class="box-center editmanu" style="width:565px;">
		<div class="add_new_box">
		<div class="col-md-12 col-lg-12 modal-box">
		<a href="{{ URL::to('admin/manufacturer') }}" class="pull-right" data-toggle="modal" >X</a>
							<h4 style="text-align:center;"> Edit Manufacturer </h4>
							<ul>
								@foreach($errors->all() as $error)
								<li style="color:red; margin:5px;">{{ $error }}</li>
								@endforeach
							</ul>
							{{ Form::model($manufacturers,['files'=>true,'action'=>['manufacturer@update',$manufacturers->id]]) }}
							<div class="input1">
							{{Form::label('label1', 'Item Number:')}}
							{{ Form::text('item_no',null,array('placeholder'=>'Item No.','style'=>'margin:5px;width:267px','disabled'=>'true')) }}
							</div>
							<div class="input1">
							{{Form::label('label1', 'Manufacturer Name:')}}
							{{ Form::text('manufacturer_name',null,array('maxlength'=>'40','placeholder'=>'Manufacturer Name','style'=>' margin:5px;width:267px')) }}
							</div>
							<div class="input1">
							{{Form::label('label1', 'Manufacturer Short Name:')}}
							{{ Form::text('manufacturer_short_name',$manufacturers->short_name,array('maxlength'=>'40','placeholder'=>'Manufacturer Short Name','style'=>' margin:5px;width:267px')) }}
							</div>
							<div class="input1" style="text-align:left">
							<label></label>
							<img src="{{URL::to('public/upload/' . $manufacturers->manufacturer_logo)}}" width="100" heigth="100" style=" margin-left:5px;"/>
							</div>
							<div class="input1" style="display:inline-block;">
							{{Form::label('label1', 'Manufacturer Logo:')}}
							{{ Form::text('image_name',null,array('placeholder'=>'Manufacturer Logo','style'=>' margin:5px;width:163px','id'=>'file_name')) }}
							</div>
							<div style="float:right;">
								{{Form::input('button','Browse','Upload Logo' ,array('style'=>' margin:5px 0px 0 0;','id'=>'browse'))}}
							{!! Form::file('image',array('id'=>'fp_upload')) !!}
							</div



							<div class="input1">
							{{ Form::submit('UPDATE',array('class'=>'btn_add_new','style'=>'width:154px; margin-left:80px; float:left;')) }}
								<a href="{{ URL::to('admin/manufacturer/remove/'.$manufacturers->id) }}" onclick="return confirm(' Are you sure you want to delete manufacturer?');" style="padding:8px 50px; float:left; margin:0px 10px; border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
							</div>
							{{ Form::close() }}
		</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
		$('#fp_upload').hide();
		 $("#browse").click(function(){
		   $('#fp_upload').click();
		   var file = document.getElementById("fp_upload");
		   });
		 $('#fp_upload').change(function() {
			$('#file_name').val($(this).val());
		});
});
</script>
@stop