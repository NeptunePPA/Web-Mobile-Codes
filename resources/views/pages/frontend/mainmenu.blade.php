@extends('layouts.userlogin')

@section('content')
<script src="{{ URL::asset('frontend/js/jquery-ui.js') }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
<script>
  $( function() {
    $( "#sortable" ).sortable();
   // $( "#sortable" ).disableSelection();
  } );
  </script>
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
	            <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Hospital</a>
                </li>
	            
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
        <!--@if(Session::has('message'))
        <p class="alert alert-danger">{{ Session::get('message') }}</p>
        @endif-->
        @if(isset($categories))
		<ul class="mainmenu-list" id="sortable">
			@foreach($categories as $category)
			<li class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ui-state-default">
				<a href="devices/{{$category->id}}" title="{{ $category->category_name}}">{{ $category->category_name}}</a>
			</li>
			@endforeach
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