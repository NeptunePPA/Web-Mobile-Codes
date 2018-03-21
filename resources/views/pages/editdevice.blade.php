@extends ('layout.default')
@section ('content')
    <style type="text/css">
        .side {
            width: 160px !important;
        }

        .sides {
            width: 90px !important;
            margin-top: 0px;
        }
    </style>

    <div class="add_new">
        <div class="box-center1">
            <div class="add_new_box" style="width: 1200px;margin-left: -100px;">
                <div class="col-md-12 col-lg-12 modal-box">
                    <div class="content-area clearfix" style="padding:0px;">
                        <div class="adddevice-modal addclient-price">
                            {{ Form::model($devices,['method'=>'PATCH','action'=>['devices@update',$devices->id],'files'=>true]) }}
                            <div class="modal-body clearfix">
                                <a title="" href="{{  URL::to('admin/devices') }}" class="pull-right">X</a>
                                <h3>Manage Device</h3>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li style="color:red; margin:5px;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <div class="modal-border clearfix">
                                    <div class="col-md-6 col-lg-6 modal-box">
                                        <div class="input1">
                                            {{Form::label('label1', 'Level Name:')}}
                                            {{ Form::select('level_name',array('Entry Level' => 'Entry Level', 'Advanced Level' => 'Advanced Level')) }}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label2', 'Project Name:')}}
                                            {{ Form::select('project_name', $projects,$devices->project_name,array('id'=>'projectname')) }}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label3', 'Category Name:')}}
                                            {{ Form::select('category_name',$category,$devices->category_name, array('id'=>'categoryname')) }}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label4', 'Manufacturer Name:')}}
                                            {{ Form::select('manufacturer_name', $manufacturer,$devices->manufacturer_name,array('id'=>'manufacturer')) }}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label5', 'Device Name:')}}
                                            {{ Form::text('device_name',null,array('placeholder'=>'Device Name'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label6', 'Model Name:')}}
                                            {{ Form::text('model_name',null,array('placeholder'=>'Model #'))}}
                                        </div>
                                        <div class="input1" style="text-align:right;padding-right:30px;">
                                            <img src="{{URL::to('public/upload/'.$devices->device_image )}}"
                                                 style="max-height:250px;width:auto;"/>
                                        </div>
                                        <div class="input1 fileup">
                                            {{Form::label('label7', 'Device Image:')}}
                                            {{ Form::text('image_name',null,array('placeholder'=>'Device Image','id'=>'file_name')) }}
                                            {{ Form::file('image',array('id'=>'fp_upload','class'=>'file-btn')) }}
                                            {{Form::input('button','Browse','Browse' ,array('id'=>'browse'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 modal-box">
                                    <!-- <div class="input1">
								{{Form::label('label8', 'Rep Email:')}}
                                    {{ Form::select('rep_email',array('0'=>'Select Rep'),'',array('id'=>'repemail')) }}
                                            </div> -->
                                        <div class="input1">
                                            {{Form::label('label9', 'Status:')}}
                                            {{ Form::select('status',array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label10', 'Exclusives:')}}
                                            {{ Form::text('exclusive',null,array('placeholder'=>'Exclusives','class'=>'side'))}}
                                            {{Form::select('exclusive_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label11', 'Longevity:')}}
                                            {{ Form::text('longevity',null,array('placeholder'=>'Longevity','class'=>'side'))}}
                                            {{Form::select('longevity_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}

                                        </div>
                                        <div class="input1">
                                            {{Form::label('label12', 'Shock:')}}
                                            {{ Form::text('shock',null,array('placeholder'=>'Shock/CT (ex. 100/32)','class'=>'side'))}}
                                            {{Form::select('shock_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label13', 'Size:')}}
                                            {{ Form::text('size',null,array('placeholder'=>'Size (ex. 10/21)','class'=>'side'))}}
                                            {{Form::select('size_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label14', 'Research:')}}
                                            {{ Form::text('research',null,array('placeholder'=>'Research','class'=>'side'))}}
                                            {{Form::select('research_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label15', 'Website Page:')}}
                                            {{ Form::text('website_page',null,array('placeholder'=>'Website Page Name','class'=>'side'))}}
                                            {{Form::select('websitepage_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label16', 'URL:')}}
                                            {{ Form::text('url',null,array('placeholder'=>'URL','class'=>'side'))}}
                                            {{Form::select('url_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            {{Form::label('label17', 'Overall Value:')}}
                                            {{ Form::select('overall_value',array('Overall Value' => 'Overall Value','Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'),null,array('class'=>'side')) }}
                                            {{Form::select('overall_value_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),null,array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Performance :</label>
                                            {{ Form::text('performance',null,array('placeholder'=>'Performance URL')) }}
                                        </div>

                                        <div class="input1">
                                            <label>Research Email :</label>
                                            {{ Form::text('research_email',null,array('placeholder'=>'Research Email')) }}
                                        </div>
                                        <div class="addmore-panel" id="add-more">
                                            <label>Add/Remove Custom Fields</label>
                                            @foreach($custom_fields as $customfield)
                                                <div class="input1" style="margin:5px 0;">
                                                    <div class="arrow-img">
                                                        <img src="../../../images/arrows1.jpg"/>
                                                    </div>
                                                    <input type="hidden" value="{{$customfield->id}}"
                                                           name="customhidden[]"/>
                                                    {{ Form::text('fieldnameedit[]',$customfield->field_name,array('placeholder'=>'Field Name','style'=>'width:100px;'))}}
                                                    {{ Form::text('fieldvalueedit[]',$customfield->field_value,array('placeholder'=>'Value','style'=>'width:100px;'))}}
                                                    <div class="file-upload btn btn-default sides">
                                                        <span>Image</span>
                                                        {{ Form::file('fieldimageedit[]',array('id'=>'fp_upload','class'=>'upload form-control sides'))}}
                                                    </div>
                                                    {{Form::select('fieldsideedit[]',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),$customfield->fieldside,array('class'=>'sides'))}}
                                                    <a href="{{ URL::to('admin/devices/customfield/remove/'.$customfield->id) }}"
                                                       class="minus-icon"><img src="../../../images/minus.jpg"/></a>

                                                </div>
                                            @endforeach
                                            <div class="input1">
                                                <div class="arrow-img">
                                                    <img src="../../../images/arrows1.jpg"/>
                                                </div>

                                                {{ Form::text('fieldname[]',null,array('id'=>'fieldname','placeholder'=>'Field Name','style'=>'width:100px;'))}}
                                                {{ Form::text('fieldvalue[]',null,array('id'=>'fieldvalue','placeholder'=>'Value','style'=>'width:100px;'))}}
                                                <div class="file-upload btn btn-default sides">
                                                    <span>Image</span>
                                                    {{ Form::file('fieldimage[]',array('id'=>'fp_upload','class'=>'upload form-control sides'))}}
                                                </div>
                                                {{Form::select('fieldside[]',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'sides'))}}
                                                <a href="javascript:void(0);" class="plus-icon"><img
                                                            src="../../../images/plus.jpg"/></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-btn clearfix">
                                    {{ Form::submit('UPDATE') }}
                                    <a href="{{ URL::to('admin/devices/remove/'.$devices->id) }}"
                                       onclick="return confirm(' Are you sure you want to delete device?');"
                                       style="padding:8px 78px;  border-radius:5px; color:#fff; text-decoration:none; background:red;">DELETE</a>
                                </div>

                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $('body').on("click", '.chkbox', function () {
                var totalchk = $('.chkbox:checked').length;

                if (totalchk > 8) {
                    alert('You can select only 8 checkbox');
                    $(this).prop('checked', false);
                }
            });

            $('#fp_upload').hide();
            $("#browse").click(function () {
                $('#fp_upload').click();
                var file = document.getElementById("fp_upload");
            });
            $('#fp_upload').change(function () {
                $('#file_name').val($(this).val());
            });


            var max_fields = 10; //maximum input boxes allowed
            var wrapper = $("#add-more"); //Fields wrapper
            var add_button = $(".plus-icon"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function (e) { //on add input button click
                var fieldname = document.getElementById('fieldname').value;
                if (fieldname == "") {
                    alert("Please enter fieldname");
                }
                else {
                    e.preventDefault();
                    if (x < max_fields) { //max input box allowed
                        x++; //text box increment

                        $(wrapper).append("<div class='input1'  style='margin-top:5px;'><div class='arrow-img'><img src='../../../images/arrows1.jpg' />" +
                            "</div><input placeholder='Field Name' name='fieldname[]' id='fieldname' type='text' style='width:100px;'>" +
                            "<input placeholder='Value' name='fieldvalue[]' type='text' id='fieldvalue' style='width:100px;'>" +
                            "<div class='file-upload btn btn-default sides'><span>Image</span>" +
                            "<input type = 'file' name ='fieldimage[]' id = 'fp_upload' class = 'upload form-control sides'>" +
                            "</div><select name='fieldside[]' class='sides'><option value=''>Select Side</option><option value='Left'>Left</option>" +
                            "<option value='Right'>Right</option></select> " +
                            "<a href='javascript:void(0);' class='minus-icon remove_field'><img src='../../../images/minus.jpg' />" +
                            "</a></div>"); //add input box
                    }
                }
            });

            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })


            $('#projectname').change(function () {
                var projectid = document.getElementById("projectname").value;

                $.ajax({
                    url: "{{ URL::to('admin/getcategory')}}",
                    data: {
                        projectid: projectid
                    },
                    success: function (data) {
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {
                                html_data += "<option value=" + item.id + ">" + item.category_name + "</option>";

                            });
                        }
                        else {
                            html_data = "<option value=0>Select Category</option>";
                        }
                        $("#categoryname").html(html_data);

                    }

                });
            });

                    {{--$('#manufacturer').change(function(){--}}
                    {{--var projectid = $('#projectname').val();--}}
                    {{--var manufacturer = $('#manufacturer').val();--}}

                    {{--$.ajax({--}}
                    {{--url: "{{ URL::to('admin/getrep')}}",--}}
                    {{--data: {--}}
                    {{--projectid: projectid,--}}
                    {{--manufacturer:manufacturer--}}
                    {{--},--}}
                    {{--success: function (data) --}}
                    {{--{--}}
                    {{--var html_data = '';--}}
                    {{--if (data.status) {--}}
                    {{--$.each(data.value, function (i, item) {--}}
                    {{--html_data += "<option value="+item.id+">"+item.email+"</option>";--}}

                    {{--});--}}
                    {{--}--}}
                    {{--else--}}
                    {{--{--}}
                    {{--html_data = "<option value=0>Select Rep</option>";--}}
                    {{--}--}}
                    {{--$("#repemail").html(html_data);--}}

                    {{--}--}}

                    {{--});--}}
                    {{--});--}}

            var projectid = {{$devices->project_name}};
            var manufacturer = {{$devices->manufacturer_name}};
            var categoryname = {{$devices->category_name}};


            // $.ajax({
            //              url: "{{ URL::to('admin/getrep')}}",
            //              data: {
            //                  projectid: projectid,
            // 		manufacturer:manufacturer
            //              },
            //              success: function (data)
            // 	{
            // 		var repid = {{$devices->rep_email}};
            //                  var html_data = '';
            // 		 if (data.status) {
            // 		$.each(data.value, function (i, item) {
            // 				var is_selected = (item.id == repid) ? "selected":"";
            //                          html_data += "<option value="+item.id+">"+item.email+"</option>";

            // 		});
            // 		 }
            // 		 else
            // 		 {
            // 			 html_data = "<option value=0>Select Rep</option>";
            // 		 }
            // 		$("#repemail").html(html_data);

            //              }

            //          });


            $.ajax({
                url: "{{ URL::to('admin/getcategory')}}",
                data: {
                    projectid: projectid
                },
                success: function (data) {
                    var html_data = '';
                    if (data.status) {
                        $.each(data.value, function (i, item) {
                            html_data += "<option value=" + item.id + ">" + item.category_name + "</option>";

                        });
                    }
                    else {
                        html_data = "<option value=0>Select Category</option>";
                    }
                    $("#categoryname").html(html_data);
                    $("#categoryname").val(categoryname);

                }

            });

        });
    </script>
@stop