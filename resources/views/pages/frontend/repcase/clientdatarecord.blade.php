@extends('layouts.repcase')
@section('content')
    <style type="text/css">
        .swapdate a {
            color: red;
        }
    </style>

    <div class="login-panel">
        <div class="header">
            <a class="menuicon" rel="popover" data-popover-content="#menu-popover" href="#"></a>

            <h1><img src="{{ URL::asset('/images/logo.jpg') }}"/></h1>
        </div>

        <div id="menu-popover" class="hide menu-popover">
            <ul class="menu">
                @if(Auth::user()->roll == '2')
                    <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Hospital</a></li>
                    <li class="menu-item"><a href="{{URL::to('selectclient')}}">Select Project</a></li>
                    <li class="menu-item"><a href="{{URL::to('menu')}}">Main Menu</a></li>

                    <li class="menu-item"><a href="{{URL::to('scorecard/physician')}}">Scorecards</a></li>
                    <li class="menu-item">
                        <a href="#">Repcasetracker</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter case details</a></li>
                            <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">view / edit case details</a></li>
                        </ul>
                    </li>
                @elseif(Auth::user()->roll == '5')
                    <li class="menu-item"><a href="{{URL::to('repcasetracker/addcase')}}">Enter Case Details</a></li>
                    <li class="menu-item"><a href="{{URL::to('repcasetracker/clients')}}">View/Edit Case Details</a></li>
                @endif

                <li class="menu-item"><a href="{{ URL::to('logout') }}">Log out</a></li>
            </ul>
        </div>

    </div>

    <div class="rap-case-tracker">
        <div class="case-entire-table">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <center>
                            <h4 class="rap-case-title">Case Entries - {{$itemfile}}</h4>
                            <table class="table case-data-table">
                                <tr>
                                    <th>Case ID:</th>
                                    <th>Manuf#</th>
                                    <th>P.O.#</th>
                                </tr>
                                <div style="display: none">{{$swapid = ''}}</div>
                                @if(count($data)>0)

                                    @foreach($data as $row)
                                        @if($row->swappedId == '')
                                            <tr class="{{$row->swapDate != '' ? 'swapdate':''}}">
                                                <td>
                                                    <a href="{{URL::to('repcasetracker/clients/record/list/'.$row->id)}}">{{$row->repcaseID}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{URL::to('repcasetracker/clients/record/list/'.$row->id)}}">{{$row->mfgPartNumber}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{URL::to('repcasetracker/clients/record/list/'.$row->id)}}">{{$row->poNumber}}</a>
                                                </td>

                                            </tr>
                                        @endif

                                        <div style="display: none">{{$swapid = $row->id}}</div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3"><center>No Data Found..!</center></td>
                                    </tr>
                                @endif
                            </table>
                        </center>
                    </div>
                </div>
            </div>

            <div class="bottom-btn-block">
                @if($status == 'produceDate')
                    <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-primary view-edit-details-btn">SELECT
                        A NEW DATE</a>
                @elseif($status =="caseid")
                    <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-primary view-edit-details-btn">SELECT
                        A NEW CASEID</a>
                @elseif($status == "poNumber")
                    <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-primary view-edit-details-btn">SELECT
                        A NEW P.O.NUMBER</a>
                @elseif($status == "physician")
                    <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-primary view-edit-details-btn">Select A New Physician</a>
                @elseif($status == "monthYear")
                    <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-primary view-edit-details-btn">Select A New Month</a>
                @elseif($status == "serialNumber")
                    <a href="{{URL::to('repcasetracker/clients')}}" class="btn btn-primary view-edit-details-btn">Select A New Serial Number</a>
                @endif
            </div>
        </div>
    </div>


@endsection