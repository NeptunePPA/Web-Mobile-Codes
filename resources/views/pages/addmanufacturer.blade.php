@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="box-center" style="width:440px;">
		<div class="add_new_box">
		<div class="col-md-12 col-lg-12 modal-box">
		<a href="{{ URL::to('admin/manufacturer') }}" class="pull-right" data-toggle="modal" >X</a>
							<h4> Add Manufacturer </h4>
							<ul>
								@foreach($errors->all() as $error)
								<li style="color:red; margin:5px; width:210px;">{{ $error }}</li>
								@endforeach
							</ul>
							{{ Form::open(array('url' => 'admin/manufacturer/create','method'=>'POST','files'=>true)) }}
							<div class="input1">
							{{ Form::text('item_no',null,array('placeholder'=>'Item No.','style'=>'float:left; margin:5px;width:97%','disabled'=>'true')) }}
							</div>
							<div class="input1">
							{{ Form::text('manufacturer_name',null,array('maxlength'=>'40','placeholder'=>'Manufacturer Name','style'=>'float:left; margin:5px;width:97%')) }}
							</div>

							<div class="input1">
							{{ Form::text('manufacturer_short_name',null,array('maxlength'=>'40','placeholder'=>'Manufacturer Short Name','style'=>'float:left; margin:5px;width:97%')) }}
							</div>

							<div class="input1">
							{{ Form::text('image_name',null,array('placeholder'=>'Manufacturer Logo','style'=>'float:left; margin:5px;','id'=>'file_name')) }}{{Form::input('button','Browse','Upload Logo' ,array('style'=>'float:left; margin:5px;','id'=>'browse'))}}
							{!! Form::file('image',array('id'=>'fp_upload')) !!}
							</div>



							<div class="btn-div">
							{{ Form::submit('SAVE',array('class'=>'btn_add_new','style'=>'width:150px;margin:5px;')) }}
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