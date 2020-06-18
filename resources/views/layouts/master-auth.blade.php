<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  -->
    <!--    Document Title-->
    <!-- =============================================-->
    <title>@yield('title') </title>
    <!--  -->
    <!--    Favicons-->
    <!--    =============================================-->
    {{--<link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/favicons/apple-touch-icon.png')}}">--}}
    {{--<link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicons/favicon-32x32.png')}}">--}}
    {{--<link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicons/favicon-16x16.png')}}">--}}
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicons/favicon.ico')}}">
    {{--<link rel="manifest" href="{{asset('images/favicons/manifest.json')}}">--}}
    {{--<link rel="mask-icon" href="{{asset('images/favicons/safari-pinned-tab.svg')}}" color="#5bbad5">--}}
    {{--<meta name="msapplication-TileImage" content="assets/images/favicons/mstile-150x150.png">--}}
    <meta name="theme-color" content="#ffffff">
    <link rel="manifest" href="manifest.json">
    <!--  -->
    <!--    Stylesheets-->
    <!--    =============================================-->
    <!-- Default stylesheets-->
    <link href="{{asset('lib/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Template specific stylesheets-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,300,400,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,400i" rel="stylesheet">
    <link href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/iconsmind/iconsmind.css')}}" rel="stylesheet">
    <link href="{{asset('lib/css-hamburgers/dist/hamburgers.css')}}" rel="stylesheet">
    <!-- Main stylesheet and color file-->
    <link href="{{asset('css/addtohomescreen.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    @yield('styles')

</head>
<body data-spy="scroll" data-target=".inner-link" data-offset="60">
@include('common.top-nav-main')
<main>

    @yield('content')

</main>

@include('common.footer')


<!--  -->
<!--    JavaScripts-->
<!--    =============================================-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="{{asset('lib/jquery/dist/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="{{asset('lib/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/core.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
@yield('scripts')
<!-- Script for add to homescreen widget -->
<script src="{{asset('js/addtohomescreen.js')}}"></script>
<script src="{{asset('js/homescreen.js')}}"></script>
</body>
</html>