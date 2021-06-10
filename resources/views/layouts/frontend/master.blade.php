<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> @yield('title') </title>
  <!-- <link rel="icon" type="image/x-icon" href="images/favicon.png" /> -->
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/css/all.css')}}">
  <!--google-fonts-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet">
  <!--custom-fonts-->
  <link rel="stylesheet" href="{{asset('theme/fonts/photograph-signature/style.css')}}">
  <!--owl-carosel css-->
  <link rel="stylesheet" href="{{asset('theme/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/css/owl.theme.default.min.css')}}">
  <!--animate.css-->
  <link rel="stylesheet" href="{{asset('theme/css/animate.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('theme/css/nice-select.css')}}">
  <!--custom-->
  <link rel="stylesheet" href="{{asset('theme/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('theme/css/custom.css')}}">
</head>
<body>
<!--navbar-->
@include('layouts.frontend.partials.header')
<!--navbar-->

<!--serch opacity-->

<!--serch opacity-->

 @yield('content')

<!--footer-->
@include('layouts.frontend.partials.footer')
<!--footer-->
<!--<script src="js/jquery-2.2.4.min.js"></script></script>-->
  <!-- <script src="{{asset('theme/js/jquery-3.3.1.min.js')}}"></script> -->
  <script src="{{asset('theme/js/jquryAjax.js')}}"></script>  
  <script src="{{asset('theme/js/popper.min.js')}}"></script>
  <script src="{{asset('theme/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('theme/js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('theme/js/owlcarousel2-progressbar.js')}}"></script>
  <script src="{{asset('theme/js/jquery.nice-select.min.js')}}"></script>
  <script src="{{asset('theme/js/custom.js')}}"></script>  
  <script src="{{asset('theme/js/script.js')}}"></script> 
  {{-- page script --}}
    @yield('page-script')
    {{-- page script --}}
    @stack('js')
</body>
</html>