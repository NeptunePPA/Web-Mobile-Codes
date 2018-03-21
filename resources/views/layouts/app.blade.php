<!DOCTYPE html>
<html lang="en">
<head>
	<title>Neptune PPA - Devices</title>
	<script src="{{ URL::asset('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<link href="{{ URL::asset('css/reset.css') }}" type="text/css" rel="stylesheet" media="all" />
	<link href="{{ URL::asset('css/style.css') }}" type="text/css" rel="stylesheet" media="all" />
	<link href="{{ URL::asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" media="all" />
	<!-- client meta -->
	<meta name="apple-mobile-web-app-title" content="Neptune PPA" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon-iphone.png') }}" />
	<link rel="shortcut icon" href="{{ asset('frontend/images/apple-touch-icon-iphone.png') }}">
	<!-- client meta -->
</head>
<body>
<div class="container-fluid">
	<div class="header">
		<div class="logo clearfix">
			<h1><a title="Neptune PPA" href="#"><img src="{{ URL::asset('images/logo.png') }}" width="300px" height="50px" style="padding-top: 10px; alt="Neptune PPA" /> </a></h1>
		</div>

	</div>
	@yield('content')
</div>
</html>
