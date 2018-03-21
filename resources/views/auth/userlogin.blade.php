@extends('layouts.userlogin')

@section('content')
<div class="login-panel">
    <div class="header">
        <a class="info-icon" href="#" title="Info">Info</a>
        <h1><img src="{{ URL::asset('frontend/images/logo.png') }}" /></h1>
    </div>
    <ul>
        @foreach($errors->all() as $error)
        <li style="color:#161443; margin:5px;">{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'login' ,'method'=>'POST')) }}
    <div class="input">
        {{ Form::text('email', null, array('placeholder'=>'Email')) }}
    </div>
    <div class="input">
        {{ Form::password('password',['placeholder' => 'Password']) }}
    </div>	
    <div class="login-btn">
        {{ Form::submit('Login') }}
    </div>
    {{ Form::close() }}
</div>
<script>

    $(document).ready(function(){
        function installation_popup(){
            
            swal({

            title: "<div style='font-size: 20px;'>Steps to install the app<br>1<br/></div>",
            text: '<img src="{{ URL::to('images/step1.png')}}" height="150" width="300" />',
            html: true,
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Next!',
            closeOnConfirm: false

            },
            function(){

                swal({

                    title: "<div style='font-size: 20px; '>Steps to install the app<br>2<br/></div>",
                    text: '<img src="{{ URL::to('images/step2.png')}}" height="150" width="300" />',
                    html: true,
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Next!',
                    closeOnConfirm: false

                },
                function(){

                    swal({

                        title: "<div style='font-size: 20px;'>Steps to install the app<br>3<br/></div>",
                        text: '<img src="{{ URL::to('images/step3.png')}}" height="150" width="300" />',
                        html: true,
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Next!',
                        closeOnConfirm: false

                    },
                    function(){

                        swal({

                            title: "<div style='font-size: 20px;'>Steps to install the app<br>4<br/></div>",
                            text: '<img src="{{ URL::to('images/step4.png')}}" height="150" width="300" />',
                            html: true,
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Next!',
                            closeOnConfirm: false

                        },
                        function(){

                            swal({

                                title: "<div style='font-size: 20px; '>Steps to install the app<br>5<br/></div>",
                                text: '<img src="{{ URL::to('images/step5.png')}}" height="150" width="300" />',
                                html: true,
                                showCancelButton: true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Done!',
                                closeOnConfirm: false

                                },
                                function(){

                                    swal("Done !", "Your app is setuped!", "success");
                            });
                        });
                    });
                });
            });
            
        }
        
        $(".info-icon").click(function() {
            installation_popup();
         });

        
    });
</script>
@endsection
