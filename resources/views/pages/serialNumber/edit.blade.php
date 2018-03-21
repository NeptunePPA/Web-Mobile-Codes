@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 30%;">

        <div align="center"><h2>Client : {{$serial->client->client_name}} </h2></div>

        <div class="top-links clearfix">
            <ul class="add-links">
                <li>
                    <a title="view" href="{{URL::to('admin/devices/serialnumber/view/'.$serialId)}}" > View </a> |
                    <a title="Save" href="#" id="savebtn"> Save </a> |
                    <a title="Import" href="#" id="import"> Import </a> |
                    <a title="Export" href="{{URL::to('admin/devices/serialnumber/export/'.$serialId)}}" data-toggle="modal">Export</a> |
                    <a title="Export" href="#" data-toggle="modal" class="remove">Remove</a>
                </li>
            </ul>
            <ul class="add-links pull-right">
                <li>
                    <a title="view" href="{{URL::to('admin/devices/view/'.$serial['deviceId'])}}#6" > Close </a>
                </li>
            </ul>

        </div>

        <div class="table" >
            <table>
                <thead>
                <tr>
                    <th><input type="checkbox" class='chk_rep' id="checkmain" value=""/></th>
                    <th>Serial Number</th>
                    <th>Discount %</th>
                    <th>Purchase Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Swap Type</th>
                </tr>


                </thead>
                <tbody id='scorecardhtml'>
                {{ Form::open(array('url' => 'admin/devices/serialnumber/update/'.$serialId,'method'=>'POST','id'=>'detailsform') )}}
                @if(count($serialnumberDetails))
                    @foreach($serialnumberDetails as $row)
                        <tr>
                            {{Form::hidden('detailsId[]',$row->id)}}
                            <td><input type="checkbox" class='chk_rep' name="chk_rep[]" value="{{$row->id}}"/></td>
                            <td>{{Form::text('serial[]',$row->serialNumber)}}</td>
                            <td>{{Form::number('discount[]',$row->discount)}}</td>
                            <td>{!!Form::text('purchaseDate[]',$row->purchaseDate,array('class' => 'datepicker'))!!}</td>
                            <td>{!!Form::text('expiryDate[]',$row->expiryDate,array('class' => 'datepicker')) !!}</td>
                            <td>{{$row->status}}</td>
                            <td>{{$row->swapType}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan='6' style='text-align:center;'> No Records Found </td>
                    </tr>
                @endif
                {{ Form::close() }}
                </tbody>


            </table>

        </div>


    </div>


    <script type="text/javascript">
        $(document).ready(function () {

            $(function () {

                $('.datepicker').datepicker({
                    numberOfMonths: 1,
                    dateFormat: 'mm-dd-yy',


                });
            });

        });

        $('#savebtn').click(function(){
            $('#detailsform').submit();
        });

        $('#import').click(function(){

            var daa = {{$serialId}};
            var url = '{{URL::to("admin/devices/serialnumber/import")}}' ;
            var path = url +"/"+daa;
            // console.log(path);
            window.location.href = path;
        });

        $("#checkmain").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on("click",".remove",function (event) {

            if($(".chk_rep:checked").length == 0)
            {

                alert("Please select record and Remove");
                return false;
            }
            else
            {

                if(confirm('Are you sure you want to delete Serial Numbers?  If the selected serial number is used in the Rep Case Tracker, it will affect the existing rep case tracker')){
                    var ck_rep = new Array();

                    $.each($("input[name='chk_rep[]']:checked"), function() {
                        var ck_reps = $(this).val();

                        ck_rep.push(ck_reps);
                    });
                    var id = {{$serialId}}

		            $.ajax({
                        url: "{{URL::to('admin/devices/serialnumber/removedata')}}/" + id,
                        data: {
                            _token: "{{ csrf_token() }}",
                            ck_rep:ck_rep
                        },
                        type: "POST",
                        success: function (response, textStatus, request) {
                            location.reload();
                        }
                    });
                }


            }
        });
    </script>

@stop