(function( $ ){
    // Initiate the wowjs animation library
  $('.access-to-security-cam').on('click',function(){
      if ( $('.access-to-security-cam').attr('data-bit') != 1 ) {
        $('.access-to-security-cam').attr('data-bit',1);
        timerModel ( 'Accessing security camera pics..', 10, 1 );
      }else{
        window.location = $('.access-to-security-cam').attr('data-url');
      }
      
  });

  $('.secret_photos').on('click',function(){
    modelGlovesFound('', 'While searching the secret corridor, we found 3 fingerprints.','secret_fingerprint.png', false);
  });
  
})( jQuery );