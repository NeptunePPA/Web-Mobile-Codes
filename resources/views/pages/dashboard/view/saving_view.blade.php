<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 3/1/2018
 * Time: 7:52 AM
 */-->

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

    {{ Form::open(array('url' => 'admin/dashboard/saving/viewmore','method'=>'POST','files'=>'true','id'=>'marketshare') )}}

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

    {{Form::close()}}


    <div class="row">

        <div class="body-box text-center">
            <div class="text-center" id="saving">
            </div>
            <div id="savingvalue" style="display: none;">
                <div class="col-sm-6" style="padding-left: 50px;width: 35%;margin-left: 200px;">
                    <div class="category-img-box text-center">
                        <a class="vertical-middle" href="#" style="text-decoration: none">

                                            <span class="text-right yr-data-box" style="font-size: 18px">
                                                <span class="amount" id="client_month_value"></span>
                                                <span class="month">{{getMonthName(Current_month)}} {{Current_Year}}</span>
                                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6" style="padding-left: 50px;width: 35%;margin-left: 200px;">
                    <div class="category-img-box text-center">
                        <a class="vertical-middle" href="#" style="text-decoration: none">

                                           <span class="text-right yr-data-box" style="font-size: 18px">
                                                <span class="amount" id="client_saving_datas"></span>
                                                <span class="month">Yearly Savings {{Current_Year}}</span>
                                            </span>
                        </a>
                        </a>
                    </div>
                </div>

            </div>
            <div class="col-sm-12" style="width: 100%;">
                <h4 class="blue-color text-center"><b>Category App</b></h4>
                <div class="column-chart" id="categories" style="width: 100%"></div>
            </div>
        </div>

    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="bar-chart" id="categories" style="width: 100%"></div>
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

        google.charts.setOnLoadCallback(savingChart);
        var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;


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
                width: 'auto',
                height: 350,
                bar: {groupWidth: "65%"},

                legend: 'left',
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

        $(document).ready(function () {
            var viewload = '<img src="{{URL::to("public/images/loading-spinner-blue.gif")}}" style="margin:100px 190px; height:100%;"/>';
            $('#saving').html(viewload);
            $('#categories').html(viewload);
            var month = {{$month}};
            var year = {{$year}};

            $.ajax({    //create an ajax request to display.php
                type: "GET",
                url: "{{URL::to('getsavingviewvalue_client')}}",
                data: {
                    'year': year,
                    'month': month,

                },
                success: function (response) {
                    // $("#responsecontainer").html(response);
                    // savingChart(response);
                    console.log(response);

                    $('#saving').hide();
                    $('#savingvalue').show();

                    var month = response.month;
                    var year = response.year;

                    $('#client_saving_datas').html(year);
                    $('#client_month_value').html(month);
                }

            });

            $.ajax({    //create an ajax request to display.php
                type: "GET",
                data: {
                    'year': year,
                    'month': month,

                },
                url: "{{URL::to('getcategoryappchart')}}",
                success: function (response) {
                    // $("#responsecontainer").html(response);
                    savingChart(response);
                }

            });
        });
        $(document).on('change', '#month_data', function (event) {

            $('#marketshare').submit();
        });

        $(document).on('change', '#year_data', function (event) {

            $('#marketshare').submit();
        });

    </script>
@endsection
