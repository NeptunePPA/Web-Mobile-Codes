@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box">

            <div class="col-md-12 col-lg-12 modal-box">
                <a title="Add Item File" href="{{URL::to('admin/repcasetracker')}}" class="pull-right" data-toggle="modal">X</a>
                <h4> Swap Device </h4>

                <ul>

                </ul>
                <div class="input1">
                    <a href="{{URL::to('admin/repcasetracker/swapdevice/serialnumber/'.$id)}}" class="btn btn-default view-edit-details-btn">Same Device new Serial #</a>
                </div>

                <div class="input1">
                    <a href="{{URL::to('admin/repcasetracker/swapdevice/newdevice/'.$id)}}" class="btn btn-default view-edit-details-btn">Completely New Device</a>
                </div>

                <div class="input1">
                    <a href="{{ URL::to('admin/repcasetracker') }}" class="btn btn-danger view-edit-details-btn  logout-btn">Cancel</a>
                </div>


            </div>
        </div>
    </div>


@stop