@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 30%;">

        <div align="center"><h2>Client : {{$serial->client->client_name}} </h2></div>

        <div class="top-links clearfix">
            <ul class="add-links">
                <li>
                    <a title="Edit" href="{{URL::to('admin/devices/serialnumber/edit/'.$serialId)}}" data-toggle="modal"> Edit </a> |
                    <a title="Import" href="#" id="import"> Import </a> |
                    <a title="Export" href="{{URL::to('admin/devices/serialnumber/export/'.$serialId)}}" data-toggle="modal">Export</a> |
                    <a title="Remove" href="#" data-toggle="modal" class="remove">Remove</a> |
                    <a title="Consignment" href="{{URL::to('admin/devices/serialnumber/consignment/'.$serialId)}}" data-toggle="modal" class="remove">Consignment</a>
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
                    <th>Purchase Type</th>
                    <th>Status</th>
                    <th>Swap Type</th>
                </tr>


                </thead>
                <tbody id='scorecardhtml'>
                @if(count($serialnumberDetails))
                    @foreach($serialnumberDetails as $row)
                        <tr>
                            <td><input type="checkbox" class='chk_rep' name="chk_rep[]" value="{{$row->id}}"/></td>
                            <td>{{$row->serialNumber}}</td>
                            <td>{{$row->discount = $row->discount == '' ? '-' : $row->discount}}</td>
                            <td>{{$row->purchaseDate = $row->purchaseDate == '' ? '-' : $row->purchaseDate}}</td>
                            <td>{{$row->expiryDate = $row->expiryDate == '' ? '-' : $row->expiryDate}}</td>
                            <td>{{$row->purchaseType = $row->purchaseType == '' ? '-' : $row->purchaseType}}</td>
                            <td>{{$row->status = $row->status == '' ? '-' : $row->status}}</td>
                            <td>{{$row->swapType = $row->swapType == '' ? '-' : $row->swapType}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan='6' style='text-align:center;'> No Records Found </td>
                    </tr>
                @endif
                </tbody>


            </table>

        </div>


    </div>
    <script type="text/javascript">

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
                    var id = {{$serialId}};
                    var client = {{$serial->clientId}};
                    var device = {{$serial['deviceId']}};

                    $.ajax({
                        url: "{{URL::to('admin/devices/serialnumber/removedata')}}/" + id,
                        data: {
                            _token: "{{ csrf_token() }}",
                            ck_rep:ck_rep,
                            client : client,
                            device : device
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