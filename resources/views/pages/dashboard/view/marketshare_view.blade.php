<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 3/1/2018
 * Time: 7:52 AM
 */-->


@extends ('layout.default')
@section('head')

    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Google Fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=PT+Mono|Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{URL::asset('css/dashboard/simple-chart.css') }}" type="text/css" rel="stylesheet">
    <link href="{{URL::asset('css/dashboard/style.css') }}" type="text/css" rel="stylesheet">
    <link href="{{URL::asset('css/dashboard/base-file.css') }}" type="text/css" rel="stylesheet">
    <style type="text/css">
        .container-fluid {
            background: #fff !important;
        }

        .columns-chart {
            width: 100%;
            min-height: 450px;
        }

        .filter {
            margin-right: 10px;
        }

        .clientname {
            margin-bottom: 20px;
            text-align: center;
            padding: 10px;
        }

        .bar-chart .sc-chart.sc-bar.sc-10-items {
            width: 100%;
            height: 160px !important;
            float: initial;
        }
    </style>
@endsection
@section ('content')
    <br>

    <div class="headerbar">
        <div class="container-fluid headclass">
            <div class="row">
                <!-- <div class="col-sm-5"></div> -->
                <div class="col-sm-12 text-center">
                    <a href="#" class="btn btn-default header-button left" data-toggle="modal" data-target="#clientmodel"><i class="fa fa-h-square" aria-hidden="true"></i></a>
                    <img src="{{URL::to('public/'.$selectedclient['image'])}}" class="img-responsive" alt="" style="height: 80px;">
                    <a href="#" class="btn btn-default header-button right" data-toggle="modal" data-target="#projectmodal"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                </div>
                <!-- <div class="col-sm-5"></div> -->
            </div>
        </div>
    </div>
    {{ Form::open(array('url' => 'admin/dashboard/market-share/viewmore','method'=>'POST','files'=>'true','id'=>'marketshare') )}}

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('year',$years,$year,array('class'=>'','id'=>'year_data','style'=>'width:110px;')) }}

            </div>
            <div class="pull-right" style="padding: 10px;">
            {{ Form::select('month',$months,$month,array('class'=>'','id'=>'month_data','style'=>'width:110px;')) }}
            </div>

        </div>
    </div>
<br>
    <div class="row" style="background: #135bae;color: #fff">


        <div class="col-md-4 text-center" style="font-size: 27px;padding-top: 5px;">Unit
            @if($unit=='unit')
                <input type="radio" name="unit" checked="true" class="marketshare"
                       data-value="unit">
            @else
                <input type="radio" name="unit" class="marketshare" data-value="unit">
            @endif

        </div>
        <div class="col-md-4 text-center" style="font-size: 35px;">Market Share</div>
        <div class="col-md-4 text-center" style="font-size: 27px;padding-top: 5px;">
            @if($unit == 'spend')
                <input type="radio" name="unit" checked="true" class="marketshare"
                       data-value="spend"> Spend
            @else
                <input type="radio" name="unit" class="marketshare" data-value="spend">
                Spend
            @endif

        </div>

        <input type="hidden" name="unit_value" value="" id="market_unit">
    </div>
    {{Form::close()}}
    <br>

    <br>
    <div class="row"><h3 style="padding: 0px 20px;"></h3></div>
    <div class="row">
        <div class="col-md-3">
            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <th colspan="3">
                            <center>{{getMonthName($month)}}</center>
                        </th>
                    </tr>
                    <tr>
                        <th>Vendor</th>
                        <th>Spend</th>
                        <th>{{$unit == 'unit'?'Unit':'MS'}}</th>
                    </tr>
                    </thead>

                    <tbody id='scorecardhtml'>

                    @forelse($Final_client_marketshare_month as $row1)

                        <tr>
                            <td style="background: #93bae987">{{$row1['manufacture']}}</td>
                            <td>${{number_format($row1['totalspend'])}}</td>
                            <td>{{round($row1['ms'],0)}}{{$unit == 'unit'?'':'%'}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center"> No Record Found..!!</td>
                        </tr>
                    @endforelse

                    <tr>

                        <td style="background: #93bae987">Total</td>
                        <td colspan="2" style="text-align: right;">
                            $ {{number_format($final_client_totalspend_month)}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3">
            <div id="month"></div>
        </div>
        <div class="col-md-3">
            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <th colspan="3">
                            <center>{{$year}} Year to Date</center>
                        </th>
                    </tr>
                    <tr>
                        <th>Vendor</th>
                        <th>Spend</th>
                        <th>{{$unit == 'unit'?'Unit':'MS'}}</th>
                    </tr>
                    </thead>

                    <tbody id='scorecardhtml'>
                    @forelse($Final_client_marketshare_year as $row1)

                        <tr>
                            <td style="background: #93bae987">{{$row1['manufacture']}}</td>
                            <td>${{number_format($row1['totalspend'])}}</td>
                            <td>{{round($row1['ms'],0)}}{{$unit == 'unit'?'':'%'}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center"> No Record Found..!!</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td style="background: #93bae987">Total</td>
                        <td colspan="2" style="text-align: right;">
                            $ {{number_format($final_client_totalspend_year)}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3">
            <div id="year"></div>
        </div>
    </div>

    <!--Client Seection Model-->
    <div id="clientmodel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Client Select</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach($clients as $row)
                            <div class="col-md-12">
                                <a href="{{URL::to('admin/administrator/clients/'.$row->id)}}">
                                    <div class="col-md-12 clientname"
                                         style="background: {{$row->id == $selectclients ? '#e1e3e4' : ''}}">
                                        <img src="{{URL::to('public/'.$row->image)}}" width="150px" height="50px">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <!--Project Seection Model-->
    <div id="projectmodal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Project Select</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if(count($project) > 0)
                            @foreach($project as $row)
                                <div class="col-md-12">
                                    <a href="{{URL::to('admin/administrator/project/'.$row->id)}}">
                                        <div class="col-md-12 clientname"
                                             style="background: {{$row->id == $selectprojects ? '#e1e3e4' : ''}}">
                                            <h3>{{$row->project_name}}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    <!-- JQuery -->
    <script src="{{ URL::asset('js/edit_script.js') }}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/simple-chart.js')}}"></script>
    <!-- pie chart -->
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jsapi.js')}}"></script>
    <script type="text/javascript">

        // Load the Visualization API library and the piechart library.
        google.load('visualization', '1.0', {'packages': ['corechart']});
        
        // ... draw the chart...
    </script>
    <script type="text/javascript">

        // Load the Visualization API library and the piechart library.
        google.charts.load("current", {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);


        var month_marketshare = <?php echo json_encode($Final_client_marketshare_month); ?>;

        var month_marketshare_spend = <?php echo json_encode($final_client_totalspend_month); ?>;

        var year_marketshare = <?php echo json_encode($Final_client_marketshare_year); ?>;

        var year_marketshare_spend = <?php echo json_encode($final_client_totalspend_year); ?>;

        var unit = "{{$unit}}" == 'spend' ? '%' : '';



        var bulk = [['Manufacture', 'totalspend', '% Marketshare', {role: "style"}]];

        $.each(month_marketshare, function (i1, item) {

            bulk.push([item.manufacture + ' ' + item.ms + unit,item.totalspend, item.ms, "color: #3b6497"]);
        });

        var monthid = "month";

        drawChart(bulk, monthid);


        var bulks = [['Manufacture', 'totalspend', '% Marketshare', {role: "style"}]];

        $.each(year_marketshare, function (i1, items) {

            bulks.push([items.manufacture + ' ' + items.ms + unit, items.totalspend, items.ms, "color: #3b6497"]);
        });

        console.log(bulks);

        var yearid = "year";

        drawCharts(bulks, yearid);


        function drawChart(bulk, monthid) {

            var data = google.visualization.arrayToDataTable(bulk);

            var options = {
                // title: 'My Daily Activities'
                'width': 'auto',
                'height': 300,
                is3D: true,
                colors: ['#0E2C61', '#6786B3', '#6A99CD', '#9CB8D7', '#808080','#BFBFBF'],
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14' }
                },
                fontName: 'Avenir_Book',
                // legend: 'none',
                pieSliceText: 'none',
                legend: {
                    position: 'labeled',
                    labeledValueText: 'none',
                    maxLines: 1,
                    textStyle: {
                        // color: 'blue',
                        fontSize: 14
                    }
                },
            };


            var formatter = new google.visualization.NumberFormat({pattern: '#,##0',prefix: '$'});

             // format number columns
            for (var i = 1; i < data.getNumberOfColumns(); i++) {
                formatter.format(data, i);
            }

            var chart = new google.visualization.PieChart(document.getElementById(monthid));

            chart.draw(data, options);
        }

        function drawCharts(bulks, yearid) {

            var data = google.visualization.arrayToDataTable(bulks);

            var options = {
                // title: 'My Daily Activities'
                'width': 'auto',
                'height': 300,
                is3D: true,
                colors: ['#0E2C61', '#6786B3', '#6A99CD', '#9CB8D7', '#808080','#BFBFBF'],
                pieSliceText: 'none',
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14' }

                },
                fontName: 'Avenir_Book',
                // legend: 'none',
                legend: {
                    position: 'labeled',
                    labeledValueText: 'none',
                    maxLines: 1,
                    textStyle: {
                        // color: 'blue',
                        fontSize: 14
                    }
                },
            };


            var formatter = new google.visualization.NumberFormat({pattern: '#,##0',prefix: '$'});

             // format number columns
            for (var i = 1; i < data.getNumberOfColumns(); i++) {
                formatter.format(data, i);
            }

            var chart = new google.visualization.PieChart(document.getElementById(yearid));

            chart.draw(data, options);
        }

        google.setOnLoadCallback(drawChart);
        google.setOnLoadCallback(drawCharts);
        // ... draw the chart...


        $(document).on('change', '.marketshare', function (event) {
            var data = $(this).attr('data-value');

            $('#market_unit').val(data);
            $('#marketshare').submit();
        });


        $(document).on('change','#month_data', function (event) {

            $('#marketshare').submit();
        });

        $(document).on('change','#year_data', function (event) {

            $('#marketshare').submit();
        });
    </script>


@endsection