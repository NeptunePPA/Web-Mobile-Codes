{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: Punit--}}
 {{--* Date: 10/31/2017--}}
 {{--* Time: 9:43 AM--}}
 {{--*/--}}
@extends ('layout.default')
@section ('content')

    <div class="content-area clearfix" style="margin:0 30%;">

        <a title="Add Serial Number" href="{{URL::to('admin/devices')}}" class="pull-right" data-toggle="modal">X</a>
        <div class="table" >
            <table>
                <thead>
                <tr>
                    <th>Required Device Model Number / Clinet Name</th>


                </tr>


                </thead>
                <tbody id='scorecardhtml'>

                @foreach($wrongdatas as $row)
                    <tr>
                        <td>{{$row['serial']}}</td>

                    </tr>
                @endforeach
                </tbody>


            </table>

        </div>


    </div>


@stop