@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="box-center1">
<div class="add_new_box" style="margin-left: 200px;">
		
<div class="col-md-12 col-lg-12 modal-box" style="margin-top:10px;">
 <!-- <a title="" href="{{ URL::to('admin/devices/view/'.$deviceid) }}#12" class="pull-right" data-toggle="modal" >X</a> -->
 <a href="{{ URL::to('admin/devices/view/'.$deviceid) }}#4" class="pull-right" >X</a>
			<ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
            <h3>Add Physician Preference</h3>
			{{ Form::open(array('url' => 'admin/devices/devicesurvey/create','method'=>'POST','files'=>true)) }}
			<div class="content-area clearfix"  style="padding:30px 0px 30px 0px;">
				<div class="col-md-12 col-lg-12 modal-box" align="center">
					<div class="input1">
						{{ Form::hidden('device_id',$deviceid)}}
					</div>
					<div class="input1">
						{{Form::label('label2', 'Select Client',array('class'=>'surveyadd'))}}
						{{ Form::select('clientId', $client_name,'',array('id'=>'clientname')) }}
					</div>
					<div class="input1">
						{{Form::label('label3', 'Question 1')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 1','class' => 'que','data-id'=>'1'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-1'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'1'))}}
					</div>
					<div class="input1">
						{{Form::label('label4', 'Question 2')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 2','class' => 'que','data-id'=>'2'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-2'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'2'))}}
					</div>
					<div class="input1">
						{{Form::label('label5', 'Question 3')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 3','class' => 'que','data-id'=>'3'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-3'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'3'))}}
					</div>
					<div class="input1">
						{{Form::label('label17', 'Question 4')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 4','class' => 'que','data-id'=>'4'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-4'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'4'))}}
					</div>
                    <div class="input1">
						{{Form::label('label6', 'Question 5')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 5','class' => 'que','data-id'=>'5'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-5'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'5'))}}
					</div>
					<div class="input1">
						{{Form::label('label7', 'Question 6')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 6','class' => 'que','data-id'=>'6'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-6'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'6'))}}
					</div>
					<div class="input1">
						{{Form::label('label7', 'Question 7')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 7','class' => 'que','data-id'=>'7'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-7'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'7'))}}
						
					</div>
					<div class="input1">
						{{Form::label('label7', 'Question 8')}}
						{{ Form::text('que[]','',array('placeholder'=>'Question 8','class' => 'que','data-id'=>'8'))}}
						{{Form::hidden('check[]','False',array('id'=>'check-8'))}}
						{{Form::checkbox('que_check[]','True',false, array('class' => 'que_check','data-id'=>'8'))}}
					</div>
					<div class="input1">
						{{Form::label('label7','Status',array('class'=>'surveyadd'))}}
						{{Form::select('status', array(''=>'Status','True' => 'Active','False'=>'DeActive'), '', array('class' => 'name'))}}
					</div>
					
				</div>
				
			</div>
			
				<div class="modal-btn clearfix">
					{{ Form::submit('SAVE') }}
					<a href="{{ URL::to('admin/devices/view/'.$deviceid) }}#4" style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">CANCEL</a>
				</div>
			{{ Form::close() }}
		</div>
</div>
</div>
</div>
<script>
$(document).ready(function(){

		$('input[class="chkbox"]').on('change',function(e){
			e.preventDefault();
			var chkid = $(this).data('id');
			var isChecked = $(this).is(":checked");
            if (isChecked) {
                var chkhidden = $('[data-id="chkhd'+chkid+'"]').val('True');
			
            } else {
               var chkhidden = $('[data-id="chkhd'+chkid+'"]').val('False');
			
            }
		});

    $(document).on("click", ".que_check", function (event) {
        var id = $(this).attr("data-id");

		var que = $(".que[data-id=" + id + "]").val();

		if(que != ""){
            if( $(".que_check[data-id=" + id + "]").is(':checked')) {
                $("#check-"+ id).val('True');

            } else {
                $("#check-"+ id).val('False');

            }

		} else {

            $(this).prop("checked",false);
		}


    });

});
</script>

@stop

