@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 30%;">

        <a title="Add Serial Number" href="{{URL::to('admin/devices/serialnumber/view/'.$serialId)}}" class="pull-right" data-toggle="modal">X</a>
        <div class="table" >
            <table>
                <thead>
                <tr>
                    <th>Serial Number</th>


                </tr>


                </thead>
                <tbody id='scorecardhtml'>

                @foreach($wrongdata as $row)
                    <tr>
                        <td>{{$row['serial']}}</td>

                    </tr>
                @endforeach
                </tbody>


            </table>

        </div>


    </div>


@stop