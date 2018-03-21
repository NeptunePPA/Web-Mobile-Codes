@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="box-center1">
            <div class="add_new_box" style=" width:106%;">

                <div class="col-md-12 col-lg-12 modal-box" style="margin-top:10px;">
                    <a title="" href="{{ URL::to('admin/devices/view/'.$deviceid) }}#2" class="pull-right">X</a>
                    <h3 style="text-align:center;">Add Device Features</h3>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color:red; margin:5px;">{{ $error }}</li>
                        @endforeach
                    </ul>

                    <div class="col-md-6 col-lg-6 delta">&nbsp;<img src="{{URL::to('public/upload/color.png')}}"
                                                                    class="deltaImage">&nbsp;
                        <img src="{{URL::to('public/upload/delta.png')}}" class="deltaImage"></div>
                    <div class="col-md-6 col-lg-6 delta"><img src="{{URL::to('public/upload/color.png')}}"
                                                              class="deltaImage">&nbsp;
                        <img src="{{URL::to('public/upload/delta.png')}}" class="deltaImage"></div>

                    {{ Form::open(array('url' => 'admin/devices/devicefeatures/create','method'=>'POST','files'=>true)) }}
                    <div class="content-area clearfix" style="padding:30px 0px 30px 0px;">
                        <div class="col-md-6 col-lg-6 modal-box" style="border-right:solid 1px #ccc;">
                            <div class="input1">
                                {{ Form::hidden('device_id',$deviceid)}}
                            </div>
                            <div class="input1">
                                {{Form::label('label2', 'Select Client')}}
                                {{ Form::select('client_name', $client_name,'',array('id'=>'clientname')) }}
                            </div>
                            <div class="input1">
                                {{Form::label('label3', 'Longevity/Yrs')}}
                                {{ Form::text('longevity',$devices['longevity'],array('placeholder'=>'Longevity/Yrs','Readonly'=>'True'))}}
                                {{ Form::checkbox('chk_longevity','True','',array('id'=>'chk_longevity')) }}
                                {{ Form::checkbox('longevity_highlight','True','',array('class' => 'deltacheck','id'=>'longevity_highlight')) }}
                                {{ Form::checkbox('longevity_delta_check','True','',array('class' => 'deltacheck','id'=>'longevity_delta_check')) }}
                            </div>
                            <div class="input1">
                                {{Form::label('label4', 'Shock CT')}}
                                {{ Form::text('shock',$devices['shock'],array('placeholder'=>'Shock CT','Readonly'=>'True'))}}
                                {{ Form::checkbox('chk_shock_ct','True','',array('id'=>'chk_shock_ct')) }}
                                {{ Form::checkbox('shock_highlight','True','',array('class' => 'deltacheck','id'=>'shock_highlight')) }}
                                {{ Form::checkbox('shock_delta_check','True','',array('class' => 'deltacheck','id'=>'shock_delta_check')) }}
                            </div>
                            <div class="input1">
                                {{Form::label('label5', 'Size')}}
                                {{ Form::text('size',$devices['size'],array('placeholder'=>'Size','Readonly'=>'True'))}}
                                {{ Form::checkbox('chk_size','True','',array('id'=>'chk_size')) }}
                                {{ Form::checkbox('size_highlight','True','',array('class' => 'deltacheck','id'=>'size_highlight')) }}
                                {{ Form::checkbox('size_delta_check','True','',array('class' => 'deltacheck','id'=>'size_delta_check')) }}
                            </div>
                            <div class="input1">
                                {{Form::label('label17', 'Research')}}
                                {{ Form::text('research',$devices['research'],array('placeholder'=>'Research','Readonly'=>'True'))}}
                                {{ Form::checkbox('chk_research','True','',array('id'=>'chk_research')) }}
                                {{ Form::checkbox('research_highlight','True','',array('class' => 'deltacheck','id'=>'research_highlight')) }}
                                {{ Form::checkbox('research_delta_check','True','',array('class' => 'deltacheck','id'=>'research_delta_check')) }}

                            </div>
                            <div class="input1">
                                {{Form::label('label6', 'Site Info')}}
                                {{ Form::text('site_info',$devices['website_page'],array('placeholder'=>'Site Info','Readonly'=>'True'))}}
                                {{ Form::checkbox('chk_site_info','True','',array('id'=>'chk_site_info')) }}
                                {{ Form::checkbox('siteinfo_highlight','True','',array('class' => 'deltacheck','id'=>'siteinfo_highlight')) }}
                                {{ Form::checkbox('site_info_delta_check','True','',array('class' => 'deltacheck','id'=>'site_info_delta_check')) }}

                            </div>
                            <div class="input1">
                                {{Form::label('label7', 'URL')}}
                                {{ Form::text('url',$devices['url'],array('placeholder'=>'URL','Readonly'=>'True'))}}

                            </div>

                        </div>
                        <div class="col-md-6 col-lg-6 modal-box">

                            <div class="input1">
                                {{Form::label('label8', 'Overall Value')}}
                                {{ Form::text('overall_value',$devices['overall_value'],array('placeholder'=>'Overall Value','Readonly'=>'True'))}}
                                {{ Form::checkbox('chk_overall_value','True','',array('id'=>'chk_overall_value')) }}
                                {{ Form::checkbox('overall_value_highlight','True','',array('class' => 'deltacheck','id'=>'overall_value_highlight')) }}
                                {{ Form::checkbox('overall_value_delta_check','True','',array('class' => 'deltacheck','id'=>'overall_value_delta_check')) }}

                            </div>
                            <div class="addmore-panel" id="add-more">
                                <div style="display: none">{{$i = 1}}</div>
                                @foreach($custom_field as $customfield)
                                    <div class="input1" style="margin:5px 0; margin-left: 60px;">
                                        <div class="arrow-img">
                                            <img src="{{URL::to('images/arrows1.jpg')}}"/>
                                        </div>
                                        <input type="hidden" value="{{$customfield->id}}" name="customhidden[]"/>
                                        {{ Form::text('fieldnameedit[]',$customfield->field_name,array('placeholder'=>'Field Name','style'=>'width:100px;','Readonly'=>'true'))}}
                                        {{ Form::text('fieldvalueedit[]',$customfield->field_value,array('placeholder'=>'Value','style'=>'width:100px;','Readonly'=>'true'))}}
                                        {{ Form::checkbox('chk_field[]','True','',array('class'=>'chkbox','id'=>'chk_field-'.$i,'data-id'=>$customfield->id,'chck-id'=>$i)) }}
                                        {{ Form::checkbox('fileld_highlight[]','True','',array('class'=>'highlight','id'=>'fileld_highlight-'.$i,'data-id'=>$customfield->id,'highlight-id'=>$i)) }}
                                        {{ Form::checkbox('chk_field_delta_check[]','True','',array('class'=>'chkkbox','id'=>'chk_hd_field_delta_check-'.$i,'data-id'=>$customfield->id,'delta-id'=>$i)) }}
                                        {{ Form::hidden('chk_hd_field[]','False',array('class'=>'chkhdbox ','data-id'=>'chkhd'.$customfield->id)) }}
                                        {{ Form::hidden('chk_hd_field_delta_check[]','False',array('class'=>'chkhdbox','data-id'=>'chkhhd'.$customfield->id)) }}
                                        {{ Form::hidden('chk_hd_field_fileld_highlight[]','False',array('class'=>'chk_highlight','data-id'=>'chk_fileld_highlight'.$customfield->id)) }}

                                        <div style="display: none;">{{$i++}}</div>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div>

                    <div class="modal-btn clearfix">
                        {{ Form::submit('SAVE') }}
                        <a href="{{ URL::to('admin/devices/view/'.$deviceid) }}#2"
                           style="padding:8px 75px; border-radius:5px; color:#fff; text-decoration:none; background:red;">CANCEL</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $('input[class="chkbox"]').on('change', function (e) {
                e.preventDefault();
                var chkid = $(this).data('id');
                var isChecked = $(this).is(":checked");
                if (isChecked) {
                    var chkhidden = $('[data-id="chkhd' + chkid + '"]').val('True');

                } else {
                    var chkhidden = $('[data-id="chkhd' + chkid + '"]').val('False');

                }
            });

            $('input[class="chkkbox"]').on('change', function (e) {
                e.preventDefault();
                var chkid = $(this).data('id');
                var isChecked = $(this).is(":checked");
                if (isChecked) {
                    var chkhidden = $('[data-id="chkhhd' + chkid + '"]').val('True');

                } else {
                    var chkhidden = $('[data-id="chkhhd' + chkid + '"]').val('False');

                }
            });

            /*Highlight*/
            $('input[class="highlight"]').on('change', function (e) {
                e.preventDefault();
                var chkid = $(this).data('id');
                var isChecked = $(this).is(":checked");
                if (isChecked) {
                    var chkhidden = $('[data-id="chk_fileld_highlight' + chkid + '"]').val('True');

                } else {
                    var chkhidden = $('[data-id="chk_fileld_highlight' + chkid + '"]').val('False');

                }
            });

            /*Highlight Start*/
            /*Longevity*/
            $(document).on('click', '#longevity_highlight', function (event) {

                var chk_longevity = $('#chk_longevity').prop('checked');

                if (chk_longevity) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Longevity');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_longevity', function (event) {

                var chk_longevity = $('#chk_longevity').prop('checked');

                if (chk_longevity) {
                    $('#longevity_highlight').attr("checked");

                }
                else {
                    $("#longevity_highlight").prop("checked", false);
                }

            });

            /*Shock CT*/
            $(document).on('click', '#shock_highlight', function (event) {

                var chk_shock_ct = $('#chk_shock_ct').prop('checked');

                if (chk_shock_ct) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Shock CT');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_shock_ct', function (event) {

                var chk_shock_ct = $('#chk_shock_ct').prop('checked');

                if (chk_shock_ct) {
                    $('#shock_highlight').attr("checked");

                }
                else {
                    $("#shock_highlight").prop("checked", false);
                }

            });

            /*Size*/
            $(document).on('click', '#size_highlight', function (event) {

                var chk_size = $('#chk_size').prop('checked');

                if (chk_size) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Size');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_size', function (event) {

                var chk_size = $('#chk_size').prop('checked');

                if (chk_size) {
                    $('#size_highlight').attr("checked");

                }
                else {
                    $("#size_highlight").prop("checked", false);
                }

            });

            /*Research*/
            $(document).on('click', '#research_highlight', function (event) {

                var chk_research = $('#chk_research').prop('checked');

                if (chk_research) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Research');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_research', function (event) {

                var chk_research = $('#chk_research').prop('checked');

                if (chk_research) {
                    $('#research_highlight').attr("checked");

                }
                else {
                    $("#research_highlight").prop("checked", false);
                }

            });

            /*Site Info*/
            $(document).on('click', '#siteinfo_highlight', function (event) {

                var chk_site_info = $('#chk_site_info').prop('checked');

                if (chk_site_info) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Site Info');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_site_info', function (event) {

                var chk_site_info = $('#chk_site_info').prop('checked');

                if (chk_site_info) {
                    $('#siteinfo_highlight').attr("checked");

                }
                else {
                    $("#siteinfo_highlight").prop("checked", false);
                }

            });

            /*Over ALl Value*/
            $(document).on('click', '#overall_value_highlight', function (event) {

                var chk_overall_value = $('#chk_overall_value').prop('checked');

                if (chk_overall_value) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Over All Value');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_size', function (event) {

                var chk_overall_value = $('#chk_overall_value').prop('checked');

                if (chk_overall_value) {
                    $('#overall_value_highlight').attr("checked");

                }
                else {
                    $("#overall_value_highlight").prop("checked", false);
                }

            });

            /*Highlight End*/

            /*Longevity delta Check start */

            $(document).on('click', '#longevity_delta_check', function (event) {

                var chk_longevity = $('#chk_longevity').prop('checked');

                if (chk_longevity) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Longevity');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_longevity', function (event) {

                var chk_longevity = $('#chk_longevity').prop('checked');

                if (chk_longevity) {
                    $('#longevity_delta_check').attr("checked");

                }
                else {
                    $("#longevity_delta_check").prop("checked", false);
                }

            });

            /*Longevity check Delta Check end*/

            /*Shock CT delta Check start */

            $(document).on('click', '#shock_delta_check', function (event) {

                var chk_shock_ct = $('#chk_shock_ct').prop('checked');

                if (chk_shock_ct) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Shock CT');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_shock_ct', function (event) {

                var chk_shock_ct = $('#chk_shock_ct').prop('checked');

                if (chk_shock_ct) {
                    $('#shock_delta_check').attr("checked");

                }
                else {
                    $("#shock_delta_check").prop("checked", false);
                }

            });

            /*Shock CT check Delta Check end*/

            /*Size delta Check start */

            $(document).on('click', '#size_delta_check', function (event) {

                var chk_size = $('#chk_size').prop('checked');

                if (chk_size) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Size');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_size', function (event) {

                var chk_size = $('#chk_size').prop('checked');

                if (chk_size) {
                    $('#size_delta_check').attr("checked");

                }
                else {
                    $("#size_delta_check").prop("checked", false);
                }

            });

            /*Size check Delta Check end*/

            /*Research delta Check start */

            $(document).on('click', '#research_delta_check', function (event) {

                var chk_research = $('#chk_research').prop('checked');

                if (chk_research) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Research');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_research', function (event) {

                var chk_research = $('#chk_research').prop('checked');

                if (chk_research) {
                    $('#research_delta_check').attr("checked");

                }
                else {
                    $("#research_delta_check").prop("checked", false);
                }

            });

            /*Research check Delta Check end*/

            /*Site Info delta Check start */

            $(document).on('click', '#site_info_delta_check', function (event) {

                var chk_site_info = $('#chk_site_info').prop('checked');

                if (chk_site_info) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Site Info');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_site_info', function (event) {

                var chk_site_info = $('#chk_site_info').prop('checked');

                if (chk_site_info) {
                    $('#site_info_delta_check').attr("checked");

                }
                else {
                    $("#site_info_delta_check").prop("checked", false);
                }

            });

            /*Site Info check Delta Check end*/

            /*Overall Value delta Check start */

            $(document).on('click', '#overall_value_delta_check', function (event) {

                var chk_overall_value = $('#chk_overall_value').prop('checked');

                if (chk_overall_value) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Overall Value');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '#chk_overall_value', function (event) {

                var chk_overall_value = $('#chk_overall_value').prop('checked');

                if (chk_overall_value) {
                    $('#overall_value_delta_check').attr("checked");

                }
                else {
                    $("#overall_value_delta_check").prop("checked", false);
                }

            });

            /*Overall Value check Delta Check end*/


            /*Custom Field Validatation Start*/

            $(document).on('click', '.chkkbox', function (event) {

                var i = $(this).attr("delta-id");

                var chk_overall_value = $('#chk_field-' + i).prop('checked');

                if (chk_overall_value) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Custom Field');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '.chkbox', function (event) {
                var i = $(this).attr("chck-id");
                var chkid = $(this).data('id');
                var chk_overall_value = $('#chk_field-' + i).prop('checked');
                if (chk_overall_value) {
                    $('#chk_hd_field_delta_check-' + i).attr("checked");

                }
                else {
                    $("#chk_hd_field_delta_check-" + i).prop("checked", false);
                    var chkhidden = $('[data-id="chkhhd' + chkid + '"]').val('False');

                }

            });
            /*Custom Field Validatation End*/

            /*Custom Field Highlight validation */
            $(document).on('click', '.highlight', function (event) {

                var i = $(this).attr("highlight-id");

                var chk_overall_value = $('#chk_field-' + i).prop('checked');

                if (chk_overall_value) {
                    $(this).attr("checked");

                }
                else {
                    alert('You can also select Custom Field');
                    $(this).prop("checked", false);
                }

            });

            $(document).on('click', '.chkbox', function (event) {
                var i = $(this).attr("chck-id");
                var chkid = $(this).data('id');
                var chk_overall_value = $('#chk_field-' + i).prop('checked');
                if (chk_overall_value) {
                    $('#fileld_highlight-' + i).attr("checked");

                }
                else {
                    $("#fileld_highlight-" + i).prop("checked", false);
                    var chkhidden = $('[data-id="chk_fileld_highlight' + chkid + '"]').val('False');

                }

            });
        });
    </script>

@stop

