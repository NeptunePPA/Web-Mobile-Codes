<!--
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 2/20/2018
 * Time: 10:39 AM
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

        .bar-chart .sc-chart.sc-bar.sc-10-items{
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

    <div class="row" style="background: #135bae;color: #fff">

            <div class="col-md-4 text-center" style="font-size: 27px;padding-top: 5px;"><i class="fa fa-cog pull-left" aria-hidden="true" style="padding-top: 7px;"></i></div>
            <div class="col-md-4 text-center" style="font-size: 35px;">Bulk Inventory</div>
            <div class="col-md-4 text-center" style="font-size: 27px;padding-top: 5px;"></div>

    </div>

    <div class="row">
        <div style="display: none">{{$i=1}}</div>
        @forelse($bulk as $row =>$items)
        <div class="col-md-4">
            <h4 class="blue-color text-center"><b style="text-align: center">{{$row}}</b></h4>
            <div id="drawChart{{$i}}" style="width: 100%"></div>
        </div>
            <div style="display: none">{{$i++}}</div>
        @empty
        <div class="col-md-12">No Data found</div>
            @endforelse
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
    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/simple-chart.js')}}"></script>
    <!-- pie chart -->
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jsapi.js')}}"></script>
    <script type="text/javascript">

        // Load the Visualization API library and the piechart library.
        google.load('visualization', '1.0', {'packages':['corechart']});

        // ... draw the chart...
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:['corechart']});


        var bulks = <?php echo json_encode($bulk); ?>;
        var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;
        var t = 1;
        $.each(bulks, function (i, item) {
            var bulk = [['Manufacture', 'Bulk', {role: "style"}]];
            var j = 0;
            $.each(item, function (ii,items) {
                bulk.push([items.manufacture_name, items.bulk, "color:" + colors[j]]);
                j++;
                var id = "drawChart"+t
                var title = item;
                drawChart(bulk,id);
            });


            t++;
        });

        // google.charts.setOnLoadCallback(datas);

        function drawChart(bulk,id) {

            var data = google.visualization.arrayToDataTable(bulk);

            var view = new google.visualization.DataView(data);

            var formatter = new google.visualization.NumberFormat({pattern: '#,##0'});

            // format number columns
            for (var k = 1; k < data.getNumberOfColumns(); k++) {
                formatter.format(data, k);
            }

            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                width: 'auto',
                height: 400,
                bar: {groupWidth: "85%"},
                legend: { position: "none" },
                tooltip: {
                    text: 'value',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14' }

                },
                vAxis: {
                    format: '#,###',
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14'
                    },

                },
                hAxis: {
                    textStyle: {
                        fontName: 'Avenir_Book',
                        fontSize: '14'
                    },

                },
                fontName: 'Avenir_Book',
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("drawChart"+t));

            chart.draw(view, options);
        }
        google.setOnLoadCallback(drawChart);

    </script>
    @endsection