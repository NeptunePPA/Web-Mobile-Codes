@extends('layouts.userlogin')

@section('content')
<div id="mobile-landscape">
	<div class="top-header clearfix">
		    <div class="col-xs-4 col-sm-4 col-md-4 humberhan-icon">
                
                <a class="humber-icon" rel="popover" data-popover-content="#menu-popover" href="#"><img src="{{ URL::asset('frontend/images/menu.png') }}" /></a>
                <span class="clientname">{{$clientname}} | {{$devicetype}}</span>
                <span class="updateddates">Update: {{$updatedate}}</span>
            </div>
            <!-- POPOVER -->    
            <div id="menu-popover" class="hide menu-popover">
                <ul class="menu">
                    <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Hospital</a></li>
                    @if(Auth::user()->roll == '2')
                    <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Project</a></li>
                    @endif 
                    <li class="menu-item"><a href="{{URL::to('menu')}}">Main Menu</a></li>
                    @if($devicetype == "SYSTEM COST")
                    <li class="menu-item"><a href="{{ URL::to('newdevice/mainmenu') }}">Category Menu</a></li>
                    @elseif($devicetype == "UNIT COST")
                    <li class="menu-item"><a href="{{ URL::to('changeout/mainmenu') }}">Category Menu</a></li>
                    @endif
                    @if(Auth::user()->roll == '2')
                    <li class="menu-item"><a href="{{URL::to('scorecard/physician')}}">Scorecards</a></li>
                    <li class="menu-item">
                        <a href="#">Repcasetracker</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter case details</a></li>
                            <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">view / edit case details</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="menu-item"><a href="{{URL::to('scorecard')}}">My Scorecard</a></li>
                    @endif
                    <li class="menu-item"><a href="{{ URL::to('logout') }}">Log out</a></li>
                </ul>
            </div>
		<div class="col-xs-4 col-sm-4 col-md-4 title-text">
			<span>{{$categoryname}}</span>
		</div>
<!--<div class="logout-link">
                <a href="{{ URL::to('logout') }}" style="color:#fff;">Logout</a>
            </div>-->
            <div class="col-xs-4 col-sm-4 col-md-4 inner-logo">
            	<a href="#">
            		<img src="{{ URL::asset('frontend/images/min-logo.png') }}" alt="" />
            	</a>
            	
            </div>			
        </div>
        
        <div class="optional-panel clearfix">
        	<div class="radio entry-level" id="radiodiv1">
        		<label for="entry-level" class="nolabelbg">ENTRY LEVEL TECHNOLOGIES</label> <input type="radio"  name="level" id="entry-level" /><label for="entry-level"></label>
        	</div>
        	<div class="radio" id="radiodiv2">
        		<input type="radio" id="advanced-level" name="level" /><label for="advanced-level">ADVANCED LEVEL TECHNOLOGIES</label>
        	</div>

        </div>
        <div class="main clearfix">
        	<div class="compared-left col-xs-7 col-sm-7 col-md-7 compare-productleft">	
        		<div class="compared-list col-xs-4 col-sm-4 col-md-4">
        			<div class="compared-checkbox clearfix">
        				<div class="compared-inner">	
        					<div class="checkbox">
        						<input type="checkbox" checked="checked" disabled = "True"/> <label></label>				
        					</div>
        					<img src="{{ URL::asset('frontend/images/arrows.png') }}" />
        					<div class="checkbox">
        						<input type="checkbox" checked="checked" disabled = "True"/> <label></label>				
        					</div>
        				</div>	
        			</div>
        			<div class="reload-img">
        				<a href="{{ URL::previous() }}"><img src="{{ URL::asset('frontend/images/refresh.png') }}" /></a>
        			</div>
        			<ul class="compared-modal">
        				<li class="active"><a href="#">Model</a></li>
        				<li><a href="#">{{ $devicetype == 'SYSTEM COST' ? 'System Cost' : 'Unit Cost' }}</a></li>
        				@if($devicetype == "UNIT COST")
        				@if($cco_discount_option == "True")
        				<li><a href="#">CCO</a></li>
        				@endif
        				@endif
        				@if($repless_discount_option == "True")
        				<li><a href="#">Repless</a></li>
        				@endif
        				@if($bulk_option == "True")
        				<li><a href="#">Bulk</a></li>
        				@endif
				<!--<li><a href="#">REIMB</a></li>
                @if($exclusive_option == "True")
				<li><a href="#">Exclusives</a></li>
                @endif
                @if($longevity_option == "True")
				<li><a href="#">Longevity</a></li>
				@endif
                @if($shock_option == "True")
                <li><a href="#">Shock/CT</a></li>
				@endif
                @if($size_option == "True")
                <li><a href="#">Size</a></li>
				@endif
                @if($bulk_option == "True")
                <li><a href="#"><b>Bulk</b></a></li>
				@endif
                @if($siteinfo_option == "True")
                <li><a href="#">Site Info</a></li>
				@endif
				<li class="active"><a href="#">Overall Value</a></li>-->
			</ul>	
		</div>	
		@foreach($first_product as $productdetail)
		<div class="comparision-list col-xs-4 col-sm-4 col-md-4">
			<div class="comparision-inner">
				<div class="clearfix">
					<div class="col-xs-9 col-sm-9 col-md-9 comapred-logo">
                    @if(!empty($productdetail->manufacturer_logo) && file_exists('public/upload/'.$productdetail->manufacturer_logo))
                   <?php $imagezUrl = URL::to('public/upload/'.$productdetail->manufacturer_logo)?>
                   @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                   @endif

						<img src="{{$imagezUrl}}" />
					</div>				
					<div class="checkbox">
						<input type="checkbox" checked="checked" disabled="disabled"/> <label></label>
					</div>
				</div>
                @if(!empty($productdetail->device_image) && file_exists('public/upload/'.$productdetail->device_image))
                   <?php $imagezUrl = URL::to('public/upload/'.$productdetail->device_image)?>
                   @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                   @endif
				<img class="comapred-img" src="{{$imagezUrl}}" />
				<h2>{{$productdetail->device_name}}</h2>
				<ul>
					<li class="system-value {{$devicetype == 'SYSTEM COST' ? $productdetail->system_cost_highlight == "True" ? "highlight" : '' : $productdetail->unit_cost_highlight == "True" ? "highlight" : '' }}">
						${{ $devicetype == 'SYSTEM COST' ? number_format($productdetail->system_cost,2) : number_format($productdetail->unit_cost,2) }}
					</li>
					@if($devicetype == 'UNIT COST')
					@if($cco_discount_option == "True")
					<li class="system-value {{$productdetail->cco_check_hightlight == "True" ? "highlight" : '' }}">
						{{$productdetail->cco_discount == "-" ? '-' : '$'. number_format($productdetail->cco_discount,2)}}
					</li>
					@endif
					@endif
					@if($repless_discount_option == "True")
					<li class="system-value {{$devicetype == 'SYSTEM COST' ? $productdetail->systemrepless_hightlight == "True" ? "highlight" : '' : $productdetail->unitrepless_hightlight == "True" ? "highlight" : '' }}">
						{{ $devicetype == 'SYSTEM COST' 
						?( $productdetail->system_repless_cost == "-" 
						? "-"
						:'$'.number_format($productdetail->system_repless_cost,2)
						) 
						: ( $productdetail->unit_repless_cost == "-" ? "-"
						:'$'.number_format($productdetail->unit_repless_cost,2)
						)
					}}
				</li>
				@endif
				@if($bulk_option == "True")
					@if($devicetype == 'SYSTEM COST')
				<li class="system-value {{$productdetail->system_bulk_highlight == "True" ? "highlight" : '' }}">
					@if($productdetail->system_bulk_check == "True")
					{{  $productdetail->remain_bulk > 0 
					?  $productdetail->remain_bulk
					: "0"
				}}
				@else
				-
				@endif
				@elseif($devicetype == 'UNIT COST')
                        <li class="system-value {{$productdetail->bulk_highlight == "True" ? "highlight" : '' }}">
				@if($productdetail->bulk_check == "True")
				{{  $productdetail->remain_bulk > 0 
				?  $productdetail->remain_bulk
				: "0"
			}}
			@else
			-
			@endif
			@endif
		</li>
		@endif
                               <!-- <li class="green-color">
								{{ $productdetail->reimbursement_check == "True" 
                                	? '$'.number_format($productdetail->reimbursement,2)
                                    : '-'
                                }}
                            </li> -->
                            @if($exclusive_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel">Exclusives:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue">
                            	@if($productdetail->exclusive_check == "True" && $productdetail->exclusive != "" )
                            	{{$productdetail->exclusive}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif

                            @if($longevity_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->longevity_highlight == "True" ? "highlight" : '' }}">Longevity:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->longevity_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->longevity_check == "True" && $productdetail->longevity != "" )
                            	{{$productdetail->longevity}} years
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif


                            @if($shock_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->shock_highlight == "True" ? "highlight" : '' }}">Shock/CT:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->shock_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->shock_check == "True" && $shock_f_product != "00J/00s")
                            	{{$shock_f_product}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif

                            @if($size_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->size_highlight == "True" ? "highlight" : '' }}">Size:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->size_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->size_check == "True" && $size_f_product != "00g/00cc")
                                {{$size_f_product}}
                                @else
                                -
                                @endif
                            </li>
                            @endif
                            
                            @if($research_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->research_highlight == "True" ? "highlight" : '' }}">Research:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->research_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->research_check == "True" && $productdetail->research != ""  )
                            	{{$productdetail->research}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif


                            @if($siteinfo_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->siteinfo_highlight == "True" ? "highlight" : '' }}">Site Info:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue blue-color {{$productdetail->siteinfo_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->siteinfo_check == "True" && $productdetail->site_info != "" )
                            	<a href="{{$productdetail->url}}" target="_blank">{{$productdetail->site_info}}</a>
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif


                               <!-- <li>
								@if($productdetail->overall_value_check == "True")
								{{$productdetail->overall_value}}
								@else
								-
								@endif
							</li> -->
							@foreach($productdetail->custom_fields as $custom)
							@if($custom->field_check == "True")
							<li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_name}}:</li>
							<li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_value}}</li>
							@endif
							@endforeach		
						</ul>
					</div>
				</div>
				@endforeach
				@foreach($second_product as $productdetail)
				<div class="comparision-list col-xs-4 col-sm-4 col-md-4">
					<div class="comparision-inner">
						<div class="clearfix">
							<div class="col-xs-9 col-sm-9 col-md-9 comapred-logo">
                            @if(!empty($productdetail->manufacturer_logo) && file_exists('public/upload/'.$productdetail->manufacturer_logo))
                   <?php $imagezUrl = URL::to('public/upload/'.$productdetail->manufacturer_logo)?>
                   @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                   @endif
								<img src="{{$imagezUrl}}" />
							</div>				
							<div class="checkbox">
								<input type="checkbox" checked="checked" disabled="disabled" /> <label></label>
							</div>
						</div>
                        @if(!empty($productdetail->device_image) && file_exists('public/upload/'.$productdetail->device_image))
                   <?php $imagezUrl = URL::to('public/upload/'.$productdetail->device_image)?>
                   @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                   @endif
                <img class="comapred-img" src="{{$imagezUrl}}" />
						
						<h2>{{$productdetail->device_name}}</h2>
						<ul>
							<li class="system-value {{$devicetype == 'SYSTEM COST' ? $productdetail->system_cost_highlight == "True" ? "highlight" : '' : $productdetail->unit_cost_highlight == "True" ? "highlight" : '' }}">
								${{ $devicetype == 'SYSTEM COST' ? number_format($productdetail->system_cost,2) : number_format($productdetail->unit_cost,2) }}
							</li>
							@if($devicetype == 'UNIT COST')
							@if($cco_discount_option == 'True')
							<li class="system-value {{$productdetail->cco_check_hightlight == "True" ? "highlight" : '' }}">
								{{$productdetail->cco_discount == "-" ? '-' : '$'. number_format($productdetail->cco_discount,2)}}
								@endif
							</li>
							@endif
							@if($repless_discount_option == 'True')
							<li class="system-value {{$devicetype == 'SYSTEM COST' ? $productdetail->systemrepless_hightlight == "True" ? "highlight" : '' : $productdetail->unitrepless_hightlight == "True" ? "highlight" : '' }}">
								{{ $devicetype == 'SYSTEM COST' 
								?( $productdetail->system_repless_cost == "-" 
								? "-"
								:'$'.number_format($productdetail->system_repless_cost,2)
								) 
								: ( $productdetail->unit_repless_cost == "-" ? "-"
								:'$'.number_format($productdetail->unit_repless_cost,2)
								)
							}}
						</li>
						@endif
						@if($bulk_option == "True")
							@if($devicetype == 'SYSTEM COST')
						<li class="system-value {{$productdetail->system_bulk_highlight == "True" ? "highlight" : '' }}">
							@if($productdetail->system_bulk_check == "True")
							{{  $productdetail->remain_bulk > 0 
							?  $productdetail->remain_bulk
							: "0"
						}}
						@else
						-
						@endif
						@elseif($devicetype == 'UNIT COST')
                        <li class="system-value {{$productdetail->bulk_highlight == "True" ? "highlight" : '' }}">
						@if($productdetail->bulk_check == "True")
						{{  $productdetail->remain_bulk > 0 
						?  $productdetail->remain_bulk
						: "0"
					}}
					@else
					-
					@endif
					@endif
				</li>
				@endif
                               <!-- <li class="green-color">
								{{ $productdetail->reimbursement_check == "True" 
                                	? '$'.number_format($productdetail->reimbursement,2)
                                    : '-'
                                }}
                            </li> -->
                            @if($exclusive_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel">Exclusives:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue">
                            	@if($productdetail->exclusive_check == "True" && $productdetail->exclusive != "" )
                            	{{$productdetail->exclusive}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif

                            @if($longevity_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->longevity_highlight == "True" ? "highlight" : '' }}">Longevity:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->longevity_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->longevity_check == "True" && $productdetail->longevity != "" )
                            	{{$productdetail->longevity}} years
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif


                            @if($shock_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->shock_highlight == "True" ? "highlight" : '' }}">Shock/CT:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->shock_highlight == "True" ? "highlight" : '' }}">

                            	@if($productdetail->shock_check == "True" && $shock_s_product != "00J/00s")
                            	{{$shock_s_product}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif

                            @if($size_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->size_highlight == "True" ? "highlight" : '' }}">Size:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->size_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->size_check == "True" && $size_s_product != "00g/00cc")
                            	{{$size_s_product}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif

                            @if($research_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->research_highlight == "True" ? "highlight" : '' }}">Research:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$productdetail->research_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->research_check == "True" && $productdetail->research != "" )
                            	{{$productdetail->research}}
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif


                            @if($siteinfo_option == "True")
                            <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$productdetail->siteinfo_highlight == "True" ? "highlight" : '' }}">Site Info:</li>
                            <li class="col-xs-6 col-sm-6 col-md-6 listvalue blue-color {{$productdetail->siteinfo_highlight == "True" ? "highlight" : '' }}">
                            	@if($productdetail->siteinfo_check == "True" && $productdetail->site_info != "" )
                            	<a href="{{$productdetail->url}}" target="_blank">{{$productdetail->site_info}}</a>
                            	@else
                            	-
                            	@endif
                            </li>
                            @endif


                               <!-- <li>
								@if($productdetail->overall_value_check == "True")
								{{$productdetail->overall_value}}
								@else
								-
								@endif
							</li> -->
							@foreach($productdetail->scustom_fields as $custom)

							@if($custom->field_check == "True")
							<li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_name}}:</li>
							<li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_value}}</li>
							@endif
							@endforeach		
						</ul>
					</div>
				</div>
				@endforeach
			</div>
			<div class="compared-right col-xs-5 col-sm-5 col-md-5">	
				@foreach($first_product as $productdetail)
				{{ Form::open(array('url' => 'purchase','id'=>'firstproductform')) }}
				<input type="hidden" value="{{$devicetype}}" name="devicetype"/>
				<input type="hidden" value="{{$productid}}" name="deviceid"/>


				<div class="delta-panel clearfix"> 
					<div class="delta-left col-xs-7 col-sm-7 col-md-7">
						<ul class="clearfix">
							<li class="col-xs-12 col-sm-12 col-md-12 delta-head">
								- Delta <img src="{{ URL::asset('frontend/images/delta.png') }}" />
							</li>
							<li class="col-xs-6 col-sm-6 col-md-6">{{$devicetype == 'SYSTEM COST' ? ($system_cost_delta_check == "True" ? ('SystemCost:'):"") : ($unit_cost_delta_check == "True" ?('Unit Cost'):"")}} </li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">                               
							{{ $devicetype == "SYSTEM COST"  ? 
							( $system_cost_delta_check == "True" ? ( $system_cost_diff > 0 
							?  "- $". number_format(abs($system_cost_diff),2)
							: "+ $". number_format(abs($system_cost_diff),2)):"" )
							:
							( $unit_cost_delta_check == "True" ? ( $unit_cost_diff > 0 
							?  "- $". number_format(abs($unit_cost_diff),2)
							: "+ $". number_format(abs($unit_cost_diff),2)):"")

						}}
					</li>
					@if($devicetype == 'UNIT COST')

					@if($cco_check_value == 'True' && $cco_discount_delta_check == 'True')
					<li class="col-xs-6 col-sm-6 col-md-6">CCO:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">
                        @if($cco_diff != "")
    					{{$cco_diff > 0 ? "- $".number_format(abs($cco_diff),2)
    					: "+ $".number_format(abs($cco_diff),2)}}
                        @else
                        -
                        @endif
					@endif
				</li>
				@endif


                @if($repless_discount_value == 'True')
                <li class="col-xs-6 col-sm-6 col-md-6">{{$devicetype == 'UNIT COST' ? ($unit_repless_delta_check == "True" ? ('Repless:'):"") : ($system_repless_delta_check == "True" ?('Repless:'):"")}} </li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">                               
                {{ $devicetype == "UNIT COST"  ? 
                ( $unit_repless_delta_check == "True" ? ( $unit_repless_cost_diff > 0 
                ?  "- $". number_format(abs($unit_repless_cost_diff),2)
                : "+ $". number_format(abs($unit_repless_cost_diff),2)):"" )
                :
                ( $system_repless_delta_check == "True" ? ( $system_repless_cost_diff > 0 
                ?  "- $". number_format(abs($system_repless_cost_diff),2)
                : "+ $". number_format(abs($system_repless_cost_diff),2)):"" )

            }}
        </li>
        @endif

        @if($reimbursement_delta_check == "True")
        <li class="col-xs-6 col-sm-6 col-md-6">Reimbursement:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">

        {{$reimbursement_diff > 0 ? " - $".number_format(abs($reimbursement_diff))
        : " + $".number_format(abs($reimbursement_diff))}}
        @endif

        @if($longevity_delta_check == "True")
        <li class="col-xs-6 col-sm-6 col-md-6">Longevity:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">

        {{$longevity_diff > 0 ? "- ".number_format(abs($longevity_diff))
        : "+ ".number_format(abs($longevity_diff))}} years
        @endif

        @if($shock_delta_check == "True")
        <li class="col-xs-6 col-sm-6 col-md-6">Shock/CT:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">
        {{$shock_diff > 0 ? "- ".number_format(abs($shock_diff))
        : "+ ".number_format(abs($shock_diff))}}J/{{$ct_diff > 0 ? "- ".number_format(abs($ct_diff))
        : "+ ".number_format(abs($ct_diff))}}s
       
        @endif

        @if($size_delta_check == "True")
        <li class="col-xs-6 col-sm-6 col-md-6">Size:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">
         {{$size_g_diff > 0 ? "- ".number_format(abs($size_g_diff))
        : "+ ".number_format(abs($size_g_diff))}}g/{{$size_cc_diff > 0 ? "- ".number_format(abs($size_cc_diff))
        : "+ ".number_format(abs($size_cc_diff))}}cc
        @endif

        @if($research_delta_check == "True")
           <li class="col-xs-6 col-sm-6 col-md-6">Research:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">
           @if($research != "")
           {{$research}}
           @else
           -
           @endif
        @endif

        @if($site_info_delta_check == "True")
           <li class="col-xs-6 col-sm-6 col-md-6">Site Info:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">
           @if($siteinfo != "")
           {{$siteinfo}}
           @else
           -
           @endif
        @endif

        @if($overall_value_delta_check == "True")
           <li class="col-xs-6 col-sm-6 col-md-6">Overall Value:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">
           @if($overAll != "")
           {{$overAll}}
           @else
           -
           @endif
           
        @endif

        @if(count($custom_diff) != '0')
        @foreach($custom_diff as $key => $value)
            
            <li class="col-xs-6 col-sm-6 col-md-6">{{$key}}:</li><li class="col-xs-6 col-sm-6 col-md-6 green-txt">

            {{$value}}
           
        @endforeach
        @endif

    </ul>
</div>
<div class="delta-right col-xs-5 col-sm-5 col-md-5">
  <h3>{{$productname}}</h3>
   @if(!empty($productimage) && file_exists('public/upload/'.$productimage))
                   <?php $imagezUrl = URL::to('public/upload/'.$productimage)?>
                   @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                   @endif

  <img class="comapred-img" src="{{$imagezUrl}}" />
  <br>
  <input type="button" value="SELECT" id="select1" data-id="{{$productid}}" />
</div>	
</div>
{{ Form::close() }}
@endforeach


</div>
</div>
</div>

<!-- Survey Modal Start -->
<div id="survey" class="modal fade item-detail-modal" class="survey" role="dialog" aria-labelledby="item-detail-modal">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<center>
					<h4 class="modal-title">Please tell us why you selected this device?</h4>
					<p>(Choose all that apply)</p>
				</center>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="ajax-loader">
						<img src="{{ url('/images/loader.gif') }}" class="img-responsive" />
					</div>
					<center><p class="errorMessage"></p></center>

					<div class="col-sm-offset-2 col-sm-8">
						{{ Form::open(array('url' =>'','method'=>'post','name'=>'surveyAnswer','id'=>'surveyAnswer')) }}
						<div class="row" id="surveycheck">

						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-default surveyButton" data-dismiss="modal">Close</button>
					@if(Auth::user()->roll == 3)
					<button type="button" class="btn btn-danger submitAnswer surveyButton" id="submitAnswer" >Next</button>
					@endif
				</center>
			</div>
		</div>

	</div>

</div>
<!-- Survey MOdal End -->

<div id="warning-message">
	<img src="{{ URL::to('images/Neptune-bg-landscape.png')}}" />
</div>

<script>
    // menu popover Start

    $('[rel="popover"]').popover({
        container: 'body',
        html: true,
        placement: 'bottom',
        content: function() {
            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
            return clone;
        }
    }).click(function(e) {
        e.preventDefault();
    });

    $('body').on('click', function (e) {

        $('[rel="popover"]').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    /*Menu popover end*/

    jQuery( document ).ready(function()  {
      $("#select2").click(function(){

       swal({   
        title: "Are you sure?",   
        text: "You want to order the product!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Yes, Purchase it",   
        cancelButtonText: "No, cancel!",   
        closeOnConfirm: false,   
        closeOnCancel: false, 
    }, 
    function(isConfirm){   
        if (isConfirm) 
        {	
         swal("Purchased!", "Thanks for the order", "success"); 
         $('#secondproductform').submit();
     } 
     else 
     {     
         swal("Cancelled", "Order is cancelled", "error");   
     } 
 });

   });

		// $("#select1").click(function(){
		// 	swal({   
		// 		title: "Are you sure?",   
		// 		text: "You want to order the product!",   
		// 		type: "warning",   
		// 		showCancelButton: true,   
		// 		confirmButtonColor: "#DD6B55",   
		// 		confirmButtonText: "Yes, Order it",   
		// 		cancelButtonText: "No, cancel!",   
		// 		closeOnConfirm: false,   
		// 		closeOnCancel: false,
		// 	}, 
		// 	function(isConfirm){   
		// 		if (isConfirm) 
		// 		{	
		// 			swal("Ordered!", "Thanks for ordering our product", "success"); 
		// 			$('#firstproductform').submit();
		// 		} 
		// 		else 
		// 		{     
		// 			swal("Cancelled", "Order is cancelled", "error");   
		// 		} 
		// 	});
		// });
		
	});

</script>

<!-- Survey Modal Script start -->
<script type="text/javascript">
    $(document).on("click",'#select1',function(){       
        var id = $(this).data('id');
        console.log(id)
        var baseUrl = "{{URL::to('/')}}";
        
        $.ajax({  
            type: "POST",  
            data: {id:id,_token:"{{csrf_token()}}"}, 
            url: "{{URL::to('survey/question')}}",
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            success:function(data){
                var html_data = '';
                console.log(data);
                var devicetype = "{{$devicetype}}";
                if(data.status) {
                    var survey = data.value;
                    console.log(survey);
                    // var devicetype = "{{$devicetype}}";
                    if("{{Auth::user()->roll == 3}}"){

                        html_data +="<input type='hidden' name='deviceId' value='" + data.value.deviceId + "'>";
                        html_data += "<div class='col-xs-12'>";
                        var j = 1;
                        $.each(data.value.survey, function (i, item) {
                            if (item.check == 'True') {
                                html_data += "<div class='checkbox-container'><label class='chk-lbl'><input type='checkbox' name='que[]' value='True' class='queAnswer que_check' data-id ='"+j+"'>&nbsp;" + item.question + "</label><input type='hidden' name='question[]' value='"+item.id+"'><input type='hidden' name='check[]' value='False' id='check-"+j+"'></div>";
                            }
                            j++;
                        });
                        html_data += "</div>";

                        $("#surveycheck").html(html_data);
                        $('#survey').modal('toggle');

                    } else {
                        html_data +="<input type='hidden' name='deviceId' value='" + data.value.deviceId + "'>";
                        html_data += "<div class='col-xs-12'>";
                        $.each(data.value.survey, function (i, item) {
                            if (item.check == 'True') {
                                html_data += "<div class='checkbox-container'><label class='chk-lbl'>" + item.question + "</label></div>";
                            }
                        });
                        html_data += "</div>";


                        $("#surveycheck").html(html_data);

                        $('#survey').modal('toggle');

                    }
                } else{

                    var id = data.value;

                    if("{{Auth::user()->roll == 3}}"){
                        placeOrder(null,id,devicetype);
                    }
                }

            },
        complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        },
    });
});


$(document).on("click",'.submitAnswer',function(){  
    var aChk = $('#surveycheck [type="checkbox"]');
    var devicetype = "{{$devicetype}}";
    var hasVal = false;
    aChk.each(function(i){
        // console.log($(aChk[i]))
        isChk = $(aChk[i]).is(":checked");
        if(isChk){
            hasVal = true;
            return;
        }
    })
    if(hasVal){
      var data = $('#surveyAnswer').serialize();
      $('#survey').modal('toggle');
      $.ajax({
        url: "{{URL::to('survey/questionAnswer')}}",
        data: $('#surveyAnswer').serialize(),
        type: "POST",
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
        }, 
        success: function (checkvalue) {
           var check = checkvalue.value;
           var devicetype = "{{$devicetype}}";

           placeOrder(check['surveyId'],check['deviceid'],devicetype);
       },
       complete: function(){
        $('.ajax-loader').css("visibility", "hidden");
    }
});
  } else{
    $(".errorMessage").html("Please check at least one checkbox.!");
    $("body").click(function(){
        $(".errorMessage").html("");

    });
}

});

function placeOrder(surveyId, deviceid, devicetype){


    swal({   
     title: "Are you sure?",   
     text: "You want to order the product!",   
     type: "warning",   
     showCancelButton: true,   
     confirmButtonColor: "#DD6B55",   
     confirmButtonText: "Yes, Order it",   
     cancelButtonText: "No, cancel!",   
     closeOnConfirm: false,   
     closeOnCancel: false,
     showLoaderOnConfirm: true,
 }, 


 function(isConfirm){  

     if (isConfirm) 
     {
        
        $.ajax({
            url:"{{URL::to('purchase')}}",
            data:{ 
               "devicetype": devicetype,
               "deviceid": deviceid,
               "surveyId": surveyId,
               _token:"{{csrf_token()}}"
           }, 
           type: "POST",
           success:function(result){

            swal("Ordered!", "Thanks for the order", "success"); 

                setTimeout(function(){
                    window.location ='{{URL::to('menu')}}';
                }, 3000);
            }

        });

    } 
    else 
    {     
      swal("Cancelled", "Order is cancelled", "error");   
  } 
});

}

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
</script>
<!-- Survey Modal Script End -->
@endsection