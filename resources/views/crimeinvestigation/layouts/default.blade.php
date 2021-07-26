<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="theme-color" content="#2c0973" />
  <meta content="" name="keywords">
  <meta content="" name="description">  
  <title>Crime investigation</title>
  <!-- Favicons -->
  <link href="{{ asset( 'assets/crime_investigation/images/favicon.png' ) }}" rel="icon">  

  <link href="{{ asset( 'assets/lib/animate/animate.min.css' ) }}" rel="stylesheet">
  <link href="{{ asset( 'assets/lib/ninja/ninja-slider.css' ) }}" rel="stylesheet" type="text/css" />
  <!-- Bootstrap CSS File -->
  <link href="{{ asset( 'assets/lib/bootstrap/css/bootstrap.min.css' ) }}" rel="stylesheet">
  <link href="{{ asset( 'assets/crime_investigation/css/lightgallery.min.css' ) }}" rel="stylesheet">
  <!-- Libraries CSS Files -->
  <!-- Main Stylesheet File -->
  <link href="{{ asset( 'assets/crime_investigation/css/style.css' ) }}" rel="stylesheet">
  <link href="{{ asset( 'assets/front/css/timer.css' ) }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset( 'assets/crime_investigation/css/jquery-confirm.min.css' ) }}">
</head>

<body id="crime_investigation">
  @yield('content')

  <!-- Watermark -->
    <div class="ocf_watermark">
        <img src="{{ asset( 'assets/crime_investigation/images/watermark1.png' ) }}" alt="" class="img-fluid" />
    </div>

  <!-- Watermark end here-->
  <!-- End Main Screen -->
  <div class="timer_mem" id="cdt_mem">
  <!-- <span class="timer_label">Game Starts In</span> -->
      <svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
        <g>
          <title>Layer 1</title>
          <circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"/>
        </g>
      </svg> 
     <span id="countdowntimer"></span>
     <div class="div_timer"></div>
</div>  
<div>
  <input type="hidden" name="gorl" value="{{route('crimeinvestigation.game_over')}}" />
  <input type="hidden" name="thanks" value="{{route('thankyou', $encId)}}" />
  <input type="hidden" name="token_rf" value="{{ csrf_token() }}" />
  <input type="hidden" name="encId" value="{{$encId}}" />
  <input type="hidden" name="hint_lru" value="{{ route('crimeinvestigation.hintunlock')}}" />
  <input type="hidden" class="life_screen" data-src="{{asset( 'assets/crime_investigation/images/gallery' ) }}">
  <a id="nextPage" href="{{ route('crimeinvestigation.file_closed', $encId) }}"></a>
  <a id="splash" href="{{ route('crimeinvestigation.splash', $encId) }}"></a>
</div>
  <!-- JavaScript Libraries -->
  <script src="{{ asset( 'assets/lib/jquery/jquery.min.js' ) }}"></script>
  <script src="{{ asset( 'assets/lib/bootstrap/js/bootstrap.bundle.min.js' ) }}"></script>
  <script src="{{ asset( 'assets/lib/waypoint/waypoints.min.js' ) }}"></script>
  <script src="{{ asset( 'assets/lib/slick/js/slick.min.js' ) }}"></script>
  <script src="{{ asset( 'assets/lib/ninja/ninja-slider.js' ) }}" type="text/javascript"></script>
  <script src="{{ asset( 'assets/lib/wow/wow.min.js' ) }}" type="text/javascript"></script>
  <script src="{{ asset( 'assets/crime_investigation/js/main.js' ) }}"></script>
  <script src="{{ asset( 'assets/crime_investigation/js/jquery-confirm.min.js' ) }}"></script>
  <script src="{{ asset( 'assets/front/js/jquery.countdownTimer.js' ) }}"></script>

  
  @stack( 'after_scripts' )
</body>
    @include( 'crimeinvestigation.includes.models' )
</html>