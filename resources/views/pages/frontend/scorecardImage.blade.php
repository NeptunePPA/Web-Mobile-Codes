@extends('layouts.userlogin')

@section('content')
    <style type="text/css">
        .scorecard {
            padding-bottom: 54px;
            padding-top: 55px;
        }
        .scorecardfooter {
            position: fixed;
            bottom: 0;
            z-index: 3;
        }
        .scorecardheader {
            position: fixed;
            top: 0;
            z-index: 4;
            width: 100%;
        }


    </style>
    <div id="mobile-landscape">
        <div class="top-header clearfix scorecardheader">
            <div class="col-xs-4 col-sm-4 col-md-4 humberhan-icon">

                <a class="humber-icon" rel="popover" data-popover-content="#menu-popover" href="#"><img
                            src="{{ URL::asset('frontend/images/menu.png') }}"/></a>
                <span class="clientname">{{$clientname}} | {{$projectname}}</span>
                <span class="updateddates">Update: {{ Carbon\Carbon::parse($score['created_at'])->format('m/d/Y')}}</span>
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
                                <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter case
                                        details</a></li>
                                <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">view / edit case
                                        details</a></li>
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
                    <img src="{{ URL::asset('frontend/images/min-logo.png') }}" alt=""/>
                </a>

            </div>
        </div>


        <div class="row content-container scorecarback scorecard">
            <br>
            <div class="col-xs-12">
                <div style="padding: 5px;">
                <table class="table">
                    <thead>
                    <tr>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" style="background: #93bae987;font-weight: bold;">Doctor</th>
                        <td>{{$users['name']}}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background: #93bae987;font-weight: bold;">Doctor Clients</th>
                        <td>{{$clientname}}</td>

                    </tr>
                    <tr>
                        <th scope="row" style="background: #93bae987;font-weight: bold;">Month</th>
                        <td>{{$score->months->month}} {{$score['year']}}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background: #93bae987;font-weight: bold;">Cost Differential</th>
                        <td style="color: red">$ {{$costdiff}}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background: #93bae987;font-weight: bold;">Total Spend</th>
                        <td>$ {{$totalspend}}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background: #93bae987;font-weight: bold;">% CD of Final Cost</th>
                        @if($costdiff != 0 || $totalspend != 0)
                            <td> {{round(($costdiff/$totalspend) * 100,2)}} %</td>
                        @else
                            <td>-</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <!--Market Share-->
            <div class="col-xs-12">
                <h3>Market Share</h3>
                <div id="marketshare" style="display: inline-block"></div>
            </div>
            <div class="col-xs-12">
                <div style="padding: 5px;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Company</th>
                                <th scope="col">Total Spend</th>
                                <th scope="col">Market Share</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($marketShare as $row)
                            <tr>
                                <th scope="row" style="background: #93bae987">{{$row['manufacture']}}</th>
                                <td>$ {{$row['totalspend'] == '' ?'-' : $row['totalspend']}}</td>
                                <td>{{$row['marketshare']}} %</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th>Total</th>
                                <th>$ {{$totalspend}}</th>
                                <th>100 %</th>
                            </tr>

                            </tbody>
                        </table>

                </div>
            </div>

            <!--CD Per Vender-->
            <div class="col-xs-12">
                <h3>CD Per Vendor</h3>
                <div id="vender" style="display: inline-block"></div>
            </div>
            <div class="col-xs-12">
                <div style="padding: 5px;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" colspan="2"><center>CD Per Vendor</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vender as $row)
                        <tr>
                            <td scope="row" style="background: #93bae987">{{$row['manufacture']}}</td>
                            <td style="color: {{$row['loss'] == '' ? '' : 'red'}}">{{$row['loss'] == '' ? '-' : $row['loss']}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!--Tech Utilization-->
            <div class="col-xs-12">
                <h3>Tech Utilization</h3>
                <div id="tech" style="display: inline-block"></div>
            </div>
            <div class="col-xs-12">

                <div style="padding: 5px;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Technology</th>
                            <th scope="col">Usage</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($technology as $row)
                            <tr>
                                <td scope="row" style="background: #93bae987">{{$row['value']}}</td>
                                <td>{{$row['count'] == '' ?'-' : $row['count']}}</td>
                                <td>{{$row['percenatge']}} %</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!--Bulk & consigment-->
            <div class="col-xs-12">
                <h3>Bulk & consigment</h3>
                <div id="bulk" style="display: inline-block"></div>
            </div>
            <div class="col-xs-12">
                <div style="padding: 5px;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Bulk v/s Consigned</th>
                            <th scope="col">Usage</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bulkcount as $row)
                            <tr>
                                <td scope="row" style="background: #93bae987">{{$row['value']}}</td>
                                <td>{{$row['count'] == '' ?'-' : $row['count']}}</td>
                                <td>{{$row['percenatge']}} %</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!--CD by Category-->
            <div class="col-xs-12">
                <h3>CD by Device Category</h3>
                <div style="padding: 5px;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">CD By Device Category</th>
                            <th scope="col">Total Spend</th>
                            <th scope="col">CD</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($category as $row)
                            <tr>
                                <td scope="row" style="background: #93bae987">{{$row['CategoryName']}}</td>
                                <td>$ {{$row['totalSpend'] == '' ?'-' : $row['totalSpend']}}</td>
                                <td>$ {{$row['loss'] == '' ?'-' : $row['loss']}}</td>
                                <td>{{$row['MarketShare']}} %</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="scorecardfooter">
            <br>
            <span class="scorecardbuttons">
                @if(Auth::user()->roll == '1')
                    <a href="{{URL::to('scorecard')}}"><i class="fa fa-calendar calendar-icon" aria-hidden="true"></i></a>
                @else
                    <a href="{{URL::to('scorecard/year/'.$users->id)}}"><i class="fa fa-calendar calendar-icon" aria-hidden="true"></i></a>
                @endif
                @if(Auth::user()->roll == '2')
                    <a href="{{URL::to('scorecard/physician')}}"><i class="fa fa-user-md" aria-hidden="true"></i></a>
                @endif
                <a href="{{URL::to('menu')}}"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
        </span>
        </div>

        </div>
    </div>
    <div id="warning-message">
        <img src="{{ URL::to('images/Neptune-bg-landscape.png')}}"/>
    </div>
    <script type="text/javascript"  >

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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawCharts);
        google.charts.setOnLoadCallback(tech);
        google.charts.setOnLoadCallback(bulk);


        function drawChart() {
            var markets = <?php echo json_encode($marketShare); ?>;
            var market = [['Company', 'Marketshare']];
            // var iCnt = 0;
            $.each(markets, function (i, item) {
                market.push([item.manufacture,item.marketshare]);
            });
            var data = google.visualization.arrayToDataTable(market);

            var options = {
                title : 'Market Share',
                width: 500,
                height: 300,
                is3D: true,
                // colors: ['#3366CC','#396bce','#578bf2','#5a8bed','#1862f7'],
            };

            var chart = new google.visualization.PieChart(document.getElementById('marketshare'));
            chart.draw(data, options);
        }

        function drawCharts() {
            var markets = <?php echo json_encode($vender); ?>;
            var market = [["Manufacture", "Total Loss (in $)", { role: "style" } ]];
            // var iCnt = 0;
            $.each(markets, function (i, item) {

                market.push([item.manufacture,item.loss,"color: #3366CC"]);
            });
            var data = google.visualization.arrayToDataTable(market);




                var formatter = new google.visualization.NumberFormat({pattern: '#,##0',prefix: '$'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title: "CD Per Vendor",
                bar: {groupWidth: "80%"},
                legend: { position: "none" },
                width: 500,
                height: 300,
                vAxis: {format: '$'},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("vender"));
            chart.draw(view, options);
        }

        function tech() {
            var markets = <?php echo json_encode($technology); ?>;
            var market = [["Technology", "Usage", { role: "style" } ]];
            // var iCnt = 0;
            $.each(markets, function (i, item) {
                // console.log(item);
                market.push([item.value,item.count,"color: #3366CC"]);
            });
            var data = google.visualization.arrayToDataTable(market);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title: "Tech Utilization",
                bar: {groupWidth: "80%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("tech"));
            chart.draw(view, options);
        }

        function bulk() {
            var markets = <?php echo json_encode($bulkcount); ?>;
            var market = [["Bulk v/s Consigned", "Usage", { role: "style" } ]];
            // var iCnt = 0;
            $.each(markets, function (i, item) {
                // console.log(item);
                market.push([item.value,item.count,"color: #3366CC"]);
            });
            var data = google.visualization.arrayToDataTable(market);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title: "Bulk v/s Consigned",
                bar: {groupWidth: "60%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("bulk"));
            chart.draw(view, options);
        }


    </script>
@endsection

