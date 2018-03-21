<!DOCTYPE html>
<html>
<head>
    <title>Neptune PPA - Repcase Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ URL::asset('frontend/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/js/bootstrap.min.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="{{ URL::asset('frontend/css/repcase/reset.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/repcase/bootstrap.min.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/repcase/font-awesome.css') }}" type="text/css" rel="stylesheet" media="all" />
    <link href="{{ URL::asset('frontend/css/repcase/style.css') }}" type="text/css" rel="stylesheet" media="all" />
    <!-- client meta -->
    <meta name="apple-mobile-web-app-title" content="Neptune PPA" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon-iphone.png') }}" />
    <link rel="shortcut icon" href="{{ asset('frontend/images/apple-touch-icon-iphone.png') }}">
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
<body class="hidden-lg">
@yield('content')
</body>
<script type="text/javascript">

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
</html>