<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="{{ asset( 'assets/front/images/fev_icon.png' ) }}" rel="icon">
    <link href="{{ asset( 'assets/front/img/apple-touch-icon.png' ) }}" rel="apple-touch-icon">	

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/font-awesome/css/font-awesome.min.css') }}">
     <!-- bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/instaslider.css') }}">
    <title>{{$title}} - Panel</title>
    <script src="{{ asset('assets/front/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.countdownTimer.js') }}"></script>
    <script src="{{ asset('assets/front/js/instaslider.js') }}"></script>

    <script src="{{ asset('assets/front/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/front/css/sweetalert.css') }}"></script>
    

  </head>
  <body>

	@yield('content')

	<!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="{{ asset('assets/front/js/script.js') }}"></script>
    
  @stack( 'after_scripts' )
  </body>
</html>