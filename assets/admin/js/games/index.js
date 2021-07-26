var eventTable = false;
(function( $ ){
  $( document ).ready(function(){ 
    eventTable = list( { listing_url: gameDataObj.listing_url, orderable: gameDataObj.orderable, order: gameDataObj.order } );
  });
})( jQuery );