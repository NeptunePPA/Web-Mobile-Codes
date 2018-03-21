@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="box-center1">
<div class="add_new_box">
		
<div class="col-md-12 col-lg-12 modal-box" style="margin-top:10px;">
 <a title="" href="{{ URL::to('admin/devices/view/'.$deviceId) }}#5" class="pull-right" data-toggle="modal" >X</a>
 <h4> Edit Rep Contact </h4>
			<ul>
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
			{{ Form::open(array('url' => 'admin/devices/repinfo/update/'.$deviceRepUser['id'],'method'=>'post','files'=>true)) }}
			<div class="content-area clearfix"  style="padding:30px 0px 30px 0px;">
				<div class="col-md-12 col-lg-12 modal-box" align="center">
					<div class="input1">
						{{ Form::hidden('deviceId',$deviceId)}}
					</div>
					<div class="input1">
						{{Form::label('label1', 'Rep Name')}}
                        {{ Form::text('repName',$deviceRepUser['name'],array('readonly'=>'true'))}}
					</div>
					
					<div class="input1">
						{{Form::label('label4', 'Email')}}
						{{ Form::text('email',$deviceRepUser['email'],array('readonly'=>'true'))}}
					</div>
					<div class="input1">
						{{Form::label('label5', 'Mobile')}}
						{{ Form::text('mobile',$deviceRepUser['mobile'],array('readonly'=>'true'))}}
					</div>
					<div class="input1">
						{{Form::label('label17', 'Title')}}
						{{ Form::text('title',$deviceRepUser['title'],array('readonly'=>'true'))}}
					</div>
                    <div class="input1">
						{{Form::label('label6', 'Company')}}
						{{ Form::text('company',$deviceRepUser['manufacturer_name'],array('readonly'=>'true'))}}
					</div>
					
					<br>
					<div class="input1">
						{{Form::label('label7', 'Subject')}}
						{{ Form::select('status',array('No' => 'No','Yes' => 'Yes'),$repStatus,array('id'=>'repstatus')) }}
					</div>
					
				</div>
				
			</div>
			
				<div class="modal-btn clearfix">
					{{ Form::submit('SAVE') }}
					<a href="{{ URL::to('admin/devices/view/'.$deviceId) }}#5" style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">CANCEL</a>
				</div>
			{{ Form::close() }}
		</div>
</div>
</div>
</div>

@stop

