(function( $ ){
	markApproved = function ( $id, $currentObj ) { 
        if( $( $currentObj ).hasClass( 'running' ) ) { 
            return false;
        }

        $.ajax({
            url     : importantObj.approved_url,
            type    : 'POST',
            data    : { id: $id },
            dataType: 'json',
            error:  function ( xhr, status, error ) { 
                $( $currentObj ).removeClass( 'running' );
                swal( 'Error!', 'Unable to approve, please try again later.', 'error' );
            },
            success : function ( json ) { 
                $( $currentObj ).removeClass( 'running' );
                if( json.status == 0 ){ 
                    swal( 'Error!', json.msg, 'error' );
                } else { 
                    swal( 'Approved!', json.msg, 'success' );
                    if( eventmanagerTable  ) { 
                        eventmanagerTable.draw();
                    }
                }
            }
        });
	};
})( $ );
