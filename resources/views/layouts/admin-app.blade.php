<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />

    <title>{{Config::get('constants.app-name')}} | Dashboard</title>
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

    <!--begin::Page Vendors Styles -->
    <link href="{{asset('css/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" /><!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <!--end::Page Vendors Styles -->

    <!--begin::Base Styles -->
    <link href="{{asset('css/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <link href="{{asset('css/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <!--end::Base Styles -->

    <link rel="shortcut icon" href="{{asset('css/images/app-logo.ico')}}" />
</head>
<!-- end::Head -->
</html>
<body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
@yield('content')
<script src="{{asset('css/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('css/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Base Scripts -->


<!--begin::Page Vendors Scripts -->
<script src="{{asset('css/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
<!--end::Page Vendors Scripts -->





<!--begin::Page Snippets -->
<script src="{{asset('css/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
<!--end::Page Snippets -->

</body>
