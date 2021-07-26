(function( $ ){
    $( document ).ready(function(){ 
        $("#edit_package_frm").validate({
            rules: {
                name: {
                    required: true,
                    lettersonly: true,
                    maxlength: 100,
                    minlength: 3
                },
                price: {
                    required: true,
                    dollarsscents:true
                },
                durations: {
                    required: true
                },
                status: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
})( jQuery );