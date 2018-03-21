@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 10%;">

        <div class="top-links clearfix">
            <ul class="add-links">
                <li>
                    <a title="Add User" href="{{URL::to('admin/itemfiles/add')}}" data-toggle="modal">Add ItemFile</a>
                </li>
                <li>
                    <a title="Add User" href="{{URL::to('admin/itemfiles/itemfile')}}" data-toggle="modal">Sample
                        Template</a>
                </li>
            </ul>

        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>Client</th>
                    <th>Project</th>
                    <th>Date Created</th>
                    <th>Last Update</th>
                    <th>Action</th>
                </tr>

                <tr>
                    {{  Form::open(array('url'=>'' , 'method' =>'POST','class'=>'form-horizontal','id'=>'ajax_data','files'=>'true'))}}
                    <td><input type="checkbox" id="checkmain"/></td>
                    <td><input type='text' class='search_text' data-field='scorecard.month' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='scorecard.month' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='scorecard.year' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='scorecard.year' name="search[]"/></td>
                    <td style="width:150px;"></td>

                    {{form::close()}}
                </tr>

                </thead>
                <tbody id='scorecardhtml'>
                @foreach($itemfile as $row)
                    @if($row->clientname['client_name'] != '')
                        <tr>
                            <td><input type="checkbox" class='chk_score' name="scorecard[]" value=""/></td>
                            <td>{{$row->clientname['client_name']}}</td>
                            <td>{{$row->projectname['project_name']}}</td>
                            <td>{{\Carbon\Carbon::parse($row->createDate)->format('d-m-Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($row->updateDate)->format('d-m-Y')}}</td>
                            <td><a href="{{ URL::to('admin/itemfiles/view/'.$row->id) }}">View</a> &nbsp;<a
                                        href="{{ URL::to('admin/itemfiles/edit/'.$row->id) }}">Edit</a>&nbsp;<a
                                        href="{{ URL::to('admin/itemfiles/remove/'.$row->id) }}"
                                        onclick="return confirm(' Are you sure you want to delete Itemfile?');">Remove</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>


            </table>

        </div>

        <div class="bottom-count clearfix">
            {{$itemfile->count()}} of {{$count}} displayed
            {{Form::open(array('url'=>'admin/itemfiles','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
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
                        $(".scorecardRemove").submit();
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            });

            $(".search_text").keyup(function () {
                var data = $('#ajax_data').serialize();
                // console.log(data);
                $.ajax({
                    url: "{{URL::to('admin/itemfiles/search')}}",
                    data: $('#ajax_data').serialize(),
                    type: "POST",
                    success: function (data) {
                        // console.log(data);
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                html_data += "<tr><td><input type='checkbox' class='chk_score' name='scorecard[]'/></td><td>" + item.client_name + "</td><td>" + item.project_name + "</td><td>" + item.createat + "</td><td>" + item.updateat + "</td><td><a href='../admin/itemfiles/view/" + item.id + "'>View</a> &nbsp;<a href='../admin/itemfiles/edit/ " + item.id + "'>Edit</a> &nbsp;<a href='../admin/itemfiles/remove/" + item.id + "' onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;Itemfile?');>Remove</a></td></tr>";

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