@extends('layouts.userlogin')

@section('content')
	<div style="float:right; padding:20px; font-weight:bold;">
	</div>
	<div class="container menu-panel">
		<div class="header">
			<h1><img src="{{ URL::asset('frontend/images/logo.png') }}" /></h1>
		</div>
        <ul class="menu-list">
			<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 changeout">
			<a style="color:#161443;">	
			
        	The NEPTUNE PPA product and its content (“Licensed Application”) contains confidential and proprietary information which is licensed, not sold, to (CUSTOMER/UVM HN) for use only under the terms of this license.  The licensor NSINC (“Application Provider”) reserves all rights not expressly granted to (Customer/UVM HN).  This license is extended to you as an employee or agent of (CUSTOMER/UVM HH) as a limited non-transferable license to use the Licensed Application on a mobile device.  You may not share, distribute or make the Licensed Application or its content available to any other person or entity.  You may not distribute the Licenses Application or its content over a network where it could be used by multiple devices at the same time. You may not rent, lease, lend, sell, redistribute or sublicense the Licensed Application. You may not copy (except as expressly permitted by this license and the Usage Rules), decompile, reverse engineer, disassemble, attempt to derive the source code of, modify, or create derivative works of the Licensed Application, any updates, or any part thereof (except as and only to the extent any foregoing restriction is prohibited by applicable law or to the extent as may be permitted by the licensing terms governing use of any open sourced components included with the Licensed Application). Any attempt to do so is a violation of the rights of the Application Provider and its licensors.  If you breach this restriction, You may be subject to prosecution and damages by the Application Provider.  The Licensed Application also contains (Customer/UVM HN) confidential information such that if you breach this restriction, you may be subject to disciplinary action or other recourse from (Customer/UVM HN).   
(something to indicate I have read, understood, and agree).
		</a>

        <div class="login-btn" style="margin:40px 0;">
        	{{ Form::open(array('url'=>'agreeconditions','method'=>'post')) }}
        	<input type="submit" name="agreebutton" value="Agree" style="width:49%;" />
            <input type="submit" name="agreebutton" value="Disagree" style="width:49%; margin-left:10px;"/>
            {{ Form::close() }}
        </div>
        
        	</li>
		</ul>
	</div>
	
@endsection