<?php

use App\clients;
use App\userClients;

$getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
if (Auth::user()->roll == "2") {
    $clients = ['0' => 'All Client'] + clients::whereIn('id', $getuserclients)->where('is_active', 1)->pluck('client_name', 'id')->all();
} else {
    $clients = ['0' => 'All Client'] + clients::where('is_active', 1)->pluck('client_name', 'id')->all();
}
$selectclients = array();
$clientdetails = session('adminclient');
if (count($clientdetails) > 0) {

    $selectclients = $clientdetails[0];
}
// print_r($selectclients);
?>
        <!doctype html>
<html>
<head>
    @include('includes.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')
</head>
<body>
<div class="container-fluid">
    <div class="header">
        <div class="logo clearfix">
            <h1><a title="Neptune PPA" href="#"><img src="{{ URL::asset('images/logo.png') }}" width="300px" height="50px" style="padding-top: 10px" alt="Neptune PPA"/> </a>
            </h1>

            {{--@if(Auth::user()->roll == "2")--}}
            {{ Form::open(array('url' => 'admin/administrator/client','method'=>'POST','files'=>true,'id'=>'target')) }}
            <div class="pull-right">
                {{ Form::select('clients',$clients,$selectclients,array('id'=>'userclientsid')) }}
            </div>
            {{ Form::close() }}
            {{--@endif--}}
        </div>
    </div>

    @include('includes.menu')

    @yield('content')
</div>
@yield('footer')


<script type="text/javascript">

    $(document).ready(function () {
        $('#userclientsid').change(function () {
            $("#target").submit();
        });
    });
</script>
</body>
</html>