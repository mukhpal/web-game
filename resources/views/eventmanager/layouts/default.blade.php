<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/event_manager/css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>{{$title}} - Panel</title>
    
    <link href="{{ asset( 'assets/front/images/fev_icon.png' ) }}" rel="icon">
    <link href="{{ asset( 'assets/front/img/apple-touch-icon.png' ) }}" rel="apple-touch-icon">	

    <script src="{{ asset('assets/event_manager/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/event_manager/js/jquery.validate.min.js') }}"></script>

  </head>
  <body>

	@yield('content')

	<!-- Essential javascripts for application to work-->

    <script src="{{ asset('assets/event_manager/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/event_manager/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/event_manager/js/main.js') }}"></script>
    <script src="{{ asset('assets/event_manager/js/script.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('assets/event_manager/js/plugins/pace.min.js') }}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });

      function fetchstates (country ,stateId=0){
        var url = "<?=url('/').'/event_manager/loadstates/'?>"+country+"/"+stateId;
        $.ajax({
          type: "GET",
          url: url,
          success: function(result){
            $("#state_tab").html(result);
          }
        });
      }
    </script>
  </body>
</html>