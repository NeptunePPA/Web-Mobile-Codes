@extends ('layout.default')
@section ('content')


    <div class="content-area clearfix" style="margin:0 0%;">

        <div class="top-links clearfix" align="center">
            <table>
                <tr>
                    <td>User:- {{$user['name']}}</td>&nbsp;<td>Email:- {{$user['email']}}</td>
                    <td>Client:-
                        <?php $resultstr = array();
                        foreach ($user->userclients as $row1) {
                            $resultstr[] = $row1->clientname['client_name'];
                        }?>
                        {{ implode(",",$resultstr)}}
                    </td>
                    &nbsp;<td>Role:- {{$user->role->roll_name}}</td>&nbsp;
                </tr>
            </table>
        </div>
        {{ Form::open(array('url' => 'admin/orders/updateall','id'=>'form1')) }}
        <div class="top-links clearfix">
            <ul class="add-links">
                <li><a href="#" id="exportuser">Export Data</a></li>
            </ul>
            <ul class="add-links pull-right">
                <li><a href="{{URL::to('admin/tracking/users')}}">Close</a></li>
            </ul>
        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <th width="30">&nbsp;</th>
                    <th>Date</th>
                    <th># of Logins</th>
                    <th># of Orders</th>
                    <th>#Total Logins</th>
                    <th>#Total Orders</th>
                    <th>Devices Ordered</th>

                </tr>
                <tr>

                    <td><input type="checkbox" id="checkmain" name="check_users"/></td>
                    <td><input type="text" class='search_text' data-field='clients.client_name' name="search[]"/></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" class='search_text' data-field='users.login' name="search[]"/></td>


                </tr>
                </thead>
                <div style="display: none;">{{$date = ""}}</div>
                <tbody id="order_result">
                @if(count($order) > 0)
                    @foreach($order as $row)
                        <tr>
                            @if($date != $row->date)
                                <td><input type="checkbox" name="order_check[]" value="{{$row->order_date}}"
                                           class="chk_orders"/></td>
                                <td>{{$row->order_date}}</td>
                                <td>{{$row->logindate}}</td>
                                <td>{{$row->ordercount}}</td>
                                <td>{{$row->login}}</td>
                                <td>{{$row->order}}</td>
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif

                            <td>{{$row->model_name}}</td>

                        </tr>
                        <div style="display: none;">{{$date = $row->date}}</div>
                    @endforeach
                @else
                    <tr>
                        <td colspan='15' style='text-align:center;'> No Result Found..</td>
                    </tr>
                @endif
                </tbody>
                {{Form::hidden('userId',$user)}}
            </table>
        </div>
        {{ Form::close() }}
        <div class="bottom-count clearfix">
            {{$order->count()}} of {{$count}} displayed
            {{Form::open(array('url'=>'admin/tracking/users/view/'.$user['id'],'method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
            {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}

            {{Form::close()}}
        </div>
    </div>

    <script type="text/javascript">

        /*Select all checkbox*/
        $("#checkmain").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on("click", "#exportuser", function (event) {

            if ($(".chk_orders:checked").length == 0) {

                alert("Please select record and export");
                return false;
            }
            else {

                var ck_rep = new Array();
                $.each($("input[name='order_check[]']:checked"), function () {
                    var ck_reps = $(this).val();

                    ck_rep.push(ck_reps);
                });

                var user = {{$user['id']}};


                $.ajax({
                    url: "{{URL::to('admin/tracking/users/view/export')}}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ck_rep: ck_rep,
                        user: user

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


        /*submit client id form*/
        $("#dataclient").change(function () {

            $("#clients").submit();
            return true;
        });

        /*Search Data*/

        $(".search_text").keyup(function () {

            var search = new Array();
            $.each($("input[name='search[]']"), function () {
                var ck_reps = $(this).val();

                search.push(ck_reps);
            });

            // console.log(search);

            var user = {{$user['id']}}

		$.ajax({
                url: "{{ URL::to('admin/tracking/users/view/search')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: search,
                    user: user,
                },
                type: "POST",
                success: function (data) {

                    var html_data = '';

                    if (data.status) {

                        var date = "";

                        $.each(data.value, function (i, item) {

                            if (date != item.date) {
                                var dat = "<td><input type='checkbox' name='order_check[]' value=' " + item.order_date + "' class='chk_orders' /></td>" +
                                    "<td>" + item.order_date + "</td><td>" + item.logindate + "</td><td>" + item.ordercount + "</td><td>" + item.login + "</td><td>" + item.order + "</td>";
                            } else {
                                var dat = "<td></td><td></td><td></td><td></td><td></td><td></td>";
                            }
                            html_data += "<tr>" + dat + "<td>" + item.model_name + "</td></tr>";
                            date = item.date;
                        });
                    } else {
                        html_data = "<tr> <td colspan='15' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    $("#order_result").html(html_data);

                }

            });

        });

    </script>
@stop 