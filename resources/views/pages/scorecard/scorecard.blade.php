@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 29%;">

        <h3>Scorecard: {{$user['name']}} @foreach($user->userclients as $row)
                | {{$row->clientname->client_name}}  @endforeach</h3>
        <div class="top-links clearfix">
            <ul class="add-links">
                <li><a title="Add User" href="{{ URL::to('admin/users/scorecard/create/'.$user['id']) }}"
                       data-toggle="modal">Add Scorecard</a> | <a title="Add User" href="#" data-toggle="modal"
                                                                  id="deletescorecard">Delete Scorecard</a></li>
            </ul>
            <ul class="add-links pull-right">
                <li><a title="Add User" href="{{ URL::to('admin/users') }}" data-toggle="modal">Close</a></li>
            </ul>

        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>

                <tr>
                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}
                    {{ Form::hidden('userId',$user['id'])}}
                    <td><input type="checkbox" id="checkmain"/></td>
                    <td><input type='text' class='scsearch_text' data-field='scorecard.month' name="search[]"/></td>
                    <td><input type='text' class='scsearch_text' data-field='scorecard.year' name="search[]"/></td>
                    <td style="width:85px;"></td>
                    {{ Form::close()}}
                </tr>
                </thead>

                <tbody id='scorecardhtml'>

                @foreach($scorecard as $row)
                    <tr>
                        <td><input type="checkbox" class='chk_score' name="scorecard[]" value="{{$row->id}}"/></td>
                        <td>{{ $row->months->month}}</td>
                        <td>{{ $row->year }}</td>
                        <td><a href="{{ URL::to('admin/users/scorecard/view/'.$row->id) }}">View</a> &nbsp;
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

        <div class="bottom-count clearfix">
            {{$scorecard->count()}} of {{$count}} displayed
            {{Form::open(array('url'=>'admin/users/scorecard/'.$user['id'],'method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
            {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
            {{Form::close()}}
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $("#checkmain").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });

            $(document).on("click", "#deletescorecard", function () {
                if ($(".chk_score:checked").length == 0) {

                    alert("Please select scorecard record and delete");
                    return false;
                }
                else {

                    if (confirm("Are you sure you want to delete scorecard?")) {
                        var ck_rep = new Array();
                        $.each($("input[name='scorecard[]']:checked"), function () {
                            var ck_reps = $(this).val();

                            ck_rep.push(ck_reps);
                        });

                        var userId = {{$user['id']}};

                        $.ajax({
                            url: "{{URL::to('admin/users/scorecard/remove/"+userid+"')}}",
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

            $(".scsearch_text").keyup(function () {
                var data = $('#ajax_data').serialize();
                // console.log(data);
                $.ajax({
                    url: "{{URL::to('admin/users/scorecard/search')}}",
                    data: $('#ajax_data').serialize(),
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                html_data += "<tr><td><input type='checkbox' class='chk_score' name='scorecard[]' value='" + item.id + "'  /></td><td>" + item.month + "</td><td>" + item.year + "</td><td><a href='../scorecard/view/" + item.id + "'>View</a></td></tr>";

                            });
                        } else {
                            html_data = "<tr> <td colspan='14' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        console.log(html_data);
                        $("#scorecardhtml").html(html_data);

                    }
                });


            });
        });

    </script>
@stop       