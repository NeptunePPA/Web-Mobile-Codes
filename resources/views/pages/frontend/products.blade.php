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
<!--            <div class="logout-link">
                <a href="{{ URL::to('logout') }}" style="color:#fff;">Logout</a>
            </div>-->
            <div class="col-xs-4 col-sm-4 col-md-4 inner-logo">
                <a href="#" id="testtest"><img src="{{ URL::asset('frontend/images/min-logo.png') }}" alt="" /></a>
            </div>
        </div>
        <div class="optional-panel clearfix">
            <div class="radio  entry-level active" id="radiodiv1">
                <label for="entry-level" class="nolabelbg">ENTRY LEVEL TECHNOLOGIES</label> <input type="radio" checked="checked"  name="level" id="entry-level" /><label for="entry-level"></label>
            </div>
            <div class="radio" id="radiodiv2">
                <input type="radio" id="advanced-level" name="level" /><label for="advanced-level">ADVANCED LEVEL TECHNOLOGIES</label>
            </div>

        </div>
        <div class="main chooose-page slider-panel clearfix">
            {{ Form::open(array('id' => 'entrylevelproduct','url'=>'compareproducts','name'=>'entrylevelproduct','method'=>'GET')) }}
            <input type="hidden" value="{{$devicetype}}" name="devicetype" />
            <div class="compared-left col-xs-2 col-sm-2 col-md-2">
                <div class="compared-list col-xs-12 col-sm-12 col-md-12">
                    <div class="compared-checkbox clearfix">
                        <div class="compared-inner">
                            <div class="checkbox">
                                <input type="checkbox" id="entry_check_first" disabled="True"/> <label></label>
                            </div>
                            <!--<a href="javascript:void(0)" id="entrylevelcompare"><img src="{{ URL::asset('frontend/images/arrows.png') }}" /></a>-->
                            <input type="submit" id="compare-submit"  name="submit" value="" />
                            <div class="checkbox">
                                <input type="checkbox" id="entry_check_second" disabled="True"/> <label></label>
                            </div>
                        </div>
                    </div>
                    <div class="reload-img">
                        <a href="{{ URL::current() }}" ><img src="{{ URL::asset('frontend/images/refresh.png') }}" /></a>
                    </div>
                    <ul class="compared-modal" id="entry_menu">
                        <li class="active"><a href="#">Model</a></li>
                        @if($devicetype == 'UNIT COST')
                        <li><a href="#">Unit Cost</a></li>
                        @elseif($devicetype == 'SYSTEM COST')
                        <li><a href="#">System Cost</a></li>
                        @endif

                        @if($devicetype == 'UNIT COST')
                        @if($ccocost_option == "True" || $ccodiscount_option == "True")
                        <li><a href="#">CCO</a></li>
                        @endif
                        @endif

                        @if($replesscost_option == "True" || $replessdiscount_option == "True")
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
                                                            <li><a href='#'>Size</a></li>
                                                        @endif
                                                        @if($bulk_option == "True")
                                                            <li><a href="#"><b>Bulk</b></a></li>
                                                        @endif
                                                        @if($siteinfo_option == "True")
                                                            <li><a href="#">Site Info</a></li>
                                                        @endif
                                                        <li class="active"><a href="#">Overall Value</a></li>
                                                        @foreach($entry_custom_fields as $custom)
                                                            <li>
                                                            @if($custom->field_check == "True")
                                                            <a href="#">{{$custom->field_name}}</a>
                                                            @endif
                                                            </li>
                                                            @endforeach-->

                                                        </ul> 
                                                        <ul class="compared-modal" id="advance_menu">
                                                            <li class="active"><a href="#">Model</a></li>
                                                            @if($devicetype == 'UNIT COST')
                                                            <li><a href="#">Unit Cost</a></li>
                                                            @elseif($devicetype == 'SYSTEM COST')
                                                            <li><a href="#">System Cost</a></li>
                                                            @endif

                                                            @if($devicetype == 'UNIT COST')
                                                            @if($advance_ccodiscount_option == "True" || $advance_ccocost_option == "True")
                                                            <li><a href="#">CCO</a></li>
                                                            @endif
                                                            @endif

                                                            @if($advance_replesscost_option == "True" || $advance_replessdiscount_option == "True")
                                                            <li><a href="#">Repless</a></li>
                                                            @endif
                                                            @if($advance_bulk_option == "True")
                                                            <li><a href="#">Bulk</a></li>
                                                            @endif
                                        <!--<li><a href="#">REIMB</a></li>
                                        @if($advance_exclusive_option == "True")
                                            <li><a href="#">Exclusives</a></li>
                                        @endif
                                        @if($advance_longevity_option == "True")
                                            <li><a href="#">Longevity</a></li>
                                        @endif
                                        @if($advance_shock_option == "True")
                                            <li><a href="#">Shock/CT</a></li>
                                        @endif
                                        @if($advance_size_option == "True")
                                            <li><a href='#'>Size</a></li>
                                        @endif
                                        @if($advance_bulk_option == "True")
                                            <li><a href="#"><b>Bulk</b></a></li>
                                        @endif
                                        @if($advance_siteinfo_option == "True")
                                            <li><a href="#">Site Info</a></li>
                                        @endif
                                        <li class="active"><a href="#">Overall Value</a></li>
                                        @foreach($advance_custom_fields as $custom)
                                            <li>
                                            @if($custom->field_check == "True")
                                            <a href="#">{{$custom->field_name}}</a>
                                            @endif
                                            </li>
                                            @endforeach-->


                                        </ul>
                                    </div>  
                                </div>
                                <div class="sliders" id="slider-panel1">
                                    <div class="compared-right col-xs-10 col-sm-10 col-md-10 compare-outer">    
                                        <div class="compare-overflow">
                                            @foreach($entry_levels as $entry_level)
                                            <div class="comparision-list col-xs-3 col-sm-3 col-md-3">
                                                <div class="comparision-inner">
                                                    <div class="clearfix">
                                                        <div class="col-xs-11 col-sm-9 col-md-9 comapred-logo">

                                                        @if(!empty($entry_level->manufacturer_logo) && file_exists('public/upload/'.$entry_level->manufacturer_logo))
                                                       <?php $imagezUrl = URL::to('public/upload/'.$entry_level->manufacturer_logo)?>
                                                       @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                                                       @endif
                                                            <img src="{{$imagezUrl}} " />
                                                        </div>              
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="product_check" name="product_chk[]" value="{{$entry_level->id}}"/> <label></label>
                                                        </div>
                                                    </div>

                                                @if(!empty($entry_level->device_image) && file_exists('public/upload/'.$entry_level->device_image))
                                                       <?php $imagezUrl = URL::to('public/upload/'.$entry_level->device_image)?>
                                                       @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                                                       @endif

                                                    <img class="comapred-img survey" src="{{$imagezUrl}}" id="{{$entry_level->id}}"  data-id="{{$entry_level->id}}" />
                                                    <h2 id="deviceHeading-{{$entry_level->id}}">{{$entry_level->device_name}}</h2>
                                                    <ul>

                                                            @if($devicetype == 'UNIT COST')
                                                <li class="system-value {{$entry_level->unit_cost_highlight == "True" ? "highlight" : '' }}">
                                                            ${{number_format($entry_level->unit_cost,2)}}
                                                            @elseif($devicetype == 'SYSTEM COST')
                                                <li class="system-value {{$entry_level->system_cost_highlight == "True" ? "highlight" : '' }}">
                                                            ${{number_format($entry_level->system_cost,2)}}
                                                            @endif
                                                        </li>
                                                        @if($devicetype == 'UNIT COST')
                                                        @if($ccocost_option == "True" || $ccodiscount_option == "True")
                                                        <li class="system-value {{$entry_level->cco_check_hightlight == "True" ? "highlight" : '' }}">
                                                            {{$entry_level->cco_discount == "-" ? '-' : '$'. number_format($entry_level->cco_discount,2)}}
                                                        </li>
                                                        @endif
                                                        @endif
                                                        @if($replesscost_option == "True" || $replessdiscount_option == "True")
                                                        <li class="system-value {{$devicetype == 'SYSTEM COST' ? $entry_level->systemrepless_hightlight == "True" ? "highlight" : '' : $entry_level->unitrepless_hightlight == "True" ? "highlight" : '' }}">
                                                            @if($devicetype == 'SYSTEM COST')
                                                            {{$entry_level->repless_cost == "-" ? '-' : '$'. number_format($entry_level->repless_cost,2)}}
                                                            @elseif($devicetype == 'UNIT COST')
                                                            {{$entry_level->unit_repless_cost == "-" ? '-' : '$'. number_format($entry_level->unit_repless_cost,2)}}
                                                            @endif
                                                        </li>
                                                        @endif
                                                        @if($bulk_option == "True")

                                                            @if($devicetype == 'SYSTEM COST')
                                                            <li class="system-value {{$entry_level->system_bulk_highlight == "True" ? "highlight" : '' }}">
                                                        @if($entry_level->system_bulk_check == "True")
                                                            {{  $entry_level->remain_bulk > 0
                                                            ?  $entry_level->remain_bulk
                                                            : "0"
                                                        }}
                                                        @else
                                                        -
                                                        @endif
                                                        @elseif($devicetype == 'UNIT COST')
                                                            <li class="system-value {{$entry_level->bulk_highlight == "True" ? "highlight" : '' }}">
                                                        @if($entry_level->bulk_check == "True")
                                                        {{  $entry_level->remain_bulk > 0
                                                        ?  $entry_level->remain_bulk
                                                        : "0"
                                                    }}
                                                    @else
                                                    -
                                                    @endif
                                                    @endif
                                                </li>
                                                @endif
                                                @if($exclusive_option == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel ">Exclusives:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue">
                                                    @if($entry_level->exclusive_check == "True")
                                                    {{$entry_level->exclusive}}
                                                    @else
                                                    -
                                                    @endif
                                                </li>
                                                @endif

                                                @if($longevity_option == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$entry_level->longevity_highlight == "True" ? "highlight" : '' }}">Longevity:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$entry_level->longevity_highlight == "True" ? "highlight" : '' }}">
                                                    @if($entry_level->longevity_check == "True")
                                                    {{$entry_level->longevity}} years
                                                    @else
                                                    -
                                                    @endif
                                                </li>
                                                @endif
                                                @if($shock_option == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$entry_level->shock_highlight == "True" ? "highlight" : '' }}">Shock/CT:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$entry_level->shock_highlight == "True" ? "highlight" : '' }}">
                                                    @if($entry_level->shock_check == "True" && $entry_level->shock != "")
                                                    {{$entry_level->shock[0]}}J/{{$entry_level->shock[1]}}s
                                                    @else
                                                    -
                                                    @endif
                                                </li>
                                                @endif
                                                @if($size_option == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$entry_level->size_highlight == "True" ? "highlight" : '' }}">Size:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$entry_level->size_highlight == "True" ? "highlight" : '' }}">
                                                    @if($entry_level->size_check == "True" && $entry_level->size != "")
                                                    {{$entry_level->size[0]}}g/{{$entry_level->size[1]}}cc
                                                    @else
                                                    -
                                                    @endif
                                                </li>
                                                @endif

                                                @if($research_option == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$entry_level->research_highlight == "True" ? "highlight" : '' }}">Research:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$entry_level->research_highlight == "True" ? "highlight" : '' }}">
                                                    @if($entry_level->research_check == "True" && $entry_level->research != "" )
                                                    {{$entry_level->research}}
                                                    @else
                                                    -
                                                    @endif
                                                </li>
                                                @endif



                                                @if($siteinfo_option == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$entry_level->siteinfo_highlight == "True" ? "highlight" : '' }}">Site Info:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue blue-color {{$entry_level->siteinfo_highlight == "True" ? "highlight" : '' }}">
                                                    @if($entry_level->siteinfo_check == "True" && $entry_level->site_info != "" )
                                                    <a href="{{$entry_level->url}}" target="_blank">{{$entry_level->site_info}}</a>
                                                    @else
                                                    -
                                                    @endif
                                                </li>
                                                @endif
                                                @foreach($entry_level->custom_fields as $custom)
                                                @if($custom->field_check == "True")
                                                <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_name = $custom->field_name ==""?"-":$custom->field_name}}:</li>
                                                <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_value = $custom->field_value ==""?"-":$custom->field_value}}</li>
                                                @endif
                                                @endforeach







                                            </ul>

                                        </div>
                                        <div><input type="button" class="mybutton btn btn-info btn-block myModal" data-toggle="modal" data-target="#myModal"  data-id="{{$entry_level->id}}" name="Rep" value="Rep Contact Info" />

                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="sliders" id="slider-panel2"  style="display:none">
                            <div class="compared-right col-xs-10 col-sm-10 col-md-10 compare-outer">
                                <div class="compare-overflow">
                                    @foreach($advance_levels as $advance_level)
                                    <div class="comparision-list col-xs-3 col-sm-3 col-md-3">
                                        <div class="comparision-inner">
                                            <div class="clearfix">
                                                <div class="col-xs-11 col-sm-9 col-md-9 comapred-logo">

                                                @if(!empty($advance_level->manufacturer_logo) && file_exists('public/upload/'.$advance_level->manufacturer_logo))
                                                       <?php $imagezUrl = URL::to('public/upload/'.$advance_level->manufacturer_logo)?>
                                                       @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                                                       @endif
                                                            <img src="{{$imagezUrl}} " />
                                                </div>              
                                                <div class="checkbox">
                                                    <input type="checkbox" class="product_check" name="product_chk[]" value="{{$advance_level->id}}"/> <label></label>
                                                </div>
                                            </div>

                                             @if(!empty($advance_level->device_image) && file_exists('public/upload/'.$advance_level->device_image))
                                                       <?php $imagezUrl = URL::to('public/upload/'.$advance_level->device_image)?>
                                                       @else<?php $imagezUrl = URL::to('public/upload/default.jpg') ?>
                                                       @endif

                                            <img class="comapred-img survey" src="{{$imagezUrl}}" id="{{$advance_level->id}}"  data-id="{{$advance_level->id}}" />
                                            <h2 id="deviceHeading-{{$advance_level->id}}">{{$advance_level->device_name}}</h2>
                                            <ul>
                                                    @if($devicetype == 'UNIT COST')
                                                <li class="system-value {{$advance_level->unit_cost_highlight == "True" ? "highlight" : '' }}">
                                                    ${{number_format($advance_level->unit_cost,2)}}
                                                    @elseif($devicetype == 'SYSTEM COST')
                                                <li class="system-value {{$advance_level->system_cost_highlight == "True" ? "highlight" : '' }}">
                                                    ${{number_format($advance_level->system_cost,2)}}

                                                    @endif
                                                </li>
                                                @if($devicetype == 'UNIT COST')
                                                @if($advance_ccodiscount_option == "True" || $advance_ccocost_option == "True")
                                                <li class="system-value {{$advance_level->cco_check_hightlight == "True" ? "highlight" : '' }}">
                                                    {{$advance_level->cco_discount == "-" ? '-' : '$'. number_format($advance_level->cco_discount,2)}}
                                                </li>
                                                @endif
                                                @endif
                                                @if($advance_replesscost_option == "True" || $advance_replessdiscount_option == "True")
                                                <li class="system-value {{$devicetype == 'SYSTEM COST' ? $advance_level->systemrepless_hightlight == "True" ? "highlight" : '' : $advance_level->unitrepless_hightlight == "True" ? "highlight" : '' }}">
                                                    @if($devicetype == 'SYSTEM COST')
                                                    {{$advance_level->repless_cost == "-" ? '-' : '$'. number_format($advance_level->repless_cost,2)}}
                                                    @elseif($devicetype == 'UNIT COST')
                                                    {{$advance_level->unit_repless_cost == "-" ? '-' : '$'. number_format($advance_level->unit_repless_cost,2)}}
                                                    @endif
                                                </li>
                                                @endif
                                                @if($advance_bulk_option == "True")
                                                    @if($devicetype == 'SYSTEM COST')
                                                    <li class="system-value {{$advance_level->system_bulk_highlight == "True" ? "highlight" : '' }}">
                                                    @if($advance_level->system_bulk_check == "True")
                                                    {{  $advance_level->remain_bulk > 0
                                                    ?  $advance_level->remain_bulk
                                                    : "0"
                                                }}
                                                @else
                                                -
                                                @endif
                                                 @elseif($devicetype == 'UNIT COST')
                                                     <li class="system-value {{$advance_level->bulk_highlight == "True" ? "highlight" : '' }}">
                                                @if($advance_level->bulk_check == "True")
                                                {{  $advance_level->remain_bulk > 0
                                                ?  $advance_level->remain_bulk
                                                : "0"
                                            }}
                                            @else
                                            -
                                            @endif
                                            @endif
                                        </li>
                                        @endif
                                        @if($advance_exclusive_option == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel">Exclusives:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue">
                                            @if($advance_level->exclusive_check == "True" && $advance_level->exclusive != "" )
                                            {{$advance_level->exclusive}}
                                            @else
                                            -
                                            @endif
                                        </li>
                                        @endif

                                        @if($advance_longevity_option == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$advance_level->longevity_highlight == "True" ? "highlight" : '' }}">Longevity:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$advance_level->longevity_highlight == "True" ? "highlight" : '' }}">
                                            @if($advance_level->longevity_check == "True" && $advance_level->longevity != "" )
                                            {{$advance_level->longevity}} years
                                            @else
                                            -
                                            @endif
                                        </li>
                                        @endif
                                        @if($advance_shock_option == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$advance_level->shock_highlight == "True" ? "highlight" : '' }}">Shock/CT:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$advance_level->shock_highlight == "True" ? "highlight" : '' }}">
                                            @if($advance_level->shock_check == "True" && $advance_level->shock != "")
                                            {{$advance_level->shock[0]}}J/{{$advance_level->shock[1]}}s
                                            @else
                                            -
                                            @endif
                                        </li>
                                        @endif
                                        @if($advance_size_option == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$advance_level->size_highlight == "True" ? "highlight" : '' }}">Size:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$advance_level->size_highlight == "True" ? "highlight" : '' }}">
                                            @if($advance_level->size_check == "True" && $advance_level->size != "")
                                            {{$advance_level->size[0]}}g/{{$advance_level->size[1]}}cc
                                            @else
                                            -
                                            @endif
                                        </li>
                                        @endif

                                        @if($advance_research_option == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$advance_level->research_highlight == "True" ? "highlight" : '' }}">Research:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$advance_level->research_highlight == "True" ? "highlight" : '' }}">
                                            @if($advance_level->research_check == "True" &&$advance_level->research != "" )
                                            {{$advance_level->research}}
                                            @else
                                            -
                                            @endif
                                        </li>
                                        @endif

                                        @if($advance_siteinfo_option == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$advance_level->siteinfo_highlight == "True" ? "highlight" : '' }}">Site Info:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue blue-color {{$advance_level->siteinfo_highlight == "True" ? "highlight" : '' }}">
                                            @if($advance_level->siteinfo_check == "True" &&$advance_level->site_info != "")
                                            <a href="{{$advance_level->url}}" target="_blank">{{$advance_level->site_info}}</a>
                                            @else
                                            -
                                            @endif
                                        </li>
                                        @endif
                                        @foreach($advance_level->custom_fields as $custom)
                                        @if($custom->field_check == "True")
                                        <li class="col-xs-6 col-sm-6 col-md-6 listlabel {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_name = $custom->field_name == "" ? "-":$custom->field_name }}:</li>
                                        <li class="col-xs-6 col-sm-6 col-md-6 listvalue {{$custom->fileld_highlight == "True" ? "highlight" : '' }}">{{$custom->field_value = $custom->field_value == ""?"-":$custom->field_value}}</li>
                                        @endif
                                        @endforeach


                                    </ul>
                                </div>
                                <div><input type="button" class="mybutton btn btn-info btn-block myModal" data-toggle="modal" data-target="#myModal"  data-id="{{$advance_level->id}}" name="Rep" value="Rep Contact Info" />
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
        <!-- Rep Contact info Modal start -->
        <div class="modal fade person-detail-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="person-detail-modal" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header repinfo_header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modelHead">Rep Contact info for ClientNames | Company + Device Name</h4>
            </div>

            <div class="modal-body">

              <div class="ajax-loader row">
                  <img src="{{ url('/images/loader.gif') }}" class="img-responsive" />
              </div>

              <div class="" id="repcontact">

              </div>

          </div>
    </div>
</div>
</div
<!-- Rep Contact Info Modal end -->
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
    jQuery( document ).ready(function()  {
     $('#entry_menu').show();
     $('#advance_menu').hide();
     $('#entry-level').on('click', function () {
        $('#slider-panel2').hide();
        $('#slider-panel1').show();
        $('#radiodiv2').removeClass('active');
        $('#radiodiv1').addClass('active');
        $('#slider-panel1').animate({
            'left': '15%'
        });
        $('#slider-panel2').css('left', '-100%');
        $('#entry_menu').show();
        $('#advance_menu').hide();

    });
     $('#advanced-level').on('click', function () {
        $('#slider-panel1').hide();
        $('#slider-panel2').show();
        $('#radiodiv1').removeClass('active');
        $('#radiodiv2').addClass('active');
                // e.preventDefault();
                $('#slider-panel2').animate({
                    'left': '15%'
                });
                $('#slider-panel1').css('left', '-100%');
                $('#entry_menu').hide();
                $('#advance_menu').show();
            });

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



});

   $('body').on('click', function (e) {

        $('[rel="popover"]').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    $('.proimg').click(function(){

  //       var deviceid = this.id;
  //       var devicetype = "{{$devicetype}}";

  //       swal({
  //        title: "Are you sure?",
  //        text: "You want to order the product!",
  //        type: "warning",
  //        showCancelButton: true,
  //        confirmButtonColor: "#DD6B55",
  //        confirmButtonText: "Yes, Order it",
  //        cancelButtonText: "No, cancel!",
  //        closeOnConfirm: false,
  //        closeOnCancel: false,
  //        showLoaderOnConfirm: true,
  //    },

  //    function(isConfirm){

  //        if (isConfirm)
  //        {

  //         $.ajax({
  //             url:"../../{{'purchase'}}",
  //             data:{
  //              "devicetype": devicetype,
  //              "deviceid": deviceid,
  //          },success:function(result){

  //           swal("Ordered!", "Thanks for ordering our product", "success");
  //               setTimeout(function(){
  //                   location.reload();
  //               }, 3000);


  //           }


  //       });

  //     }
  //     else
  //     {
  //         swal("Cancelled", "Order is cancelled", "error");
  //     }
  // });

});


    $('.product_check').change(function() {

        if($(".product_check:checked").length <= 2)
        {

            if($(".product_check:checked").length == 1)
            {
               $("#entry_check_first").prop('checked',true);
               $("#entry_check_second").prop('checked',false);
           }
           else if($(".product_check:checked").length == 2)
           {
               $("#entry_check_second").prop('checked',true);
           }
           else
           {
               $("#entry_check_first").prop('checked',false);
           }
       }
       else
       {
        $(this).prop('checked',false);
        alert('Please select any two products');
        return false;
    }

});
    $('body').on('click', '#entrylevelcompare', function(ev){

       ev.preventDefault();
       if($(".product_check:checked").length == 2)
       {
//                            
console.log(document.entrylevelproduct);
document.entrylevelproduct.submit();
console.log(document.entrylevelproduct);
document.getElementById('testtest').click();
//                            document.entrylevelproduct.submit();
//                            document.getElementById('entrylevelproduct').submit();
//                            $( "#entrylevelproduct" ).submit();
//                            alert(1);
}
else
{

    $(this).prop('checked',false);
    alert('Please select any two products');
}
});
    $('body').on('click', '#compare-submit', function(ev){

        if($(".product_check:checked").length == 2)
        {
            console.log(1);
            return true;
        }
        else
        {

            $(this).prop('checked',false);
            alert('Please select any two products');
            return false;
        }
    });


    function entrylevelcompare()
    {

    }

    function reload_entry()
    {
     location.reload();
     $('#entrylevelproduct')[0].reset();
 }

</script>
<!-- Rep contact info modal Start -->
<script type="text/javascript">
    $(document).on("click",'.myModal',function(){
        var id = $(this).data('id');
        var deviceName = $("#deviceHeading-"+id).text();
        var clientName = $('.client').text();
        var baseUrl = "{{URL::to('/')}}";
        $.ajax({
            type: "POST",
            beforeSend: function(){
                $('.ajax-loader').css("visibility", "visible");
            },
            data: {id:id,_token:"{{csrf_token()}}"},
            url: "{{URL::to('repcontact/info')}}",

            success:function(data){
                var html_data = '';

                if (data.value.rep.status) {
                    html_data +="<div class='left-part'><div class='black-part'><div class='caption'><p class='name'>Rep Name:</p><p class='email'>Email:</p><p class='mobile'>Mobile:</p><p class='title'>Title:</p><p class='company'>Company:</p></div></div></div><div class='right-part'><div class='right-wrapper'><div class='right-container clearfix'>";



                    $.each(data.value.rep.data, function (i, item) {

                        var mobile = item.mobile == null ? "-": item.mobile;
                        var title = item.title == null ? "-": item.title;
                        var image = item.profilePic == null ? "upload/default.png" : "upload/user/" + item.profilePic;

                        html_data +="<div class='single-person-detail'><div class='thumbnail'><img src='" + baseUrl + "/public/"+ image +"' alt='person' class='img-circle person-img'><div class='caption'><p class='name'>"+item.name+"</p><p class='email'><a href='mailto:" + item.email + "'>"+item.email+"</a></p><p class='mobile'><a href='tel:"+ mobile +"'>" + mobile + "</a></p><p class='title'>" + title + "</p><p class='company'>" + item.manufacturer_name + "</p></div></div></div>";



                    });
                    html_data +="</div></div></div>";
                } else {
                    html_data = "<div class='col-sm-12'  align='center'> " + data.value.rep.data + "</div"
                }

            var modelHead = "Rep Contact info for " + data.value.clientName + " | "+ data.value.manufacturer + " " + deviceName;


            $("#modelHead").text(modelHead);
            $("#repcontact").html(html_data);

        },

        complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });

    });
</script>
<!-- Rep Contact info modal  End -->

<!-- Survey Modal Script start -->
<script type="text/javascript">
    $(document).on("click",'.survey',function(){
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
            url:"../../{{'purchase'}}",
            data:{
             "devicetype": '{{$devicetype}}',
             "deviceid": deviceid,
             "surveyId": surveyId
         },
         success:function(result){

            swal("Ordered!", "Thanks for the order", "success");

                    setTimeout(function(){
                        location.reload();
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

