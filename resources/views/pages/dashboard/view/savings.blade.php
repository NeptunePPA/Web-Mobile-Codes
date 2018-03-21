<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 3/17/2018
 * Time: 5:02 PM
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

        .select2.select2-container {
            width: 300px !important;
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
    {{ Form::open(array('url' => 'admin/dashboard/saving','method'=>'POST','files'=>'true','id'=>'marketshare') )}}

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right modal-btn" style="padding: 10px;width: auto">

                    {{ Form::submit('SUBMIT') }}

            </div>

            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('year',$years,$year,array('class'=>'','id'=>'year_data','style'=>'width:110px;')) }}

            </div>
            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('month',$months,$month,array('class'=>'','id'=>'month_data','style'=>'width:110px;')) }}
            </div>
            <div class="pull-right" style="padding: 10px;width: auto">
                {{ Form::select('user_id[]',$user_list,$user_id,array('class'=>'js-example-basic-multiple-user','id'=>'user_data','multiple'=>'true')) }}
            </div>

        </div>
    </div>
    <br>

    {{Form::close()}}
    <div class="container">
        <div class="row">
            <div class="col-md-6" style="height: 1080px">
                <div class="row">
                    <h4 class="text-center" style="color:#0b5698;font-size: 20px;"><b>{{getclientName($client_name)}}</b></h4>
                    <div class="text-center" id="client_saving_loder"></div>
                    <div id="client_savings">
                        <div class="col-md-12">
                            <div class="category-img-box text-center">
                                <a class="vertical-middle" href="#" style="text-decoration: none">
                                <span class="text-right yr-data-box" style="font-size: 18px">
                                    <span class="amount"
                                          id="client_month_saving">$21,545,142</span>
                                    <span class="month">{{getMonthName($month)}} {{$year}} Savings</span>
                                </span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="category-img-box text-center">
                                <a class="vertical-middle" href="#" style="text-decoration: none">
                                <span class="text-right yr-data-box" style="font-size: 18px">
                                    <span class="amount"
                                          id="client_year_saving">$5,484,855</span>
                                    <span class="month">Year to Date Savings</span>
                                </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-center" style="color:#0b5698;font-size: 20px;"><b>Monthly Spend</b></h4>
                        <div class="text-center" id="client_spend"></div>
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-center" style="color:#0b5698;font-size: 20px;"><b>Monthly Savings</b></h4>
                        <div class="text-center" id="client_saving"></div>
                    </div>
                </div>
            </div>
            @foreach($user_first as $row => $key)
                <div class="col-md-6" style="height: 1080px">
                    <div class="row">
                        <h4 class="text-center" style="color:#0b5698;font-size: 20px;"><b>{{$key->name}}</b></h4>
                        <div class="text-center" id="user_saving_loder-{{$row}}"></div>
                        <div id="user_savings-{{$row}}">
                            <div class="col-md-12">
                                <div class="category-img-box text-center">
                                    <a class="vertical-middle" href="#" style="text-decoration: none">
                                <span class="text-right yr-data-box" style="font-size: 18px">
                                    <span class="amount"
                                          id="user_month_amount-{{$row}}"><label>$21,545,142</label></span>
                                    <span class="month">{{getMonthName($month)}} {{$year}} Savings</span>
                                </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="category-img-box text-center">
                                    <a class="vertical-middle" href="#" style="text-decoration: none">
                                <span class="text-right yr-data-box" style="font-size: 18px">
                                    <span class="amount"
                                          id="user_year_amount-{{$row}}">$5,484,855</span>
                                    <span class="month">Year to Date Savings</span>
                                </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h4 class="text-center" style="color:#0b5698;font-size: 18px;"><b>Monthly Spend</b></h4>
                            <div class="text-center" id="user_spend-{{$row}}"></div>
                        </div>
                        <div class="col-md-12">
                            <h4 class="text-center" style="color:#0b5698;font-size: 18px;"><b>Monthly Savings</b></h4>
                            <div class="text-center" id="user_saving-{{$row}}"></div>
                        </div>
                    </div>

                </div>
            @endforeach
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
@endsection
@section('footer')
    <script type="text/javascript" src="{{URL::asset('js/edit_script.js')}}"></script>

    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>

    <!-- Bootstrap core JavaScript -->

    <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/simple-chart.js')}}"></script>
    <!-- pie chart -->
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            google.charts.setOnLoadCallback(drawChart_spend);

            var viewload = '<img src="{{URL::to("public/images/loading-spinner-blue.gif")}}" style="margin:100px 190px; height:100%;"/>';

            $('#client_saving_loder').html(viewload);
            $('#client_spend').html(viewload);
            $('#client_saving').html(viewload);
            $('#client_savings').hide();

            var user_first = <?php echo json_encode($user_first); ?>;
            var month = {{$month}};
            var year = {{$year}};

            $.ajax({    //create an ajax request to display.php
                type: "GET",
                url: "{{URL::to('getsavingviewvalue_client')}}",
                data: {
                    'year': year,
                    'month': month,
                    'user_first': user_first,

                },
                success: function (response) {
                    console.log(response);

                    $('#client_saving_loder').hide();
                    $('#client_savings').show();

                    var month = response.month;
                    var year = response.year;

                    $('#client_year_saving').html(year);
                    $('#client_month_saving').html(month);

                    var chartid_spend = 'client_spend';
                    var chartid_saving = 'client_saving';

                    drawChart(response.monthwise,chartid_spend);
                    drawChart_spend(response.monthwise,chartid_saving);
                }

            });

            $.each(user_first, function (i, item) {
                var user_data = item;

                $('#user_saving_loder-'+ i).html(viewload);
                $('#user_spend-' + i).html(viewload);
                $('#user_saving-' + i).html(viewload);
                $('#user_savings-' + i).hide();
                $.ajax({    //create an ajax request to display.php
                    type: "GET",
                    url: "{{URL::to('getsavingviewvalue')}}",
                    data: {
                        'year': year,
                        'month': month,
                        'user_first': user_data,

                    },
                    success: function (response) {
                        console.log(response);
                        $('#user_saving_loder-' + i).hide();
                        $('#user_savings-' + i).show();

                        var month = response.month;
                        var year = response.year;

                        $('#user_year_amount-' + i).html(year);
                        $('#user_month_amount-' + i).html(month);

                        var chartid_spend = 'user_spend-' + i;
                        var chartid_saving = 'user_saving-' + i;
                        drawChart(response.monthwise,chartid_spend);
                        drawChart_spend(response.monthwise,chartid_saving);

                    }

                });
            });

            var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;

            function drawChart(spend,div_id) {

                var savings = spend;
                var saving = [['Month Name', 'Spends(in $)', {role: "style"}]];
                var j = 0;
                $.each(savings, function (i, item) {
                    j++;
                    saving.push([item.month, item.totalspend, "color:" + colors[j]]);
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

                var chart = new google.visualization.ColumnChart(document.getElementById(div_id));
                chart.draw(view, options);
            }

            function drawChart_spend(spend,div_id) {

                var savings = spend;
                var saving = [['Month Name', 'Savings(in $)', {role: "style"}]];
                var j = 0;
                $.each(savings, function (i, item) {
                    j++;
                    saving.push([item.month, item.totalsaving, "color:" + colors[j]]);
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

                var chart = new google.visualization.ColumnChart(document.getElementById(div_id));
                chart.draw(view, options);
            }
        });

        $(document).on('change', '#month_data', function (event) {

            $('#marketshare').submit();
        });

        $(document).on('change', '#year_data', function (event) {

            $('#marketshare').submit();
        });

    </script>
@endsection