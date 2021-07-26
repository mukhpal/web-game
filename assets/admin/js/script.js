$(document).ready(function() {

    $.fn.exists = function() { return this.length > 0; };


    $("#login_frm").validate({
      rules: {
         email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         },
         password: {required:true, minlength: 6}
        },
        messages: {
	    	email:{
	    		required: 'Please enter email',
	    		email: 'Please enter a valid email',
	    		maxlength: 'Email can not be greater than {0} characters'
	    	},
	    	password: {
	    		required: 'Please enter password',
	    		minlength: "Please enter at least {0} characters"	
	    	}
	    },
	    submitHandler: function(form) {
   		  form.submit();
	    }
   
   });

    $(".forget-form").validate({
      rules: {
        forgot_email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         }
       },
        messages: {
	    	forgot_email:{
	    		required: 'Please enter email',
	    		email: 'Please enter a valid email',
	    		maxlength: 'Email can not be greater than {0} characters'
	    	}
	    },
	 submitHandler: function(form) {
   		form.submit();
	 }
   
   });

  /*** Alphanumeric characters only **/  
  jQuery.validator.addMethod("alphanumericonly", function(value, element) {
   return this.optional(element) || /^[0-9a-zA-Z\s]+$/i.test(value);
  }, ""); 

  /*** Integer values only **/  
  jQuery.validator.addMethod("integeronly", function(value, element) {
   return this.optional(element) || /^[0-9\s]+$/i.test(value);
  }, ""); 
    
    $("#add_eventmanager_frm, #edit_eventmanager_frm").validate({
      rules: {
         companyname: {
              required: {
                depends:function(){
                    if ( $.trim($(this).val()) ) {
                      $(this).val($(this).val().replace(/  +/g, ' ') );
                    }else{
                      $(this).val($.trim($(this).val()));
                    }
                    return true;
                }
              }, 
              alphanumericonly: true,
              maxlength: 100,
              minlength: 3
          },
         fullname: {
              required: {
                depends:function(){
                    if ( $.trim($(this).val()) ) {
                      $(this).val($(this).val().replace(/  +/g, ' ') );
                    }else{
                      $(this).val($.trim($(this).val()));
                    }
                    return true;
                }
              }, 
              alphanumericonly: true,
              maxlength: 100,
              minlength: 3
         },
         email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 100,
         },
         password: {
           required: function(element) {
              if($("#eventmanager_id").exists() && $("#eventmanager_id").val().length > 0) {
                  return false;
              } else {
                  return true;
              }
          }, 
          minlength: 6 },
          gender: { required: true }
        },
        messages: {
          companyname: {required: "Please enter company name", alphanumericonly: "Enter only alphanumeric values", maxlength: 'Company name can not be greater than {0} characters',minlength: "Please enter at least {0} characters"},
          fullname: {required: "Please enter full name", alphanumericonly: "Enter only alphanumeric values", maxlength: 'Full name can not be greater than {0} characters',minlength: "Please enter at least {0} characters"},
          email:{
          required: 'Please enter email',
          email: 'Please enter a valid email',
          maxlength: 'Email can not be greater than {0} characters'
        },
        password: {
          required: 'Please enter password',
          minlength: "Please enter at least {0} characters" 
        },
        gender : 'Please select gender type'
      },
      submitHandler: function(form) {
        form.submit();
      }
   
    }); 


   $("#add_user_frm, #edit_user_frm").validate({
      rules: {
      	 fullname: {
              required: {
                depends:function(){
                    if ( $.trim($(this).val()) ) {
                      $(this).val($(this).val().replace(/  +/g, ' ') );
                    }else{
                      $(this).val($.trim($(this).val()));
                    }
                    return true;
                }
              }, 
              alphanumericonly: true,
              maxlength:100
         },
         email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         }
        },
        messages: {
        	fullname: {required: "Please enter full name", alphanumericonly: "Enter only alphanumeric values", maxlength: 'Full name can not be greater than {0} characters'},
        	email:{
	    		required: 'Please enter email',
	    		email: 'Please enter a valid email',
	    		maxlength: 'Email can not be greater than {0} characters'
	    	}
	    },
	    submitHandler: function(form) {
   		  form.submit();
	    }
   
   }); 

   $("#profile_update_frm").validate({
        rules: {
          fullname: {
              required: {
                depends:function(){
                    if ( $.trim($(this).val()) ) {
                      $(this).val($(this).val().replace(/  +/g, ' ') );
                    }else{
                      $(this).val($.trim($(this).val()));
                    }
                    return true;
                }
              }, 
              alphanumericonly: true,
              maxlength: 100,
              minlength: 3
          },
          email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         }
        },
        messages: {
          fullname: {required: "Please enter full name", alphanumericonly: "Enter only alphanumeric values", maxlength: 'Full name can not be greater than {0} characters', minlength: "Please enter at least {0} characters"},
          email:{
          required: 'Please enter email',
          email: 'Please enter a valid email',
          maxlength: 'Email can not be greater than {0} characters'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
   
   });

   $("#update_password_frm").validate({
      rules: {
         old_password: {required:true, minlength: 6},
         password: {required:true, minlength: 6},
         cpassword: {required:true, minlength: 6, equalTo: "#password"}
        },
        messages: {
          old_password: {
            required: 'Please enter current password',
            minlength: "Please enter at least {0} characters"
          },
          password: {
            required: 'Please enter new password',
            minlength: "Please enter at least {0} characters" 
          },
          cpassword: {
            required: 'Please enter confirm password',
            minlength: "Please enter at least {0} characters",
            equalTo: "Please enter confirm password same as password"

          }
      },
      submitHandler: function(form) {
        form.submit();
      }
   
   });


   $("#game_settings").validate({
      rules: {
         gametime: {
            required: {
              depends:function(){
                  $(this).val($.trim($(this).val()));
                  return true;
              }
            }, 
            integeronly: true
         },
         awaintingscreentime: {
            required: {
              depends:function(){
                  $(this).val($.trim($(this).val()));
                  return true;
              }
            }, 
            integeronly: true
        }
        },
        messages: {
          gametime: {required: "Please enter game time", integeronly: "Enter only numeric values"},
          awaintingscreentime: {required: "Please enter waiting time", integeronly: "Enter only numeric values"},
        },
        submitHandler: function(form) {
          form.submit();
        }   
   }); 

   //game_settings 
   var decimalCount = 0;
    //edit_game_frm js
      $("#edit_game_frm input[type=number]").keypress(function(evt)
      {
        $value = $("#edit_game_frm input[type=number]").val();
        if($value == ""){
          decimalCount = 0;
        }
        if($value.length > 5){
          return false;
        }
        if (evt.which === 46) {
         // Allow only 1 decimal point
         decimalCount++;
         if(decimalCount == 1){
          return true;
         }else{
          return false;
         }
        }

        if (evt.which != 8 && evt.which != 0 && evt.which < 46 || evt.which > 57)
        {
            evt.preventDefault();
        }
      });

      $("#game_settings input").keypress(function(evt){
        if (evt.which != 8 && evt.which != 0 && evt.which < 46 || evt.which > 57)
        {
            evt.preventDefault();
        }
      });

});

function activeInactiveState(affected_id, status){
   
    let affected_data_model = $("#data_model").val(); 
    let setActiveInactiveUrl = $("#setActiveInactiveUrl").attr('url');
    let token = $('input[name="_token"]').val();
    // let token = "{{ csrf_token() }}";

    swal({
    title: "Are you sure you want to perform this action?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, update it!"
    }, function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type:'POST',
          url: setActiveInactiveUrl,
          data: {"_token": token, "affected_id":affected_id,"status": status, "affected_data_model":affected_data_model, "activeinactive":1},
          success:function(data){
            let obj = JSON.parse(data);
            if(obj.code==200){
              eventmanagerTable.ajax.reload(); eventTable.ajax.reload();

              setTimeout(function(){ 
                swal("Done!", obj.message, "success"); 
              }, 100);
              
            }else{
              setTimeout(function(){ 
                swal("Error Occured!",obj.message, "error");
              }, 250);
              
            }
          }

        });
      }

    });


}
