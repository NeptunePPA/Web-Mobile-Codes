<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 3/14/2018
 * Time: 12:13 PM
 */-->
@extends ('layout.default')
@section ('content')

    <div class="tab-pane" id="Survey">
        <div class="content-area clearfix" style="padding:30px 30px 30px;">
            <h1 class="" align="center">Category Group</h1>
            <div class="top-links clearfix">
                <ul class="add-links">
                    <li><a title="Add Device" href="{{URL::to('admin/category-group/create')}}">Add</a></li>
                    <li><a title="Add Device" href="#" id="delete" class="itemexport">Delete</a></li>
                </ul>
                <ul class="add-links pull-right">
                    <li><a title="Add Device" href="{{URL::to('admin/category')}}" id="itemexport" class="itemexport">Close</a></li>
                </ul>

            </div>
            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkmain"/></th>
                        <th>Project Name</th>
                        <th>Category Group Name</th>
                        <th>Category Name</th>


                    </tr>

                    </thead>

                    <tbody id="device_survey_result">
                    @forelse($category as $row)
                        <tr>
                            <td><input type="checkbox" class='chk_rep' name="chk_rep[]"
                                       value="{{$row->id}}"/></td>
                            <td>{{$row->project->project_name}}</td>
                            <td>{{$row->category_group_name}}</td>
                            <td>{{$row->category->category_name}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Record Found.</td>
                        </tr>
                    @endforelse
                    </tbody>


                </table>
            </div>
            <div class="bottom-count clearfix">

            </div>
        </div>
    </div>

    <script type="text/javascript">

        $("#checkmain").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on("click", "#delete", function () {
            if ($(".chk_rep:checked").length == 0) {

                alert("Please select Category Group record and delete");
                return false;
            }
            else {

                if (confirm("Are you sure you want to delete Category Group?")) {

                    var ck_rep = new Array();
                    $.each($("input[name='chk_rep[]']:checked"), function () {
                        var ck_reps = $(this).val();

                        ck_rep.push(ck_reps);
                    });

                    var userId = '';

                    $.ajax({
                        url: "{{URL::to('admin/category-group/delete')}}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ck_rep: ck_rep,

                        },
                        type: "POST",
                        success: function () {
                            setTimeout(function () {
                                location.reload();
                            }, 100);
                        }
                    });
                    return true;
                }
                else {
                    return false;
                }
            }
        });
    </script>

@stop