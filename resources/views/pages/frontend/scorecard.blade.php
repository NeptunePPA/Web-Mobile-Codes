@extends('layouts.userlogin')

@section('content')
    <div id="mobile-landscape">
        <div class="top-header clearfix">
            <div class="col-xs-4 col-sm-4 col-md-4 humberhan-icon">
                
                <a class="humber-icon" rel="popover" data-popover-content="#menu-popover" href="#"><img src="{{ URL::asset('frontend/images/menu.png') }}" /></a>
                <span class="clientname">{{$clientname}} | {{$projectname}}</span>
                <span class="updateddates">Update: {{ Carbon\Carbon::parse($scorecarddate['created_at'])->format('m/d/Y')}}</span>
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
            <span>Physician | {{$username}}</span>
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
    
    <div class="row scorecarback">
        
        <center>
            <div class="col-sm-12 scorecardfront">
                <div class="">
                    <div class="scorecarddiv">
                        {{Form::select('name', $year,'', array('class' => 'name','id'=>'year'))}}
                    </div>
                    {{Form::hidden('userId',$userId,array('id'=>'userId'))}}
                    <div class="scorecarddiv">
                        {{Form::select('name',array(''=>'Select Month'), '', array('class' => 'name','id'=>'month'))}}
                    </div>        
                </div>
            </div>
        </center>
    <br>
    </div>

    <div class="scorecardfooter">
    <br>
        <span class="scorecardbuttons">
                @if(Auth::user()->roll == '1')
                <a href="{{URL::to('scorecard')}}"><i class="fa fa-calendar calendar-icon" aria-hidden="true"></i></a>
                @else
                <a href="{{URL::to('scorecard/year/'.$userId)}}"><i class="fa fa-calendar calendar-icon" aria-hidden="true"></i></a>
                @endif
                @if(Auth::user()->roll == '2')
                <a href="{{URL::to('scorecard/physician')}}"><i class="fa fa-user-md" aria-hidden="true"></i></a>
                @endif
                <a href="{{URL::to('menu')}}"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
        </span>
    </div>
    </div> 
<div id="warning-message">
	<img src="{{ URL::to('images/Neptune-bg-landscape.png')}}" />
</div>



<script>
$(document).ready(function(){
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
    
      $(document).on("change",'#year',function (e) {

                var scoreId = document.getElementById("year").value;
                var userId = document.getElementById("userId").value;
                
                if(scoreId != "")
                {
                     $.ajax({
                        url: "{{ URL::to('scorecard/getmonth')}}",
                        type: "POST",
                        data: {
                             _token: "{{ csrf_token() }}",
                            scoreId: scoreId,
                            userId:userId
                        },
                        success: function (data)
                        {
                          
                            var html_data = '';
                            if (data.status) {
                                html_data += "<option value=''>Select Month</option>";
                                $.each(data.value, function (i, item) {
                                    
                                    html_data += "<option value=" + item.id + ">" + item.month + "</option>";

                                });
                            } else
                            {
                                html_data = "<option value=''>Select Month</option>";
                            }
                           
                            $("#month").html(html_data);

                        }

                        });
                }
        });

        $(document).on("change",'#month',function () {

              var scoreId = document.getElementById("month").value;
              
                if(scoreId != "")
                {
                    var url = '{{URL::to("scorecard/scorecardimage/")}}' ;
                    var path = url +"/"+scoreId;
                    
                    window.location.href = path;
                }
        });

});
</script>

@endsection

