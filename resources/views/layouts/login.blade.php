<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>{{Config::get('constants.app-name')}}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="{{ asset('css/custom/vendors.bundle.css') }}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <link href="{{asset('css/custom/style.bundle.css')}}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <!--end::Base Styles -->

    <link rel="shortcut icon" href="{{asset('css/images/app-logo.ico')}}" />
</head>
<!-- begin::Body -->
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
@yield('content')

<!--begin::Base Scripts -->
<script src="{{asset('js/custom/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('js/custom/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Base Scripts -->

<!--begin::Page Snippets -->
<script src="{{asset('js/custom/login.js')}}" type="text/javascript"></script>
<!--end::Page Snippets -->
</body>
</html>
