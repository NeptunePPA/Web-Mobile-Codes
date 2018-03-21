<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/13/2018
 * Time: 10:00 AM
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
        .columns-chart {
            width: 100%;
            min-height: 450px;
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
                    <a href="#" class="btn btn-default header-button left" data-toggle="modal"
                       data-target="#clientmodel"><i class="fa fa-h-square" aria-hidden="true"></i></a>
                    <img src="{{URL::to('public/'.$selectedclient['image'])}}" class="img-responsive" alt=""
                         style="height: 80px;">
                    <a href="#" class="btn btn-default header-button right" data-toggle="modal"
                       data-target="#projectmodal"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                </div>
                <!-- <div class="col-sm-5"></div> -->
            </div>
        </div>
    </div>

    <div class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4">
                    <div class="main-box-card">
                        <div class="today-cases">
                            <div class="header-box">
                                <h4 class="text-center">Today's Cases</h4>
                            </div>
                            <div class="body-box">
                                <div class="table-responsive">
                                    <table class="table">
                                        <th>Physician</th>
                                        <th>Manufacturer</th>
                                        <th>Category</th>
                                        <th>Device</th>
                                        <th>Model No.</th>
                                        <th>Serial No.</th>
                                        <th>Client</th>
                                        <th>Purchase Type</th>
                                        <tbody>
                                        @forelse($case as $row)
                                            <tr>
                                                <td>{{$row->physician}}</td>
                                                <td>{{$row->manufacturer}}</td>
                                                <td>{{$row->category}}</td>
                                                <td>{{$row->supplyItem}}</td>
                                                <td> {{$row->mfgPartNumber}} </td>
                                                <td> {{$row->serialNumber}} </td>
                                                <td> {{$row->client}} </td>
                                                <td> {{$row->purchaseType}} </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <center>No Cases Found..!!</center>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="menu-option">
                                    <a href="{{URL::to('admin/repcasetracker')}}" class="gray-color"><i
                                                class="fa fa-ellipsis-h"
                                                aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="main-box-card">
                        <div class="market-share">
                            <div class="header-box">
                                <h4 class="text-center">
                                    {{ Form::open(array('url' => 'admin/dashboard','method'=>'POST','files'=>'true','id'=>'marketshare') )}}
                                    <span class="pull-left ml-10">Unit
                                        @if($unit=='unit')
                                            <input type="radio" name="unit" checked="true" class="marketshare"
                                                   data-value="unit">
                                        @else
                                            <input type="radio" name="unit" class="marketshare" data-value="unit">
                                        @endif
                                    </span>
                                    <span class="text-center">Market Share</span>
                                    <span class="pull-right mr-10">
                                        @if($unit == 'spend')
                                            <input type="radio" name="unit" checked="true" class="marketshare"
                                                   data-value="spend"> Spend
                                        @else
                                            <input type="radio" name="unit" class="marketshare" data-value="spend">
                                            Spend
                                        @endif
                                    </span>
                                    <input type="hidden" name="unit_value" value="" id="market_unit">
                                    {{Form::close()}}
                                </h4>
                            </div>
                            <div class="body-box vertical-middle">
                                <div class="">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <div class="text-center" id="piechart"></div>
                                        </div>
                                        <div class="col-sm-12" style="padding-left: 40px;padding-right: 40px;">
                                            <h4 class="blue-color text-center">{{Current_Year}} Year to Date</h4>
                                            <table class="table blue-color text-center">
                                                <tr>
                                                    <th class="text-center">Vendor</th>
                                                    <th class="text-center">{{Current_Year}} Spend</th>
                                                    <th class="text-center">{{$unit == 'unit'?'Unit':'MS'}}</th>
                                                </tr>
                                                @foreach($Final_client_marketshare as $row)
                                                    <tr>
                                                        <td>{{$row['manufacture']}}</td>
                                                        <td>$ {{number_format($row['totalspend'])}}</td>
                                                        <td>{{round($row['ms'],0)}}{{$unit == 'unit'?'':'%'}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="menu-option">
                                    <a href="{{URL::to('admin/dashboard/market-share/viewmore')}}" class="gray-color"><i
                                                class="fa fa-ellipsis-h"
                                                aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="main-box-card">
                        <div class="md-analytics">
                            <div class="header-box">
                                <h4 class="text-center">Savings</h4>
                            </div>
                            <div class="body-box">
                                <div class="text-center" id="saving">
                                </div>
                                <div id="savingvalue" style="display: none;">
                                    <div class="col-sm-6">
                                        <div class="category-img-box text-center">
                                            <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">
                                                <span class="amount"
                                                      id="month_amount">{{round($clientSavings,0) < 0 ? '-$'.abs(round($clientSavings,0)):'$'.round($clientSavings,0)}}</span>
                                                <span class="month">{{getMonthName(Current_month)}} {{Current_Year}}</span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="category-img-box text-center">
                                            <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">

                                                <span class="amount"
                                                      id="year_amount">{{round($clientSaving,0) < 0 ? '-$'.abs(round($clientSaving,0)):'$'.round($clientSaving,0)}}</span>
                                                <span class="month">Year to Date Savings {{Current_Year}}</span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" style="width: 100%;">
                                    <h4 class="blue-color text-center"><b>Category APP</b></h4>
                                    <div class="content-scrollable">
                                        <div class="column-chart text-center" id="categories" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-option">
                        <a href="{{URL::to('admin/dashboard/saving/viewmore')}}" class="gray-color"><i
                                    class="fa fa-ellipsis-h"
                                    aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <br/>
            <br/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="main-box-card">
                        <div class="md-analytics">
                            <div class="header-box">
                                <h4 class="text-center">Bulk Inventory</h4>
                            </div>
                            <div class="body-box">
                                {{--<div class="text-right">--}}
                                {{--<span class="btn-box">--}}
                                {{--<a href="#" class="btn btn-primary blue-btn"><img--}}
                                {{--src="{{URL::to('public/dashboard/Crane.png')}}"--}}
                                {{--class="img-responsive" alt=""> <br> Bulk Builder--}}
                                {{--</a>--}}
                                {{--</span>--}}
                                {{--</div>--}}
                                <div class=" vertical-middle">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="blue-color text-center"><b>Bulk Inventory</b></h4>
                                            <div class="content-scrollable">
                                                <div class="columns-chart" id="Bulkchart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-option">
                            <a href="{{URL::to('admin/dashboard/viewbulk')}}" class="gray-color"><i
                                        class="fa fa-ellipsis-h"
                                        aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="main-box-card">
                        <div class="market-share">
                            <div class="header-box">
                                <h4 class="text-center">
                                    <!-- <span class="pull-left ml-10">Unit <input type="radio" name="unit"></span> -->
                                    <span class="text-center">Alerts & Observations</span>
                                    <!-- <span class="pull-right mr-10"><input type="radio" name="unit"> Spend</span> -->
                                </h4>
                            </div>
                            <div class="body-box vertical-middle">
                                <div class="">
                                    <div class="row">

                                        <div class="col-sm-4 col-sm-offset-1">
                                            <a href="#"
                                               class="btn btn-primary blue-btn"><img
                                                        src="{{URL::to('public/dashboard/voting.png')}}"
                                                        class="img-responsive" alt=""> <br> Voting
                                            </a>
                                            <a href="#"
                                               class="btn btn-primary blue-btn mt-110"><img
                                                        src="{{URL::to('public/dashboard/analysis.png')}}"
                                                        class="img-responsive" alt=""> <br> Outliers/Analysis
                                            </a>
                                        </div>

                                        <div class="col-sm-4 col-sm-offset-1">
                                            <a href="#"
                                               class="btn btn-primary blue-btn"><img
                                                        src="{{URL::to('public/dashboard/bulk.png')}}"
                                                        class="img-responsive" alt=""> <br> Aging/Bulk
                                            </a>
                                            <a href="{{URL::to('admin/dashboard/view-market-share')}}"
                                               class="btn btn-primary blue-btn mt-110"><img
                                                        src="{{URL::to('public/dashboard/swap.png')}}"
                                                        class="img-responsive" alt=""> <br> Swaps/Transfers
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-option">
                                    <a href="#" class="gray-color"><i class="fa fa-ellipsis-h"
                                                                      aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="main-box-card">
                        <div class="md-analytics">
                            <div class="header-box">
                                <h4 class="text-center">MD Analytics </h4>
                            </div>
                            <div class="body-box vertical-middle">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-offset-1">
                                        <a href="{{URL::to('admin/dashboard/saving')}}"
                                           class="btn btn-primary blue-btn"><img
                                                    src="{{URL::to('public/dashboard/Savings.png')}}"
                                                    class="img-responsive" alt=""> <br> Savings
                                        </a>
                                        <a href="{{URL::to('admin/dashboard/view-market-share')}}"
                                           class="btn btn-primary blue-btn mt-110"><img
                                                    src="{{URL::to('public/dashboard/Market_Share.png')}}"
                                                    class="img-responsive" alt=""> <br> Market Share
                                        </a>
                                    </div>

                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="{{URL::to('admin/dashboard/neptune')}}"
                                           class="btn btn-primary blue-btn"><img
                                                    src="{{URL::to('public/dashboard/Neptune_Icon.png')}}"
                                                    class="img-responsive" alt=""> <br> Neptune </a>
                                        <a href="{{URL::to('admin/dashboard/app')}}"
                                           class="btn btn-primary blue-btn mt-110"><img
                                                    src="{{URL::to('public/dashboard/App.png')}}" class="img-responsive"
                                                    alt=""> <br> APP </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>
    <br><br>
    <!-- JQuery -->
    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/simple-chart.js')}}"></script>
    <!-- pie chart -->
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // Load google charts
            google.charts.load('visualization', "1", {
                packages: ['corechart', 'imagebarchart']
            });

            google.charts.setOnLoadCallback(drawChart);
            google.charts.setOnLoadCallback(drawCharts);
            google.charts.setOnLoadCallback(savingChart);


            var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;


            // Draw the chart and set the chart values
            function drawChart() {

                var bulks = <?php echo json_encode($Final_client_marketshare); ?>;
                var bulk = [['Manufacture', 'ms', '% Marketshare', {role: "style"}]];

                $.each(bulks, function (i, item) {
                    bulk.push([item.manufacture + ' ' + item.ms + '%', parseInt(item.totalspend), item.ms, "color: #3b6497"]);
                });


                var piechartData = google.visualization.arrayToDataTable(bulk);

                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var i = 1; i < piechartData.getNumberOfColumns(); i++) {
                    formatter.format(piechartData, i);
                }

                // Optional; add a title and set the width and height of the chart
                var piechartOptions = {
                    title: 'Spend % MS',
                    width: 'auto',
                    height: 300,

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
                    is3D: true,
                    colors: colors,
                    tooltip: {
                        text: 'value',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        }
                    },
                    fontName: 'Avenir_Book',


                };

                // Display the chart inside the <div> element with id="piechart"
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(piechartData, piechartOptions);
            }

            var data =  <?php echo json_encode($bulk); ?>;

            function drawCharts() {

                var bulks = <?php echo json_encode($bulk); ?>;

                var bulk = [['Category', 'Bulk', {role: "style"}]];
                $.each(bulks, function (i, item) {
                    bulk.push([item.category_name, item.bulk, "color:" + colors[i]]);
                });

                var data = google.visualization.arrayToDataTable(bulk);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2]);

                var options = {
                    //title: "Bulk Inventory",
                    bar: {groupWidth: "75%"},
                    legend: {position: "none"},
                    width: 1000,
                    // colors: ['#0E2C61', '#6786B3', '#6A99CD', '#9CB8D7', '#808080','#BFBFBF']
                    // colors: ['red', 'green'],
                    fontName: 'Avenir_Book',
                    vAxis: {
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        }
                    },
                    hAxis: {
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        }
                    },
                    tooltip: {
                        textStyle:
                            {
                                fontName: 'Avenir_Book',
                                fontSize: 14
                            }
                    },


                };
                var chart = new google.visualization.ColumnChart(document.getElementById("Bulkchart"));

                chart.draw(view, options);
            }

            var viewload = '<img src="{{URL::to("public/images/loading-spinner-blue.gif")}}" style="margin:100px 190px; height:100%;"/>';
            $('#categories').html(viewload);
            $.ajax({    //create an ajax request to display.php
                type: "GET",
                url: "{{URL::to('getcategoryappchart')}}",
                success: function (response) {
                    // $("#responsecontainer").html(response);
                    savingChart(response);
                }

            });

            function savingChart(cateogries) {

                var savings = cateogries;
                var saving = [['Category', 'APP Value (in $)', {role: "style"}]];
                var j = 0;
                $.each(savings, function (i, item) {
                    j++;
                    saving.push([i, item.category_app_avg_value, "color:" + colors[j]]);
                });

                var data = google.visualization.arrayToDataTable(saving);

                var view = new google.visualization.DataView(data);


                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2]);


                var options = {
                    // title: "Category APP",
                    width: 1000,
                    height: 350,
                    labeledValueText: 'none',
                    fontSize: 12,
                    bar: {
                        groupWidth: "75%",
                        fontName: 'Avenir_Book',
                        fontSize: 4
                    },

                    legend: 'none',

                    vAxis: {
                        format: '$#,###', textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: 10
                        }
                    },
                    hAxis: {
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: 10
                        }
                    },
                    tooltip: {
                        textStyle:
                            {
                                fontName: 'Avenir_Book',
                                fontSize: 10
                            }
                    },
                    fontName: 'Avenir_Book',


                };


                var chart = new google.visualization.ColumnChart(document.getElementById("categories"));
                chart.draw(view, options);
            }


            /**
             * Count Saving In dashboard start
             */

            var viewload = '<img src="{{URL::to("public/images/loading-spinner-blue.gif")}}" style="margin:100px 190px; height:100%;"/>';
            $('#saving').html(viewload);

            $.ajax({    //create an ajax request to display.php
                type: "GET",
                url: "{{URL::to('getsavingvalue')}}",
                success: function (response) {
                    // $("#responsecontainer").html(response);
                    // savingChart(response);
                    $('#saving').hide();
                    $('#savingvalue').show();

                    var month = response.month;
                    var year = response.year;

                    // month = month < 0 ? '- $'+ Math.abs(month) : '$' + month;
                    // year = year < 0 ? '- $'+ Math.abs(year) : '$' + year;

                    $('#year_amount').html(year);
                    $('#month_amount').html(month);

                }

            });

            /**
             * Count Saving In dashboard End
             */
        });
        $(document).on('change', '.marketshare', function (event) {
            var data = $(this).attr('data-value');

            $('#market_unit').val(data);
            $('#marketshare').submit();
        });
    </script>
@endsection