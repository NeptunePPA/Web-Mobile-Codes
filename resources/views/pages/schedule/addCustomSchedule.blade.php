@extends ('layout.default')
@section ('content')
<div class="add_new">
<div class="box-center">
    <div class="add_new_box">

        <div class="col-md-12 col-lg-12 modal-box">
            <a title="" href="{{ URL::to('admin/orders') }}" class="pull-right" data-toggle="modal">X</a>
            <h4 style="text-align:center;"> Schedule Event </h4>
            <ul style="display:inline-block;">
                @foreach($errors->all() as $error)
                <li style="color:red; margin:5px;">{{ $error }}</li>
                @endforeach
            </ul>
            {{ Form::open(array('url' => 'admin/schedule/create','method'=>'post','files'=>true)) }}
            <div class="input1">
                {{Form::label('label1', 'Project:')}}
                {{ Form::select('project_name',$projects,$device['project_name'],array('id'=>'projectname')) }}
            </div>
			
			<div class="input1">
				{{Form::label('label10', 'Client Name:')}}
                {{ Form::select('client_name',$clients,$order['clientId'],array('id'=>'clientname')) }}
            </div>
			
            <div class="input1">
                {{Form::label('label9', 'Physician:')}}
                {{ Form::select('physician_name',$physician,$order['orderby'],array('id'=>'physician')) }}
            </div>
            <div class="input1">
                {{Form::label('label2', 'Patient ID:')}}
                {{ Form::text('patient_id',null,array('placeholder'=>'Patient ID','disabled'=>'true'))}}
            </div>
            <div class="input1">
                {{Form::label('label3', 'Manufacturer:')}}
                {{ Form::select('manufacturer_name',$manufacturer,$order['manufacturer_name'],array('id'=>'manufacturer'))}}
            </div>
            <div class="input1">
                {{Form::label('label4', 'Device Name:')}}
                {{ Form::select('device_name',$devices,$device['id'],array('id'=>'device'))}}
            </div>
            <div class="input1">
                {{Form::label('label5', 'Model #:')}}
                {{ Form::text('model_no',$order['model_no'],array('placeholder'=>'Model #','id'=>'model','readonly'=>'True'))}}
            </div>
            <div class="input1">
                {{Form::label('label6', 'Rep Name:')}}
                {{ Form::select('rep_name',$rep,'',array('id'=>'device'))}}
            </div>
            <div class="input1">
                {{Form::label('label7', 'Event Date:',array('style'=>''))}}
                {!! Form::text('event_date',\Carbon\Carbon::now()->format('d-m-Y'), array('id' => 'datepicker1','placeholder'=>'Event Date')) !!} 
            </div>
            <div class="input1">
                {{Form::label('label8', 'Start Time:')}}
                {{ Form::select('start_time_hours',array('01' => '01','02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'),null,array('style'=>'width:70px;')) }}
                {{ Form::select('start_time_minutes',array('00'=>'00','01' => '01','02' => '02','03' => '03','04' => '04','05' => '05','06' => '06','07' => '07','08' => '08','09' => '09','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '19','20' => '20','21' => '21','22' => '22','23' => '23','24' => '24','25' => '25','26' => '26','27' => '27','28' => '28','29' => '29','30' => '30','31' => '31','32' => '32','33' => '33','34' => '34','35' => '35','36' => '36','37' => '37','38' => '38','39' => '39','40' => '40','41' => '41','42' => '42','43' => '43','44' => '44','45' => '45','46' => '46','47' => '47','48' => '48','49' => '49','50' => '50','51' => '51','52' => '52','53' => '53','54' => '54','55' => '55','56' => '56','57' => '57','58' => '58','59' => '59','60' => '60'),null,array('style'=>'width:70px;')) }}
                {{ Form::select('start_time',array('AM' => 'AM','PM' => 'PM'),null,array('style'=>'width:65px;')) }}
            </div>
            <div class="input1">
                {{Form::label('label11', 'Status:')}}
                {{ Form::select('status',array('' => 'Status','Active' => 'Active', 'Inactive' => 'Inactive')) }}
            </div>

            <div class="btn-div">
                {{ Form::submit('SAVE',array('class'=>'btn_add_new','style'=>'width:210px;')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {
            $(function () {
                $("#datepicker").datepicker();
            });

        });
    </script>
</div>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/black-tie/jquery-ui.css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>  
<script type="text/javascript" src="{{ URL::asset('js/datepicker.js') }}"></script>

@stop       