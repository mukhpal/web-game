<!DOCTYPE html>
<html>

  <head>
    <title>{{isset( $pageData ) && isset($pageData['data']['page_meta_title']) && $pageData['data']['page_meta_title']?$pageData['data']['page_meta_title']:$title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2c0973" />
    <meta content="{{isset( $pageData ) && isset($pageData['data']['page_meta_keywords']) && $pageData['data']['page_meta_keywords']?$pageData['data']['page_meta_keywords']:''}}" name="keywords" />
    <meta content="{{isset( $pageData ) && isset($pageData['data']['page_meta_desc']) && $pageData['data']['page_meta_desc']?$pageData['data']['page_meta_desc']:''}}" name="description" />

    <link href="{{ asset( 'assets/front/images/fev_icon.png' ) }}" rel="icon">
    <link href="{{ asset( 'assets/front/img/apple-touch-icon.png' ) }}" rel="apple-touch-icon">	
    <!-- Bootstrap CSS File -->
    <link href="{{ asset( 'assets/front/lib/bootstrap/css/bootstrap.min.css' ) }}" rel="stylesheet">
    <!-- Libraries CSS Files -->
    <link href="{{ asset( 'assets/front/lib/slick/css/slick.css' ) }}" rel="stylesheet">
    <link href="{{ asset( 'assets/front/lib/animate/animate.min.css' ) }}" rel="stylesheet">
    <!-- Main Stylesheet File -->
    <link href="{{ asset( 'assets/front/css/style.css' ) }}" rel="stylesheet">

    @stack( 'after_styles' )

  </head>
  <body>

    @include('pages.includes.header')

	  @yield('content')

    @include('pages.includes.footer')

    <!-- JavaScript Libraries -->
    <script src="{{ asset( 'assets/front/lib/jquery/jquery.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/js/jquery.validate.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/bootstrap/js/bootstrap.bundle.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/easing/easing.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/waypoint/waypoints.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/counter/counterup.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/slick/js/slick.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/mobile-nav/mobile-nav.js' ) }}"></script>
    <script src="{{ asset( 'assets/front/lib/wow/wow.min.js' ) }}"></script>
    <!-- Template Main Javascript File -->
    <script src="{{ asset( 'assets/front/js/main.js' ) }}"></script>
    
    @stack( 'after_scripts' )

  </body>
</html>