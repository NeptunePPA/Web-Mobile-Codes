<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 3/11/2018
 * Time: 1:39 PM
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

        .category-img-box {
            color: #fff;
            background-color: #0b5698;
            border-color: #204d74;
            margin-bottom: 15px;
            box-shadow: 2px 2px 6px #666;
        }

        .category-img-box a {
            /*display: inline-block;*/
            color: #fff;
            height: 130px;
        }

        .category-img-box img {
            padding: 5px;
        }
    </style>

@endsection
@section ('content')

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

    {{ Form::open(array('url' => 'admin/dashboard/neptune','method'=>'POST','files'=>'true','id'=>'usersdata') )}}

    <div class="row">
        <div class="col-md-12">

            <div class="pull-right" style="padding: 10px;">
                {{ Form::select('user_id',$user_list,$user_id,array('class'=>'','id'=>'user_data','style'=>'width:110px;')) }}
            </div>

        </div>
    </div>
    <br>

    {{Form::close()}}

    <br>
    <div class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h2 style="text-align: center;color: #0b5698">{{$user['user_name']}}</h2>
                    <div class="category-img-box text-center">
                        <a class="vertical-middle" href="#" style="text-decoration: none">
                            {{--<label style="text-align: center;font-size:80px">100</label>--}}
                            <span class="text-center" style="font-size: 30px">
                               <span>Logins : {{$user['login']}}</span><br/>
                               <span>Orders : {{$user['order']}}</span><br/>

                           </span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h2 style="text-align: center;color: #0b5698">{{$client_name}}</h2>
                    <div class="category-img-box text-center">
                        <a class="vertical-middle" href="#" style="text-decoration: none">
                            {{--<label style="text-align: center;font-size:80px">50  </label>--}}

                            <span class="text-center" style="font-size: 30px">


                               <span>Logins : {{$client['login']}}</span><br/>
                               <span>Orders : {{$client['order']}}</span><br/>
                           </span>
                        </a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="blue-color text-center"><b>{{$client_name}} Users Login Details</b></h4>
                    <div id="user-login"></div>
                    <hr>
                </div>
                <div class="col-sm-12">
                    <h4 class="blue-color text-center"><b>{{$client_name}} Users Order Details</b></h4>
                    <div id="user-order"></div>
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
    <br/>
    <br/>
    <!-- JQuery -->
    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/simple-chart.js')}}"></script>
    <!-- pie chart -->
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            google.charts.load("current", {packages: ["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            google.charts.setOnLoadCallback(drawCharts);

            function drawChart() {
                var user_details = <?php echo json_encode($userDetails); ?>;

                var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;

                var login = [['User', 'login', {role: "style"}]];

                $.each(user_details, function (i1, item) {

                    login.push([item.user_name + ' ' + item.login, item.login, "color: #3b6497"]);
                });

                var data = google.visualization.arrayToDataTable(login);


                var options = {

                    width: 'auto',
                    height: 400,
                    // legend: 'none',
                    pieSliceText: 'none',

                    // pieStartAngle: 100,
                    is3D: true,
                    colors: colors,
                    // tooltip: {
                    //     text: 'value',
                    //     pieSliceText: 'percentage',
                    //     textStyle: {
                    //         fontName: 'Avenir_Book',
                    //         fontSize: '14' },
                    //
                    //
                    //
                    // },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var allData = data.datasets[tooltipItem.datasetIndex].data;
                                var tooltipLabel = data.labels[tooltipItem.index];
                                var tooltipData = allData[tooltipItem.index];
                                var total = 0;


                                for (var i in allData) {
                                    total += allData[i];
                                }
                                var tooltipPercentage = (tooltipData / total) * 100;
                                tooltipPercentage = Math.round(tooltipPercentage);

                                return tooltipLabel + ': ' + tooltipData + ' (' + tooltipPercentage + '%)';
                            }
                        },
                        text: 'value',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        },
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

                var chart = new google.visualization.PieChart(document.getElementById('user-login'));
                chart.draw(data, options);
            }

            function drawCharts() {
                var user_details = <?php echo json_encode($userDetails); ?>;

                var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;

                var login = [['User', 'Order', {role: "style"}]];

                $.each(user_details, function (i1, item) {

                    login.push([item.user_name + ' ' + item.order, item.order, "color: #3b6497"]);
                });

                var data = google.visualization.arrayToDataTable(login);


                // var formatter = new google.visualization.NumberFormat({pattern: '#,##0',prefix: '$'});
                //
                // // format number columns
                // for (var i = 1; i < data.getNumberOfColumns(); i++) {
                //     formatter.format(data, i);
                // }

                var options = {

                    width: 'auto',
                    height: 400,
                    // legend: 'none',
                    pieSliceText: 'none',
                    // pieStartAngle: 100,
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
                    legend: {
                        position: 'labeled',
                        labeledValueText: 'none',
                        maxLines: 2,
                        textStyle: {
                            // color: 'blue',
                            fontSize: 14
                        }
                    },


                };

                var chart = new google.visualization.PieChart(document.getElementById('user-order'));
                chart.draw(data, options);
            }
        });

        $(document).on('change', '#user_data', function (event) {

            $('#usersdata').submit();
        });
    </script>
@endsection