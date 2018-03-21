<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/13/2018
 * Time: 11:06 AM
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
    </style>

@endsection
@section ('content')
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
    <br>
    <div class="dashboard">
        <div class="container">
            <div class="row">
                @forelse($category as $row)
                <div class="col-sm-4">
                    <a href="{{URL::to('admin/dashboard/unitapp/'.$row->id)}}" class="item-box btn btn-primary blue-btn vertical-middle">
                        @if(!empty($row->image))
                            <img src="{{URL::to($row->image)}}" class="img-responsive" alt=""> <br>
                        @endif
                            {{$row->category_name}}

                    </a>
                    <br/>
                    <br/>
                </div>
                @empty
                    <div class="col-sm-5 col-sm-offset-5">
                        <span> <b>No Data Found.!!</b></span>
                        <br/>
                        <br/>
                    </div>
                @endforelse
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
    {{--<script type="text/javascript" src="{{URL::asset('js/simple-chart.js')}}"></script>--}}
    <!-- pie chart -->
    {{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
    <script type="text/javascript">

    </script>
@endsection