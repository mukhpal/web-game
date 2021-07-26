<style type="text/css">
  body {margin: 0;}
</style>

<!-- CSS added for insta slider -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/red5/css/red5-custom.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/eventstart.css') }}" />



<script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script src="{{ asset('assets/socket/socket.io.js') }}"></script>

<script type="text/javascript">
    var mmurl   = "{{ Config::get("constants.mm_url") . '?enc=' . $encryptedId }}";
    var ciurl   = "{{ route('crimeinvestigation.splash' , $encryptedId ) }}";
    var $joinedUserObj  = false;
    var doMmRedirect    = true;
    var doPublishVideo  = true;
    var bitt = <?php echo $bitt; ?>;
    var mainGameUrl = "{{ $mainGameUrl }}";
    var mainGameKey = "{{ $mainGameKey }}";

    function iframeLoaded( $this, mainGameKey = 'market_madness' ){
      $( $this ).removeClass( 'loading-frame' );
      if( $('#myIframe').contents().find("#joined_users").length <= 0 ) { 
        $( '.video-wraps.joined_member' ).removeClass( 'hidden' );
        
        var iframe = document.getElementById('myIframe');
        var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
        var cont = iframeDocument.getElementById( 'gameCanvas' );
        var cigame = iframeDocument.getElementById( 'crime_investigation' );
        if( cont || cigame ) { 
          iframe.classList.add( 'mmrules-screen' )
          $( '.video-wraps.joined_member' ).addClass( 'mmrulscreen' );
          if( mainGameKey != 'market_madness'){
            $('.cap_video').removeClass('cap_video');
          }
          var $audioObj = document.getElementById( 'audio' );
          var vol = $audioObj.volume;
          var interval = 100;

          var fadeout = setInterval( function( ) { 
            if (vol > 0) {
              $audioObj.volume = vol;
              vol -= 0.2;
            } else { 
              $audioObj.pause();
              clearInterval(fadeout);
            }
          }, interval );
        } else { 
          
          var iframe = document.getElementById('myIframe');
          var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
          var isThankYouScreen = iframeDocument.getElementById( 'thankyou-screen' );
          if( isThankYouScreen ) { 
            $( '.video-wraps.joined_member.mmrulscreen' ).removeClass( 'mmrulscreen' );
          }
          
        }

      }
      getJoinedUsers( mainGameKey );

    }

    function loadIframe(iframeName, url) {
      var $iframe = $('#' + iframeName);
      if ( $iframe.length ) {
          $iframe.attr('src',url);   
          return false;
      }
      return true;
    }
</script>

<audio loop style="display:none;" id="audio" preload="auto">
  <source src="{{ asset('assets/audio/Whistling_Away.wav') }}" type="audio/wav">
  Your browser does not support the audio element.
</audio> 

<audio id="save-sound" preload="auto" style="display:none;">
  <source src="{{ asset('assets/audio/Button.mp3') }}" type="audio/mp3">
  Your browser does not support the audio element.
</audio>

<audio id="cheers-sound" preload="auto" style="display:none;">
  <source src="{{ asset('assets/audio/female_crowd_celebration.mp3') }}" type="audio/mp3">
  Your browser does not support the audio element.
</audio>

<?php //@include( 'front.includes.red5' ) ?>

<div class="video-wraps hidden col-md-12 joined_member text-center <?php if($bitt != 1 ) { echo ' mmrulscreen'; } ?>">
  <div class="members-streaming">
    <ul id="aw_joined_users" class="cab-add"></ul> 
  </div>

</div>

<!-- Notification badge code starts here -->
<div class="toast ml-auto" role="alert" data-delay="700" data-autohide="false">
  <div class="toast-header">
    <strong class="mr-auto text-primary not-title">Notification!! </strong>
    <!-- <small class="text-muted ">Unlocked</small> -->
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="toast-body not-msg"> Wow! New unlock by the team..... </div>
</div>
<!-- Notification badge code ends here -->


<?php if($bitt == 1 ) {?>
  <iframe onload="iframeLoaded( this, mainGameKey );" id="myIframe" class="loading-frame" style="border: 0; width: 100%; height: 100%" src="<?=url('/awaitingscreen/'.$encryptedId)?>"></iframe>
<?php } else { ?>
  <iframe onload="iframeLoaded( this, mainGameKey );" id="myIframe" class="loading-frame mmrules-screen" style="border: 0; width: 100%; height: 100%" src='{{ $mainGameUrl }}'></iframe>
<?php } ?>

@include( 'front.includes.chat' )

<a href="" id="abc" onclick="return loadIframe('myIframe', this.href);"></a>

  <script> 
    var socket = false;
    var runningVS = false;

    /*navigator.permissions.query({name:'camera'}).then(function(permissionStatus) {
      permissionStatus.onchange = function() { 
        if( runningVS ) { 
          if( this.state == 'denied' ) { 
            disableVideoWrap( );
            videoCheck.checked = false;
            console.warn( 'Shutting Down' );
            shutdown( );
          } else if( this.state == 'granted' ) { 
            enableVideoWrap( );
            videoCheck.checked = true;
            console.warn( 'Starting' );
            tried = 1;
            doPublishAuto( 1000 );
          }
        }
      };
    });*/

    function getJoinedUsers( mainGameKey = 'escape_room')
    { 
      $.ajax({
          type:'POST',
          url:'{{ route("front.getjoinedusers") }}',
          data:{"_token": "{{ csrf_token() }}", "user_id":"{{$user_id}}","event_id":"{{$event_id}}"},
          success:function(data){
            
            if( $('#myIframe').hasClass( 'loading-frame' ) ) return false;

            $joinedUserObj = ( $('#myIframe').contents().find("#joined_users").length > 0 )?$('#myIframe').contents().find("#joined_users"):$('#aw_joined_users');

              if( $joinedUserObj.length > 0 ) { 
                $.each(data, function( uIndex, uObj ) { 
                  $nodeObj = $joinedUserObj.find( '#joinuser_' + uObj['id'] );
                  var videoClass = "cap_video";
                  var capimg = '';
                  if( uObj['capsneeded'] == 1 ){
                    capimg = '<img src="{{ asset('assets/front/images/caps/') }}/' + uObj['cap'] + '.png" alt="">';
                  }

                  if( uIndex == 0 ) { 
                    if( $nodeObj.length <= 0 ) { 
                      $joinedUserObj.prepend( '<li class="active" id="joinuser_' + uObj['id'] + '"><figure><!--<button id="join-button" type="button" class="btn btn-xs btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off" value="0"><div class="handle"></div></button> --><div id="video_joinuser_' + uObj['id'] + '" class="hidden vd-wrap"><video id="red5pro-publisher" autoplay muted playsinline></video></div><div id="hide-image" class="ava-img"><img id="dark-camera" src="' + uObj['avatar'] + '" border="0" style="display:inline-block;" /><img id="light-camera" src="' + uObj['avatar'] +'" border="0" style="display:none;"" /></div></figure><div class="'+videoClass+' hidden cap' + uObj['cap'] + '">'+ capimg +' </div><h6>' + uObj['name'] + '</h6></li>' );
                    }
                  } else { 
                    if( $nodeObj.length <= 0 ) { 
                      $joinedUserObj.append( '<li class="' + uObj['disabled'] +'" id="joinuser_' + uObj['id'] + '"><figure><div id="video_joinuser_' + uObj['id'] + '" class="hidden vd-wrap"></div><div class="hide-image ava-img"><img src="' + uObj['avatar'] + '" border="0" style="display:inline-block" /></div></figure><div class="'+videoClass+' hidden cap' + uObj['cap'] + '"> '+ capimg +' </div><h6>' + uObj['name'] + '</h6></li>' );
                    } else { 
                      $nodeObj.removeClass( 'disabled' ).removeClass( 'active' ).addClass( uObj['disabled'] );
                      $nodeObj.find( '.ava-img img' ).attr( 'src', uObj['avatar'] );
                      $nodeObj.find( 'h6' ).text( uObj['name'] );
                    }
                  }
                });
              }
          }
      });
    }
    
    $(function(){ 
          
      var isRedirect = 1;
      var AppUrl = "{{URL('')}}";
      socket = io.connect('{{\Config::get("constants.socket_ip")}}',{transports: ['websocket'], upgrade: false});
      
      socket.emit("eventStart", "{{$channel_id}}");

      socket.on('connect', function () {
        $.ajax({
            type:'POST',
            url:'{{ route("front.userconnectedtosocket") }}',
            data:{"_token": "{{ csrf_token() }}", "team_id":"{{$team_id}}", "user_id":"{{$user_id}}", "socket_id":socket.id, "event_id":"{{$event_id}}"},
            success:function(data){
              getJoinedUsers( mainGameKey );
            }
        });
      })

      socket.on("{{$channel_id}}", function (data) {
        var obj = JSON.parse(data);
        if( obj.bit == 1 ) { 
          document.getElementById('myIframe').contentWindow.getAnswerScreen();
        }

        if( obj.RedirectBit == 2 ) {
          isRedirect = 1;
        }

        if( bitt == 1 || bitt == 3 ) {
          if( obj.mm_redirect == 1 && doMmRedirect ) {
            $.ajax({
                type:'POST',
                url:'{{ route("front.getibstatus") }}',
                data:{"_token": "{{ csrf_token() }}", "team_id":"{{$team_id}}", "event_id": "{{$event_id}}"},
                success:function(data){
                  if( data.status == 1){
                    $('#abc').attr('href', mainGameUrl);

                    $("#abc")[0].click();
                    doMmRedirect = false;
                  }
                }
            });
          } else if( obj.redirectTo == 'crimeinvestigation' && isRedirect == 1){
            $.ajax({
                type:'POST',
                url:'{{ route("front.getibstatus") }}',
                data:{"_token": "{{ csrf_token() }}", "team_id":"{{$team_id}}", "event_id": "{{$event_id}}"},
                success:function(data){
                  if( data.status == 1){
                    isRedirect = 0;

                    if( $( '#myIframe' ).hasClass( 'mmrules-screen' ) && obj.redirectTo == 'crimeinvestigation' ) return false;
                    
                    $('#abc').attr('href', mainGameUrl);
                    $("#abc")[0].click();
                  }
                }
            });
          }else if( obj.totalUserCount > 2 && isRedirect == 1 ) { 
            $.ajax({
                type:'POST',
                url:'{{ route("front.getibstatus") }}',
                data:{"_token": "{{ csrf_token() }}", "team_id":"{{$team_id}}", "event_id": "{{$event_id}}"},
                success:function(data){
                  if( data.status == 1){
                    isRedirect = 0;

                    if( $( '#myIframe' ).hasClass( 'fun-facts' ) && obj.redirectTo == 'funfacts' ) return false;
                    if( $( '#myIframe' ).hasClass( 'game-screen' ) && obj.redirectTo == 'gamescreen' ) return false;
                    if( $( '#myIframe' ).hasClass( 'mmrules-screen' ) && obj.redirectTo == 'mmrulesscreen' ) return false;

                    if( $( '#myIframe' ).hasClass( 'mmrules-screen' ) && obj.redirectTo == 'crimeinvestigation' ) return false;
                    
                    /*$( '.video-wraps.joined_member' ).addClass( 'hidden' );*/
                    if( obj.redirectTo == 'mmrulesscreen' || obj.redirectTo ==  'crimeinvestigation' ) { 
                      $('#abc').attr('href', mainGameUrl);
                      
                    } else if (obj.redirectTo == "gamescreen" ){
                      if(obj.totalUserCount == obj.activeMembers ){
                        $('#abc').attr('href', AppUrl+"/"+obj.redirectTo+"/{{$encryptedId}}");
                        $("#abc")[0].click();
                      }
                    }else{
                      $('#abc').attr('href', AppUrl+"/"+obj.redirectTo+"/{{$encryptedId}}");
                      $("#abc")[0].click();
                    }

                  }
                }
            });
          }
        }
        //check if any chat module message received
        if( obj.chatmessage ){
          //if message isn't from the sender which is me
          if( obj.sender != '{{ $user_id }}' ){
            //new received message HTML
            var $html = '<div class="chat_msg_item chat_msg_item_admin"><div class="chat_top"><div class="chat_avatar"><img src="'+obj.avatar+'" alt=""/></div><span>'+obj.username+'</span></div><div class="chat_msg">'+obj.message+'</div></div>';
            //default team tab
            var $mytab = '#tab1';

            if( obj.chat_box == 2 ){
              //event group message
              var $mytab = '#tab2';
            }
            $($mytab).append($html);

            //notifications
            if( !$( '#prime' ).find( '.is-active' ).length > 0 ) {
              //if chat model is not open than add notification count
              addNotification( '#prime' );
            }

            if( obj.chat_box == 1 ){
              //team chat box check and notification
              if( !$('#tab1_link').parent().hasClass('active') ){
                addNotification('.tab1_title');
              }else{
                 //message focus on the last sent message
                focusOnMsg ('chat_fullscreen');
              }
              
            }else{
              //Event chat box check and notification
              if( !$('#tab2_link').parent().hasClass('active') ){
                addNotification('.tab2_title');
              }else{
                 //message focus on the last sent message
                  focusOnMsg ('chat_fullscreen');
              }
            } 

          }
        }
        //chat message code ended here..

        // Crime investigations socket handling starts here.. 
        if( obj.game == 'crime_investigations' ){
          
          if( obj.user_id != '{{ $user_id }}' ){
            //move to Crime investigations game
            if( obj.action == 'enbleCIGame'){
              document.getElementById('myIframe').contentWindow.moveToCiGame();
            }
            //Answered a question module starts here
            if( obj.action == 'question'){
              // console.log(obj);
              //overview page js starts here
              if(obj.ansbit == 5 || obj.unlock == 4 ){
                //team has answer correctly need to show game over
                if( obj.team_id == '{{$team_id}}' ){
                  var teamnamewithrank = obj.teamname+" ( "+obj.teamrank+" )";
                  document.getElementById('myIframe').contentWindow.CiCaseSolved( teamnamewithrank, obj.html);
                }else{
                  notificationBadge ('Notification!!', ' Team '+obj.teamname+' has solved the case and came on '+obj.teamrank+' position.');
                }

              }else{

                if(obj.lifes == 0){
                  // document.getElementById('myIframe').contentWindow.resetLifes( obj.lifes );
                  //game over
                  document.getElementById('myIframe').contentWindow.ciGameOverPop( obj.teamname, obj.html);
                }else{
                  if(obj.unlock == 3){
                    document.getElementById('myIframe').contentWindow.addNotiMenu();
                  }

                    // if(obj.unlock != $unlock){
                      
                    // }
                    if(obj.ansbit == 1){
                      document.getElementById('myIframe').contentWindow.goodjobmodel(obj.msg);
                      document.getElementById('myIframe').contentWindow.hintTimer ( obj.hintMinutes, obj.hintSeconds, $("input[name=encId]").val() );
                      document.getElementById('myIframe').contentWindow.resetUnlock(obj.unlock);
                      document.getElementById('myIframe').contentWindow.unlockById(obj.unlock);
                    }else if(obj.ansbit == 2){
                      //update life on page
                      document.getElementById('myIframe').contentWindow.CiIncorrectAns();
                      document.getElementById('myIframe').contentWindow.resetLifes( obj.lifes );
                    }else{
                      document.getElementById('myIframe').contentWindow.badluckmodel(obj.msg);
                    }
                  
                }

              }
              //overview page js ends here
              
            }//Answered a question module ends here

            //search house module starts here
            if( obj.action == 'search_house'){
              notificationBadge ('Notification!!', ' Player '+obj.user_name+' searched house of the suspect  '+obj.suspectName);
            }//search house module ends here

            //finger print take module starts here
            if( obj.action == 'take_fingerprints'){
              notificationBadge ('Notification!!', 'Player '+obj.user_name+' took fingerprints of the suspect '+obj.suspectName);
            }//finger print take module ends here

            //Take interview module starts here
            if( obj.action == 'take_interview'){
              notificationBadge ('Notification!!', 'Player '+obj.user_name+' took interview of the suspect '+obj.suspectName);
            }//Take interview module ends here
            
            //search mansion module starts here
            if( obj.action == 'search_mansion'){
              notificationBadge ('Notification!!', 'Player '+obj.user_name+' is searching the mansion again');
            }//search mansion module ends here

            //catch thief module starts here
            if( obj.action == 'catch_theif'){
              notificationBadge ('Notification!!', 'Player '+obj.user_name+' tried catching the old thief');
            }//catch thief module ends here

            //accessed the security camera module starts here
            if( obj.action == 'security_camera'){
              notificationBadge ('Notification!!', 'Player '+obj.user_name+' accessed the security camera.');
            }//accessed the security camera module ends here

            //compare_gloves module starts here
            if( obj.action == 'compare_gloves'){
              notificationBadge ('Notification!!', 'Player '+obj.user_name+' compared the gloves.');
            }//compare_gloves camera module ends here

          }

          if( obj.action == 'enable_hint'){
            notificationBadge ('Congrats!', 'Hint unlocked for the question '+obj.ques +', on the overview page.');
          }

        }// Crime investigations socket handling ends here.. 

        getJoinedUsers( mainGameKey );

      });

      socket.on('disconnectUser', function(data) {
        getJoinedUsers( mainGameKey );
      });

      $(document).on( 'mouseover', "#aw_joined_users li", function () {
        if( $( this ).find( '.btn-toggle' ).length > 0 ) {
          $( this ).find( '.btn-toggle' ).show();
        }
      });
      $(document).on( 'mouseleave', "#aw_joined_users li", function () {
        if( $( this ).find( '.btn-toggle' ).length > 0 ) { 
          $( this ).find( '.btn-toggle' ).hide();
        }
      });
    });

  /* Add notification if chat tab is not active for chat module */
  function addNotification ( selector ){
    var $newCount = parseInt(1);

    if( $(selector).find("span").length > 0 ){
      var $ntCount = $(selector).find("span").html();
      $newCount = parseInt( $ntCount ) + $newCount;
      $(selector).find("span").html($newCount);
    }else{
      $(selector).append('<span class="notifi_bell"> '+ $newCount +' </span>');
    }
    playSound();
  }

  function focusOnMsg (selector){
    const messages = document.getElementById(selector);
    messages.scrollTop = messages.scrollHeight;
  }

  function playSound(){
    //lets play the sound
  }

  // special methods for crime investigations starts here
  function notificationBadge (title, msg){
      $('.not-title').html( title );
      $('.not-msg').html( msg );
      $('.toast').toast('show');

      setTimeout(function(){
        $('.toast').toast('hide');
      }, 5000);
  }

  // special methods for crime investigations ends here


  </script>
  <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.min.js') }}"></script>