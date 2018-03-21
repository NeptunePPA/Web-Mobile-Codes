<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 3/14/2018
 * Time: 11:16 AM
 */-->

@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box">

            <div class="col-md-12 col-lg-12 modal-box">
                <a href="{{ URL::to('admin/category-group') }}" class="pull-right" data-toggle="modal">X</a>
                <h4> Add Category Group </h4>
                <p style="color:red; margin:5px; text-align:left; width:210px;">
                    {{ $errors->first('project_name') }}
                </p>
                <p style="color:red; margin:5px; text-align:left; width:210px;">
                    {{ $errors->first('category_name') }}
                </p>
                {{ Form::open(array('url' => 'admin/category-group/store','files'=>'true')) }}
                <div class="input1">
                    {{ Form::select('project_name', $project,null,array('id'=>'project','required'=>'true')) }}
                </div>
                <div class="input1">
                    {{ Form::text('category_group_name',null,array('placeholder'=>'Category Group Name','maxlength'=>'40','required'=>'true'))}}
                </div>

                <div class="input1">
                    {{ Form::select('category[]',$category,null,array('class'=>'js-example-basic-multiple-category','multiple'=>'multiple','required'=>'true','id'=>'category_name'))}}
                </div>

                <div>
                    {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section ('footer')
    <script src="{{ URL::asset('js/edit_script.js') }}"></script>

    <script type="text/javascript">

        $('#project').change(function(){
            var project = $('#project').val();

            $.ajax({
                url: "{{ URL::to('admin/getcategories')}}",
                data: {
                    project:project,
                },
                success: function (data)
                {
                    var html_data = '';
                    if (data.status) {
                        html_data += "<option value=''>Select Category</option>";
                        $.each(data.value, function (i, item) {
                            console.log(item);
                            html_data += "<option value="+item.id+">"+item.category_name+"</option>";

                        });
                    }
                    else
                    {
                        html_data = "<option value=''>Select Category</option>";
                    }
                    $("#category_name").html(html_data);

                }

            });
        });
    </script>
@stop
