<!doctype html>
<html>
<head>
    @include('includes.head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container-fluid">
	<div class="header">
		<div class="logo clearfix">
			<h1><a title="Neptune PPA" href="#"><img src="{{ URL::asset('images/logo.jpg') }}" alt="Neptune PPA" /> </a></h1>
		</div>
	</div>
	<div class="content-area clearfix">
    <div class="add_new">
    	<div class="add_new_box" style="margin-left:0% !important;">
        <h2 style="padding:10px 0;">Our Terms & Conditions</h2>
    <p>
        	The NEPTUNE PPA product and its content (“Licensed Application”) contains confidential and proprietary information which is licensed, not sold, to (CUSTOMER/UVM HN) for use only under the terms of this license.  The licensor NSINC (“Application Provider”) reserves all rights not expressly granted to (Customer/UVM HN).  This license is extended to you as an employee or agent of (CUSTOMER/UVM HH) as a limited non-transferable license to use the Licensed Application on a mobile device.  You may not share, distribute or make the Licensed Application or its content available to any other person or entity.  You may not distribute the Licenses Application or its content over a network where it could be used by multiple devices at the same time. You may not rent, lease, lend, sell, redistribute or sublicense the Licensed Application. You may not copy (except as expressly permitted by this license and the Usage Rules), decompile, reverse engineer, disassemble, attempt to derive the source code of, modify, or create derivative works of the Licensed Application, any updates, or any part thereof (except as and only to the extent any foregoing restriction is prohibited by applicable law or to the extent as may be permitted by the licensing terms governing use of any open sourced components included with the Licensed Application). Any attempt to do so is a violation of the rights of the Application Provider and its licensors.  If you breach this restriction, You may be subject to prosecution and damages by the Application Provider.  The Licensed Application also contains (Customer/UVM HN) confidential information such that if you breach this restriction, you may be subject to disciplinary action or other recourse from (Customer/UVM HN).   
(something to indicate I have read, understood, and agree).

        </p>
        	<div style="display:inline-block;">
            {{ Form::open(array('url'=>'admin/agreeconditionsuser','method'=>'post')) }}
        	<input class="btn_add_new" type="submit" value="AGREE" name="agreebutton" style="width:210px;">
            <input class="btn_add_new" type="submit" value="DISAGREE" name="agreebutton" style="width:210px;  margin-left:10px;">
        	{{ Form::close() }}
            </div>
            </div>
        </div>
    </div>
</div>
@yield('footer')

</body>
</html>