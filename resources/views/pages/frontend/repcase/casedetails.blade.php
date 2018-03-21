@extends('layouts.repcase')
@section('content')
    <!-- <div style="margin:-25px 20px 0 0;">
    <a class="menuinfoicon" href="#" title="Info">Info</a>
</div> -->

    <style type="text/css">
        table {
            border-collapse: separate;
            border-spacing: 0 1em;
        }

        .newswap tr td {
            background-color: #c7c6c6;
            font-size: 20px;
            padding-top: .5em;
            padding-bottom: .5em;
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
        <div class="case-details-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <center>
                            <h4 class="rap-case-title">Case Details</h4>
                            <table class="table case-details-table">
                                <tr>
                                    <td>Case ID:</td>
                                    <td>{{$data['repcaseID']}}</td>
                                </tr>
                                <tr>
                                    <td>Procedure Date:</td>
                                    <td>{{Carbon\Carbon::parse($data->itemfilename->produceDate)->format('m-d-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Hospital:</td>
                                    <td>{{$data->itemfilename->client['client_name']}}</td>
                                </tr>
                                <tr>
                                    <td>Rep User:</td>
                                    <td>{{$data->itemfilename->users['name']}}</td>
                                </tr>
                                <tr>
                                    <td>Physician:</td>
                                    <td>{{$data->itemfilename->physician}}</td>
                                </tr>

                            </table>
                            <h5>Devices Details</h5>
                            <table class="table case-details-table">
                                <tr>
                                    <td>Category:</td>
                                    <td>{{$data->category}}</td>
                                </tr>
                                <tr>
                                    <td>Manufaturer:</td>
                                    <td>{{$data->manufacturer}}</td>
                                </tr>
                                <tr>
                                    <td>Manuf Part #:</td>
                                    <td>{{$data->mfgPartNumber}}</td>
                                </tr>
                                <tr>
                                    <td>Hospital Part #:</td>
                                    <td>{{$data->hospitalPart}}</td>
                                </tr>
                                <tr>
                                    <td>Device Name:</td>
                                    <td>{{$data->supplyItem}}</td>
                                </tr>
                                {{--<tr>--}}
                                    {{--<td>Quantity:</td>--}}
                                    {{--<td>{{$data->quantity}}</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td>Purchase Type:</td>
                                    <td>{{$data->purchaseType}}</td>
                                </tr>
                                {{--<tr>--}}
                                    {{--<td>Order Id:</td>--}}
                                    {{--<td>{{$data->orderId == ''? '-': $data->orderId}}</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td>Serial Number:</td>
                                    <td>{{$data->serialNumber}}</td>
                                </tr>
                                <tr>
                                    <td>P.O. Numer:</td>
                                    <td>{{$data->poNumber}}</td>
                                </tr>
                            </table>
                            @if(!empty($swap))
                            <h4>Swapped Item {{Carbon\Carbon::parse($data->swapDate)->format('m-d-Y')}}</h4>
                                @if($swap['new'] == NULL)
                                <table class="table case-details-table newswap">
                                    <tr>
                                        <td>Serial Number:</td>
                                        <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                     style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['serialNumber']}}
                                        </td>
                                    </tr>

                                </table>
                                @else
                                    <table class="table case-details-table newswap">
                                        <tr>
                                            <td>Category:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['category']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Manufacture:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['manufacturer']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Manufacture Part Number#::</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['mfgPartNumber']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hospital Part Number:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['hospitalPart']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Device Name:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['supplyItem']}}
                                            </td>
                                        </tr>
                                        {{--<tr>--}}
                                            {{--<td>Quantity:</td>--}}
                                            {{--<td><span><i class="fa fa-minus-circle" aria-hidden="true"--}}
                                                         {{--style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['quantity']}}--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                        <tr>
                                            <td>Purchase Type:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['purchaseType']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Serial Number:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['serialNumber']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>P.O.Number:</td>
                                            <td><span><i class="fa fa-minus-circle" aria-hidden="true"
                                                         style="color: #1988da;"></i></span>&nbsp;&nbsp;{{$swap['poNumber']}}
                                            </td>
                                        </tr>

                                    </table>
                                @endif
                            @endif
                        </center>
                    </div>
                </div>
            </div>

            <div class="bottom-btn-block">
                <a href="{{URL::to('repcasetracker/swapdevice/'.$data->id)}}"
                   class="btn btn-primary view-edit-details-btn">SWAP DEVICE</a>
                <a href="{{ URL::to('repcasetracker/clients') }}"
                   class="btn btn-danger view-edit-details-btn">CANCEL</a>
            </div>
        </div>
    </div>

@endsection