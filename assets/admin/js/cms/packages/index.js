var listDTObj = false;
(function( $ ){

  $( document ).ready(function(){ 
    eventmanagerTable = listDTObj = list( { 
            listing_url: importantObj.listing_url,
            orderable: { orderable: false, targets: [ 0, 2, 3, 6 ] },
            order:  [ 1, "desc" ],
            /* Row Reorder [ */
            reorder: true, 
            reorder_url: importantObj.update_reorder, 
            idIndex: 7, // primary auto inc id
            orderIndex: 8 // sort order index
            /* ] */
          } );
  });
})( jQuery );