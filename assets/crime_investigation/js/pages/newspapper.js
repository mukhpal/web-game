(function( $ ){
	//js to write 
    $('.contact_btn').on('click', function(){
    	timerModel ( 'Contacting museum..........', 10, 7 );
    	setTimeout(function(){
            badluckmodel( 'Nothing important was found' );
        }, 9000);
    });
})( jQuery );

	