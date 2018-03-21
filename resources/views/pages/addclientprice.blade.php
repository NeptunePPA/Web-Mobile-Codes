@extends ('layout.default')
@section ('content')
	<div class="add_new">
		<div class="box-center1">
			<div class="add_new_box" style=" width:106%;">

				<div class="col-md-12 col-lg-12 modal-box" style="margin-top:10px;">
					<a title="" href="{{ URL::to('admin/devices/view/'.$deviceid) }}#1" class="pull-right"  >X</a>		<h3 style="text-align:center;">Add Client Price</h3>
					<ul>
						@foreach($errors->all() as $error)
							<li style="color:red; margin:5px;">{{ $error }}</li>
						@endforeach
					</ul>
					<div class="col-md-6 col-lg-6 delta">&nbsp;<img src="{{URL::to('public/upload/color.png')}}" class="deltaImage">&nbsp;
						<img src="{{URL::to('public/upload/delta.png')}}" class="deltaImage"></div>
					<div class="col-md-6 col-lg-6 delta"><img src="{{URL::to('public/upload/color.png')}}" class="deltaImage">&nbsp;
						<img src="{{URL::to('public/upload/delta.png')}}" class="deltaImage"></div>

					{{ Form::open(array('url' => 'admin/devices/clientpricecreate','method'=>'POST','files'=>true)) }}
					<div class="content-area clearfix"  style="padding:20px 0px 20px 0px;">
						<div class="col-md-6 col-lg-6 modal-box" style="border-right:solid 1px #ccc;">
							<div class="input1">
								{{ Form::hidden('device_id',$deviceid)}}
							</div>

							<div class="input1">
								{{Form::label('label2', 'Select Client')}}
								{{ Form::select('manufacturer_name', $manufacturer,'',array('id'=>'clientname')) }}
							</div>
							<div class="input1">
								{{Form::label('label3', 'Unit Cost')}}
								{{ Form::text('unit_cost',null,array('placeholder'=>'Unit Cost'))}}
								{{ Form::checkbox('unit_cost_check','True','', array('class' => 'pricecheck','id'=>'unit_cost_check')) }}
								{{ Form::checkbox('unit_cost_highlight','True','',array('class' => 'deltacheck','id'=>'unit_cost_highlight')) }}
								{{ Form::checkbox('unit_cost_delta_check','True','',array('class' => 'deltacheck','id'=>'unit_cost_delta_check')) }}
							</div>
							<div class="input1">
								{{Form::label('label4', 'Bulk Unit Cost%')}}
								{{ Form::text('bulk_unit_cost',null,array('placeholder'=>'Bulk Unit Cost%'))}}
								{{ Form::checkbox('chk_bulk_unit_cost','True','',array('id'=>'bulk_unit_cost_check','class' => 'pricecheck')) }}

							</div>
							<div class="input1">
								{{Form::label('label5', 'Unit Bulk')}}
								{{ Form::text('bulk',null,array('placeholder'=>'Bulk'))}}
								{{ Form::checkbox('chk_bulk','True','',array('class' => 'pricecheck','id'=>'chk_bulk')) }}
								{{ Form::checkbox('bulk_highlight','True','',array('class' => 'deltacheck','id'=>'bulk_highlight')) }}
							</div>
							<div class="input1">
								{{Form::label('label17', 'CCO Discount')}}
								{{ Form::text('cco',null,array('placeholder'=>'CCO Discount'))}}
								{{ Form::checkbox('chk_cco','True','',array('id'=>'chk_cco','class' => 'pricecheck')) }}
								{{ Form::checkbox('cco_highlight','True','',array('class' => 'deltacheck','id'=>'cco_highlight')) }}
								{{ Form::checkbox('cco_delta_check','True','',array('class' => 'deltacheck','id'=>'chk_cco_delta')) }}


							</div>
							<div class="input1">
								{{Form::label('label6', 'CCO Discount %')}}
								{{ Form::text('cco_discount',null,array('placeholder'=>'CCO Discount%'))}}
								{{ Form::checkbox('chk_cco_discount','True','',array('id'=>'chk_cco_discount','class' => 'pricecheck')) }}
								{{ Form::checkbox('cco_discount_highlight','True','',array('id'=>'cco_discount_highlight','class' => 'deltacheck')) }}
								{{ Form::checkbox('cco_discount_delta_check','True','',array('id'=>'chk_cco_discount_delta','class' => 'deltacheck')) }}

							</div>
							<div class="input1">
								{{Form::label('label7', 'Unit Repless Discount')}}
								{{ Form::text('unit_rep_cost',null,array('placeholder'=>'Unit Repless Discount'))}}
								{{ Form::checkbox('chk_unit_rep_cost','True','',array('id'=>'unit_rep_cost_check','class' => 'pricecheck')) }}
								{{ Form::checkbox('unit_repless_discount_highlight','True','',array('class' => 'deltacheck','id'=>'unit_repless_discount_highlight')) }}
								{{ Form::checkbox('unit_repless_discount_delta_check','True','',array('class' => 'deltacheck','id'=>'unit_repless_discount_delta')) }}

							</div>
							<div class="input1">
								{{Form::label('label8', 'Unit Repless Discount %')}}
								{{ Form::text('unit_rep_discount',null,array('placeholder'=>'Unit Repless Discount%'))}}
								{{ Form::checkbox('chk_unit_rep_discount','True','',array('id'=>'unit_rep_discount_check','class' => 'pricecheck')) }}
								{{ Form::checkbox('unit_repless_highlight','True','',array('class' => 'deltacheck','id'=>'unit_repless_highlight')) }}
								{{ Form::checkbox('unit_repless_delta_check','True','',array('class' => 'deltacheck','id'=>'unit_repless_delta_check')) }}

							</div>

						</div>
						<div class="col-md-6 col-lg-6 modal-box">
							<div class="input1">
								{{Form::label('label9', 'System Cost')}}
								{{ Form::text('system_cost',null,array('placeholder'=>'System Cost'))}}
								{{ Form::checkbox('system_cost_check','True','',array('class' => 'pricecheck','id'=>'system_cost_check')) }}
								{{ Form::checkbox('system_cost_highlight','True','',array('class' => 'deltacheck','id'=>'system_cost_highlight')) }}
								{{ Form::checkbox('system_cost_delta_check','True','',array('class' => 'deltacheck','id'=>'system_cost_delta_check')) }}

							</div>
							<div class="input1">
								{{Form::label('label9', 'System Bulk')}}
								{{ Form::text('system_bulk',null,array('placeholder'=>'System Bulk'))}}
								{{ Form::checkbox('system_bulk_check','True','',array('class' => 'pricecheck','id'=>'system_bulk_check')) }}
								{{ Form::checkbox('system_bulk_highlight','True','',array('class' => 'pricecheck','id'=>'system_bulk_highlight')) }}

							</div>
							<div class="input1">
								{{Form::label('label12', 'Bulk System Cost%')}}
								{{ Form::text('bulk_system_cost',null,array('placeholder'=>'Bulk System Cost%'))}}
								{{ Form::checkbox('chk_bulk_system_cost','True','',array('id'=>'bulk_system_cost_check','class' => 'pricecheck')) }}

							</div>
							<div class="input1">
								{{Form::label('label13', 'System Repless Discount')}}
								{{ Form::text('system_rep_cost',null,array('placeholder'=>'System Repless Discount'))}}
								{{ Form::checkbox('chk_system_rep_cost','True','',array('id'=>'system_rep_cost_check','class' => 'pricecheck')) }}
								{{ Form::checkbox('system_repless_discount_highlight','True','',array('class' => 'deltacheck','id'=>'system_repless_discount_highlight')) }}
								{{ Form::checkbox('system_repless_discount_delta_check','True','',array('class' => 'deltacheck','id'=>'system_repless_discount_delta')) }}
							</div>
							<div class="input1">
								{{Form::label('label14', 'System Repless Discount%')}}
								{{ Form::text('system_rep_discount',null,array('placeholder'=>'System Repless Discount%'))}}
								{{ Form::checkbox('chk_system_rep_discount','True','',array('id'=>'system_rep_discount_check','class' => 'pricecheck')) }}
								{{ Form::checkbox('system_repless_highlight','True','',array('class' => 'deltacheck','id'=>'system_repless_highlight')) }}
								{{ Form::checkbox('system_repless_delta_check','True','',array('class' => 'deltacheck','id'=>'system_repless_delta')) }}
							</div>
							<div class="input1">
								{{Form::label('label15', 'Reimbursement')}}
								{{ Form::text('reimbursement',null,array('placeholder'=>'Reimbursement'))}}
								{{ Form::checkbox('chk_reimbursement','True','',array('class' => 'pricecheck','id'=>'chk_reimbursement')) }}
								{{ Form::checkbox('reimbursement_highlight','True','',array('class' => 'deltacheck','id'=>'reimbursement_highlight')) }}
								{{ Form::checkbox('reimbursement_delta_check','True','',array('class' => 'deltacheck','id'=>'reimbursement_delta_check')) }}
							</div>
						<!-- <div class="input1">
						{{Form::label('label16', 'Order Email')}}
						{{ Form::select('order_email',array('0'=>'Select Order Email'),'',array('id'=>'orderemail')) }}

								</div> -->
						</div>
					</div>

					<div class="modal-btn clearfix">
						{{ Form::submit('SAVE') }}
						<a href="{{ URL::to('admin/devices/view/'.$deviceid) }}#1" style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">CANCEL</a>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	<script>
        $(document).ready(function(){



            $('#chk_cco_discount').change(function() {
                var chk_cco = $('#chk_cco').prop('checked');
                if(chk_cco)
                {
                    alert('You can select only one in CCO Discount or CCO Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#chk_cco').change(function() {
                var chk_cco_discount = $('#chk_cco_discount').prop('checked');
                if(chk_cco_discount)
                {
                    alert('You can select only one in CCO Discount or CCO Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });



            $('#unit_rep_discount_check').change(function() {
                var unit_rep_cost_check = $('#unit_rep_cost_check').prop('checked');
                if(unit_rep_cost_check)
                {
                    alert('You can select only one in Unit Repless Discount or Unit Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#unit_rep_cost_check').change(function(){

                var unit_rep_discount_check = $('#unit_rep_discount_check').prop('checked');
                if(unit_rep_discount_check)
                {
                    alert('You can select only one in Unit Repless Discount or Unit Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#system_rep_discount_check').change(function() {
                var system_rep_cost_check = $('#system_rep_cost_check').prop('checked');
                if(system_rep_cost_check)
                {
                    alert('You can select only one in System Repless Discount or System Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#system_rep_cost_check').change(function() {
                var system_rep_discount_check = $('#system_rep_discount_check').prop('checked');
                if(system_rep_discount_check)
                {
                    alert('You can select only one in System Repless Discount or System Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#chk_cco_discount_delta').change(function() {
                var chk_cco_delta = $('#chk_cco_delta').prop('checked');
                if(chk_cco_delta)
                {
                    alert('You can select only one delta in CCO Discount or CCO Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#chk_cco_delta').change(function() {
                var chk_cco_discount_delta = $('#chk_cco_discount_delta').prop('checked');
                if(chk_cco_discount_delta)
                {
                    alert('You can select only one delta in CCO Discount or CCO Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });


            $('#unit_repless_discount_delta').change(function() {
                var unit_repless_delta = $('#unit_repless_delta').prop('checked');
                if(unit_repless_delta)
                {
                    alert('You can select only one delta in Unit Repless Discount or Unit Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#unit_repless_delta').change(function() {
                var unit_repless_discount_delta = $('#unit_repless_discount_delta').prop('checked');
                if(unit_repless_discount_delta)
                {
                    alert('You can select only one delta in Unit Repless Discount or Unit Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });


            $('#system_repless_discount_delta').change(function() {
                var system_repless_delta = $('#system_repless_delta').prop('checked');
                if(system_repless_delta)
                {
                    alert('You can select only one delta in System Repless Discount or System Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

            $('#system_repless_delta').change(function() {
                var system_repless_discount_delta = $('#system_repless_discount_delta').prop('checked');
                if(system_repless_discount_delta)
                {
                    alert('You can select only one delta in System Repless Discount or System Repless Discount%');
                    $(this).prop("checked",false);
                }
                else
                {
                    $(this).attr("checked");
                }

            });

			/*Unit Cost Delta Check start */

            $(document).on('click','#unit_cost_delta_check',function(event){

                var unit_cost_check = $('#unit_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit cost');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#unit_cost_check',function(event){

                var unit_cost_check = $('#unit_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_cost_check)
                {
                    $('#unit_cost_delta_check').attr("checked");

                }
                else
                {
                    $("#unit_cost_delta_check").prop("checked",false);
                }

            });

			/*Unit Cost Delta Check end*/

			/*cco discount delta Check start */

            $(document).on('click','#chk_cco_discount_delta',function(event){

                var chk_cco_discount = $('#chk_cco_discount').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco_discount)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select CCO Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#chk_cco_discount',function(event){

                var chk_cco_discount = $('#chk_cco_discount').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco_discount)
                {
                    $('#chk_cco_discount_delta').attr("checked");

                }
                else
                {
                    $("#chk_cco_discount_delta").prop("checked",false);
                }

            });

			/*cco Discount Delta Check end*/

			/*cco discount % delta Check start */

            $(document).on('click','#chk_cco_delta',function(event){

                var chk_cco = $('#chk_cco').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select CCO Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#chk_cco',function(event){

                var chk_cco = $('#chk_cco').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco)
                {
                    $('#chk_cco_delta').attr("checked");

                }
                else
                {
                    $("#chk_cco_delta").prop("checked",false);
                }

            });

			/*cco Discount % Delta Check end*/

			/*unit rep cost check delta Check start */

            $(document).on('click','#unit_repless_discount_delta',function(event){

                var unit_rep_cost_check = $('#unit_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit Repless Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#unit_rep_cost_check',function(event){

                var unit_rep_cost_check = $('#unit_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_cost_check)
                {
                    $('#unit_repless_discount_delta').attr("checked");

                }
                else
                {
                    $("#unit_repless_discount_delta").prop("checked",false);
                }

            });

			/*unit rep cost check Delta Check end*/

			/*unit rep cost % check delta Check start */

            $(document).on('click','#unit_repless_delta_check',function(event){

                var unit_rep_discount_check = $('#unit_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_discount_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit Repless');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#unit_rep_discount_check',function(event){

                var unit_rep_discount_check = $('#unit_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_discount_check)
                {
                    $('#unit_repless_delta_check').attr("checked");

                }
                else
                {
                    $("#unit_repless_delta_check").prop("checked",false);
                }

            });

			/*unit rep cost % check Delta Check end*/

			/*System Cost delta Check start */

            $(document).on('click','#system_cost_delta_check',function(event){

                var system_cost_check = $('#system_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Cost');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_cost_check',function(event){

                var system_cost_check = $('#system_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_cost_check)
                {
                    $('#system_cost_delta_check').attr("checked");

                }
                else
                {
                    $("#system_cost_delta_check").prop("checked",false);
                }

            });

			/*System Cost check Delta Check end*/

			/*System Repless Discount delta Check start */

            $(document).on('click','#system_repless_discount_delta',function(event){

                var system_rep_cost_check = $('#system_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Repless Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_rep_cost_check',function(event){

                var system_rep_cost_check = $('#system_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_cost_check)
                {
                    $('#system_repless_discount_delta').attr("checked");

                }
                else
                {
                    $("#system_repless_discount_delta").prop("checked",false);
                }

            });

			/*System Repless Discount check Delta Check end*/

			/*System Repless Discount % delta Check start */

            $(document).on('click','#system_repless_delta',function(event){

                var system_rep_discount_check = $('#system_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_discount_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Repless');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_rep_discount_check',function(event){

                var system_rep_discount_check = $('#system_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_discount_check)
                {
                    $('#system_repless_delta').attr("checked");

                }
                else
                {
                    $("#system_repless_delta").prop("checked",false);
                }

            });

			/*System Repless Discount % check Delta Check end*/

			/*Reimbursement delta Check start */

            $(document).on('click','#reimbursement_delta_check',function(event){

                var chk_reimbursement = $('#chk_reimbursement').prop('checked');
                // console.log(unit_cost_check);
                if(chk_reimbursement)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Reimbursement');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#chk_reimbursement',function(event){

                var chk_reimbursement = $('#chk_reimbursement').prop('checked');
                // console.log(unit_cost_check);
                if(chk_reimbursement)
                {
                    $('#reimbursement_delta_check').attr("checked");

                }
                else
                {
                    $("#reimbursement_delta_check").prop("checked",false);
                }

            });

			/*Reimbursement check Delta Check end*/

			/*Highlight Section Start*/

			/*Unit Cost Highlight*/
            $(document).on('click','#unit_cost_highlight',function(event){

                var chk_unithighlight = $('#unit_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(chk_unithighlight)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit Cost');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#unit_cost_check',function(event){

                var chk_unithighlight = $('#unit_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(chk_unithighlight)
                {
                    $('#unit_cost_highlight').attr("checked");

                }
                else
                {
                    $("#unit_cost_highlight").prop("checked",false);
                }

            });

			/*Unit Bulk Highlight*/

            $(document).on('click','#bulk_highlight',function(event){

                var chk_bulk = $('#chk_bulk').prop('checked');
                // console.log(unit_cost_check);
                if(chk_bulk)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit Bulk');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#chk_bulk',function(event){

                var chk_bulk = $('#chk_bulk').prop('checked');
                // console.log(unit_cost_check);
                if(chk_bulk)
                {
                    $('#bulk_highlight').attr("checked");

                }
                else
                {
                    $("#bulk_highlight").prop("checked",false);
                }

            });

			/*Cco discount Highlight*/
            $(document).on('click','#cco_discount_highlight',function(event){

                var chk_cco_discount = $('#chk_cco_discount').prop('checked');
                // console.log(unit_cost_check);
                if(chk_bulk)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select CCO Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#chk_cco_discount',function(event){

                var chk_cco_discount = $('#chk_cco_discount').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco_discount)
                {
                    $('#cco_discount_highlight').attr("checked");

                }
                else
                {
                    $("#cco_discount_highlight").prop("checked",false);
                }

            });

			/*cco  Highlight*/
            $(document).on('click','#cco_highlight',function(event){

                var chk_cco = $('#chk_cco').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select CCO');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#chk_cco',function(event){

                var chk_cco = $('#chk_cco').prop('checked');
                // console.log(unit_cost_check);
                if(chk_cco)
                {
                    $('#cco_highlight').attr("checked");

                }
                else
                {
                    $("#cco_highlight").prop("checked",false);
                }

            });

			/*Unit Repless Discount*/
            $(document).on('click','#unit_repless_discount_highlight',function(event){

                var unit_rep_cost_check = $('#unit_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit Repless Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#unit_rep_cost_check',function(event){

                var unit_rep_cost_check = $('#unit_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_cost_check)
                {
                    $('#unit_repless_discount_highlight').attr("checked");

                }
                else
                {
                    $("#unit_repless_discount_highlight").prop("checked",false);
                }

            });

			/*Unit Repless Discount %*/
            $(document).on('click','#unit_repless_highlight',function(event){

                var unit_rep_discount_check = $('#unit_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_discount_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Unit Repless Discount %');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#unit_rep_discount_check',function(event){

                var unit_rep_discount_check = $('#unit_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(unit_rep_discount_check)
                {
                    $('#unit_repless_highlight').attr("checked");

                }
                else
                {
                    $("#unit_repless_highlight").prop("checked",false);
                }

            });

			/*System Cost*/
            $(document).on('click','#system_cost_highlight',function(event){

                var system_cost_check = $('#system_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Cost');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_cost_check',function(event){

                var system_cost_check = $('#system_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_cost_check)
                {
                    $('#system_cost_highlight').attr("checked");

                }
                else
                {
                    $("#system_cost_highlight").prop("checked",false);
                }

            });

			/*System Bulk*/
            $(document).on('click','#system_bulk_highlight',function(event){

                var system_bulk_check = $('#system_bulk_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_bulk_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Bulk');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_bulk_check',function(event){

                var system_bulk_check = $('#system_bulk_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_bulk_check)
                {
                    $('#system_bulk_highlight').attr("checked");

                }
                else
                {
                    $("#system_bulk_highlight").prop("checked",false);
                }

            });

			/*System Repless Discount*/
            $(document).on('click','#system_repless_discount_highlight',function(event){

                var system_rep_cost_check = $('#system_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_cost_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Repless Discount');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_rep_cost_check',function(event){

                var system_rep_cost_check = $('#system_rep_cost_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_cost_check)
                {
                    $('#system_repless_discount_highlight').attr("checked");

                }
                else
                {
                    $("#system_repless_discount_highlight").prop("checked",false);
                }

            });

			/*System Repless Discount %*/
            $(document).on('click','#system_repless_highlight',function(event){

                var system_rep_discount_check = $('#system_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_discount_check)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select System Repless Discount %');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_rep_discount_check',function(event){

                var system_rep_discount_check = $('#system_rep_discount_check').prop('checked');
                // console.log(unit_cost_check);
                if(system_rep_discount_check)
                {
                    $('#system_repless_highlight').attr("checked");

                }
                else
                {
                    $("#system_repless_highlight").prop("checked",false);
                }

            });

			/*Reimbursement*/
            $(document).on('click','#reimbursement_highlight',function(event){

                var chk_reimbursement = $('#chk_reimbursement').prop('checked');
                // console.log(unit_cost_check);
                if(chk_reimbursement)
                {
                    $(this).attr("checked");

                }
                else
                {
                    alert('You can also select Reimbursement');
                    $(this).prop("checked",false);
                }

            });

            $(document).on('click','#system_rep_discount_check',function(event){

                var chk_reimbursement = $('#chk_reimbursement').prop('checked');
                // console.log(unit_cost_check);
                if(chk_reimbursement)
                {
                    $('#reimbursement_highlight').attr("checked");

                }
                else
                {
                    $("#reimbursement_highlight").prop("checked",false);
                }

            });
			/*Highlight Section End*/
        });
	</script>

@stop

