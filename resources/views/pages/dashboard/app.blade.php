<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/13/2018
 * Time: 12:30 PM
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
        .filter {
            margin-right: 10px;
        }

        .category-img-box {
            color: #fff;
            background-color: #286090;
            border-color: #204d74;
            margin-bottom: 15px;

        }

        .category-img-box a {
            /*display: inline-block;*/
            color: #fff;
            height: 130px;
        }

        .category-img-box img {
            padding: 5px;
            margin: 0 auto;
            max-height: 100px;
            width: 60px;
            height: 60px;
        }

        .button-with-text {
            display: inline-block;
            vertical-align: top;
        }

        .button-with-text .txt {
            display: block;
        }

        .header-button {
            background: #e6e6e6;
            color: #fff;
            font-size: 30px;
            margin-top: 10px;
            display: inline-block;
        }

        .btn.btn-default.header-button.filter.active{
            background: #08579d;
            color: #fff;
            font-size: 30px;
            margin-top: 10px;
            display: inline-block;
        }



    </style>
@endsection
@section ('content')
    <div class="headerbar">
        <div class="container-fluid headclass">
            <center>
                <div class="container">
                    {{ Form::open(array('url' =>'admin/dashboard/unitapp/'.$id,'method'=>'POST','id'=>'targetas')) }}
                    <div class="row">

                        <div class="col-sm-2">
                        <span class="button-with-text">
                            <a href="#" class="btn btn-default header-button filter {{$unit == '' ? '' : 'active'}}"
                               data-id="unit">
                                <img src="{{URL::to('public/dashboard/neptune_icon.png')}}" width="40px" height="40px">
                                <input type="hidden" name="unit" value="{{$unit == '' ? '' : 'unit'}}"
                                       class="datafilter"
                                       id="unit">
                            </a>

                            <span class="txt">Unit</span>
                        </span>

                            <span class="button-with-text">
                            <a href="#" class="btn btn-default header-button filter {{$system == '' ? '' : 'active'}}"
                               data-id="system">
                                <img src="{{URL::to('public/dashboard/neptune_icon.png')}}" width="40px" height="40px">
                                 <input type="hidden" name="system" value="{{$system == '' ? '' : 'system'}}"
                                        class="datafilter" id="system">
                            </a>

                            <span class="txt">System</span>
                        </span>
                        </div>
                        <div class="col-sm-8"></div>
                        <div class="col-sm-2">
                         <span class="button-with-text">
                            <a href="#" class="btn btn-default header-button filter {{$entry == '' ? '' : 'active'}}"
                               data-id="entry">
                                <img src="{{URL::to('public/dashboard/neptune_icon.png')}}" width="40px" height="40px">
                                 <input type="hidden" name="entry" value="{{$entry == '' ? '' : 'entry'}}"
                                        class="datafilter"
                                        id="entry">
                            </a>

                            <span class="txt">Entry</span>
                        </span>

                            <span class="button-with-text">
                            <a href="#" class="btn btn-default header-button filter {{$advanced == '' ? '' : 'active'}}"
                               data-id="advanced">
                                <img src="{{URL::to('public/dashboard/neptune_icon.png')}}" width="40px" height="40px">
                                <input type="hidden" name="advanced" value="{{$advanced == '' ? '' : 'advanced'}}"
                                       class="datafilter" id="advanced">
                            </a>

                            <span class="txt">Advanced</span>
                        </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center" style="padding: 10px;">
                                {{ Form::select('year',$years,$year,array('class'=>'','id'=>'year_data','style'=>'width:110px;')) }}
                            </div>
                        </div>
                    </div>

                    {{Form::close()}}
                </div>
            </center>
        </div>
    </div>
    <br>
    <div class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-xs-2">
                    @foreach($even_category as $row)
                        <div class="category-img-box text-center">
                            <a class="vertical-middle" href="{{URL::to('admin/dashboard/unitapp/'.$row->id)}}">
                                @if($row->image != '')
                                    <img src="{{URL::to($row->image)}}" class="img-responsive"><br/>
                                @endif
                                {{$row->category_name}}
                            </a>

                        </div>
                    @endforeach
                </div>
                <div class="col-xs-8">
                    <h2 class="blue-title-text"
                        style="text-align: center">{{getclientName($client_name)}} {{$categoryName}} Average Purchase
                        Price (APP)</h2>

                    <div class="row">

                        @if(count($manufacture) > 0)
                            <div class="col-sm-12">
                                {{--<div id="chart_div2" data-toggle="modal" data-target="#myModal"></div>--}}
                                <div id="chart_div_manufacture"></div>

                            </div>
                        @else
                            <div class="col-sm-12">
                                <center><span> <b>No Data Found.!!</b></span></center>
                                <br/>
                                <br/>
                            </div>
                        @endif
                    </div>
                    <br/>

                    <h2 class="blue-title-text" style="text-align: center">M.D. {{$categoryName}} Average Purchase Price
                        (APP)</h2>
                    <div class="row">
                        @forelse($physician as $item => $value)
                            <div class="col-sm-6">
                                {{--<div id="chart_div2" data-toggle="modal" data-target="#myModal"></div>--}}
                                <div id="chart_div_{{$value['physician_name']}}" class="manu"
                                     data-id="{{$value['physician_name']}}"></div>
                                <input type="hidden" name="physician" class="physician"
                                       data-id="{{$value['physician_name']}}"
                                       value="{{$value['physician_name']}}">
                                <br>
                                <br>
                            </div>
                        @empty
                            <div class="col-sm-12">
                                <center><span> <b>No Data Found.!!</b></span></center>
                                <br/>
                                <br/>
                            </div>
                        @endforelse
                    </div>

                </div>
                <div class="col-xs-2">
                    @foreach($odd_category as $rows)
                        <div class="category-img-box text-center">
                            <a class="vertical-middle" href="{{URL::to('admin/dashboard/unitapp/'.$rows->id)}}">
                                @if($rows->image != '')
                                    <img src="{{URL::to($rows->image)}}" class="img-responsive"><br/>
                                @endif
                                {{$rows->category_name}}
                            </a>

                        </div>
                    @endforeach

                </div>
            </div>

            <br/>
            <br/>
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
    <script type="text/javascript" src="{{URL::asset('js/jsapi.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/loader.js')}}"></script>
    <script type="text/javascript">

        // Load the Visualization API library and the piechart library.
        google.load('visualization', '1.0', {'packages': ['corechart', 'bar']});

    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAxisTickColors);

            var category = <?php echo json_encode($category); ?>;
            /**
             * Manufacture Data Calculation Start
             */
            var manufactures = <?php echo json_encode($manufacture); ?>;

            var colors = <?php echo json_encode(Config('neptune.barcolors')); ?>;

            var value = [category.minvalue, category.maxvalue];
            var datas = [['Manufacture', 'value', {role: 'style'},{ role: 'annotation'}]];
            if (manufactures.length != 0) {
                var j = 0;
                $.each(manufactures, function (i, item) {
                    if (item.manufacturer_name == 'Average' || item.manufacturer_name == "Average App") {
                        datas.push(['{{getclientName($client_name)}}' + ' APP', item.avgvalue, "color:" + colors[j],item.avgvalue]);
                    } else {
                        datas.push([item.manufacturer_name + ' APP', item.avgvalue, "color:" + colors[j],item.avgvalue]);
                    }

                    j++;
                });

            }

            manufacture(datas, value);

            /**
             * Manufacture Data Calculation end
             */
            var system = "{{$system }}";
            var unit = "{{$unit}}";


            /**
             * physician Manufacture Data calculation start
             */

                var physicianmanufacture = <?php echo json_encode($phymanufature); ?>;
                var phymanufdata = '';
                var phym = '';
                var manufp = '';
                var phymanufvalue = [category.minvalue, category.maxvalue];

                $.each(physicianmanufacture, function (i, item) {

                    var phymanufdata = [['', 'value', {role: 'style'},{ role: 'annotation'}]];
                    var newdata = '';
                    var k = 0;
                    var avg = '';
                    $.each(item, function (is, items) {

                            if(items.physician_name == 'Avg Value') {
                                if(avg != 'Avg Value') {
                                    phymanufdata.push(['{{getclientName($client_name)}}' + ' APP', items.avgvalue, "color:" + colors[k],items.avgvalue]);
                                }
                                avg = items.physician_name;
                            } else {
                                phymanufdata.push([items.manufacturer_name + ' APP', items.avgvalue, "color:" + colors[k],items.avgvalue]);
                            }

                        k++;
                    });
                    phym = 'chart_div_' + i;

                    physician(phymanufdata, phymanufvalue, phym, i);
                });

            /**
             * physician Manufacture Data calculation End
             */

            function drawAxisTickColors() {

                var markets = <?php echo json_encode($category); ?>;

                if (markets == '') {
                    var min = [0, 0];
                    var market = [['', 'value', {role: 'style'}],
                        ['Avg App', 0, '#08579d'],
                        // ['Batch',0,'red'],
                    ];
                } else {
                    var min = [markets.minvalue, markets.maxvalue];
                    var market = [['', 'value', {role: 'style'}],
                        ['Avg App', markets.avgvalue, '#08579d'],
                        // ['Batch',0,'red'],
                    ];
                }

                var data = google.visualization.arrayToDataTable(market);


                var options = {
                    title: 'VVIP IPG - Entry Average Purchage Price',
                    chartArea: {width: '30%'},
                    focusTarget: 'category',
                    fontName : 'Avenir_Book',
                    labeledValueText: 'none',
                    fontSize: 12,
                    legend: 'none',
                    hAxis: {
                        textStyle: {
                            fontSize: 14,
                            color: '#053061',
                            bold: true,
                            italic: false,
                            fontName : 'Avenir_Book'
                        },
                        titleTextStyle: {
                            fontSize: 18,
                            color: '#053061',
                            bold: true,
                            italic: false,
                            fontName : 'Avenir_Book'
                        }
                    },
                    vAxis: {
                        format: '$#,###',
                        textStyle: {
                            fontSize: 18,
                            color: '#053061',
                            // fontName : 'Avenir_Book'

                        },
                        ticks: min
                    },

                };
                var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
                chart1.draw(data, options);
            }

            function manufacture(datas, value) {


                var data = google.visualization.arrayToDataTable(datas);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2]);

                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

                var options = {
                    title: '{{getclientName($client_name)}} {{$categoryName}} Average Purchase Price (APP)',
                    chartArea: {width: '40%'},
                    focusTarget: 'category',
                    fontName : 'Avenir_Book',
                    legend: 'none',

                    hAxis: {
                        textStyle: {
                            fontSize: 14,
                            color: '#053061',
                            bold: true,
                            italic: false,
                            fontName : 'Avenir_Book'
                        },
                        titleTextStyle: {
                            fontSize: 18,
                            color: '#053061',
                            bold: true,
                            italic: false,
                            fontName : 'Avenir_Book'
                        }
                    },
                    height: 300,
                    vAxis: {
                        format: '$#,###',
                        textStyle: {
                            fontSize: 18,
                            color: '#053061',
                            fontName : 'Avenir_Book'

                        },
                        ticks: value
                    },


                };
                var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div_manufacture'));
                chart1.draw(data, options);


            }

            function physician(phymanufdata, phymanufvalue, phym, i) {

                var data = google.visualization.arrayToDataTable(phymanufdata);

                var view = new google.visualization.DataView(data);

                view.setColumns([0, 1,
                    {
                        calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"
                    },
                    2]);

                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var j = 1; j < data.getNumberOfColumns(); j++) {
                    formatter.format(data, j);
                }

                var options = {
                    title: i + ' APP',
                    chartArea: {width: '40%'},
                    focusTarget: 'category',
                    // fontName : 'Avenir_Book',
                    labeledValueText: 'none',
                    fontSize: 12,
                    legend: 'none',
                    hAxis: {
                        textStyle: {
                            fontSize: 14,
                            color: '#053061',
                            bold: true,
                            italic: false,
                            // fontName : 'Avenir_Book'
                        },
                        titleTextStyle: {
                            fontSize: 18,
                            color: '#053061',
                            bold: true,
                            italic: false,
                            // fontName : 'Avenir_Book'
                        }
                    },

                    vAxis: {
                        format: '$#,###',
                        textStyle: {
                            fontSize: 18,
                            color: '#053061',
                            // fontName : 'Avenir_Book'

                        },
                        ticks: phymanufvalue
                    },

                };

                var chart1 = new google.visualization.ColumnChart(document.getElementById(phym));
                chart1.draw(data, options);
            }

            function physicianschart(phydata, phyvalue, phy) {


                var data = google.visualization.arrayToDataTable(phydata);
                var formatter = new google.visualization.NumberFormat({pattern: '#,##0', prefix: '$'});

                // format number columns
                for (var i = 1; i < data.getNumberOfColumns(); i++) {
                    formatter.format(data, i);
                }

                var options = {
                    title: phy + ' APP',
                    chartArea: {width: '40%'},
                    focusTarget: 'category',
                    labeledValueText: 'none',
                    fontSize: 12,
                    titleTextStyle: {},
                    legend: 'none',
                    hAxis: {
                        textStyle: {
                            fontSize: 14,
                            color: '#053061',
                            bold: true,
                            italic: false
                        },
                        titleTextStyle: {
                            fontSize: 18,
                            color: '#053061',
                            bold: true,
                            italic: false
                        }
                    },

                    vAxis: {
                        format: '$#,###',
                        textStyle: {
                            fontSize: 18,
                            color: '#053061',
                            // fontName : 'Avenir_Book'

                        },
                        ticks: phyvalue,
                    },

                };
                var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div_' + phy));
                chart1.draw(data, options);
            }

        });

        $(document).on('click', '.filter', function (event) {
            var dataId = $(this).attr("data-id");
            var value = $('#' + dataId).val();

            if (value == '') {
                if (dataId == 'unit') {
                    $("#system").val('');
                    $("#unit").val('unit');
                    $(".filter[data-id=" + dataId + "]").addClass("active");
                    $(".filter[data-id='system']").removeClass("active");
                } else if (dataId == 'system') {
                    $("#system").val('system');
                    $("#unit").val('');
                    $(".filter[data-id=" + dataId + "]").addClass("active");
                    $(".filter[data-id='unit']").removeClass("active");
                } else if (dataId == 'entry') {
                    $("#entry").val('entry');
                    $("#advanced").val('');
                    $(".filter[data-id=" + dataId + "]").addClass("active");
                    $(".filter[data-id='advanced']").removeClass("active");
                } else if (dataId == 'advanced') {
                    $("#entry").val('');
                    $("#advanced").val('advanced');
                    $(".filter[data-id=" + dataId + "]").addClass("active");
                    $(".filter[data-id='entry']").removeClass("active");
                }

                $("#targetas").submit();
            }
        });

        $(document).on('change', '#year_data', function (event) {
            $("#targetas").submit();
        });


    </script>
@endsection