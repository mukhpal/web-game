(function( $ ){
    
    /*** Alphanumeric characters only **/  
    $.validator.addMethod("alphanumericonly", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z\s]+$/i.test(value);
    }, ""); 
    
    /*** Integer values only **/  
    $.validator.addMethod("integeronly", function(value, element) {
        return this.optional(element) || /^[0-9\s]+$/i.test(value);
    }, ""); 

    $( document ).ready(function(){
        $("#send_request").validate({
            rules: {
                name: {
                    required: true,
                    alphanumericonly: true,
                    maxlength: 100,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                comment: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        }); 

        if( moveToAlert && $( '.alert' ).length > 0 ) { 
            $( window ).scrollTop( $( '.alert' ).eq( 0 ).offset( ).top-50 );
        }
    });
})( jQuery );