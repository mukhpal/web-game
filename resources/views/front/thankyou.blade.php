@extends('front.layouts.default')
@section('content')

<style>
  html, body {height:100%;}
  body {   
  background: #400cae; /* Old browsers */
  background: -moz-linear-gradient(left,  #400cae 0%, #250a57 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(left,  #400cae 0%,#250a57 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right,  #400cae 0%,#250a57 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#400cae', endColorstr='#250a57',GradientType=1 ); /* IE6-9 */
}
.fun_facts_screen {display:flex; align-items:center; height:100%;}
.thanku_screen { margin: 80px 0;}
</style>

  <div class="oc_bg_main ocf_top_left"></div>
  <div class="oc_bg_main ocf_top_right"></div>
 
    <div class="fun_facts_screen" id="thankyou-screen">

        <div class="container-fluid">
             <div class="fill_facts">
                <div class="row align-items-center">
                    <div class="col-md-5">                                
                        <div class="cf_header">
                            <div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_wht_logo.png') }}" alt="" width="300"/></a></div>
                        </div>
                        <div class="thanku_screen text-center pt-5">
                            <h2 class="pt-5">We hope you enjoyed the event!</h2>
                            <p>Please feel free to stay back for few minutes and share your reflections with each other</p>
                            <h6>Thank You!</h6>                      
                        </div>
                   </div>
                   <div class="col-md-7">
                        <figure><img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/></figure>
                    </div>
                </div>

                <div class="timer_mem text-center" id="cdt_mem">
                    <span class="timer_label">Event ends in:</span>
                    <svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <title>Layer 1</title>
                            <circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"/>
                        </g>
                    </svg>         
                    <span id="countdowntimer" style="color:#fff;">10</span>
                </div>
                    
            </div>
         </div>
    </div>

<script>

    $(function(){

        var minutes = {{ $mm?$mm:0 }};
        var seconds = {{ $ss?$ss:0 }};

          $mainTotalSecs = parseInt( minutes ) * 60 + parseInt( seconds );
          if( $mainTotalSecs <= 5 ) { 
            $('#cdt_mem').addClass( 'blink' );
          } else { 
            setTimeout(function(){
              $('#cdt_mem').addClass( 'blink' );
            }, ( $mainTotalSecs - 5 ) * 1000 );
          }

          $('#countdowntimer').countdowntimer({
              minutes : minutes,
              seconds : seconds,
              displayFormat : 'MS',
              timeUp : whenTimesUp,
              size : "lg"
          });

          var secondsforsvg = <?php echo ($mm*60)+$ss; ?>;

          $('.timer_mem svg circle').css('animation-duration',secondsforsvg+'s');

          function whenTimesUp() {
            $('#cdt_mem').removeClass( 'blink' );
            try{ 
                window.parent.disableVideoWrap( );
                window.parent.videoCheck.checked = false;
                // console.warn( 'Shutting Down' );
                window.parent.shutdown( );
            } catch( e ) { 
                console.log( e.message );
            }

            $( '.joined_member', window.parent.document ).remove();
            // console.log( $( '.joined_member', window.parent.document ) );
            
            $( '#cdt_mem' ).remove( );
            $('.chat_modal').remove();
            // $('#abc', window.parent.document).attr('href', "{{route('front.index')}}" );
            // $("#abc", window.parent.document)[0].click( );
            window.top.location.href="{{route('front.index')}}";

          }
    });
</script>

@stop