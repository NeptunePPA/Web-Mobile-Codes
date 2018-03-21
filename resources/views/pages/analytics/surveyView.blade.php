@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 30%;">

        {{ Form::open(array('url' => 'admin/orders/updateall','id'=>'form1')) }}
        <div class="top-links clearfix">
            <ul class="add-links">
                <li><a href="#" id="exportsurvey">Export Data</a></li>
            </ul>
            <ul class="add-links pull-right">
                <li><a href="{{URL::to('admin/tracking/survey')}}">Close</a></li>
            </ul>
        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <!-- <th width="30">&nbsp;  </th> -->
                    <th>Questions</th>
                    <th>Yes</th>
                    <th>No</th>

                </tr>
                <tr>
                    <!-- <td><input type="checkbox" id="checkmain"/></td> -->
                    <td><input type="text" class='search_text' data-field='client.client_name' name="search[]"/></td>
                    <td><!-- <input type="text" class='search_text' data-field='que_1' name="search[]" /> --></td>
                    <td><!-- <input type="text" class='search_text' data-field='que_2' name="search[]" /> --></td>
                </tr>
                </thead>

                <tbody id="order_result">
                @if(count($data) > 0)
                    @foreach($data as $row)
                        @if($row['que'] != '')
                            <tr>
                                <!-- <td><input type="checkbox" name="survey_check[]" value="" class="chk_orders" /></td> -->

                                <td>{{$row['que']}}</td>
                                <td>{{$row['yes'] == ""? '-':$row['yes']}}</td>
                                <td>{{$row['no'] == ""? '-':$row['no']}}</td>

                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan='15' style='text-align:center;'>No result found</td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>
        {{ Form::close() }}
        <div class="bottom-count clearfix">

        </div>
    </div>

    <script type="text/javascript">

        /*Select all checkbox*/
        $("#checkmain").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on("click", "#exportsurvey", function (event) {

            var user = {{$user}};

            $.ajax({

                url: "{{URL::to('admin/tracking/survey/view/export')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    // ck_rep:ck_rep,
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

        });

        /*submit client id form*/
        $("#dataclient").change(function () {

            $("#clients").submit();
            return true;
        });


        $("#populardata").change(function () {
            var pdata = document.getElementById('populardata').value;

            if (pdata != '0') {
                $("#popular").submit();
                return true;
            }
        });
        /*Search Data*/

        $(".search_text").keyup(function () {

            var search = new Array();
            $.each($("input[name='search[]']"), function () {
                var ck_reps = $(this).val();

                search.push(ck_reps);
            });

            // console.log(search);

            var user = {{$user}}

		$.ajax({
                url: "{{ URL::to('admin/tracking/survey/view/search')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: search,
                    user: user,
                },
                type: "POST",
                success: function (data) {

                    var html_data = '';
                    var j = '0';
                    if (data.status) {
                        $.each(data.value, function (i, item) {

                            var yes = (item.yes != null) ? item.yes : '-';
                            var no = (item.no != null) ? item.no : '-';


                            if (item.que != null) {

                                html_data += "<tr><td>" + item.que + "</td><td>" + yes + "</td><td>" + no + "</td></tr>";
                                j++;
                            }
                        });
                        if (j == '0') {
                            html_data = "<tr> <td colspan='3' style='text-align:center;'> No data Found.!!! </td> </tr>"
                        }
                    } else {
                        html_data = "<tr> <td colspan='3' style='text-align:center;'> " + data.value + " </td> </tr>"
                    }

                    $("#order_result").html(html_data);

                }

            });

        });

    </script>
@stop 