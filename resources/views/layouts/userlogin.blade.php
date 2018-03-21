<!DOCTYPE html>
<html lang="en">
<head>
    <title>Neptune PPA - Devices</title>
    <script src="{{ URL::asset('frontend/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/bootstrap.min.js') }}"></script>

    <link href="{{ URL::asset('frontend/css/reset.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/font-awesome.css') }}" type="text/css" rel="stylesheet" media="all" />

    <script src="{{ URL::asset('dist/sweetalert-dev.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/leaflet.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/leaflet-beautify-marker-icon.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/imgViewer2.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('dist/sweetalert.css') }}">
    <link href="{{ URL::asset('frontend/css/build.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/style.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/leaflet.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/leaflet-beautify-marker-icon.css') }}" type="text/css" rel="stylesheet" media="all" />

    <link rel="shortcut icon" href="{{ asset('frontend/images/apple-touch-icon-iphone.png') }}">
    <meta charset="utf-8">
    <meta name="mobile-web-app-capable" content="yes">
    <!-- client meta -->
    <meta name="apple-mobile-web-app-title" content="Neptune PPA" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="blank" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon-iphone.png') }}" />

    <script>
        (function (standalone) {

            if (!standalone) {
                return;
            }

            document.addEventListener('click', function (e) {
                var element = e.target,
                    href = '';

                while (!/^(a|html)$/i.test(element.nodeName)) {
                    element = element.parentNode;
                }

                if (element.getAttribute) {
                    href = element.getAttribute('href');

                    if ('' !== href && '#' !== href && null !== href && (!element.protocol || element.protocol !== 'tel:')) {
                        e.preventDefault();
                        window.location = element.href;
                    }
                }
            }, false);

        }(window.navigator.standalone));
    </script>
    <!-- client meta -->
</head>

<body class="innerbg hidden-lg">

@yield('content')

</body>
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

                                                    swal("Done !", "You are now successfully setup", "success");
                                                });
                                        });
                                });
                        });
                });

        }

        $(".info-icon").click(function() {
            installation_popup();
        });

        $(".menuinfoicon").click(function() {
            installation_popup();
        });


    });
</script>
</html>
