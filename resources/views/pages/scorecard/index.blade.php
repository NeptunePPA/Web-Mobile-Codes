<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 12/30/2017
 * Time: 2:32 PM
 */-->
@extends ('layout.default')
@section ('content')

    <style type="text/css">
        .clientms {
            height: 100%;
            width: 100%;
        }

        .devicedata {
            text-align: center !important;
        }

        .venderms {
            height: 100%;
            width: 100%;
        }

        .clientspend {
            height: 100%;
            width: 100%;
            margin-bottom: 35px;
        }

        .username {
            padding-bottom: 15px;
        }

        .userdetails tr {
            background: #93bae987;
            font-weight: bold;
            border-bottom: 10px solid white;
        }

        .userdetails tr td {
            background: #93bae987;

        }

        tbody.userdetails tr:nth-child(n) td {
            background: #ebecec;
        }

        .clientimgae {
            padding-top: 70px;
            padding-left: 90px;
        }

        .scorecard_div {
            border-right: 8px solid #ebecec;
        }

        .category-img-box {
            color: #fff;
            background-color: #ebf3fb;
            border-color: #204d74;
            margin-bottom: 15px;
            box-shadow: 2px 2px 6px #666;
            width: 100%;
            padding: 20px;
        }

        .category-img-box a {
            /*display: inline-block;*/
            color: #fff;
            height: 60px;
        }

        .category-img-box img {
            padding: 5px;
        }

        .border-data{
            box-shadow: 1px 1px 15px #666;
            border-radius: 7px;
        }

        .table tbody tr:first-child td:first-child {
            border-radius: 7px 0 0 0;

        }
        .table tbody tr:first-child td:last-child {
            border-radius: 0 7px 0 0;

        }

        .table tbody tr:last-child td:first-child {
            border-radius: 0 0 0 7px;

        }
        .table tbody tr:last-child td:last-child {
            border-radius: 0 0 7px 0;

        }
        .cost tr:first-child td {
            border: 0;
        }

    </style>

    <div class="content-area">


        <h3 style="text-align: center;">Scorecard</h3>

        {{--<div class="col-sm-12" style="text-align: center;">--}}

            {{--<img src="{{$client_image}}" width="500px" height="150px">--}}
        {{--</div>--}}

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 top-links clearfix">

                    {{ Form::open(array('url' =>'admin/users/scorecard/view/'.$id,'method'=>'POST','id'=>'targetas')) }}
                    <ul class="add-links pull-right">

                        <?php
                        $resultstr = array();
                        foreach ($users->userclients as $row) {
                            $resultstr[] = $row->clientname['client_name'];
                        }

                        ?>
                        @if(count($resultstr)>0)

                            @foreach($resultstr as $row)
                                <li><a href="#" id="clientname" data-id="{{$row}}">{{$row}}</a></li>
                            @endforeach
                            <input type="hidden" name="client" value="{{$client}}" class="client" id="client">
                            <li>{{form::select('project_id',$project_name,$user_project['projectId'],array('id' => 'project_name'))}}</li>
                        @endif

                        <li><a href="{{ URL::to('admin/users/scorecard/'.$users['id'])}}" id="deviceexport">Close</a>
                        </li>

                    </ul>
                    {{Form::close()}}

                </div>

                <!-- Client Scorecard Start-->
                <hr>
                <div class="col-sm-12">

                    {{--</div>--}}
                    <div class="col-sm-4">

                        <table class="table" style="color:#0b5698;">
                            <thead>
                            <tr>
                                <th colspan="3">
                                    <center>{{$score->months->month}} {{$score['year']}}</center>
                                </th>
                            </tr>
                            <tr>
                                <th>Vendor</th>
                                <th>Spend</th>
                                <th>MS</th>
                            </tr>
                            </thead>
                            <tbody id='scorecardhtml'>

                            @foreach($Final_client_marketshare as $row)
                                <tr>
                                    <td>{{$row['manufacture']}}</td>
                                    <td>{{$row['totalspend'] == '' ? '-' : '$ '.number_format($row['totalspend'])}}</td>
                                    <td>{{$row['ms'] == '' ? '-' : round($row['ms'],0)}} %</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                    </div>
                    <div class="col-sm-4">
                        <div id="clientms" class="clientms text-center"></div>
                    </div>
                    <div class="col-sm-4">
                        <div style="height: 300px;position: relative;">
                            <div style="position: absolute; right: 0; bottom: 0; width: 66%;">
                                <h2 style="text-align: center;color: #0b5698">Monthly Saving</h2>
                                <div class="category-img-box text-center pull-right border-data">
                                    <a class="vertical-middle" href="#" style="text-decoration: none">
                                        <span class="text-center" style="font-size: 30px">
                                             @if($clientDelta < 0)
                                                <span style="color: #0b5698"> $ ({{number_format(abs($clientDelta))}})</span>
                                            @else
                                                <span style="color: red"> $ {{number_format($clientDelta)}}</span>
                                            @endif


                                        </span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                </div>

                <div class="col-sm-12" style="padding-top: 25px;color:#0b5698 ;">
                    <br>
                    <div style="display: none">{{$i = 1}}
                        {{$j = 1}}

                        {{$z = 0}}

                    </div>

                    @foreach($finalclient as $item =>$value)
                        <div style="display: none">{{$total = 0}}</div>

                        @if($value[0]['totaldevice'] != 0 || $value[1]['totaldevice'] != 0)

                            <div class="col-md-6 col-sm-12 col-xs-12" style="height: 310px;">
                                <div class="category-img-box text-center border-data"
                                     style="background: {{$color[$z]}}; padding: 15px;">
                                    <a class="vertical-middle" href="#" style="text-decoration: none;color:#0b5698;">
                                        <span class="text-center" style="font-size: 20px">
                                            {{$item}}
                                        </span>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{$score['year'] - 1}} APP</th>
                                            <th>Utilization</th>
                                            <th>Spend</th>
                                            <th>{{$score['year']}} APP</th>
                                            <th>Spend</th>
                                            <th>Delta</th>
                                        </tr>
                                        </thead>
                                        <tbody class="border-data">


                                        @if($value[2] != 2)
                                            <tr class="active">

                                                <td>{{$item}}</td>
                                                <td>$ {{number_format($value[$value[2]]['oldavgvlaue'])}}</td>
                                                <td>{{number_format($value[$value[2]]['totaldevice'])}}</td>
                                                <td>$ {{number_format($value[$value[2]]['oldSpend'])}}</td>
                                                <td>$ {{number_format($value[$value[2]]['currentavgvalue'])}}</td>
                                                <td>$ {{number_format($value[$value[2]]['newSpend'])}}</td>
                                                <td>$ {{number_format($value[$value[2]]['delta'])}}</td>
                                            </tr>
                                            <div style="display: none">{{$total = $value[$value[2]]['delta']}}</div>
                                        @else
                                            @if($value[0]['totaldevice'] != 0)
                                                <tr class="info">
                                                    <td>Entry</td>
                                                    <td>$ {{number_format($value[0]['oldavgvlaue'])}}</td>
                                                    <td>{{number_format($value[0]['totaldevice'])}}</td>
                                                    <td>$ {{number_format($value[0]['oldSpend'])}}</td>
                                                    <td>$ {{number_format($value[0]['currentavgvalue'])}}</td>
                                                    <td>$ {{number_format($value[0]['newSpend'])}}</td>
                                                    <td>$ {{number_format($value[0]['delta'])}}</td>
                                                </tr>
                                                <div style="display: none">{{$total = $value[0]['delta']}}</div>
                                            @endif
                                            @if($value[1]['totaldevice'] != 0)
                                                <tr class="active">
                                                    <td>Advanced</td>
                                                    <td>$ {{number_format($value[1]['oldavgvlaue'])}}</td>
                                                    <td>{{number_format($value[1]['totaldevice'])}}</td>
                                                    <td>$ {{number_format($value[1]['oldSpend'])}}</td>
                                                    <td>$ {{number_format($value[1]['currentavgvalue'])}}</td>
                                                    <td>$ {{number_format($value[1]['newSpend'])}}</td>
                                                    <td>$ {{number_format($value[1]['delta'])}}</td>
                                                </tr>
                                                <div style="display: none">{{$total += $value[1]['delta']}}</div>
                                            @endif
                                        @endif
                                        <tr style="font-size: 15px;">
                                            @if($total < 0)
                                            <td colspan="6">Total Saving</td>
                                            <td>$({{number_format(abs($total))}})</td>
                                            @else
                                                <td colspan="6" style="color: red">Cost Increase</td>
                                                <td style="color: red">${{number_format($total)}}</td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="display: none;">

                                {{$j = $i/2}}

                                @if(is_int($j))
                                    {{$z = $j}}
                                @endif

                            </div>
                            <div style="display: none">{{$i++}}</div>
                        @endif
                    @endforeach

                </div>

                <!-- Client Scorecard End-->
                <div class="row">
                    <div class="pull-right">
                        <img src="{{URL::to('images/logo.png')}}" width="300px" alt="Neptune PPA" height="50px"
                             style="padding-top: 10px;">

                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="col-sm-4 username">
                        <h2>{{$users['name']}}</h2>
                        <img src="{{$users['profilePic']}}" width="200px" height="200px">
                    </div>
                    <div class="col-sm-8 clientimgae">

                        <img src="{{$users['client_image']}}" width="500px" height="150px">
                    </div>
                </div>
                <div class="row" style="color:#0b5698 ;">
                    <div class="col-sm-8" style="padding-top: 25px;">

                        <div class="col-sm-4" style="color:#0b5698 ;">

                            <table class="table cost">
                                <thead>

                                </thead>
                                <tbody>

                                <tr class="info">
                                    <td style="background: #93bae987;font-weight: bold;">Cost Differential</td>
                                    <td style="color: red">$ {{number_format($costdiff)}}</td>
                                </tr>
                                <tr class="info">
                                    <td style="background: #93bae987;font-weight: bold;">Total Spend</td>
                                    <td>$ {{number_format($totalspend)}}</td>
                                </tr>
                                <tr class="info">
                                    <td style="background: #93bae987;font-weight: bold;">% CD of Final Cost</td>
                                    @if($costdiff != 0 && $totalspend != 0)
                                        <td> {{round(($costdiff/$totalspend) * 100,0)}} %</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>

                                </tbody>
                            </table>

                        </div>


                        @foreach($device as $key =>$value)
                            <div class="category-img-box text-center pull-right border-data"
                                 style="background: #e4ebf5; padding: 5px; color:#0b5698 ;">
                                <a class="vertical-middle" href="#" style="text-decoration: none">
                                        <span class="text-center" style="font-size: 20px;color:#0b5698 ;">
                                            {{$key}}
                                        </span>
                                </a>
                            </div>
                            <table class="table" style="font-size: 8px;">
                                <thead>

                                <tr class="border-data">
                                    <th colspan="7" class="active">
                                        <center>Implanted Device</center>
                                    </th>
                                    <th colspan="4" class="info">
                                        <center>Alternative Device</center>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Company</th>
                                    <th>Device Name</th>
                                    <th>Technology</th>
                                    <th>Bulk/Consigned</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Final Cost ID</th>

                                    <th>Company</th>
                                    <th>Device Name</th>
                                    <th>AD Unit Price</th>
                                    <th>Delta</th>
                                </tr>
                                </thead>

                                    <tbody class="border-data">
                                    @foreach($value as $row)
                                    <tr>

                                        <td>{{$row->manufacturer}}</td>
                                        <td>{{$row->device_name}}</td>
                                        <td>{{$row->level_name}}</td>
                                        <td>{{$row->purchaseType}}</td>
                                        <td>1</td>
                                        <td>{{number_format($row->price)}}</td>
                                        <td>{{number_format($row->price)}}</td>
                                        <td>{{$row->comparecompany}}</td>
                                        <td>{{$row->comparedevice_name}}</td>
                                        <td>{{number_format($row->compareprice)}}</td>
                                        <td style="color :{{$row->count == "loss" ? 'red' : 'green'}}">
                                            $ {{number_format($row->countprice)}}
                                        </td>
                                    </tr>

                                @endforeach
                                    </tbody>
                            </table>

                        @endforeach

                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-12">
                            <div class="text-center" id="marketshare"></div>
                        </div>
                        <div class="col-sm-12">
                            <div class="text-center" id="tech"></div>
                        </div>

                        <div class="col-sm-12">
                            <div class="text-center" id="bulk"></div>
                        </div>
                        <div class="col-sm-12">
                            <div class="text-center" id="vender"></div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="pull-right">
                        <img src="{{URL::to('images/logo.png')}}" width="300px" alt="Neptune PPA" height="50px"
                             style="padding-top: 10px;">

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>
    {{--<script type="text/javascript" src="{{URL::asset('js/jsapi.js')}}"></script>--}}
    <script type="text/javascript">

        $(document).on('click', '#clientname', function (event) {
            var id = $(this).attr('data-id');
            $(".client").val(id);

            $('#targetas').submit();
        });

        $(document).on('change', '#project_name', function (event) {

            $("#client").val();

            $('#targetas').submit();
        });
    </script>

    <script type="text/javascript">


        $(document).ready(function () {
            google.charts.load("current", {packages: ["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            google.charts.setOnLoadCallback(drawCharts);
            google.charts.setOnLoadCallback(tech);
            google.charts.setOnLoadCallback(bulk);
            google.charts.setOnLoadCallback(clientmarketsharechart);
            // google.charts.setOnLoadCallback(vendormarketsharechart);
            // google.charts.setOnLoadCallback(drawVisualization);

            var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;

            var datacolor = ['#0E2C61','#808080'];

            function drawChart() {
                var markets = <?php echo json_encode($marketShare); ?>;
                var market = [['Company', 'Spend', 'Marketshare']];
                // var iCnt = 0;
                console.log(markets);
                $.each(markets, function (i, item) {
                    market.push([item.manufacture + ' ' + item.marketshare + '%', item.totalspend, item.marketshare]);
                });
                var data = google.visualization.arrayToDataTable(market);


                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

                var options = {
                    title: 'Market Share',
                    width: 'auto',
                    height: 300,
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
                        maxLines: 1,
                        textStyle: {
                            // color: 'blue',
                            fontSize: 14
                        }
                    },

                };

                var chart = new google.visualization.PieChart(document.getElementById('marketshare'));
                chart.draw(data, options);
            }

            function drawCharts() {
                var markets = <?php echo json_encode($vender); ?>;
                var market = [["Manufacture", "Total Loss (in $)", {role: "style"}]];
                // var iCnt = 0;
                var j = 0;
                $.each(markets, function (i, item) {

                    market.push([item.manufacture, item.loss, "color:" + colors[j]]);
                    j++;
                });
                var data = google.visualization.arrayToDataTable(market);


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
                    title: "CD Per Vendor",
                    bar: {groupWidth: "80%"},
                    legend: {position: "none"},
                    vAxis: {
                        format: '$#,###',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        },

                    },
                    tooltip: {
                        text: 'value',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        }

                    },

                    fontName: 'Avenir_Book',
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("vender"));
                chart.draw(view, options);
            }

            function tech() {
                var markets = <?php echo json_encode($technology); ?>;
                var market = [["Technology", "Usage", {role: "style"}]];
                // var iCnt = 0;
                var j = 0;
                $.each(markets, function (i, item) {
                    // console.log(item);
                    market.push([item.value, item.count, "color:" + datacolor[j]]);
                    j++;
                });
                var data = google.visualization.arrayToDataTable(market);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2]);

                var formatter = new google.visualization.NumberFormat({pattern: '#,##0'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

                var options = {
                    title: "Tech Utilization",
                    bar: {groupWidth: "80%"},
                    legend: {position: "none"},
                    tooltip: {
                        text: 'value',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        },
                    },
                    vAxis: {
                        format: '#,###',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        },

                    },
                    fontName: 'Avenir_Book',
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("tech"));
                chart.draw(view, options);
            }

            function bulk() {
                var markets = <?php echo json_encode($bulkcount); ?>;
                var market = [["Bulk v/s Consigned", "Usage", {role: "style"}]];
                // var iCnt = 0;
                var j = 0;
                $.each(markets, function (i, item) {
                    // console.log(item);
                    market.push([item.value, item.count, "color:" + datacolor[j]]);
                    j++;
                });
                var data = google.visualization.arrayToDataTable(market);


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
                    title: "Bulk v/s Consigned",
                    bar: {groupWidth: "60%"},
                    legend: {position: "none"},
                    tooltip: {
                        text: 'value',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        }

                    },
                    vAxis: {
                        format: '#,###',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        },

                    },
                    fontName: 'Avenir_Book',
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("bulk"));
                chart.draw(view, options);
            }

            /**
             * client Marketshare
             */
            function clientmarketsharechart() {
                var clientmss = <?php echo json_encode($Final_client_marketshare); ?>;
                var markets = [['Company', 'Spend', 'Marketshare']];
                // var iCnt = 0;
                $.each(clientmss, function (i, item) {
                    markets.push([item.manufacture + ' ' + item.ms + '%', item.totalspend, item.ms]);
                });
                var data = google.visualization.arrayToDataTable(markets);

                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

                var options = {
                    title: 'Spend % MS',
                    width: 'auto',
                    height: 300,
                    // legend: 'none',
                    // pieSliceText: 'label',
                    // pieStartAngle: 100,
                    is3D: true,
                    colors: colors,
                    pieSliceText: 'none',
                    tooltip: {
                        text: 'value',
                        textStyle: {
                            fontName: 'Avenir_Book',
                            fontSize: '14'
                        }

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

                var chart = new google.visualization.PieChart(document.getElementById('clientms'));
                chart.draw(data, options);
            }

        });
    </script>
@stop