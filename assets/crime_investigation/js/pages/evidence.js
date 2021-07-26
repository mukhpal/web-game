(function( $ ){
	if( $('.notification').children('.badge').length == 0 )
    {
    	$('.notification').children('.badge').remove();
    }
    // cating old thief method
    $( ".catch_theif" ).on( "click", function() {
    	// $.ajax({
     //        type: "POST",
     //        url: $(".ts_url").data('url'),
     //        data: { _token: $("input[name=_token]").val(), user_id:$("input[name=user_id]").val(), event_id:$("input[name=event_id]").val(), team_id:$("input[name=team_id]").val() },
     //        success: function (result) {
     //            if(result.status == 1){
                    timerModel ( 'Trying to locate the old thief.........', 10, 5 );
                    setTimeout(function(){
                        // var URL = $('.oldimg').attr('src');
                        // URL = URL.substring(0, URL.lastIndexOf("/") + 1) + 'bad_luck.png';
                        // var html = '<img src="'+URL+'" alt="" class="img-fluid" />';
                        // $("a.thief").replaceWith( html );
                        badluckmodel( 'The old thief could not be located.' );
                    }, 9000);

                // }else{
                //     badluckmodel( result.msg );
                // }
        //     }
        // });
	});
    

    // Searching mansion
    $( ".search_mansion" ).on( "click", function() {
    	$.ajax({
            type: "POST",
            url: $(".ms_url").data('url'),
            data: { _token: $("input[name=token_rf]").val(), user_id:$("input[name=user_id]").val(), event_id:$("input[name=event_id]").val(), team_id:$("input[name=team_id]").val() },

            success: function (result) {
                if(result.status == 1){
                    timerModel ( 'Searching mansion.........', 10, 6 );
                    setTimeout(function(){
                        addNotiMenu('mansion');
                        var URL = $(".m_url").data('url');
                        // URL = URL.substring(0, URL.lastIndexOf("/") + 1) + 'mansion';
                        var html = '<a href="'+URL+'" class="contact_btn">View <br/>Details </a>';
                        $("a.search_mansion").replaceWith( html );
                        goodjobmodel( result.msg );
                    }, 9000);

                }else{
                    badluckmodel( result.msg );
                }
            }
        });
	});

    $('.lamp').on( "click", function() {
        modelGlovesFound('Congratulations!'," Paint used on the mansions sconces matches with the stains found on the Professor's gloves", 'evidence.png');
    });

})( jQuery );