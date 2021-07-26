@extends('front.layouts.default')
@section('content')

<!-- CSS added for insta slider -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">

<style>
  body {   
  background: #400cae; /* Old browsers */
  background: -moz-linear-gradient(left,  #400cae 0%, #250a57 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(left,  #400cae 0%,#250a57 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right,  #400cae 0%,#250a57 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#400cae', endColorstr='#250a57',GradientType=1 ); /* IE6-9 */
 }
 .ocf_top_right {display:none;}
 .cf_header {position:static;}
</style>

  <div class="oc_bg_main ocf_top_left"></div>
  <div class="oc_bg_main ocf_top_right"></div>
 
    <div class="fun_facts_screen">

        <div class="play-icon-wrap">         
          <a href="#" class="play-icon paused" title="Click to play audio"><i class="play-music"><img src="{{ asset('assets/front/images/icons/music_icon.png') }}" /></i></a>         
           <label class="switch-label"><span class="switch-btn"></span></label>
        </div>

      <div class="container-fluid">

        <div class="fill_facts">
          <div class="row align-items-center">
            <div class="col-md-5">
                    
              <div class="cf_header">
                  <div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_wht_logo.png') }}" alt="" width="300"/></a></div>
              </div>
              
              <form class="funfact-form" id="funfact_frm" method="post" action="{{ route('front.savefunfact') }}">
                <input type="hidden" name="event_id" value="{{$event_id}}" />
                <input type="hidden" name="user_id" value="{{$user_id}}" />
                <input type="hidden" name="team_id" value="{{$team_id}}" />
                {{ csrf_field() }}
               <div class="about_fun_facts @if($intro_game == 'ice_breaker_truth_lie') about_fun_facts_new @endif">
                <h5 class="mb-0">{{ $statement }}</h5>
              <!--   <span class="sub_txt">You have {{ $funFactScrrenTime }} minutes to add {{$title}}s.</span> -->
                
                  <div class="row mt-lg-3 mt-xl-3">
                    <div class="col-md-12">
                      <label class="control-label">{{$title}} no. 1</label>
                      <div class="form-group">
                        <textarea style="resize: none;" maxlength="100" class="form-control" type="text" placeholder="e.g. I love to play cricket." name="funfact1"></textarea>
                        @if($intro_game == 'ice_breaker_truth_lie')
                        <div class="d-flex align-items-center justify-content-start true_lie radio-tile-group">
                          <div class="input-container">
                              <input id="Truth1" class="radio-button" type="radio" name="statement1type" value="1" checked="checked" />
                              <div class="radio-tile">        
                                <label for="Truth1" class="btn btn-primary-black correct_ans">Truth</label>
                              </div>
                          </div>
                          <span class="white_text"> Or </span>
                          <div class="input-container">
                            <input id="Lie1" class="radio-button btn btn-primary-white" type="radio" value="2" name="statement1type" />
                            <div class="radio-tile">        
                              <label for="Lie1" class="radio-tile-label wrong_ans">Lie</label>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label class="control-label">{{$title}} no. 2</label>
                      <div class="form-group">
                        <textarea style="resize: none;" maxlength="100" class="form-control" type="text" placeholder="e.g. Black is my favourite color." name="funfact2"></textarea>
                        @if($intro_game == 'ice_breaker_truth_lie')
                        <div class="d-flex align-items-center justify-content-start true_lie radio-tile-group">
                          <div class="input-container">
                              <input id="Truth2" class="radio-button" type="radio" name="statement2type" value="1" checked="checked" />
                              <div class="radio-tile">        
                                <label for="Truth1" class="btn btn-primary-black correct_ans">Truth</label>
                              </div>
                          </div>
                          <span class="white_text"> Or </span>
                          <div class="input-container">
                            <input id="Lie2" class="radio-button btn btn-primary-white" type="radio" value="2" name="statement2type" />
                            <div class="radio-tile">        
                              <label for="Lie2" class="radio-tile-label wrong_ans">Lie</label>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label class="control-label">{{$title}} no. 3</label>
                      <div class="form-group">
                        <textarea style="resize: none;" maxlength="100" class="form-control" type="text" placeholder="e.g. I love to travel." name="funfact3"></textarea>
                        @if($intro_game == 'ice_breaker_truth_lie')
                        <div class="d-flex align-items-center justify-content-start true_lie radio-tile-group">
                          <div class="input-container">
                              <input id="Truth3" class="radio-button" type="radio" name="statement3type" value="1" checked="checked" />
                              <div class="radio-tile">        
                                <label for="Truth3" class="btn btn-primary-black correct_ans">Truth</label>
                              </div>
                          </div>
                          <span class="white_text"> Or </span>
                          <div class="input-container">
                            <input id="Lie3" class="radio-button btn btn-primary-white" type="radio" value="2" name="statement3type" />
                            <div class="radio-tile">        
                              <label for="Lie3" class="radio-tile-label wrong_ans">Lie</label>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                
                  <div class="form-group btn-container mt-2" id="submitFunFact">
                    <button class="btn btn-primary-pink btn-block btn-primary-black btn-radius" type="submit">Submit</button>
                  </div>
                </div>

              </form>
            </div>  

             
                 <figure><img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/></figure>
            

        </div><!-- End Row -->
      </div>
       <div class="timer_mem text-center" id="cdt_mem">
          <span class="timer_label">Fill {{$title}} In</span>
            <svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
              <g id="gf_id">
                <title>Layer 1</title>
               <circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"/>
              </g>
            </svg>         
            <span id="countdowntimer" style="color:#fff;"></span>            
        </div>        
    </div> <!-- End Containerfluid --> 
  </div>  
  <!-- End Fun Facts Screen -->


<!-- Start Cam Event -->

    <div class="modal fade commencing_modal" id="myModal" role="dialog">
        <div class="modal-dialog">    
          
            <div class="modal-content">
                <div class="oc_bg_main ocf_top_left"></div>
                <div class="oc_bg_main ocf_top_right"></div>    

                <div class="fun_page">
                    <h6> Welcome to the <strong>OFFICE CAMPFIRE </strong>event </h6>
                    <span>Below is today’s agenda:</span>
                    <ul class="fun_listing">
                        <li><em>1) {{$introGame->name}} ({{$introGame->game_times}} mins)</em> : {{$introGame->description}}</li>   
                        <li><em>2) {{$mainGame->name}} ({{$mainGame->game_times}} mins)</em> : {{$mainGame->description}} </li>
                    </ul>
                    <h5>Enjoy!</h5>
                </div>
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <div class="ocf_bottom_right"></div>  
            </div>      
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
  <script>
    $(function(){ 

        window.parent.document.getElementById( 'myIframe' ).classList.add( 'fun-facts' );
        
        var eventId = $('input[name="event_id"]').val();
        var team_id = $('input[name="team_id"]').val();
        var user_id = $('input[name="user_id"]').val();

        var adio = window.parent.document.getElementById( 'save-sound' );

        setCookie = function (cname, cvalue, exdays) {
          var d = new Date();
          d.setTime(d.getTime() + (exdays*24*60*60*1000));
          var expires = "expires="+ d.toUTCString();
          document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        getCookie = function (cname) {
          var name = cname + "=";
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');
          for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
            }
          }
          return "";
        }

        var isShown = getCookie( eventId + '--' + team_id + '--' + user_id );
        if( !isShown ) { 
          
          $('#myModal').modal('show');
            setTimeout(function() {
                setCookie(  eventId + '--' + team_id + '--' + user_id, true, 10 );
                $("button[data-dismiss]").click()
          }, 6500);
        }

        @if( $runningMinutes == $funFactScrrenTime )

          var minutes = {{ $minutes?$minutes:0 }};
          var seconds = {{ $seconds?$seconds:0 }};

          $mainTotalSecs = parseInt( minutes ) * 60 + parseInt( seconds );
          /* var mainToggleInterval = false; */
          if( $mainTotalSecs <= 5 ) { 
            $('#cdt_mem').addClass( 'blink' );
            /* mainToggleInterval = setInterval(function(){ $('#cdt_mem').toggle(); }, 500); */
          } else { 
            setTimeout(function(){
              $('#cdt_mem').addClass( 'blink' );
              /* mainToggleInterval = setInterval(function(){ $('#cdt_mem').toggle(); }, 500); */
            }, ( $mainTotalSecs - 5 ) * 1000 );
          }

          $('#countdowntimer').countdowntimer({
              minutes :<?php echo $minutes; ?>,
              seconds : <?php echo $seconds; ?>,
              displayFormat : 'MS',
              timeUp : whenTimesUp,
              size : "lg"
          });

          var secondsforsvg = <?php echo ($minutes*60)+$seconds; ?>;

          $('.timer_mem svg circle').css('animation-duration',secondsforsvg+'s');

          function whenTimesUp() {
            /* $('#cdt_mem').show();
            clearInterval( mainToggleInterval ); */
            $('#cdt_mem').removeClass( 'blink' );
          	// check if fun fact not yet added timer extend by one minute
            checkMyFunFactStatus();
          }
        @elseif( $runningMinutes == $funFactWaitingScrrenTime )
          extendTimerForOneMin( {{$minutes}}, {{$seconds}} );
        @endif


      $( document ).ready(function(){
        $( document ).on( 'click', 'a.play-icon', function(){
          if( !$( this ).hasClass( 'playing' ) ) { 
            window.parent.document.getElementById( 'audio' ).play();
            $( this ).attr( 'title', 'Click here to pause audio' );
            $( this ).removeClass( 'paused' ).addClass( 'playing' );
            //$( this ).find( '.fa-play' ).removeClass( 'fa-play' ).addClass( 'fa-pause' );
          } else { 
            window.parent.document.getElementById( 'audio' ).pause();
            $( this ).attr( 'title', 'Click here to play audio' );
            $( this ).removeClass( 'playing' ).addClass( 'paused' );
          //  $( this ).find( '.fa-pause' ).removeClass( 'fa-pause' ).addClass( 'fa-play' );
          }
          
          return false;
        });

        $( document ).on('click', '#submitFunFact', function(){
          adio.pause();
          adio.currentTime = 0;
          adio.play();
        });

      });

    });

    function extendTimerForOneMin ( $m, $s ){
      if( typeof $m == typeof undefined ) $m = <?php echo $funFactWaitingScrrenTime; ?>;
      if( typeof $s == typeof undefined ) $s = 00;

      $mainTotalSecs = parseInt( $m ) * 60 + parseInt( $s );

      if( $mainTotalSecs <= 5 ) { 
        $('#cdt_mem').addClass( 'blink' );
      } else { 
        setTimeout(function(){
          $('#cdt_mem').addClass( 'blink' );
        }, ( $mainTotalSecs - 5 ) * 1000 );
      }

      $('#countdowntimer  ').countdowntimer({
          minutes : parseInt($m),
          seconds : parseInt($s),
          displayFormat : 'MS',
          timeUp : whenThisTimesUp,
          size : "lg"
      });
       
      $('#gf_id').remove();
      $('#cdt_mem svg').html('<g id="gf_id"><title>Layer 1</title><circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"  style="animation-duration: '+$mainTotalSecs+'s;"/></g>');      
    }

    function whenThisTimesUp() {
      $('#cdt_mem').removeClass( 'blink' );
      var eventId = $('input[name="event_id"]').val();
      var team_id = $('input[name="team_id"]').val();
      var user_id = $('input[name="user_id"]').val();
      $.ajax({
        type: 'POST',
        url: "<?=url('/')?>/checkfunfactstatus",
        data: {"_token": "{{ csrf_token() }}", 'eventId': eventId, 'team_id':team_id, 'user_id' : user_id },
        success: function( response ) { 
          $( '.video-wraps.joined_member', window.parent.document ).addClass( 'hidden' );
          if( response.totalSubmittedFF < 1){
            $('#abc', window.parent.document).attr('href', "{{ $mainGameUrl }}" );

          }else{
            $('#abc', window.parent.document).attr('href', "{{route('front.gamescreen',['encryptedId'=>$encryptedId])}}" );
          }
          
          $("#abc", window.parent.document)[0].click( );
        }
      });
    }

    function checkMyFunFactStatus (){
      var eventId = $('input[name="event_id"]').val();
      var team_id = $('input[name="team_id"]').val();
      var user_id = $('input[name="user_id"]').val();

      $.ajax({
        type: 'POST',
        url: "<?=url('/')?>/checkfunfactstatus",
        data: {"_token": "{{ csrf_token() }}", 'eventId': eventId, 'team_id':team_id, 'user_id' : user_id },
        success: function( response ) { 
          if( response.count < 1){
            /* swal("Fun Facts!", 'Please fill up your fun facts, You will have one more minut to fill this up. Otherwise, You will be skipped from ICE BREAKER game.', "warning"); */
            swal("Alert!", 'Please submit your {{$title}}. You have <?php echo $funFactWaitingScrrenTime; ?> minute extra time to fill this up.', "warning");
            extendTimerForOneMin( response.m, response.s );
          }else{
            swal("Alert!", 'Please wait for others to fill up their {{$title}}.', "warning");

            /*mainToggleInterval = false;*/
            setTimeout(function(){
              $('#cdt_mem').addClass( 'blink' );
              /* mainToggleInterval = setInterval(function(){ $('#cdt_mem').toggle(); }, 500); */
            }, 55000 );

            $('#countdowntimer').countdowntimer({
                minutes : {{$funFactWaitingScrrenTime}},
                seconds : 0,
                displayFormat : 'MS',
                timeUp : function(){
                  $('#cdt_mem').removeClass( 'blink' );
                  //window.location.href="{{route('front.gamescreen',['encryptedId'=>$encryptedId])}}";

                  $('#abc', window.parent.document).attr('href', "{{route('front.gamescreen',['encryptedId'=>$encryptedId])}}" );
                  $("#abc", window.parent.document)[0].click( );
                },
                size : "lg"
            });

          }
        }
      });
    }

      // Slick hand slider
  $('.members-streaming').slick({
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

