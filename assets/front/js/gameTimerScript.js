var loadFunFacturl = gameVars.loadFunFacturl;
var gameMinuts = gameVars.gameMinuts;
var gameSeconds = gameVars.gameSeconds;
var appurl = gameVars.appurl;
var csrf_token = gameVars.csrf_token;
var encId = gameVars.encId;
var event_id = gameVars.event_id;
var team_id = gameVars.team_id;
var mm_game_url = gameVars.mm_game_url;
var ciurl = gameVars.ciurl;

var formurl = appurl + '/gamescreensave';

function blink(selector){
  $(selector).fadeOut('slow', function(){
      $(this).fadeIn('slow', function(){
          blink(this);
      });
  });
}

function showGameOverMsg( ) {
  // swal({
  //     title: "Thank you for playing the Ice Breaker",
  //     text: "We hope you enjoyed and learned something new about your team.",
  //     type: "",
  //     buttons: false,
  //     timer: 5000
  //   },
  //   function(){ 
        
  //     updateIBgameStatus(event_id, team_id);
  //     swal.close();

  //   });  
  /*Ajax call get Result screen data starts here*/
  $.ajax({
    type: "POST",
    url: appurl + '/getintorresult',
    data: { "_token": csrf_token, 'event_id': event_id, "team_id" : team_id },
    success: function (result) {
      $("#result_screen_model").html(result);
    }
  });
  /*Ajax call get Result screen data ends here*/
  setTimeout(function() {
    $('#modal-result').modal('show');
  }, 500);

  setTimeout(function() {
      setCookie(  'ibgs_' + eventId + '--' + team_id + '--' + user_id, true, 10 );
      updateIBgameStatus(event_id, team_id);
      $("button[data-dismiss]").click()
  }, 10500);
}

$(document).ready(function () {

  if( !window.parent.document.getElementById( 'audio' ).paused ) { 
    $( 'a.play-icon' ).attr( 'title', 'Click here to pause audio' );
    $( 'a.play-icon' ).removeClass( 'paused' ).addClass( 'playing' );
    $( 'a.play-icon' ).find( '.fa-play' ).removeClass( 'fa-play' ).addClass( 'fa-pause' );
  }

  //load questions on screen.
  loadFunFact();
  //front check method
  formChechFunFact();
  //form submission and fetch next Fun Fact
  // $("#submitForm").click(function (event) {
    $("#submitForm").click(function (event) {
    event.preventDefault();

    var valueof = this.value;
    if (valueof == 1) {
      var selections = $('input[name="selected_option_userids[]"]:checked').length;
      if (selections >= 1) {
        window.parent.document.getElementById( 'save-sound' ).pause();
        window.parent.document.getElementById( 'save-sound' ).currentTime = 0;
        window.parent.document.getElementById( 'save-sound' ).play();
        $.ajax({
          type: "POST",
          url: formurl,
          data: $("#gameform").serialize(),
          success: function (result) {
            if ($('#lastq').val() == 1) {
              $('#submitForm').html('Finish');
              $('#submitForm').val(3);
            } else {
              $('#submitForm').html('Next');
              $('#submitForm').val(2);
              $('#submitForm').hide();
              $('.user_options').prop("disabled", true);
            }
          }
        });
      } else {
        swal("Alert!", 'Please choose your answer.', "warning");
      }
    } else {
      if (valueof == 2) {
        loadFunFact();
      } else {
        showGameOverMsg();
      }
    }

  });
});

//Timer for game starts here..
$(function () {


  $mainTotalSecs = parseInt(gameMinuts) * 60 + parseInt(gameSeconds);
  var mainToggleInterval = false;

  $('#countdowntimer').countdowntimer({
    minutes: parseInt(gameMinuts),
    seconds: parseInt(gameSeconds),
    displayFormat: "MS",
    timeUp: whenTimesUp,
    size: "lg"
  });
  function whenTimesUp() {
      clearInterval( mainToggleInterval );
      showGameOverMsg( );
  }
});
//Timer for game ends here.

//Load question/Funfact and start question timer
function loadFunFact() {
  $.ajax({
    url: loadFunFacturl,
    success: function (result) {
      let obj = JSON.parse(result);
      if (obj.gameminutes != 'x' || obj.gameseconds != 'x') {
        $("#getData").html(obj.html);
        $('#submitForm').html('Submit');
        $('#submitForm').val(1);
        $('#submitForm').show();
        $( '#quiz_timing' ).addClass( 'qq__' + obj.funfactId );
        questionTimer(obj.gameminutes, obj.gameseconds, obj.funfactId);
      } else {
        showGameOverMsg();
      }
    }
  });
}

//Load answer screen as per current funfact Id and start answer screen timer here..
function getAnswerScreen() {

  var funfactId = $('input[name="funfactId"]').val();
  var selection = $('input[name="selected_option_userids[]"]:checked').val();
  $.ajax({
    type: "POST",
    url: appurl + "/getanswerdata",
    data: { "_token": csrf_token, 'funfactId': funfactId, 'selection' : selection, 'user_id' : user_id },
    success: function (result) {
      let obj = JSON.parse(result);
      if (result) {
        $("#getData").html(obj.html);

        $( '#quiz_timing' ).removeAttr( 'class' );
        $( '#quiz_timing' ).addClass( 'qa__' + obj.funfactId );

        answerTimer(obj.ansminuts, obj.anssecounds);
        if ($('#lastq').val() == 1) {
          $('#submitForm').html('Finish');
          $('#submitForm').val(3);
        } else {
          $('#submitForm').val(2);
          $('#submitForm').hide();
        }
      } else {
        showGameOverMsg();
      }
    }
  });
}

function reset($seconds){
  $('#g_id').remove();
  $('#quiz_timing svg').html('<g id="g_id"><title>Layer 1</title><circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"  style="animation-duration: '+$seconds+'s;"/></g>');
}

var tdestroy = function (id) {
  jQuery("#" + id).countdowntimer("pause", "pause");
}

function questionTimer(quesminuts, queseconds, qid) {
  if (queseconds != 'x') {
    $(function () {
      $('.timer2').html('Question Time');

      var $obj = '#quiz_timing.qq__' + qid;

      $('#quiz_timing').css({"visibility": "visible", "opacity": "1"});
      
      $totalSecs = parseInt(quesminuts) * 60 + parseInt(queseconds);
      //reset svg circle processing
      reset($totalSecs);

      if( qtToggleInterval ) {
        clearInterval( qtToggleInterval );
        qtToggleInterval = false;
      }
      if( qtTimeout ) { 
        clearTimeout( qtTimeout );
        qtTimeout = false;
      }
      
      var qtToggleInterval = false;
      var qtTimeout = false;
      $('#quiz_timing').show();

      if( $totalSecs <= 5 ) { 
        $('#quiz_timing').addClass( 'blink' );
      } else { 
        qtTimeout = setTimeout(function(){
          qtToggleInterval = setInterval(function(){ $($obj).addClass( 'blink' ); }, 500);
        }, ( $totalSecs - 5 ) * 1000 );
      }

      $('#quiz_timing #timer').countdowntimer({
        minutes: parseInt(quesminuts),
        seconds: parseInt(queseconds),
        displayFormat: "MS",
        timeUp: whenTimesUpQus
      });

      function whenTimesUpQus() { 

        $('#quiz_timing').removeClass( 'blink' );

        $( '#quiz_timing' ).show();
        if( qtToggleInterval ) clearInterval(qtToggleInterval);
        if( qtTimeout ) clearTimeout(qtTimeout);
        getAnswerScreen();
      }
    });
  } else {
    showGameOverMsg();
  }
}

function answerTimer(ansminuts, anssecounds) {
  tdestroy('quiz_timing #timer');
  if (anssecounds != 'x') {
    $(function () {
      $('.timer2').html('Answer Time');

      $('#quiz_timing').css({"visibility": "hidden", "opacity": "0"});
      
      $('#quiz_timing #timer').countdowntimer({
        minutes: parseInt(ansminuts),
        seconds: parseInt(anssecounds),
        displayFormat: "MS",
        timeUp: whenTimesUpAns
      });

      function whenTimesUpAns() {
        tdestroy('quiz_timing #timer');
        loadFunFact();
      }
    });
  } else {
    showGameOverMsg();
  }
}

function geteventgametime(event_id) {
  $.ajax({
    type: 'POST',
    url: appurl + "/geteventgametime",
    data: { "_token": csrf_token, 'event_id': event_id },
    success: function (result) {
    }
  });
}

function formChechFunFact() {
  $(document).on('click', '.user_options', function (evt) {
    //click sound
    window.parent.document.getElementById( 'save-sound' ).pause();
    window.parent.document.getElementById( 'save-sound' ).currentTime = 0;
    window.parent.document.getElementById( 'save-sound' ).play();

   /* var choosedoptions = $('input[name="selected_option_userids[]"]:checked').length;
    if (choosedoptions > 1) {
      $(this).prop('checked', false);
    }*/

    $('input[name="selected_option_userids[]"]').prop('checked', false);
    $(this).prop('checked', true);
  });
}

function updateIBgameStatus(event_id, team_id) {
  var status = 2;
  $.ajax({
    type: "POST",
    url: appurl + "/update_ib_status",
    data: { "_token": csrf_token, 'event_id': event_id, 'team_id': team_id, 
        'status': status, 'encId' : encId },
    success: function (data) {
      if ( data.result ) {
        //window.location.href = appurl + '/mmrulesscreen/' + encId; // redirect to market madness rules screen when game finished

        $('#abc', window.parent.document).attr( 'href', data.url );
        $("#abc", window.parent.document)[0].click();
      }
    }
  });
}