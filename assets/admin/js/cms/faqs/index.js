var listDTObj = false;
(function( $ ){

  $( document ).ready(function(){ 
    listDTObj = list( { 
            listing_url: importantObj.listing_url,
            orderable: { orderable: false, targets: [ 0, 3 ] },
            order:  [ 1, "desc" ],
            /* Row Reorder [ */
            reorder: true, 
            reorder_url: importantObj.update_reorder, 
            idIndex: 4, // primary auto inc id
            orderIndex: 5 // sort order index
            /* ] */
          } );
  });
})( jQuery );