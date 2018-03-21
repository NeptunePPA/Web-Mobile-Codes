@extends('layouts.repcase')
@section('content')
<!-- <div style="margin:-25px 20px 0 0;">
    <a class="menuinfoicon" href="#" title="Info">Info</a>
</div> -->
        <div class="login-panel">
            <div class="header">
                <a class="menuicon" rel="popover" data-popover-content="#menu-popover" href="#"></a>
                
                <h1><img src="{{ URL::asset('/images/logo.jpg') }}" /></h1>
            </div>
          
            <div id="menu-popover" class="hide menu-popover">
                <ul class="menu">
                    @if(Auth::user()->roll == '2')
                        <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Hospital</a></li>
                        <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Project</a></li>
                        <li class="menu-item"><a href="{{URL::to('menu')}}">Main Menu</a></li>

                        <li class="menu-item"><a href="{{URL::to('scorecard/physician')}}">Scorecards</a></li>
                        <li class="menu-item">
                            <a href="#">Repcasetracker</a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter case details</a></li>
                                <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">view / edit case details</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->roll == '5')
                        <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter Case Details</a></li>
                        <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">View/Edit Case Details</a></li>
                    @endif

                    <li class="menu-item"><a href="{{ URL::to('logout') }}">Log out</a></li>
                </ul>
            </div>
           
        </div>
        <div class="rap-case-tracker">
            <div class="case-details-btn-block">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                                <h4 class="rap-case-title">Rep Case Tracker</h4>
                                <a href="{{URL::to('repcasetracker/addcase')}}" class="btn btn-default view-edit-details-btn">Enter Case Details</a>
                                <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-default view-edit-details-btn">View/Edit Case Details</a>
                                <a href="{{ URL::to('logout') }}" class="btn btn-danger logout-btn">Logout</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  @endsection