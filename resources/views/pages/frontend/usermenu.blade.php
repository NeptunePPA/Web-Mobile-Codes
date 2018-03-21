@extends('layouts.userlogin')

@section('content')
	<div style="margin:10px 20px 0 0;">
	    <a class="menuinfoicon" href="#" title="Info">Info</a>
	</div>
	<div class="container menu-panel">
		<div class="header">
        	<a class="menuicon" rel="popover" data-popover-content="#menu-popover" href="#"></a>
        	<!-- <a class="info-icon" href="#" title="Info">Info</a> -->
        	<h1><img src="{{ URL::asset('frontend/images/logo.png') }}" /></h1>
    	</div>
	    <!-- POPOVER -->
	    <div id="menu-popover" class="hide menu-popover">
	        <ul class="menu">
	            <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Hospital</a></li>
	             @if(Auth::user()->roll == '2')
                    <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Project</a></li>
                 @endif
	            <li class="menu-item"><a href="{{URL::to('menu')}}">Main Menu</a></li>
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
        @if($nodevice == "False")
		<ul class="menu-list">
			<li class="col-xs-6 col-sm-6 col-md-6 col-lg-6 changeout">
				<a href="{{ URL::asset('changeout/mainmenu') }}">
					<div class="menu-img">
						<img src="{{ URL::asset('frontend/images/changeout.png') }}" />
					</div>
					<span>UNIT COST</span>
				</a>
			</li>
			<li class="col-xs-6 col-sm-6 col-md-6 col-lg-6 newdevice">
				<a href="{{ URL::asset('newdevice/mainmenu') }}">
					<div class="menu-img">
						<img src="{{ URL::asset('frontend/images/newdevice.png') }}" />
					</div>	
					<span>SYSTEM COST</span>
				</a>
			</li
		</ul>
        @else
        <p class="alert alert-danger">There is no device available!</p>
        @endif
	</div>
<script>
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
</script>
@endsection