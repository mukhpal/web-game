(function ($) {

  "use strict";
  // alert( $('#abc', window.parent.document).attr( 'href') );
  // $('.cap_video', window.parent.document).removeClass('cap_video');
  // alert('dresgsred');
})(jQuery);



$(window).on('load', function(){
  var gameMinutes = CIVars.gameMinutes;
  var gameSeconds = CIVars.gameSeconds;
  var hintMinutes = CIVars.hintMinutes;
  var hintSeconds = CIVars.hintSeconds;
  var waitingOn   = CIVars.waitingOn;
  //Timer for CI game starts here..
  // console.log('waitingOn : '+waitingOn);
  if( waitingOn != "1" ) {
    gameTimerInt ( gameMinutes, gameSeconds );
    hintTimer ( hintMinutes, hintSeconds, $("input[name=encId]").val() );
  }
  
  // console.log(gameSeconds);
  //Timer for CI game ends here.
  
});

  var gorl        = $("input[name=gorl]").val();
  var encId       = $("input[name=encId]").val();
  var token       = $("input[name=token_rf]").val();

new WOW().init();

function lightbox(idx) {
  //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
  var ninjaSldr = document.getElementById("ninja-slider");
  ninjaSldr.parentNode.style.display = "block";

  nslider.init(idx);

  var fsBtn = document.getElementById("fsBtn");
  fsBtn.click();
}

function fsIconClick(isFullscreen, ninjaSldr) { //fsIconClick is the default event handler of the fullscreen button
  if (isFullscreen) {
      ninjaSldr.parentNode.style.display = "none";
  }
}

  function alert(message){
    $.alert({
        title: 'Alert!',
        content: message,
    });
  }

  function addNotiMenu (page = false){
    if(page == false){
      page = 'evidence';
    }
    var selector = '.'+page;
    var htm = '<span class="badge">1</span>';
    if( $(''+selector+' .notification').children('.badge').length == 0 )
    {
      $(''+selector+' .notification').append('<span class="badge">1</span>');
    }else{
      var count = parseInt( $(''+selector+' .notification').children('.badge').html() ) + 1;
      $(''+selector+' .notification').children('.badge').html( count );
    }
  }

    function goodjobmodel ( message ){
        $('.good_job_msg').html( message );
        $('#good_job').modal('show');
    }

    function badluckmodel ( message ){
        $('.bad_luck_msg').html( message );
        $('#bad_luck').modal('show');
    }

    function timerModel ( title, timer, bit = 2 ){
        $('.timer_msg').html( title );
        $('.getting_fingerprint').modal('show');
        timerJob ( timer, bit );
    }

    function modelActuallyHappened (){
        $('#actually_happened').modal('show');
    }

    function timerJob ( seconds, bit ){
      var $totalsec = parseInt(seconds);
      var mainToggleInterval = false;
      $('.main_screen').addClass('disable_bg');
      $('#timer_val').countdowntimer({
        seconds: parseInt(seconds),
        displayFormat: "S",
        timeUp: whenTimesUp,
        size: "lg"
      });

      function whenTimesUp() {
        $('.main_screen').removeClass('disable_bg');
      // clearInterval( mainToggleInterval );
      if( bit == 1){
        //security camra pics case
        window.location = $('.access-to-security-cam').attr('data-url');
      }else {
        //case upto 2 to 8 bit values
      }
      //close model
      $('.getting_fingerprint').modal('hide');
      }
    }

    function modelGlovesFound (title, msg, img = false, background = true){
      if(img == false){
        img = 'gloves.png';
      }

      if(background == true){
        $('.evidence_detail').removeClass('no_background');
      }else{
        $('.evidence_detail').addClass('no_background');
      }

      $('.search_house_msg').html(msg);
      $('.search_house_title').html(title);
      //image setup gloves_img
      var src = $('.gloves_img').attr('src');
      src = src.substring(0, src.lastIndexOf("/") + 1) + img;
      $('.gloves_img').attr('src', src );
      $('#found_gloves').modal('toggle');
    }

    function fingerprintModel (){
      var img = $('.fingre_print_img img').attr('src');
      img = img.substring(0, img.lastIndexOf(".")) + '_full.jpg';
      $('.fngr_img').attr('src', img);
      $('#prnt_fingr').modal('show');
    }

    $(document).ready(function() {
      (function($) {
        $(".header-icon").click(function(e) {
          e.preventDefault();
          $("body").toggleClass("toggle_navigation");
        });
      })(jQuery);
    });


    //Remove text:: Ninja Slider trial version 
    (function($){
      $.fn.extend({
      removeByContent: function(str) {
      return this.each(function(){
      var self = $(this);
      
      if(self.html().indexOf(str) != -1) self.remove();
      
      });
      }
      });
    })(jQuery);
      
      // your script
      $('.book_cover').removeByContent('Ninja Slider trial version');

      function ciGameOverPop (teamname, html){
            $('.case_unsolved_teamname').html( teamname );
            $('.case_unsolved_team_members').html( html );
            $('#unsolved_case').modal('show');
      }
      
      function ciGameOver (){

        var gorl        = $("input[name=gorl]").val();
        var encId       = $("input[name=encId]").val();
        var token       = $("input[name=token_rf]").val();
        
        $.ajax({
          type: "POST",
          url: gorl,
          data: { encId : encId, _token: token },
          success: function (result) {
            $('.case_unsolved_teamname').html( result.teamname );
            $('.case_unsolved_team_members').html( result.html );
            $('#unsolved_case').modal('toggle');
          }
        });
      }

    // overview page/question answer methods starts here

    function CiCaseSolved ( teamname, html){
      $('.case_solved_teamname').html( teamname );
      $('.case_solved_team_members').html( html );
      $('#case_solved').modal('show');
      window.parent.document.getElementById( 'cheers-sound' ).pause();
      window.parent.document.getElementById( 'cheers-sound' ).currentTime = 0;
      window.parent.document.getElementById("cheers-sound").volume = 0.2;
      window.parent.document.getElementById( 'cheers-sound' ).play();

      setTimeout(function() {
        window.parent.document.getElementById( 'cheers-sound' ).pause();
      }, 5000);
    }

    function CiIncorrectAns (){
      $('#incorrect_ans').modal('show');
    }

    function resetLifes ( lifes ){

      var src		= 	$('.life_screen').data('src');
      var imgred = '<img src="'+src+ '/heart.svg" class="img-fluid remaining_life" width="18px">';
      var imgblk = '<img src="'+src+ '/heart_black.svg" class="img-fluid used_life" width="18px">';
      var html 	=	imgblk + imgblk + imgblk;
      
      if( lifes == 5 ){
        html 	=	imgred + imgred + imgred + imgred + imgred;
      }else if ( lifes == 4 ){
        html 	=	imgblk + imgred + imgred + imgred + imgred;
      }else if ( lifes == 3 ){
        html 	=	imgblk + imgblk + imgred + imgred + imgred;
      }else if ( lifes == 2 ){
        html 	=	imgblk + imgblk + imgblk + imgred + imgred;
      }else if ( lifes == 1 ){
        html 	=	imgblk + imgblk + imgblk + imgblk + imgred;
      }
      html = '<div class="remaining_lives">'+html+'</div>';
      $('.life_screen').html( html );
      $('.popupLifes').html( html );
    }

    function resetUnlock (unlock){
      if(unlock == 1){
        $("#question2 select").attr("disabled", "disabled").off('click');
        $("#question2").addClass("disabledbutton blur");
        $("#question2").removeClass("activeQus");
        $("#question3").removeClass("activeQus");
        $("#question3 select").attr("disabled", "disabled").off('click');
        $("#question3").addClass("disabledbutton blur");
        $("#question1 select").removeAttr("disabled");
        $("#question1").removeClass("disabledbutton");
        $("#question1").addClass("activeQus");
      }
      if(unlock == 2){
        $("#question1 select").attr("disabled", "disabled").off('click');
        $("#question1").addClass("disabledbutton");
        $("#question1").removeClass("activeQus");
        $("#question3").removeClass("activeQus");
        $("#question3 select").attr("disabled", "disabled").off('click');
        $("#question3").addClass("disabledbutton blur");
        $("#question2 select").removeAttr("disabled");
        $(".ans2").find("button.disabled").removeClass("disabled");
        $("#question2").removeClass("disabledbutton blur");
        $("#question2 select").addClass("multi");
        $("#question2").addClass("activeQus");
      
      }
      if(unlock == 3){
        $("#question1 select").attr("disabled", "disabled").off('click');
        $("#question1").addClass("disabledbutton");
        $("#question1").removeClass("activeQus");
        $("#question2").removeClass("activeQus");
        $("#question2 select").attr("disabled", "disabled").off('click');
        $("#question2").addClass("disabledbutton");
        $("#question3 select").removeAttr("disabled");	
        $(".ans3").find("button.disabled").removeClass("disabled");
        $("#question3").removeClass("disabledbutton blur");
        $("#question3 select").addClass("multi");
        $("#question3").addClass("activeQus");
      }
      if(unlock == 4){
        $("#question1 select").attr("disabled", "disabled").off('click');
        $("#question1").addClass("disabledbutton");
        $("#question1").removeClass("activeQus");
  
        $("#question2 select").attr("disabled", "disabled").off('click');
        $("#question2").addClass("disabledbutton");
        $("#question2").removeClass("activeQus");
  
        $("#question3 select").attr("disabled", "disabled").off('click');
        $("#question3").addClass("disabledbutton");
        $("#question3").removeClass("activeQus");
  
        $(".submit_btn").addClass("disabledbutton");
      }
    }

    function unlockById ( unlock ){
      $('#unlock').val(unlock);
    }
    // overview page/question answer methods ends here

    // General methods starts here

    function gameTimerInt ( minuts, seconds){
      var gamemainToggleInterval = false;
      
      $('#countdowntimer').countdowntimer({
        minutes: parseInt(minuts),
        seconds: parseInt(seconds),
        displayFormat: "MS",
        timeUp: whenTimesUp,
        size: "lg"
      });
      function whenTimesUp() {
          clearInterval( gamemainToggleInterval );
          ciGameOver( );
      }
    }

    function unlockhint( encId ){
      //unlock hint for the current unanswered question
      $.ajax({
        type: "POST",
        url: $("input[name=hint_lru]").val(),
        data: { encId : $("input[name=encId]").val(), _token: $("input[name=token_rf]").val() },
        success: function (result) {
          if( result.result == 1 ){
            //new code for hint case
            var htm = '<div class="hint_view"><a href="javascript:void(0)" class="contact_btn" data-target="#clue_block'+result.ques+'" data-toggle="modal">!</a></div>';
            //add html
            $(".hint"+result.ques+"").html( htm );

          }
        }
      });
    }

    function hintTimer ( minuts, seconds, encId)
    {
      var hintmainToggleInterval = false;
      $('.div_timer').html('');
      $('.div_timer').html('<span id="hintTimer'+$('.activeQus').attr('id')+'" style="display:none"></span>');

      $('#hintTimer'+$('.activeQus').attr('id')).countdowntimer({
        minutes: parseInt(minuts),
        seconds: parseInt(seconds),
        displayFormat: "MS",
        timeUp: whenTimesUp,
        size: "lg"
      });
      function whenTimesUp( ) {
        $('.div_timer').html('');
        clearInterval( hintmainToggleInterval );
        unlockhint( encId );
      }
    }

      $(function(){ 
        // redirection to feedback page after case solved pop up
        $('#case_solved').on('hidden.bs.modal', function () {
          window.parent.document.getElementById( 'cheers-sound' ).pause();
          if(!$('#actually_happened').hasClass('show')){
            moveTofeedback();
          }
        });
        
        $('#unsolved_case').on('hidden.bs.modal', function () {
            
          if(!$('#actually_happened').hasClass('show')){
            moveTofeedback();
          }
        });
        
        $('#actually_happened').on('hidden.bs.modal', function () {
          moveTofeedback();
        });
      });

      function moveTofeedback(){
        moveTothanksPage ();
      }

      function moveTothanksPage (){
        window.location.href = $("input[name=thanks]").val();
      }

      function moveToCiGame (){
        window.location.href = $("#nextPage").attr('href');
      }
    // General methods ends here