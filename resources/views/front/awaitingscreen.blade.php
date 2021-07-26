@extends('front.layouts.default')
@section('content')

<!-- CSS added for insta slider -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">

<div class="oc_bg_main ocf_top_left"></div>
<div class="oc_bg_main ocf_top_right"></div>

<div class="cf_header">
    <div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_logo.png') }}" alt="" width="300"/></a></div>
</div>


<div class="timer_mem" id="cdt_mem">
  <span class="timer_label">Game Starts In</span>
      <svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
        <g>
          <title>Layer 1</title>
          <circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"/>
        </g>
      </svg> 
     <span id="countdowntimer"></span>
      <!-- <span class="time-remaining">Time Remaining</span> -->
</div>  
<div class="container">
  
   <section class="login-content">
        <div class="login-box">
         <div class="member-box">       
           <div class="join_team_hdr">
             
             <div class="row">                                
                <div class="col-md-12 text-center">
                  <h4>Awaiting other team members to join</h4> 
                </div>
              </div> 
              <div class="row justify-content-center">
                <div class="col-md-12 joined_member text-center">
                  
                  <ul id="joined_users">
                  </ul>                  
                 
                  <?php /*
                   <span class="camera-activate-text">Turn on camera </span>
                    <button type="button" class="btn btn-xs btn-toggle active" data-toggle="button" aria-pressed="false" autocomplete="off" value="0">
                    <div class="handle"></div>
                  </button>
                  */ ?>
                   <p id="waitingMsg">{{$waitingmessage}}</p>
                </div> 
              </div>  
          </div><!--join_team_hdr-->

            <!-- Insta slider start -->
            <div class="testimonial-slider">
             
              <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                    <li data-thumb="So, what if. Instead of thinking about solving your whole life, You just think about adding additional good things. One at a time. Just let your pile of good things grow."> 
                        <p>So, what if. Instead of thinking about solving your whole life, You just think about adding additional good things. One at a time. Just let your pile of good things grow.</p>
                    </li>
                    <li data-thumb="Alone we can do so little; together we can do so much."> 
                        <p>Alone we can do so little; together we can do so much.</p>
                        <div class="client-name">– Helen Keller</div>
                    </li>
                    <li data-thumb="Talent wins games, but teamwork and intelligence win championships."> 
                        <p>Talent wins games, but teamwork and intelligence win championships.</p>
                        <div class="client-name">– Michael Jordan</div>
                    </li>
                    <li data-thumb="None of us, including me, ever do great things. But we can all do small things, with great love, and together we can do something wonderful."> 
                        <p>None of us, including me, ever do great things. But we can all do small things, with great love, and together we can do something wonderful.</p>
                        <div class="client-name">– Mother Teresa</div>
                    </li>
                    <li data-thumb="If everyone is moving forward together, then success takes care of itself."> 
                        <p>If everyone is moving forward together, then success takes care of itself.</p>
                        <div class="client-name">– Henry Ford</div>
                    </li>
                    <li data-thumb="If I have seen further, it is by standing on the shoulders of giants."> 
                        <p>If I have seen further, it is by standing on the shoulders of giants.</p>
                        <div class="client-name">– Isaac Newton</div>
                    </li>
                    <li data-thumb="No one can whistle a symphony. It takes a whole orchestra to play it."> 
                        <p>No one can whistle a symphony. It takes a whole orchestra to play it.</p>
                        <div class="client-name">– H.E. Luccock</div>
                    </li>
                    <li data-thumb="Teamwork is the ability to work together toward a common vision. The ability to direct individual accomplishments toward organizational objectives. It is the fuel that allows common people to attain uncommon results."> 
                        <p>Teamwork is the ability to work together toward a common vision. The ability to direct individual accomplishments toward organizational objectives. It is the fuel that allows common people to attain uncommon results.</p>
                        <div class="client-name">– Andrew Carnegie</div>
                    </li>
                    <li data-thumb="The strength of the team is each individual member. The strength of each member is the team."> 
                        <p>The strength of the team is each individual member. The strength of each member is the team.</p>
                        <div class="client-name">– Phil Jackson</div>
                    </li>
                    <li data-thumb="The way a team plays as a whole determines its success. You may have the greatest bunch of individual stars in the world, but if they don’t play together, the club won’t be worth a dime."> 
                        <p>The way a team plays as a whole determines its success. You may have the greatest bunch of individual stars in the world, but if they don’t play together, the club won’t be worth a dime.</p>
                        <div class="client-name">– Babe Ruth</div>
                    </li>
                    <li data-thumb="Great things in business are never done by one person; they're done by a team of people."> 
                        <p>Great things in business are never done by one person; they're done by a team of people.</p>
                        <div class="client-name">– Steve Jobs</div>
                    </li>
                    <li data-thumb="If you want to lift yourself up, lift up someone else."> 
                        <p>If you want to lift yourself up, lift up someone else.</p>
                        <div class="client-name">– Booker T. Washington</div>
                    </li>
                     <li data-thumb="If you want to go fast, go alone. If you want to go far, go together."> 
                        <p>If you want to go fast, go alone. If you want to go far, go together.</p>
                        <div class="client-name">– African Proverb</div>
                    </li>
                     <li data-thumb="Many ideas grow better when transplanted into another mind than the one where they sprang up."> 
                        <p>Many ideas grow better when transplanted into another mind than the one where they sprang up.</p>
                        <div class="client-name">– Oliver Wendell Holmes</div>
                    </li>
                     <li data-thumb="Great teamwork is the only way we create the breakthroughs that define our careers."> 
                        <p>Great teamwork is the only way we create the breakthroughs that define our careers.</p>
                        <div class="client-name">– Pat Riley</div>
                    </li>
                    <li data-thumb="No individual can win a game by himself."> 
                        <p>No individual can win a game by himself.</p>
                        <div class="client-name">– Pele</div>
                    </li>
                    <li data-thumb="We may have all come on different ships, but we’re in the same boat now."> 
                        <p>We may have all come on different ships, but we’re in the same boat now.</p>
                        <div class="client-name">– Martin Luther King, Jr.</div>
                    </li>
                    <li data-thumb="When you form a team, why do you try to form a team? Because teamwork builds trust and trust builds speed."> 
                        <p>When you form a team, why do you try to form a team? Because teamwork builds trust and trust builds speed.</p>
                        <div class="client-name">– Russel Honore</div>
                    </li>
                    <li data-thumb="Never doubt that a small group of thoughtful, committed citizens can change the world; indeed, it’s the only thing that ever has."> 
                        <p>Never doubt that a small group of thoughtful, committed citizens can change the world; indeed, it’s the only thing that ever has.</p>
                        <div class="client-name">– Margaret Mead</div>
                    </li>
                    <li data-thumb="The main ingredient of stardom is the rest of the team."> 
                        <p>The main ingredient of stardom is the rest of the team.</p>
                        <div class="client-name">– John Wooden</div>
                    </li>
                    <li data-thumb="Individually, we are one drop. Together, we are an ocean."> 
                        <p>Individually, we are one drop. Together, we are an ocean.</p>
                        <div class="client-name">– Ryunosuke Satoro</div>
                    </li>
                </ul>
              </div>
              <!-- Insta slider end -->

       </div>
  </section>

</div>  
<style type="text/css">
  .cap_video.hidden { display: none; }
</style>

  <script>

    $(function(){
        
        window.parent.document.getElementById( 'myIframe' ).classList.add( 'awaiting-screen' );

        var minutes = {{ $minutes?$minutes:0 }};
        var seconds = {{ $seconds?$seconds:0 }};

        $mainTotalSecs = parseInt( minutes ) * 60 + parseInt( seconds );
        var mainToggleInterval = false;
        if( $mainTotalSecs <= 5 ) { 
          $('#cdt_mem').addClass( 'blink' );
          // mainToggleInterval = setInterval(function(){ $('#cdt_mem').toggle(); }, 500);
        } else { 
          setTimeout(function(){
            $('#cdt_mem').addClass( 'blink' );
            // mainToggleInterval = setInterval(function(){ $('#cdt_mem').toggle(); }, 500);
          }, ( $mainTotalSecs - 5 ) * 1000 );
        }

        $('.btn.btn-toggle').click(function() {
          var adio = window.parent.document.getElementById( 'save-sound' );
          adio.pause();
          adio.currentTime = 0;
          adio.play();
        })

        $('#countdowntimer').countdowntimer({
            minutes : <?php echo $minutes; ?>,
            seconds : <?php echo $seconds; ?>,
            displayFormat : 'MS',
            timeUp : whenTimesUp,
            size : "lg"
        });

        var secondsforsvg = <?php echo ($minutes*60)+$seconds; ?>;

        $('.timer_mem svg circle').css('animation-duration',secondsforsvg+'s');
        
        function whenTimesUp() {
            $('#cdt_mem').removeClass( 'blink' );
            $('#cdt_mem').show();
            clearInterval( mainToggleInterval );

            $('#abc', window.parent.document).attr('href', "{{ $mainGameUrl }}" );
            $("#abc", window.parent.document)[0].click( );
        }
    });    
  </script>
@stop

