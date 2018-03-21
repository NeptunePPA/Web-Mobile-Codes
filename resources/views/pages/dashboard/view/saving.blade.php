<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 2/19/2018
 * Time: 4:32 PM
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

    {{ Form::open(array('url' => 'admin/dashboard/viewsaving','method'=>'POST','files'=>'true','id'=>'marketshare') )}}

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('year',$years,$year,array('class'=>'','id'=>'year_data','style'=>'width:110px;')) }}

            </div>
            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('month',$months,$month,array('class'=>'','id'=>'month_data','style'=>'width:110px;')) }}
            </div>

            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('user_id',$user_list,'',array('class'=>'','id'=>'user_data','style'=>'width:110px;')) }}
            </div>

        </div>
    </div>
    <br>

    {{Form::close()}}

    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <h3 class="blue-color text-center"><b>{{$user_first['name']}}</b></h3>

            </div>
            <br>
            <br>
            <div class="row">

                <div class="body-box">
                    <div class="text-center" id="user_savings">
                    </div>
                    <div id="user_savingvalue" style="display: none;">
                        <div class="col-sm-12">
                            <div class="category-img-box text-center">
                                <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">
                                                <span class="amount" id="user_month_amount"></span>
                                                <span class="month">{{getMonthName($month)}} {{$year}} Savings</span>
                                            </span>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="category-img-box text-center">
                                <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">

                                                <span class="amount" id="user_year_amount"></span>
                                                <span class="month">Annual Saving Value of {{$year}}</span>
                                            </span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <br>
            <br>
            <div class="text-center" style="width: 100%;height: 150px">
                <div id="chart_div"></div>
            </div>

        </div>

        <div class="col-md-8" style="background: #eaeaea">

            <br>
            <div class="row">
                <div class="col-md-6">

                    <div class="body-box">
                        <div class="text-center" id="client_saving_dataa">
                        </div>
                        <div id="client_savingvalues" style="display: none;">
                            <div class="col-sm-12">
                                <div class="category-img-box text-center">
                                    <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">
                                                <span class="amount" id="client_month_value"></span>
                                                <span class="month">{{getMonthName($month)}} {{$year}}</span>
                                            </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="category-img-box text-center">
                                    <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">

                                                <span class="amount" id="client_saving_datas"></span>
                                                <span class="month">Yearly Savings {{$year}}</span>
                                            </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="coloum-chart" id="coloum-chart"></div>

                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-6">
                    <div id="user_saving" style="width: 100%"></div>
                </div>
                <div class="col-md-6">
                    <div id="saving_users" style="width: 100%"></div>
                </div>
            </div>

            <br>

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

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);
        google.charts.setOnLoadCallback(barchart6);
        google.charts.setOnLoadCallback(barchart7);
        google.charts.setOnLoadCallback(piechart);

        function drawVisualization(clientspeds) {
            // Some raw data (not necessarily accurate)

            var clientspeds = clientspeds;

            var clientspend = [['Month', 'Spend', 'Saving']];
            // var iCnt = 0;
            $.each(clientspeds, function (i, item) {
                clientspend.push([item.month, item.totalspend, item.totalsaving]);
            });

            var data = google.visualization.arrayToDataTable(clientspend);


            var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

            // format number columns
            for (var i = 1; i < data.getNumberOfColumns(); i++) {
                formatter.format(data, i);
            }

            var options = {
                title: ' Monthly Spend and Saving',
                vAxis: {title: 'Total Spend', format: '$'},
                hAxis: {title: ' Month'},
                seriesType: 'bars',
                series: {1: {type: 'line'}},
                height: 300,
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14'
                    }

                },
                fontName: 'Avenir_Book',
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function barchart6(saving_users) {

            var saving_users = saving_users;

            var saving_user = [['Saving', 'Amount', {role: "style"}]];
            // var iCnt = 0;
            $.each(saving_users, function (i, item) {
                saving_user.push([item.user_name, Math.round(item.saving), '#3366cc']);
            });

            var data = google.visualization.arrayToDataTable(saving_user);

            var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

            // format number columns
            for (var i = 1; i < data.getNumberOfColumns(); i++) {
                formatter.format(data, i);
            }

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
                title: "{{getMonthName($month)}} {{$year}} Users Savings",
                width: 'auto',
                height: 600,
                bar: {groupWidth: "75%"},
                legend: {position: "none"},
                hAxis: {format: '$'},
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14'
                    }

                },
                fontName: 'Avenir_Book',
            };
            var chart = new google.visualization.BarChart(document.getElementById("user_saving"));
            chart.draw(view, options);
        }

        function barchart7(bulks) {

            var bulks = bulks;

            var bulk = [['Month', 'Saving', {role: "style"}]];
            // var iCnt = 0;

            var j = 0;
            $.each(bulks, function (i, item) {
                j++;
                bulk.push([item.month, item.totalsaving, '#3366cc']);
            });

            var data = google.visualization.arrayToDataTable(bulk);

            var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

            // format number columns
            for (var i = 1; i < data.getNumberOfColumns(); i++) {
                formatter.format(data, i);
            }

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
                title: "Monthly Saving",
                width: 'auto',
                height: 400,
                bar: {groupWidth: "75%"},
                legend: {position: "none"},
                hAxis: {format: '$'},
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14'
                    }

                },
                fontName: 'Avenir_Book',
            };
            var chart = new google.visualization.BarChart(document.getElementById("coloum-chart"));
            chart.draw(view, options);
        }

        function piechart(physicinas) {

            var physicinas =physicinas;
            var physicina = [['Physician', 'Total Saving', 'Total Spend', {role: "style"}]];

            $.each(physicinas, function (i, item) {
                physicina.push([item.user_name + ' ' + Math.round(item.saving), Math.round(item.saving), item.spend, "color: #3b6497"]);
            });


            var piechartData = google.visualization.arrayToDataTable(physicina);

            // Optional; add a title and set the width and height of the chart
            var piechartOptions = {
                title: 'Saving Per physician',
                width: "auto",
                height: 300,
                pieSliceText: 'none',
                // legend: 'none',
                is3D: true,
                colors: ['#0E2C61', '#6786B3', '#6A99CD', '#9CB8D7', '#808080', '#BFBFBF'],
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14'
                    }

                },
                fontName: 'Avenir_Book',
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

            var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

            // format number columns
            for (var i = 1; i < piechartData.getNumberOfColumns(); i++) {
                formatter.format(piechartData, i);
            }


            // Display the chart inside the <div> element with id="piechart"

            var chart = new google.visualization.PieChart(document.getElementById('saving_users'));


            chart.draw(piechartData, piechartOptions);
        }

        $(document).on('change', '#month_data', function (event) {

            $('#marketshare').submit();
        });

        $(document).on('change', '#year_data', function (event) {

            $('#marketshare').submit();
        });

        $(document).on('change', '#user_data', function (event) {

            $('#marketshare').submit();
        });

        var viewload = '<img src="{{URL::to("public/images/loading-spinner-blue.gif")}}" style="margin:100px 190px; height:100%;"/>';

        $('#user_savings').html(viewload);
        $('#client_saving_dataa').html(viewload);
        $('#chart_div').html(viewload);
        $('#coloum-chart').html(viewload);
        $('#user_saving').html(viewload);
        $('#saving_users').html(viewload);

        var user_first = <?php echo json_encode($user_first); ?>;
        var month = {{$month}};
        var year = {{$year}};

        $.ajax({    //create an ajax request to display.php
            type: "GET",
            url: "{{URL::to('getsavingviewvalue')}}",
            data: {
                'year': year,
                'month': month,
                'user_first': user_first,

            },
            success: function (response) {
                // $("#responsecontainer").html(response);
                // savingChart(response);
                console.log(response);
                $('#user_savings').hide();
                $('#user_savingvalue').show();

                var month = response.month;
                var year = response.year;

                $('#user_year_amount').text(year);
                $('#user_month_amount').text(month);

                drawVisualization(response.monthwise);

            }

        });

        $.ajax({    //create an ajax request to display.php
            type: "GET",
            url: "{{URL::to('getsavingviewvalue_client')}}",
            data: {
                'year': year,
                'month': month,
                'user_first': user_first,

            },
            success: function (response) {
                // $("#responsecontainer").html(response);
                // savingChart(response);
                console.log(response);

                $('#client_saving_dataa').hide();
                $('#client_savingvalues').show();

                var month = response.month;
                var year = response.year;

                $('#client_saving_datas').text(year);
                $('#client_month_value').text(month);

                barchart7(response.monthwise);
            }

        });

        $.ajax({    //create an ajax request to display.php
            type: "GET",
            url: "{{URL::to('getsaving_chart_value_client')}}",
            data: {
                'year': year,
                'month': month,

            },
            success: function (response) {
                barchart6(response);
                piechart(response);
            }

        });


    </script>
@endsection
