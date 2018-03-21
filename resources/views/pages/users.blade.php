@extends ('layout.default')
@section ('content')
    <style>
        .scorecard_icon {
            padding-left: 20px;
        }
    </style>
    <div class="content-area clearfix" style="margin:0 5%;">
        {{ Form::open(array('url' => 'admin/users/updateall')) }}
        <div class="top-links clearfix">
            <ul class="add-links">
                <li><a title="Add User" href="{{ URL::to('admin/users/add') }}" data-toggle="modal">Add User</a></li>
            </ul>
            <div style="float:right;">
                {{ Form::submit('EDIT / SAVE',array('class'=>'btn_add_new','style'=>'width:100px; height:30px;')) }}
            </div>
        </div>
        <div class="table">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Organization</th>
                    @if(Auth::user()->roll == 1)
                        <th>Manufacturers</th>
                    @endif
                    <th>Projects</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @if(Auth::user()->roll == 1)
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                    <td style="width:85px;"></td>
                </tr>
                <tr>
                    <td>
                        <input type='text' class='search_text' data-field='users.name' name="search[]"/>
                    </td>
                    <td>
                        <input type='text' class='search_text' data-field='users.email' name="search[]"/>
                    </td>
                    <td>
                        <input type='text' class='search_text' data-field='roll.roll_name' name="search[]"/></td>
                    <td>
                        <input type='text' class='search_text' id="organization_search" data-field='clients.clientname'
                               name="search[]"/>
                    </td>
                    @if(Auth::user()->roll == 1)
                        <td><input type='text' class='search_text' data-field='manufacturers.manufacturer_name'
                                   name="search[]"/></td>
                    @endif
                    <td><input type='text' class='search_text' data-field='projects.project_name' name="search[]"/></td>
                    <td><input type='text' class='search_text' data-field='users.status' style="width:85px;"
                               name="search[]"/></td>
                    <td style="width:85px;"></td>
                </tr>
                </thead>
                <tbody id='user_result'>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->roll_name }}</td>
                        <?php
                        $resultstr = array();
                        foreach ($user->userclients as $row) {
                            $resultstr[] = $row->clientname['client_name'];
                        }

                        ?>
                        @if(count($resultstr)>0)
                            <td>{{ implode(",",$resultstr)}}</td>
                        @else
                            <td>-</td>
                        @endif
                        @if(Auth::user()->roll == 1)
                            <td>{{$user->roll == "5" ? $user->manufacture['manufacturer_name'] : ''}}
                        @endif
                        <?php
                        $resultstrproject = array();
                        foreach ($user->usersproject as $row) {
                            $resultstrproject[] = $row->projectname['project_name'];
                        }
                        ?>
                        <td>


                                @if(count($resultstrproject)>0)
                                    {{ implode(",",$resultstrproject)}}
                                @else
                                    -
                                @endif

                        </td>
                        <td>{{ Form:: hidden('hiddenid[]',$user->id)}}{{ Form::select('status[]',array('Enabled' => 'Enabled', 'Disabled' => 'Disabled'),$user->status) }}</td>
                        <td><a href="{{ URL::to('admin/users/edit/'.$user->id) }}"><i class="fa fa-edit"></i></a> &nbsp;

                            @if($user->roll == 3)
                                <a href="{{ URL::to('admin/users/scorecard/'.$user->id) }}"><i
                                            class="fa fa-check-square-o" aria-hidden="true"></i></a>&nbsp;
                            @else
                                <span class="scorecard_icon"></span>
                            @endif

                            <a href="{{ URL::to('admin/users/remove/'.$user->id) }}"
                               onclick="return confirm(' Are you sure you want to delete user?');"><i
                                        class="fa fa-close"></i></a></td>

                    </tr>
                @endforeach
                </tbody>


            </table>

        </div>
        {{ Form::close() }}
        <div class="bottom-count clearfix">
            {{$users->count()}} of {{$count}} displayed
            {{Form::open(array('url'=>'admin/users','method'=>'get','id'=>'pagesize_form','style'=>'display:inline-block;'))}}
            {{Form::select('pagesize', array('10' => 'Show 10','15' => 'Show 15','20' => 'Show 20',$count=>'Show all'),$pagesize,array('id'=>'pagesize','onchange' => 'this.form.submit()'))}}
            {{Form::close()}}
        </div>
    </div>


    <script type="text/javascript">

        $(document).ready(function () {
            $(".search_text").keyup(function () {
                var userrole = {{Auth::user()->roll}};
                var search = new Array();
                var selectclient = $('#userclientsid').val();

                $.each($("input[name='search[]']"), function () {
                    var ck_reps = $(this).val();
                    search.push(ck_reps);
                });
                $.ajax({
                    url: "{{ URL::to('admin/search_user')}}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: search,
                        selectclient: selectclient
                    },
                    success: function (data) {
                        var html_data = '';
                        if (data.status) {
                            $.each(data.value, function (i, item) {

                                if (item.status == 'Enabled') {
                                    var option = "<option value='Enabled' selected='selected'>Enabled</option><option value='Disabled'>Disabled</option>";
                                }
                                else {
                                    var option = "<option value='Enabled' >Enabled</option><option value='Disabled' selected='selected'>Disabled</option>";
                                }

                                var project = (item.project_name != null) ? item.project_name : '';
                                var manufacturer = (item.manufacturer != null) ? item.manufacturer : '';
                                // if(userrole == '1'){
                                var scorcardicon = item.roll == 3 ? "<a href=users/scorecard/" + item.id + "><i class='fa fa-check-square-o' aria-hidden='true'></i></a>&nbsp;" : "<span class='scorecard_icon'></span>";
                                // }else{
                                //     var scorcardicon = "";
                                // }

                                var manufacturer = userrole == "1" ? '<td>' + item.manufacturer + '</td>' : '';
                                if (item.view) {
                                    html_data += "<tr><td>" + item.name + "</td><td>" + item.email + "</td><td>" + item.roll_name + "</td><td>" + item.clientarr + "</td>" + manufacturer + "<td>" + project + "</td><td><input type='hidden' value='" + item.id + "' name='hiddenid[]' /><select name='status[]'>" + option + "</select></td><td><a href=users/edit/" + item.id + "><i class='fa fa-edit'></i></a>&nbsp; " + scorcardicon + "<a href=users/remove/" + item.id + " onclick=return&nbsp;confirm('Are&nbsp;you&nbsp;sure&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;user?');><i class='fa fa-close'></i></a></td></tr>";
                                }
                            });
                        }
                        else {
                            html_data = "<tr> <td colspan='7' style='text-align:center;'> " + data.value + " </td> </tr>"
                        }

                        $("#user_result").html(html_data);
                    }
                });
            });
        });


    </script>

@stop