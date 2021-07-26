@extends('front.layouts.default')
@section('content')

<audio id="save-sound" preload="auto" style="display:none;">
  <source src="{{ asset('assets/audio/Button.mp3') }}" type="audio/mp3">
  Your browser does not support the audio element.
</audio>

<div class="oc_bg_main ocf_top_left"></div>
<div class="oc_bg_main ocf_top_right"></div>

<div class="cf_header">
    <div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_logo.png') }}" alt="" width="300"/></a></div>
</div>

<div class="container">
    
    <section class="login-content">
         
        <div class="login-box">

        <form class="login-form" id="evntstart_frm" method="post" action="{{ route('front.updateusername') }}">
            <input type="hidden" name="user_id" value="{{$user_id}}" />
            <input type="hidden" name="team_id" value="{{$team_id}}" />
            <input type="hidden" name="avatar"  value="" id="avatar" />
            <input type="hidden" name="event_id" value="{{$event_id}}" />
            {{ csrf_field() }}
          <div class="create_conection">
              <h4 class="login-head">Event Name</h4>
              <p>{{$name}}</p>
          </div>
          
          <div class="form-group">
            <label class="control-label">Enter your full name</label>
            <input class="form-control font-bold btn-radius" type="text" placeholder="e.g. John Doe" name="fullname" value="" autofocus autocomplete="off" minlength="3" maxlength="25" />
            {!! $errors->first('fullname', '<p class="validation-errors">:message</p>') !!}
          </div>
          
          <div class="form-group">
            <label class="control-label">Select Avatar</label>
            <ul class="avatar-image">
            <li value="1"><span><img src="{{ asset('assets/front/images/icons/avtar1.png') }}" alt="avtar"/></span></li>
                <li value="2"><span><img src="{{ asset('assets/front/images/icons/avtar2.png') }}" alt="avtar"/></span></li>                
                <li value="3"><span><img src="{{ asset('assets/front/images/icons/avtar3.png') }}" alt="avtar"/></span></li>
                <li value="4"><span><img src="{{ asset('assets/front/images/icons/avtar4.png') }}" alt="avtar"/></span></li>
                <li value="5"><span><img src="{{ asset('assets/front/images/icons/avtar5.png') }}" alt="avtar"/></span></li>
                <li value="6"><span><img src="{{ asset('assets/front/images/icons/avtar6.png') }}" alt="avtar"/></span></li>
                <li value="7"><span><img src="{{ asset('assets/front/images/icons/avtar7.png') }}" alt="avtar"/></span></li>
                <li value="8"><span><img src="{{ asset('assets/front/images/icons/avtar8.png') }}" alt="avtar"/></span></li>
                <li value="9"><span><img src="{{ asset('assets/front/images/icons/avtar9.png') }}" alt="avtar"/></span></li>
                <li value="10"><span><img src="{{ asset('assets/front/images/icons/avtar10.png') }}" alt="avtar"/></span></li>
                <li value="11"><span><img src="{{ asset('assets/front/images/icons/avtar11.png') }}" alt="avtar"/></span></li>
                <li value="12"><span><img src="{{ asset('assets/front/images/icons/avtar12.png') }}" alt="avtar"/></span></li>
                <li value="13"><span><img src="{{ asset('assets/front/images/icons/avtar13.png') }}" alt="avtar"/></span></li>
                <li value="14"><span><img src="{{ asset('assets/front/images/icons/avtar14.png') }}" alt="avtar"/></span></li>
                <li value="15"><span><img src="{{ asset('assets/front/images/icons/avtar15.png') }}" alt="avtar"/></span></li>
                <li value="16"><span><img src="{{ asset('assets/front/images/icons/avtar16.png') }}" alt="avtar"/></span></li>
                <li value="17"><span><img src="{{ asset('assets/front/images/icons/avtar17.png') }}" alt="avtar"/></span></li>
                <li value="18"><span><img src="{{ asset('assets/front/images/icons/avtar18.png') }}" alt="avtar"/></span></li>
                <li value="19"><span><img src="{{ asset('assets/front/images/icons/avtar19.png') }}" alt="avtar"/></span></li>
                <li value="20"><span><img src="{{ asset('assets/front/images/icons/avtar20.png') }}" alt="avtar"/></span></li>
                <li value="21"><span><img src="{{ asset('assets/front/images/icons/avtar21.png') }}" alt="avtar"/></span></li>
                <li value="22"><span><img src="{{ asset('assets/front/images/icons/avtar22.png') }}" alt="avtar"/></span></li>
            </ul>
            {!! $errors->first('avatar', '<p class="validation-errors">:message</p>') !!}
          </div> 

          <div class="form-group btn-container">
            <div class="timer_mem" id="cdt_hme">
               <span class="timer_label">Event Starts In</span>
              <svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <title>Layer 1</title>
                  <circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"/>
                </g>
              </svg> 
               <span id="beforegamestart"></span>
            </div><!--timer-->

            <button id="submitbutton" class="btn btn-primary-pink btn-block btn-primary-black btn-radius" type="submit">JOIN NOW</button>
          </div>

        </form>

      </div>
  </section>
</div>   

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<script>

  var initial_event_timer = "<?php echo $initial_event_timer*60 ?>";

  $(document).ready(function(){

    document.getElementById("evntstart_frm").onkeypress = function(e) {
      var key = e.charCode || e.keyCode || 0;     
      if (key == 13) {
        e.preventDefault();
      }
    }

    $(function(){
      $('#submitbutton').hide();
      $('#beforegamestart').html('<span id="countdowntimerforgame"></span>');

        var secondsforsvg = <?php echo ($pendingMinut*60)+$pendingSeconds; ?>;

        $mainTotalSecs = parseInt( secondsforsvg );

        var mainToggleInterval = false;

        if( $mainTotalSecs <= 5 ) { 
          // mainToggleInterval = setInterval(function(){ $('#cdt_hme').toggle(); }, 500);
          $('#cdt_hme').addClass( 'blink' );
        } else { 
          setTimeout(function(){
            $('#cdt_hme').addClass( 'blink' );
            // mainToggleInterval = setInterval(function(){ $('#cdt_hme').toggle(); }, 500);
          }, ( $mainTotalSecs - 5 ) * 1000 );
        }

        try{
          $('#countdowntimerforgame').countdowntimer({
              displayFormat : 'MS',
              minutes :<?php echo $pendingMinut; ?>,
              seconds : <?php echo $pendingSeconds; ?>,
              timeUp : whenTimesUp,
              size : "lg"
          });
        }catch(e) {
          console.log( e.message );
        }

        $('.timer_mem svg circle').css('animation-duration',secondsforsvg+'s');

        function whenTimesUp() {
          $('#cdt_hme').removeClass( 'blink' );
          $('#cdt_hme').show();
          clearInterval( mainToggleInterval );
          $('#beforegamestart').html('');
          $('#submitbutton').show(); 
           $('.timer_mem').hide();
        }
    });

    $( '#evntstart_frm' ).on( 'submit', function(){
      document.getElementById( 'save-sound' ).pause( );
      document.getElementById( 'save-sound' ).currentTime = 0;
      document.getElementById( 'save-sound' ).play( );
    });

    $(document).on( 'click', '.slick-prev.slick-arrow, .slick-next.slick-arrow, .avatar-image li',  function(){
      document.getElementById( 'save-sound' ).pause( );
      document.getElementById( 'save-sound' ).currentTime = 0;
      document.getElementById( 'save-sound' ).play( ); 
    });
  });

  // Slick hand slider
  $('.avatar-image').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 5,
      slidesToScroll: 1, 
      swipeToSlide: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        } 
      ]
    });
</script>
@stop