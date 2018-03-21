@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix">
        <a title="" href="{{ URL::to('admin/devices') }}" class="pull-right">X</a>

        <div class="tab-container">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" id="0" class="active"><a href="#Devices-Details" aria-controls="Devices-Details"
                                                                 role="tab" data-toggle="tab">Device Details</a></li>
                <li role="presentation" id="1"><a href="#Prices-Details" aria-controls="Prices-Details" role="tab"
                                                  data-toggle="tab">Price Details</a></li>
                <li role="presentation" id="2"><a href="#Features" aria-controls="Features" role="tab"
                                                  data-toggle="tab">Features</a>
                </li>
                <li role="presentation" id="3"><a href="#Contacts" aria-controls="Contacts" role="tab"
                                                  data-toggle="tab">Contacts</a>
                </li>
                <li role="presentation" id="4"><a href="#Survey" aria-controls="Survey" role="tab" data-toggle="tab">Physician
                        Preference</a>
                </li>
                <li role="presentation" id="5"><a href="#Reps" aria-controls="Reps" role="tab"
                                                  data-toggle="tab">Reps</a>
                </li>
                <li role="presentation" id="6"><a href="#Serial" aria-controls="Serial" role="tab" data-toggle="tab">Serial
                        Number</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="Devices-Details">

                    @if(Auth::user()->roll == 1)
                        <a title="" href="{{ URL::to('admin/devices/edit/'.$device_view->id) }}" class="pull-right"
                           style="margin-top:10px;" data-toggle="modal" style="float:right;">Edit Device Details</a>
                    @endif
                    <div class="col-md-12 col-lg-12 modal-box" style="border:solid 1px #ccc; margin-top:10px;">
                        <div class="content-area clearfix" style="padding:30px 0px 30px 0px;">

                            <div class="col-md-6 col-lg-6 modal-box" style="border-right:solid 1px #ccc;">
                                <div class="input1">
                                    {{Form::label('label1', 'Device Image',array("style"=>"vertical-align:top;"))}}
                                    <img src="{{URL::to('public/upload/'.$device_view->device_image )}}" width="210"
                                         height="150"
                                         style="border:solid 1px #ccc;"/>
                                </div>
                                <div class="input1">
                                    {{Form::label('label2', 'Select Level')}}
                                    {{ Form::text('level',$device_view->level_name,array('placeholder'=>'Device ID','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label2', 'Select Project')}}
                                    {{ Form::text('project',$device_view->project_name,array('placeholder'=>'Device ID','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label2', 'Select Category')}}
                                    {{ Form::text('category',$device_view->category_name,array('placeholder'=>'Device ID','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label2', 'Device ID')}}
                                    {{ Form::text('deviceid',$device_view->id,array('placeholder'=>'Device ID','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label3', 'Manufacturer Name')}}
                                    {{ Form::text('manufacturername',$device_view->manu_name,array('placeholder'=>'Manufacturer Name','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label4', 'Device Name')}}
                                    {{ Form::text('devicename',$device_view->device_name,array('placeholder'=>'Device Name','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label5', 'Model No')}}
                                    {{ Form::text('model',$device_view->model_name,array('placeholder'=>'Model No','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                    {{Form::label('label6', 'Longevity/Yrs')}}
                                    {{ Form::text('longevity',$device_view->longevity,array('placeholder'=>'Longevity/Yrs','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['longevityimage'])}}"
                                         width="30px" height="30px">
                                </div>
                                <div class="input1">
                                    {{Form::label('label7', 'Shock CT')}}
                                    {{ Form::text('shock',$device_view->shock,array('placeholder'=>'Shock CT','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['shockimage'])}}"
                                         width="30px" height="30px">
                                </div>
                                <div class="input1">
                                {{Form::label('label8', 'Size')}}
                                {{ Form::text('size',$device_view->size,array('placeholder'=>'Size','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['sizeimage'])}}"
                                         width="30px" height="30px">
                                </div>

                            </div>
                            <div class="col-md-6 col-lg-6 modal-box">
                                <div class="input1">
                                    {{Form::label('label10', 'Status')}}
                                    {{ Form::text('status',$device_view->status,array('placeholder'=>'Status','readonly'=>'true'))}}
                                </div>
                                <div class="input1">
                                {{Form::label('label11', 'Research')}}
                                {{ Form::text('research',$device_view->research,array('placeholder'=>'Research','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['researchimage'])}}"
                                         width="30px" height="30px">
                                </div>
                                <div class="input1">
                                {{Form::label('label12', 'Site Info:')}}
                                {{ Form::text('siteinfo',$device_view->website_page,array('placeholder'=>'Site Info','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['websiteimage'])}}"
                                         width="30px" height="30px">
                                </div>
                                <div class="input1">
                                    {{Form::label('label13', 'URL')}}
                                    {{ Form::text('URL',$device_view->url,array('placeholder'=>'URL','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['urlimage'])}}"
                                         width="30px" height="30px">
                                </div>
                                <div class="input1">
                                {{Form::label('label14', 'Overall Value')}}
                                {{ Form::text('overall_value',$device_view->overall_value,array('placeholder'=>'Overall Value','readonly'=>'true'))}}
                                    <img src="{{URL::to('public/upload/devicefeature/'.$device_features_image['overallimage'])}}"
                                         width="30px" height="30px">
                                </div>
                                @foreach($custom_fields as $custom_field)
                                    <div class="input1">
                                        {{Form::label('label13', $custom_field->field_name)}}
                                        {{ Form::text('custom_field'.$custom_field->id,NULL,array('placeholder'=>$custom_field->field_value,'readonly'=>'true'))}}
                                        <img src="{{URL::to('public/upload/devicefeature/custom/'.$custom_field->fieldimage)}}"
                                             width="30px" height="30px">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Prices-Details">
                    <div class="content-area clearfix" style="padding:30px 30px 30px;">
                        <div class="top-links clearfix">
                            @if(Auth::user()->roll == 1)
                                <a title="" href="{{ URL::to('admin/devices/clientprice/'.$device_view->id) }}"
                                   class="pull-right" data-toggle="modal"><i class="fa fa-plus-circle"></i> Add Client
                                    Price</a>
                            @endif
                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Unit Cost</th>
                                    <th>Dis. Unit Cost%</th>
                                    <th>Repless Disc.</th>
                                    <th>Repless Disc%</th>
                                    <th>System Cost</th>
                                    <th>Disc.Sys. Cost%</th>
                                    <th>CCO Discount</th>
                                    <th>CCO Disc. %</th>
                                    <th>Repless Disc.</th>
                                    <th>Repless Disc.%</th>
                                    <th>Unit Bulk</th>
                                    <th>System Bulk</th>
                                    <th>Reimb.</th>
                                    @if(Auth::user()->roll == 1)
                                        <th>Action</th>
                                    @endif
                                </tr>
                                <tr>
                                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data_clientprice','files'=>'true'))}}

                                    {{form::hidden('deviceId',$device_view->id)}}

                                    <td><input type="text" class='search_text' data-field='clients.client_name'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.unit_cost'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.bulk_unit_cost'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.unit_rep_cost'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text'
                                               data-field='client_price.unit_repless_discount' name="clientsearch[]"/>
                                    </td>
                                    <td><input type="text" class='search_text' data-field='client_price.system_cost'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text'
                                               data-field='client_price.bulk_system_cost' name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.cco'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.cco_discount'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text'
                                               data-field='client_price.system_repless_cost' name="clientsearch[]"/>
                                    </td>
                                    <td><input type="text" class='search_text'
                                               data-field='client_price.system_repless_discount' name="clientsearch[]"/>
                                    </td>
                                    <td><input type="text" class='search_text' data-field='client_price.bulk'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.system_bulk'
                                               name="clientsearch[]"/></td>
                                    <td><input type="text" class='search_text' data-field='client_price.reimbursement'
                                               name="clientsearch[]"/></td>
                                    @if(Auth::user()->roll == 1)
                                        <td style="width:100px;"></td>
                                    @endif

                                    {{form::close()}}

                                </tr>
                                </thead>
                                <tbody id="device_result">
                                @foreach($client_prices as $client_price)
                                    <tr>
                                        <td>{{$client_price->client_name}}</td>
                                        <td>${{$client_price->unit_cost}}</td>
                                        <td>{{$client_price->bulk_unit_cost > 0 ? $client_price->bulk_unit_cost : '-'}}</td>
                                        <td>{{$client_price->unit_rep_cost > 0 ? "$".$client_price->unit_rep_cost : '-'}}</td>
                                        <td>{{$client_price->unit_repless_discount > 0 ? $client_price->unit_repless_discount ."%": '-'}}</td>
                                        <td>${{$client_price->system_cost}}</td>
                                        <td>{{$client_price->bulk_system_cost > 0 ? $client_price->bulk_system_cost : '-'}}</td>
                                        <td>{{$client_price->cco > 0 ? "$".$client_price->cco : '-'}}</td>
                                        <td>{{$client_price->cco_discount > 0 ? $client_price->cco_discount : '-'}}</td>
                                        <td>{{$client_price->system_repless_cost > 0 ? "$".$client_price->system_repless_cost : '-'}}</td>
                                        <td>{{$client_price->system_repless_discount > 0 ? $client_price->system_repless_discount  : '-'}}</td>
                                        <td>{{$client_price->remain_bulk > 0 ? $client_price->remain_bulk : '-' }}</td>
                                        <td>{{$client_price->remain_system_bulk > 0 ? $client_price->remain_system_bulk : '-' }}</td>
                                        <td>{{$client_price->reimbursement > 0 ? "$".$client_price->reimbursement : '-'}}</td>
                                        @if(Auth::user()->roll == 1)
                                            <td>
                                                <a href="{{ URL::to('admin/devices/clientpriceedit/'.$client_price->id) }}"
                                                   data-toggle="modal"><i class="fa fa-edit"></i></a>
                                                &nbsp; <a
                                                        href="{{ URL::to('admin/devices/clientpriceremove/'.$client_price->id) }}"
                                                        onclick="return confirm(' Are you sure you want to delete clientprice?');"><i
                                                            class="fa fa-close"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="bottom-count clearfix">

                        </div>
                    </div>
                </div>


                <div role="tabpanel" class="tab-pane" id="Features">
                    <div class="content-area clearfix" style="padding:30px 30px 30px;">
                        <div class="top-links clearfix">
                            @if(Auth::user()->roll == 1)
                                <a title="" href="{{ URL::to('admin/devices/devicefeatures/'.$device_view->id) }}"
                                   class="pull-right" data-toggle="modal"><i class="fa fa-plus-circle"></i> Add Device
                                    Features</a>
                            @endif
                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Longevity/Yrs</th>
                                    <th>Shock CT</th>
                                    <th>Size</th>
                                    <th>Research</th>
                                    <th>Site Info</th>
                                    <th>URL</th>
                                    <th>Overall Value</th>
                                    @if(Auth::user()->roll == 1)
                                        <th>Action</th>
                                    @endif
                                </tr>
                                <tr>
                                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data_features','files'=>'true'))}}

                                    {{form::hidden('deviceId',$device_view->id)}}

                                    <td><input type="text" class='dfsearch_text' data-field='clients.client_name'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text' data-field='device_features.longevity'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text' data-field='device_features.shock'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text' data-field='device_features.size'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text' data-field='device_features.research'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text' data-field='device_features.site_info'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text' data-field='device_features.url'
                                               name="dfsearch[]"/></td>
                                    <td><input type="text" class='dfsearch_text'
                                               data-field='device_features.overall_value' name="dfsearch[]"/></td>
                                    @if(Auth::user()->roll == 1)
                                        <td style="width:100px;"></td>
                                    @endif
                                    {{form::close()}}
                                </tr>
                                </thead>
                                <tbody id="device_features_result">
                                @foreach($device_features as $row)
                                    <tr>
                                        <td>{{$row->client_name}}</td>
                                        <td>{{$row->longevity}}</td>
                                        <td>{{$row->shock}}</td>
                                        <td>{{$row->size}}</td>
                                        <td>{{$row->research}}</td>
                                        <td>{{$row->website_page}}</td>
                                        <td>{{$row->url}}</td>
                                        <td>{{$row->overall_value}}</td>
                                        @if(Auth::user()->roll == 1)
                                            <td>
                                                <a href="{{ URL::to('admin/devices/devicefeatures/edit/'.$row->id) }}"
                                                   data-toggle="modal"><i class="fa fa-edit"></i></a>
                                                &nbsp; <a
                                                        href="{{ URL::to('admin/devices/devicefeatures/remove/'.$row->id) }}"
                                                        onclick="return confirm('Are you sure you want to delete device features?');"><i
                                                            class="fa fa-close"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="bottom-count clearfix">

                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Survey">
                    <div class="content-area clearfix" style="margin:0 20%;">
                        <div class="top-links clearfix">

                            <a title="" href="" id="copysurvey" class="pull-right surveystyle" data-toggle="modal">
                                <i class="fa fa-files-o" aria-hidden="true"></i> Copy Existing Preference</a>

                            <a title="" href="{{ URL::to('admin/devices/devicesurvey/'.$device_view->id) }}"
                               class="pull-right" data-toggle="modal"><i class="fa fa-plus-circle"></i> Add Physician
                                Preference</a>
                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                <tr>

                                    <th width="30">&nbsp;</th>

                                    <th>Client Name</th>
                                    <th>Question 1</th>
                                    <th>Question 2</th>
                                    <th>Question 3</th>
                                    <th>Question 4</th>
                                    <th>Question 5</th>
                                    <th>Question 6</th>
                                    <th>Question 7</th>
                                    <th>Question 8</th>
                                    <th>Action</th>

                                </tr>
                                <tr>
                                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}


                                    <td></td>

                                    {{ Form::hidden('device_id',$device_view->id)}}
                                    <td><input type="text" class='dssearch_text' name="search[]"
                                               data-field='clients.client_name'/></td>
                                    <td style="width:100px;" colspan="8">
                                        <input type="text" class='dssearch_text' name="search[]" data-field='question'/>
                                    </td>

                                    <td style="width:100px;"></td>

                                    {{ Form::close()}}
                                </tr>
                                </thead>

                                <tbody id="device_survey_result">

                                @foreach($device_survey as $key=>$row)
                                    <tr>

                                        <td><input type="checkbox" class='chk_device' name="chk_survey"
                                                   value=" {{$row['clientId']}}"/></td>


                                        <td>{{$row['clientName']}}</td>
                                        <td>{{$row[0]['question'] = $row[0]['question'] == ''?'-' :$row[0]['question'] }}
                                            &nbsp; {!!$row[0]['check'] = $row[0]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[1]['question'] = $row[1]['question'] == ''?'-' :$row[1]['question'] }}
                                            &nbsp; {!!$row[1]['check'] = $row[1]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[2]['question'] = $row[2]['question'] == ''?'-' :$row[2]['question'] }}
                                            &nbsp; {!!$row[2]['check'] = $row[2]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[3]['question'] = $row[3]['question'] == ''?'-' :$row[3]['question'] }}
                                            &nbsp; {!!$row[3]['check'] = $row[3]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[4]['question'] = $row[4]['question'] == ''?'-' :$row[4]['question'] }}
                                            &nbsp; {!!$row[4]['check'] = $row[4]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[5]['question'] = $row[5]['question'] == ''?'-' :$row[5]['question'] }}
                                            &nbsp; {!!$row[5]['check'] = $row[5]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[6]['question'] = $row[6]['question'] == ''?'-' :$row[6]['question'] }}
                                            &nbsp; {!!$row[6]['check'] = $row[6]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>
                                        <td>{{$row[7]['question'] = $row[7]['question'] == ''?'-' :$row[7]['question'] }}
                                            &nbsp; {!!$row[7]['check'] = $row[7]['check'] == 'True'?'<i class="fa fa-check-circle" aria-hidden="true"></i>' :''!!}</td>

                                        <td>
                                            &nbsp;
                                            <a href="{{ URL::to('admin/devices/devicesurvey/edit/'.$row['clientId'].'/'.$device_view->id) }}"
                                               data-toggle="modal"><i class="fa fa-edit"></i></a>

                                            &nbsp; <a
                                                    href="{{ URL::to('admin/devices/devicesurvey/remove/'.$row['clientId'].'/'.$device_view->id) }}"
                                                    onclick="return confirm(' Are you sure you want to delete physician preference?');"><i
                                                        class="fa fa-close"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="bottom-count clearfix">

                        </div>
                    </div>
                </div>

                <!-- Serial Number Start -->

                <div role="tabpanel" class="tab-pane" id="Serial">
                    <div class="content-area clearfix" style="margin:0 20%;">
                        <div class="top-links clearfix">
                            <ul class="add-links">
                                <li>
                                    <a title="Add User"
                                       href="{{URL::to('admin/devices/serialnumber/create/'.$device_view->id)}}"
                                       data-toggle="modal">Add Serial Number</a>
                                </li>
                                <li>
                                    <a title="Add User" href="{{URL::to('admin/devices/serialnumber/serial-number')}}"
                                       data-toggle="modal">Sample
                                        Template</a>
                                </li>
                                <li style="margin-top: -6px;">
                                    {{ Form::select('serialnumber',$serialnumbers,null,array('class'=>'js-example-basic-single2','id'=>'serialNumber','placeholder'=>'Select Serial Number')) }}
                                </li>
                            </ul>

                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                <tr>

                                    <th>Client Name</th>
                                    <th>Date Created</th>
                                    <th>List Update</th>
                                    <th>Action</th>

                                </tr>
                                <tr>

                                    <td><input type="text" class='sisearch_text' name="serial[]"
                                               data-field='clients.client_name'/></td>
                                    <td><input type="text" class='sisearch_text' name="serial[]"
                                               data-field='survey.order_email'/></td>
                                    <td><input type="text" class='sisearch_text' name="serial[]"
                                               data-field='survey.cc1'/>
                                    </td>
                                    <td style="width:100px;"></td>

                                </tr>
                                </thead>

                                <tbody id="serialResult">

                                @foreach($serial as $row)
                                    <tr>

                                        <td>{{$row->client->client_name}}</td>
                                        <td>{{Carbon\Carbon::parse($row->created_at)->format('Y-m-d')}}</td>
                                        <td>{{Carbon\Carbon::parse($row->updated_at)->format('Y-m-d')}}</td>

                                        <td>
                                            <a href="{{ URL::to('admin/devices/serialnumber/view/'.$row->id) }}"
                                               data-toggle="modal"><i class="fa fa-eye"></i></a>
                                            &nbsp;
                                            <a href="{{ URL::to('admin/devices/serialnumber/edit/'.$row->id) }}"
                                               data-toggle="modal"><i class="fa fa-edit"></i></a>

                                            &nbsp; <a
                                                    href="{{ URL::to('admin/devices/serialnumber/remove/'.$row->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete Serial Number List?  If you removed the Serial Number List of the client it will affect the rep case tracker if the serial numbers are used in the rep case tracker');"><i
                                                        class="fa fa-close"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="bottom-count clearfix">

                        </div>
                    </div>
                </div>
                <!-- Serial Number End -->


                <!-- Custom Contact Information Start -->

                <div role="tabpanel" class="tab-pane" id="Contacts">
                    <div class="content-area clearfix" style="padding:30px 30px 30px;">
                        <div class="top-links clearfix">


                            <a title="" href="{{ URL::to('admin/devices/customcontact/'.$device_view->id) }}"
                               class="pull-right" data-toggle="modal"><i class="fa fa-plus-circle"></i> Add Contact
                                Features</a>

                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                <tr>

                                    <th>Client Name</th>
                                    <th>Order Email</th>
                                    <th>Email CC 1</th>
                                    <th>Email CC 2</th>
                                    <th>Email CC 3</th>
                                    <th>Email CC 4</th>
                                    <th>Email CC 5</th>
                                    <th>Email CC 6</th>

                                    <th>Subject</th>


                                    <th>Action</th>

                                </tr>
                                <tr>
                                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_contact_data','files'=>'true'))}}


                                    {{ Form::hidden('device_id',$device_view->id)}}
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='clients.client_name'/></td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.order_email'/></td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.cc1'/>
                                    </td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.cc2'/>
                                    </td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.cc3'/>
                                    </td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.cc4'/></td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.cc5'/></td>
                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.cc6'/></td>

                                    <td><input type="text" class='cisearch_text' name="search[]"
                                               data-field='survey.subject'/></td>

                                    <td style="width:100px;"></td>

                                    {{ Form::close()}}
                                </tr>
                                </thead>

                                <tbody id="device_contact_result">

                                @foreach($deviceCustomContact as $row)
                                    <tr>

                                        <td>{{$row->client['client_name']}}</td>
                                        <td>{{$row->user['email']}}</td>
                                        <td>{{$row->cc1}}</td>
                                        <td>{{$row->cc2}}</td>
                                        <td>{{$row->cc3}}</td>
                                        <td>{{$row->cc4}}</td>
                                        <td>{{$row->cc5}}</td>
                                        <td>{{$row->cc6}}</td>
                                        <td>{{$row->subject}}</td>


                                        <td>

                                            <a href="{{ URL::to('admin/devices/customcontact/edit/'.$row->id) }}"
                                               data-toggle="modal"><i class="fa fa-edit"></i></a>
                                            &nbsp; <a
                                                    href="{{ URL::to('admin/devices/customcontact/remove/'.$row->id) }}"
                                                    onclick="return confirm(' Are you sure you want to delete contacts?');"><i
                                                        class="fa fa-close"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="bottom-count clearfix">

                        </div>
                    </div>
                </div>
                <!-- Custom Contact Information End -->

                <!-- Rep User Tab start -->

                <div role="tabpanel" class="tab-pane" id="Reps">
                    <div class="content-area clearfix" style="padding:30px 30px 30px;">
                        <div class="top-links clearfix">
                            @if(Auth::user()->roll == 1)

                                <a href="#"
                                   class="pull-left repexport" id="repexport">Export</a>
                            @endif
                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                <tr>
                                    @if(Auth::user()->roll == 1)
                                        <th></th>
                                    @endif
                                    <th>Rep Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Title</th>
                                    <th>Company</th>
                                    <th>Client</th>

                                    <th>Receives Order Email</th>
                                    @if(Auth::user()->roll == 1)
                                        <th>Action</th>
                                    @endif
                                </tr>
                                <tr>
                                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_rep_data','files'=>'true'))}}


                                    {{ Form::hidden('deviceId',$device_view->id)}}

                                    @if(Auth::user()->roll == 1)

                                        <td><input type="checkbox" id="checkmain"/></td>

                                    @endif
                                    <td><input type="text" class='repsearch_text' name="search[]"
                                               data-field='rep.name'/></td>
                                    <td><input type="text" class='repsearch_text' name="search[]"
                                               data-field='rep.email'/></td>
                                    <td><input type="text" class='repsearch_text' name="search[]"
                                               data-field='rep.mobile'/>
                                    </td>
                                    <td><input type="text" class='repsearch_text' name="search[]"
                                               data-field='rep.email'/></td>
                                    <td><input type="text" class='repsearch_text' name="search[]"
                                               data-field='rep.title'/>
                                    </td>
                                    <td><input type="text" class='repsearch_text' name="search[]"
                                               data-field='rep.company'/>
                                    </td>
                                    <td style="width:100px;"></td>

                                    @if(Auth::user()->roll == 1)
                                        <td style="width:100px;"></td>
                                    @endif

                                    {{ Form::close()}}

                                </tr>
                                </thead>

                                <tbody id="device_rep_result">
                                @foreach($deviceRepUser as $row)
                                    <tr>

                                        {{ Form::hidden('deviceId',$device_view->id,array('id'=>'deviceId'))}}

                                        @if(Auth::user()->roll == 1)
                                            <td><input type="checkbox" class='chk_rep' name="chk_rep[]"
                                                       value="{{$row->id}}"/></td>
                                        @endif
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->mobile == "" ? '-':$row->mobile}}</td>
                                        <td>{{$row->title == "" ? '-':$row->title}}</td>
                                        <td>{{$row->manufacturer_name}}</td>
                                        <td>{{$row->userclientName}}</td>


                                        <td>{{ Form:: hidden('repId',$row->id,array('class'=>'repId'))}}

                                            {{ Form::select('status',array('No' => 'No','Yes' => 'Yes'),$row->repStatus =="Yes"?"Yes":"No",array('id'=>'repStatus','class'=>'repStatus')) }}</td>
                                        @if(Auth::user()->roll == 1)
                                            <td>

                                                <a href="{{ URL::to('admin/users/edit/'.$row->id) }}"
                                                   data-toggle="modal">Edit</a>

                                            </td>

                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                        </div>
                        <div class="bottom-count clearfix">
                            {{$deviceRepUser->count()}} of {{$count}} displayed
                            {{Form::open(array('url'=>'admin/devices/view/'.$device_view->id,'method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
                            {{Form::select('repPageSize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}

                            {{Form::close()}}
                        </div>
                    </div>
                </div>
                <!-- Rep User Tab End -->
            </div>

        </div>


    </div>

    <script>
        $(document).ready(function () {
            var url = window.location.href;
            var tab = url.slice(-1);
            var hash = url.slice(-2, -1);

            if (hash == "#") {
                var divclass = $("#Devices-Details").removeClass('active');
                var tabclass = $("#0").removeClass('active');

                if (tab == '4') {
                    $("#Survey").addClass("active");
                    divclass;
                    tabclass;
                    $("#4").addClass("active");
                }
                if (tab == '3') {
                    $("#Contacts").addClass("active");
                    divclass;
                    tabclass;
                    $("#3").addClass("active");
                }
                if (tab == '2') {
                    $("#Features").addClass("active");
                    divclass;
                    tabclass;
                    $("#2").addClass("active");
                }
                if (tab == '1') {
                    $("#Prices-Details").addClass("active");
                    divclass;
                    tabclass;
                    $("#1").addClass("active");
                }
                if (tab == '5') {
                    $("#Reps").addClass("active");
                    divclass;
                    tabclass;
                    $("#5").addClass("active");
                }
                if (tab == '6') {
                    $("#Serial").addClass("active");
                    divclass;
                    tabclass;
                    $("#6").addClass("active");
                }
            }


            $(".search_text").keyup(function () {
                var userrole = {{Auth::user()->roll}};
                var data = $('#ajax_data_clientprice').serialize();
// console.log(data);
                if (userrole == 1) {

                    $.ajax({
                        url: "{{ URL::to('admin/searchclientprice')}}",
                        data: $('#ajax_data_clientprice').serialize(),
                        success: function (data) {
                            // console.log(data);
                            var html_data = '';
                            if (data.status) {
                                $.each(data.value, function (i, item) {

                                    var bulk_unit_cost = item.bulk_unit_cost > 0 ? item.bulk_unit_cost + "%" : "-";
                                    var bulk_system_cost = item.bulk_system_cost > 0 ? item.bulk_system_cost + "%" : "-";
                                    var unit_rep_cost = item.unit_rep_cost > 0 ? "$" + item.unit_rep_cost : "-";
                                    var unit_repless_discount = item.unit_repless_discount > 0 ? item.unit_repless_discount + "%" : "-";
                                    var cco = item.cco > 0 ? "$" + item.cco : "-";
                                    var cco_discount = item.cco_discount > 0 ? item.cco_discount + "%" : "-";

                                    var system_repless_cost = item.system_repless_cost > 0 ? "$" + item.system_repless_cost : "-";
                                    var system_repless_discount = item.system_repless_discount > 0 ? item.system_repless_discount + "%" : "-";

                                    html_data += "<tr><td>" + item.client_name + "</td><td>$" + item.unit_cost + "</td><td>" + bulk_unit_cost + "</td><td>" + unit_rep_cost + "</td><td>" + unit_repless_discount + "</td><td>$" + item.system_cost + "</td><td>" + bulk_system_cost + "</td><td>" + cco + "</td><td>" + cco_discount + "</td><td>" + system_repless_cost + "</td><td>" + system_repless_discount + "</td><td>" + item.remain_bulk + "</td><td>" + item.remain_system_bulk + "</td><td>$" + item.reimbursement + "</td><td><a href=../clientpriceedit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; <a href=../clientpriceremove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;clientprice?');><i class='fa fa-close'></i></a></td></tr>";
                                    var reimbursement = item.reimbursement > 0 ? "$" + item.reimbursement : "-";

                                });
                            } else {
                                html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                            }

                            // console.log(html_data);
                            $("#device_result").html(html_data);

                        }

                    });
                }
                else {
                    $.ajax({
                        url: "{{ URL::to('admin/searchclientprice')}}",
                        data: $('#ajax_data_clientprice').serialize(),
                        success: function (data) {
                            console.log(data);
                            var html_data = '';
                            if (data.status) {
                                $.each(data.value, function (i, item) {

                                    var bulk_unit_cost = item.bulk_unit_cost > 0 ? item.bulk_unit_cost + "%" : "-";
                                    var bulk_system_cost = item.bulk_system_cost > 0 ? item.bulk_system_cost + "%" : "-";
                                    var unit_rep_cost = item.unit_rep_cost > 0 ? "$" + item.unit_rep_cost : "-";
                                    var unit_repless_discount = item.unit_repless_discount > 0 ? item.unit_repless_discount + "%" : "-";
                                    var cco = item.cco > 0 ? "$" + item.cco : "-";
                                    var cco_discount = item.cco_discount > 0 ? item.cco_discount + "%" : "-";

                                    var system_repless_cost = item.system_repless_cost > 0 ? "$" + item.system_repless_cost : "-";
                                    var system_repless_discount = item.system_repless_discount > 0 ? item.system_repless_discount + "%" : "-";
                                    var reimbursement = item.reimbursement > 0 ? "$" + item.reimbursement : "-";


                                    html_data += "<tr><td>" + item.client_name + "</td><td>$" + item.unit_cost + "</td><td>" + bulk_unit_cost + "</td><td>" + unit_rep_cost + "</td><td>" + unit_repless_discount + "</td><td>$" + item.system_cost + "</td><td>" + bulk_system_cost + "</td><td>" + cco + "</td><td>" + cco_discount + "</td><td>" + system_repless_cost + "</td><td>" + system_repless_discount + "</td><td>" + item.remain_bulk + "</td><td>" + item.remain_system_bulk + "</td><td>" + reimbursement + "</td></tr>";

                                });
                            } else {
                                html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                            }

                            // console.log(html_data);
                            $("#device_result").html(html_data);

                        }

                    });

                }

            });


            $(".dfsearch_text").keyup(function () {

                var data = $('#ajax_data_features').serialize();
                var userrole = {{Auth::user()->roll}};
                $.ajax({
                    url: "{{ URL::to('admin/searchdevicefeatures')}}",
                    data: $('#ajax_data_features').serialize(),
                    success: function (data) {
                        console.log(data);
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {
                                if (userrole == '1') {
                                    var action = "<td><a href='../devicefeatures/edit/" + item.id + "' data-toggle='modal'><i class='fa fa-edit'></i></a> &nbsp; <a href='../devicefeatures/remove/" + item.id + "' onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;device&nbsp;features?');><i class='fa fa-close'></i></a> </td>";
                                } else {
                                    var action = "";
                                }

                                html_data += "<tr><td>" + item.client_name + "</td><td>" + item.longevity + "</td><td>" + item.shock + "</td><td>" + item.size + "</td><td>" + item.research + "</td><td>" + item.website_page + "</td><td>" + item.url + "</td><td>" + item.overall_value + "</td>" + action + "</tr>";

                            });
                        } else {
                            html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        // console.log(html_data);
                        $("#device_features_result").html(html_data);

                    }

                });


            });

//            Device Survey
            $(".dssearch_text").keyup(function () {
                var data = $('#ajax_data').serialize();
                var userrole = {{Auth::user()->roll}};
                var deviceId = {{$device_view->id}};
                // console.log(data);
                $.ajax({
                    url: "{{URL::to('admin/devices/devicesurvey/search')}}",
                    data: $('#ajax_data').serialize(),
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                var item1 = item[0]['question'] == item[0]['question'] == '' ? '-' : item[0]['question'];
                                var check1 = item[0]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item2 = item[1]['question'] == item[1]['question'] == '' ? '-' : item[1]['question'];
                                var check2 = item[1]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item3 = item[2]['question'] == item[2]['question'] == '' ? '-' : item[2]['question'];
                                var check3 = item[2]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item4 = item[3]['question'] == item[3]['question'] == '' ? '-' : item[3]['question'];
                                var check4 = item[3]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item5 = item[4]['question'] == item[4]['question'] == '' ? '-' : item[4]['question'];
                                var check5 = item[4]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item6 = item[5]['question'] == item[5]['question'] == '' ? '-' : item[5]['question'];
                                var check6 = item[5]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item7 = item[6]['question'] == item[6]['question'] == '' ? '-' : item[6]['question'];
                                var check7 = item[6]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';
                                var item8 = item[7]['question'] == item[7]['question'] == '' ? '-' : item[7]['question'];
                                var check8 = item[7]['check'] == 'True' ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '';


                                var check = "<td><input type='checkbox' class='chk_device' name='chk_survey' value=" + item['clientId'] + "></td>";
                                var action = "<td><a href=../devicesurvey/edit/" + item['clientId'] + "/" + deviceId + "><i class='fa fa-edit'></i></a>&nbsp; <a href=../devicesurvey/remove/" + item['clientId'] + "/" + deviceId + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;physician&nbsp;preference?');><i class='fa fa-close'></i></a></td>";

                                html_data += "<tr>" + check + "<td>" + item['clientName'] + "</td><td>" + item1 + " " + check1 + "</td><td>" + item2 + " " + check2 + "</td><td>" + item3 + " " + check3 + "</td><td>" + item4 + " " + check4 + "</td><td>" + item5 + " " + check5 + "</td><td>" + item6 + " " + check6 + "</td><td>" + item7 + " " + check7 + "</td><td>" + item8 + " " + check8 + "</td>" + action + "</tr>";

                            });
                        } else {
                            html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        // console.log(html_data);
                        $("#device_survey_result").html(html_data);

                    }
                });


            });

// Custom Contact
            $(".cisearch_text").keyup(function () {
                var data = $('#ajax_contact_data').serialize();
                var userrole = {{Auth::user()->roll}};
                $.ajax({
                    url: "{{URL::to('admin/devices/customcontact/search')}}",
                    data: $('#ajax_contact_data').serialize(),
                    type: "POST",
                    success: function (data) {

                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                var email = item.email == null ? '-' : item.email;
                                var cc1 = item.cc1 == null ? '-' : item.cc1;
                                var cc2 = item.cc2 == null ? '-' : item.cc2;
                                var cc3 = item.cc3 == null ? '-' : item.cc3;
                                var cc4 = item.cc4 == null ? '-' : item.cc4;
                                var cc5 = item.cc5 == null ? '-' : item.cc5;
                                var cc6 = item.cc6 == null ? '-' : item.cc6;

                                if (userrole == '1') {
                                    var check = "<td><input type='checkbox' class='chk_rep' name='chk_rep[]' value='" + item.id + "'/></td>";
                                    var action = "<td><a href=../customcontact/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; <a href=../customcontact/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;Contacts?');><i class='fa fa-close'></i></a></td>";
                                } else {
                                    action = "<td><a href=../customcontact/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; <a href=../customcontact/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;Contacts?');><i class='fa fa-close'></i></a></td>";
                                }


                                html_data += "<tr><td>" + item.client_name + "</td><td>" + email + "</td><td>" + cc1 + "</td><td>" + cc2 + "</td><td>" + cc3 + "</td><td>" + cc4 + "</td><td>" + cc5 + "</td><td>" + cc6 + "</td><td>" + item.subject + "</td>" + action + "</tr>";

                            });
                        } else {
                            html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        // console.log(html_data);
                        $("#device_contact_result").html(html_data);

                    }
                });


            });

// rep Contact

            $(document).on("keyup", ".repsearch_text", function () {

                var data = $('#ajax_rep_data').serialize();
                var userrole = {{Auth::user()->roll}};
                $.ajax({
                    url: "{{URL::to('admin/devices/repcontact/search')}}",
                    data: $('#ajax_rep_data').serialize(),
                    type: "POST",
                    success: function (data) {

                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                console.log(data);
                                if (userrole == '1') {
                                    var check = "<td><input type='checkbox' class='chk_rep' name='chk_rep[]' value='" + item.id + "'/></td>";
                                    var action = "<td><a href=../repinfo/edit/" + item.id + "/" + item.device + ">Edit</a></td>";

                                }
                                if (item.repStatus == 'Yes') {
                                    var option = "<option value='Yes' selected='selected'>Yes</option><option value='No'>No</option>";
                                } else {
                                    var option = "<option value='Yes' >Yes</option><option value='No' selected='selected'>No</option>";
                                }

                                html_data += "<tr>" + check + "<td>" + item.name + "</td><td>" + item.email + "</td><td>" + item.mobile + "</td><td>" + item.title + "</td><td>" + item.manufacturer_name + "</td><td>" + item.userclientName + "</td><td><input type='hidden' name='deviceId' value='" + item.device + "' id='deviceId'><input type='hidden' name='repId' class='repId' value='" + item.id + "'><select name='status' class ='repStatus' id ='repStatus'>" + option + "</select><input type='hidden' name='repId' value='" + item.id + "' id='repId'></td>" + action + "</tr>";
                            });

                        } else {
                            html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>";
                        }

                        // console.log(html_data);
                        $("#device_rep_result").html(html_data);

                    }
                });


            });

            /*Serial number Search start*/
            $(document).on("keyup", ".sisearch_text", function () {
                var search = new Array();
                var userrole = {{Auth::user()->roll}};
                $.each($("input[name='serial[]']"), function () {
                    var ck_reps = $(this).val();

                    search.push(ck_reps);
                });

                var deviceId = {{$device_view->id}};

                $.ajax({
                    url: "{{ URL::to('admin/devices/serialnumber/search')}}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: search,
                        deviceId: deviceId,
                    },
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        var html_data = '';
                        var caseId = ""
                        if (data.status) {
                            $.each(data.value, function (i, item) {

//                                if (userrole == '1') {
                                var action = "<td><a href=../serialnumber/view/" + item.id + "><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=../serialnumber/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; &nbsp;<a href=../serialnumber/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;serial&nbsp;number?');><i class='fa fa-close'></i></a></td>";
//                                } else {
//                                   / action = "<td><a href=../customcontact/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; <a href=../customcontact/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;survey?');><i class='fa fa-close'></i></a></td>";
//                                }

                                html_data += "<tr><td>" + item.client_name + "</td><td>" + item.createat + "</td><td>" + item.updateat + "</td>" + action + "</tr>";

                            });

                        } else {
                            html_data = "<tr> <td colspan='4' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        $("#serialResult").html(html_data);


                    }

                });


            });
            /*Serial number Search end*/
        });
    </script>


    <script type="text/javascript">

        // rep status change start

        $(document).on("change", ".repStatus", function (event) {
            var deviceId = $('#deviceId').val();
            var repId = $(this).parent("td").children(".repId").val();
            var repStatus = $(this).val();

            $.ajax({
                url: "{{URL::to('admin/devices/repinfo/status')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    deviceId: deviceId, repId: repId, repStatus: repStatus
                },
                type: "POST",
                success: function (data) {

                }
            });

        });

        // rep status change end


        $(function () {
            $('#copysurvey').on("click", function (e) {

                if ($(".chk_device:checked").length == 0) {

                    alert("Please select record ");

                    return false;
                }
                else if ($(".chk_device:checked").length > 1) {
                    alert("Please select only one record ");

                    return false;
                }
                else {

                    // e.preventDefault();
                    var daa = $("input[name='chk_survey']:checked").val();
                    var device = {{$device_view->id}};
                    var url = '{{URL::to("admin/devices/devicesurvey/copysurvey/")}}';
                    var path = url + "/" + daa + "/" + device;
                    // console.log(path);
                    window.location.href = path;
                    // window.location(path);
                    // $(location).attr('href',url+"/"+daa);
                }

            });
        })
        ;
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on("change", "#checkmain", function (event) {


                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });


            $(document).on("click", ".repexport", function (event) {

                if ($(".chk_rep:checked").length == 0) {

                    alert("Please select record and export");
                    return false;
                }
                else {

                    var ck_rep = new Array();
                    $.each($("input[name='chk_rep[]']:checked"), function () {
                        var ck_reps = $(this).val();

                        ck_rep.push(ck_reps);
                    });

                    var deviceId = $('#deviceId').val();
                    $.ajax({
                        url: "{{URL::to('admin/devices/reinfo/export')}}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            deviceId: deviceId, ck_rep: ck_rep
                        },
                        type: "POST",
                        success: function (response, textStatus, request) {
                            var a = document.createElement("a");
                            a.href = response.file;
                            a.download = response.name;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on("change", "#serialNumber", function (event) {
            var serial = $(this).val();

            $.ajax({
                url: "{{ URL::to('admin/devices/deviceserialnumber')}}",
                data: {
                    serial: serial,
                },

                success: function (data) {
//                    console.log(data);
                    var html_data = '';

                    if (data.status) {
                        $.each(data.value, function (i, item) {

                            var action = "<td><a href=../serialnumber/view/" + item.id + "><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=../serialnumber/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; &nbsp;<a href=../serialnumber/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;serial&nbsp;number?');><i class='fa fa-close'></i></a></td>";

                            html_data += "<tr><td>" + item.client_name + "</td><td>" + item.createat + "</td><td>" + item.updateat + "</td>" + action + "</tr>";

                        });

                    } else {
                        html_data = "<tr> <td colspan='4' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    $("#serialResult").html(html_data);
                }
            });
        });
    </script>

    <script src="{{ URL::asset('js/edit_script.js') }}"></script>

@stop