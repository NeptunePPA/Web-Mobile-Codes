@extends ('layout.default')
@section ('content')
        <style type="text/css">
            .side {
                width: 160px !important;
            }
            .sides {
                width: 100px !important;
                margin-top : 0px;
            }
        </style>

    <div class="add_new">
        <div class="box-center1">
            <div class="add_new_box" style="width: 1200px;margin-left: -100px;">
                <div class="col-md-12 col-lg-12 modal-box">
                    <div class="content-area clearfix" style="padding:0px;">
                        <div class="adddevice-modal addclient-price">

                            {{ Form::open(array('url' => 'admin/devices/create','method'=>'POST','files'=>true,'multiple'=>true)) }}
                            <div class="modal-body clearfix">
                                <a href="{{ URL::to('admin/devices') }}" class="pull-right">X</a>
                                <h3>Add Device</h3>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li style="color:red; margin:5px;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <div class="modal-border clearfix">
                                    <div class="col-md-6 col-lg-6 modal-box">
                                        <div class="input1">
                                            <label>Level Name:</label>
                                            {{ Form::select('level',array('0' => 'Select Level','Entry Level' => 'Entry Level', 'Advanced Level' => 'Advanced Level')) }}
                                        </div>
                                        <div class="input1">
                                            <label>Project Name:</label>
                                            {{ Form::select('project_name', $projects,'',array('id'=>'projectname')) }}
                                        </div>
                                        <div class="input1">
                                            <label>Category Name:</label>
                                            {{ Form::select('category_name',array('0'=>'Select Category'),'', array('id'=>'categoryname')) }}
                                        </div>
                                        <div class="input1">
                                            <label>Manufacturer Name:</label>
                                            {{ Form::select('manufacturer_name', $manufacturer,'',array('id'=>'manufacturer')) }}
                                        </div>
                                        <div class="input1">
                                            <label>Device Name:</label>
                                            {{ Form::text('devicename',null,array('placeholder'=>'Device Name'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Model Name:</label>
                                            {{ Form::text('modelname',null,array('placeholder'=>'Model #'))}}
                                        </div>
                                        <div class="input1 fileup">
                                            <label>Device Image:</label>
                                            {{ Form::text('image_name',null,array('placeholder'=>'Device Image','id'=>'file_name')) }}
                                            {{ Form::file('image',array('id'=>'fp_upload','class'=>'file-btn')) }}
                                            {{Form::input('button','Browse','Browse' ,array('id'=>'browse'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 modal-box">
                                    <!-- <div class="input1">
							<label>Rep Email:</label>
								{{ Form::select('rep_email',array('0'=>'Select Rep'),'',array('id'=>'repemail')) }}
                                            </div> -->
                                        <div class="input1">
                                            <label>Status:</label>
                                            {{ Form::select('status',array('0' => 'Status','Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}
                                        </div>
                                        <div class="input1">
                                            <label>Exclusives:</label>
                                        {{ Form::text('exclusive',null,array('placeholder'=>'Exclusives','class'=>'side'))}}
                                         {{Form::select('exclusive_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Longevity:</label>
                                        {{ Form::text('longevity',null,array('placeholder'=>'Longevity','class'=>'side'))}}
                                        {{Form::select('longevity_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Shock:</label>
                                        {{ Form::text('shock',null,array('placeholder'=>'Shock/CT (ex. 100/32)','class'=>'side'))}}
                                        {{Form::select('shock_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Size:</label>
                                        {{ Form::text('size',null,array('placeholder'=>'Size (ex. 10/21)','class'=>'side'))}}
                                        {{Form::select('size_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Research:</label>
                                        {{ Form::text('research',null,array('placeholder'=>'Research','class'=>'side'))}}
                                        {{Form::select('research_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Website Page:</label>
                                        {{ Form::text('websitepage',null,array('placeholder'=>'Website Page Name','class'=>'side'))}}
                                        {{Form::select('websitepage_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>URL:</label>
                                            {{ Form::text('url',null,array('placeholder'=>'URL','class'=>'side'))}}
                                            {{Form::select('url_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Overall Value:</label>
                                        {{ Form::select('overall_value',array('Overall Value' => 'Overall Value','Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'),'',array('class'=>'side')) }}
                                        {{Form::select('overall_value_side',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'side'))}}
                                        </div>
                                        <div class="input1">
                                            <label>Performance :</label>
                                            {{ Form::text('performance','',array('placeholder'=>'Performance URL')) }}
                                        </div>

                                        <div class="input1">
                                            <label>Research Email :</label>
                                            {{ Form::text('research_email','',array('placeholder'=>'Research Email')) }}
                                        </div>
                                        <div class="addmore-panel" id="add-more">
                                            <label>Add/Remove Custom Fields</label>
                                            <div class="input1" data-id="0">
                                                <div class="arrow-img">
                                                    <img src="../../images/arrows1.jpg"/>
                                                </div>
                                            {{ Form::text('fieldname[]',null,array('id'=>'fieldname','placeholder'=>'Field Name','style'=>'width:100px;'))}}
                                            {{ Form::text('fieldvalue[]',null,array('id'=>'fieldvalue','placeholder'=>'Value','style'=>'width:100px;'))}}

                                                <div class="file-upload btn btn-default sides">
                                                    <span>Image</span>
                                                    {{ Form::file('fieldimage[]',array('id'=>'fp_upload','class'=>'upload form-control sides'))}}
                                                </div>
                                            {{Form::select('fieldside[]',array(''=>'Select Side','Left'=>'Left','Right'=>'Right'),'',array('class'=>'sides'))}}
                                            <a href="javascript:void(0);" class="plus-icon"><img
                                                            src="../../images/plus.jpg"/></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-btn clearfix">
                                    {{ Form::submit('SAVE') }}
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
                        //$(wrapper).append("<div class='input1'  style='margin-top:5px;'><div class='arrow-img'><img src='../../images/arrows1.jpg' /></div><input placeholder='Field Name' name='fieldname[]' id='fieldname' type='text' style='width:100px;'><input placeholder='Value' name='fieldvalue[]' type='text' id='fieldvalue' style='width:100px;'><input name='chk_fieldname[]' type='checkbox' value='True' class='chkbox'><a href='javascript:void(0);' class='minus-icon remove_field'><img src='../../images/minus.jpg' /></a><a href='javascript:void(0);' class='plus-icon'><img src='' /></a></div>"); //add input box
                        $(wrapper).append("<div class='input1'  style='margin-top:5px;'><div class='arrow-img'><img src='../../images/arrows1.jpg' />" +
                            "</div><input placeholder='Field Name' name='fieldname[]' id='fieldname' type='text' style='width:100px;'>" +
                            "<input placeholder='Value' name='fieldvalue[]' type='text' id='fieldvalue' style='width:100px;'>" +
                            "<div class='file-upload btn btn-default sides'><span>Image</span>" +
                            "<input type = 'file' name ='fieldimage[]' id = 'fp_upload' class = 'upload form-control sides'>"+
                            "</div><select name='fieldside[]' class='sides'><option value=''>Select Side</option><option value='Left'>Left</option>" +
                            "<option value='Right'>Right</option></select> " +
                            "<a href='javascript:void(0);' class='minus-icon remove_field'><img src='../../images/minus.jpg' />" +
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
                                // console.log(item);
                                html_data += "<option value=" + item.id + ">" + item.category_name + "</option>";

                            });
                        }
                        else {
                            html_data = "<option value=0>Select Category</option>";
                        }
                        // console.log(html_data);
                        $("#categoryname").html(html_data);

                    }

                });


            });

            // $('#manufacturer').change(function(){
            // 	var projectid = $('#projectname').val();
            // 	var manufacturer = $('#manufacturer').val();

            // 	$.ajax({
            //               url: "{{ URL::to('admin/getrep')}}",
            //               data: {
            //                   projectid: projectid,
            // 			manufacturer:manufacturer
            //               },
            //               success: function (data)
            // 		{
            // 			console.log(data);
            //                   var html_data = '';
            // 			 if (data.status) {
            // 			$.each(data.value, function (i, item) {
            // 				console.log(item);
            //                           html_data += "<option value="+item.id+">"+item.email+"</option>";

            // 			});
            // 			 }
            // 			 else
            // 			 {
            // 				 html_data = "<option value=0>Select Rep</option>";
            // 			 }
            // 			console.log(html_data);
            //                   $("#repemail").html(html_data);

            //               }

            //           });
            // });


        });
    </script>
@stop