<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />

    <title>{{Config::get('constants.app-name')}} | Error Page</title>
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
    <link href="{{asset('css/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <link href="{{asset('css/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->


    <!--end::Base Styles -->

    <link rel="shortcut icon" href="{{asset('css/images/app-logo.ico')}}" />
</head>
<!-- end::Head -->


<!-- begin::Body -->
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >



<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">


    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-5" style="background-image: url(../../../assets/app/media/img//error/bg5.jpg);">
        <div class="m-error_container">
		<span class="m-error_title">
			<h1>Oops!</h1>
		</span>
            <p class="m-error_subtitle">
               {{$code}} | {{$message}}
            </p>
        </div>
    </div>


</div>
<!-- end:: Page -->


<!--begin::Base Scripts -->
<script src="{{asset('css/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('css/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Base Scripts -->
</body>
<!-- end::Body -->
</html>