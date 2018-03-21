@extends('layouts.userlogin')

@section('content')
<div style="margin:-25px 20px 0 0;">
    <a class="menuinfoicon" href="#" title="Info">Info</a>
</div>
<div class="login-panel">
    <div class="header">
        <a class="menuicon" rel="popover" data-popover-content="#menu-popover" href="#"></a>
        <!-- <a class="info-icon" href="#" title="Info">Info</a> -->
        <h1><img src="{{ URL::asset('frontend/images/logo.png') }}" /></h1>
    </div>
    <!-- POPOVER -->
    <div id="menu-popover" class="hide menu-popover">
        <ul class="menu">
            <li class="menu-item"><a href="{{ URL::to('logout') }}">Log out</a></li>
        </ul>
    </div>
    <ul>
        @foreach($errors->all() as $error)
        <li style="color:#161443; margin:5px;">{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'logincontinue' ,'method'=>'POST')) }}
    
    <div class="input">
        {{ Form::select('clients',$clients,'',array('id'=>'client_name','style'=>'width:100%; height:30px;')) }}
    </div>
    
    @if(Auth::user()->roll == 2)
    <div class="input">
        {{ Form::select('projects',array('0'=>'Select Project'),'',array('id'=>'project_name','style'=>'width:100%; height:30px;')) }}
    </div>
    @endif

    <div class="login-btn">
        {{ Form::submit('Continue',array('id'=>'btnContinue')) }}
    </div>
    {{ Form::close() }}
</div>

<script>
    $(document).ready(function(){

        
        $('#btnContinue').prop("disabled", true);
        $('#project_name').hide();


        $('#client_name').change(function(){

            var rollid = '{{Auth::user()->roll}}';
            var clientid = $(this).val();
            
            if(rollid == '3' && clientid != '0')
            {
                $("#btnContinue").prop("disabled", false);
            }

            $('#project_name').show();

            $.ajax({
                url: "{{ URL::to('selectclient/getprojects')}}",
                data: {
                    clientid:clientid,
                },
                success: function (data) 
                {
                    var html_data = '';
                     if (data.status) {
                        html_data += "<option value=0>Project Name</option>";
                        $.each(data.value, function (i, item) {
                                html_data += "<option value="+item.project_id+">"+item.project+"</option>";

                        });
                     }
                     else
                     {
                         html_data = "<option value=0>Select Project</option>";
                     }
                    $("#project_name").html(html_data);

                }

            });
        });

        $('#project_name').change(function(){
             $('#btnContinue').prop("disabled", false);
        });

        

    });
    $('[rel="popover"]').popover({
            container: 'body',
            html: true,
            placement: 'bottom',
            content: function() {
                var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                return clone;
            }
        }).click(function(e) {
            e.preventDefault();
    });

    $('body').on('click', function (e) {

        $('[rel="popover"]').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
</script>
@endsection
