hideChat(0);

$('#prime').click(function() {
  toggleFab();
});

//Toggle chat and links
function toggleFab() {
	$('.prime').toggleClass('zmdi-comment-outline');
	$('.prime').toggleClass('zmdi-close');
	$('.prime').toggleClass('is-active');
	$('#prime').toggleClass('is-float');
	$('.chat').toggleClass('is-visible');
  //remove notifiactions from the chat icon
  $("#prime").find("span").remove();
}

$('#chat_fullscreen_loader').click(function(e) {
      $('.fullscreen').toggleClass('zmdi-window-maximize');
      $('.fullscreen').toggleClass('zmdi-window-restore');
      $('.chat').toggleClass('chat_fullscreen');
      $('.fab').toggleClass('is-hide');
      $('.header_img').toggleClass('change_img');
      $('.img_container').toggleClass('change_img');
      $('.chat_header').toggleClass('chat_header2');
      $('.fab_field').toggleClass('fab_field2');
      $('.chat_converse').toggleClass('chat_converse2');
});

function hideChat(hide) {
    switch (hide) {
      case 0:            
		$('.chat_login').css('display', 'block');
		$('.chat_fullscreen_loader').css('display', 'none');            
        break;      
    }
}

$('.smile_block').click(function(e) {
	$(this).toggleClass('show');
	$('.emojis').slideToggle('slow');   

  if ( $(this).hasClass('show') ) {
    $("#chat_fullscreen").animate("margin-bottom","80px");  
  }else{
    $("#chat_fullscreen").animate("margin-bottom","0px");
  }
});

$(function() {
  $('.tab a').click(function() {

    // Check for active
    $('.tab').removeClass('active');
    $(this).parent().addClass('active');

    // Display active tab
    let currentTab = $(this).attr('href');
    $('.tab-content').hide();
    $(currentTab).show();
    //code to remove notification pop-up from active tab
    var elem = $(".tab2_title");

    if( currentTab == '#tab1'){
      elem = $(".tab1_title");
    }
    elem.find("span").remove();
    //got to the lst message on screen
    const messages = document.getElementById('chat_fullscreen');
    messages.scrollTop = messages.scrollHeight;
    
    return false;
  });
});

//submit a chat message
$('#fab_send').click(function() {
  //chat message
  var message = $('#chat_message').val().trim();
  message = message.replace("\n", "<br/>");
  if( message ){
    var room = $('div.chat_tab').find('div.active').data('room');
    var enc_id  =  $('#enc_id').val();
    var chat_url  =  $('#chat_url').val();
    var csrf_token  =  $('#csrf_token').val();
    document.getElementById("chat_message").value = "";

    $.ajax({
      type: 'POST',
      url: chat_url+"/sendmessage",
      data: {
        "_token": csrf_token, 
        'message': message,
        'chat_box':room,
        'enc_id' : enc_id
      },
      success: function( response ) {
        var obj = JSON.parse( response );
        var $html = '<div class="chat_msg_item chat_msg_item_user"><div class="chat_msg">'+obj.message+'</div></div>';
        //default team tabe
        var $mytab = '#tab1';
        if( room == 2 ){
          //event group message
          var $mytab = '#tab2';
        }
        
        $($mytab).append($html);
        //message focus on the last sent message
        const messages = document.getElementById('chat_fullscreen');
        messages.scrollTop = messages.scrollHeight;
      }
    });
  }
});

//emojis section js starts here..

$(document).on('click', '.emj', function() {
  var imgalt = $(this).find('img').attr('alt');
  var ecode = '&#'+$(this).data('ecode');
  insertMessage('chat_message', imgalt);
} );

/*
  * Method to add message to textarea on active cursor
*/
function insertMessage(areaId, text) {
  var txtarea = document.getElementById(areaId);
  if (!txtarea) {
    return;
  }

  var scrollPos = txtarea.scrollTop;
  var strPos = 0;
  var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
    "ff" : (document.selection ? "ie" : false));
  if (br == "ie") {
    txtarea.focus();
    var range = document.selection.createRange();
    range.moveStart('character', -txtarea.value.length);
    strPos = range.text.length;
  } else if (br == "ff") {
    strPos = txtarea.selectionStart;
  }

  var front = (txtarea.value).substring(0, strPos);
  var back = (txtarea.value).substring(strPos, txtarea.value.length);
  txtarea.value = front + text + back;
  strPos = strPos + text.length;
  if (br == "ie") {
    txtarea.focus();
    var ieRange = document.selection.createRange();
    ieRange.moveStart('character', -txtarea.value.length);
    ieRange.moveStart('character', strPos);
    ieRange.moveEnd('character', 0);
    ieRange.select();
  } else if (br == "ff") {
    txtarea.selectionStart = strPos;
    txtarea.selectionEnd = strPos;
    txtarea.focus();
  }

  txtarea.scrollTop = scrollPos;
}
//emojis section js ends here..


$(document).on('click', '.close_note', function() {
    $('.note').remove();
});

function getCaret(el) { 
    if (el.selectionStart) { 
        return el.selectionStart; 
    } else if (document.selection) { 
        el.focus();
        var r = document.selection.createRange(); 
        if (r == null) { 
            return 0;
        }
        var re = el.createTextRange(), rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);
        return rc.text.length;
    }  
    return 0; 
}

//on enter send message
$("#chat_message").keyup(function(event) {
    if (event.keyCode === 13) { 

      var content = this.value;  
      var caret = getCaret(this);
      
      if (event.shiftKey) {
        this.value = content.substring(0, caret - 1) + "\n" + content.substring(caret, content.length);
      }else{
        $("#fab_send").click();
      }
    }
});