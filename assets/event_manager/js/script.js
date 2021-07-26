$(document).ready(function() {

    $.fn.exists = function() { return this.length > 0; };

    if (typeof minTeamsForEvent === 'undefined' || minTeamsForEvent == null ){
      minTeamsForEvent = 2;
    }

    if (typeof min_team_size === 'undefined' || min_team_size == null ){
      min_team_size = 3;
    }

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

   jQuery.validator.addMethod("lettersonly", function(value, element) {
     return this.optional(element) || /^[0-9a-zA-Z\s]+$/i.test(value);
   }, ""); 

    jQuery.validator.addMethod("minteamsize", function(value, element) {
      return this.optional(element) || value.length >= minTeamsForEvent;
    },"");

    jQuery.validator.addMethod("minteamMembers", function(value, element) {
      return this.optional(element) || value.split(',').length >= min_team_size;
    },"");

    
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
              lettersonly: true
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
              lettersonly: true,
              maxlength: 50
         },
         email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         },
         password: {
           required: function(element) {
              if($("#eventmanager_id").exists() && $("#eventmanager_id").val().length > 0) {
                  return false;
              } else {
                  return true;
              }
          }, 
          minlength: 6 }
        },
        messages: {
          companyname: {required: "Please enter company name", lettersonly: "Enter only alphanumeric values"},
          fullname: {required: "Please enter full name", lettersonly: "Enter only alphanumeric values", maxlength: "Full name can not be greater than {0} characters"},
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

    $("#add_user_frm, #edit_user_frm").validate({
      rules: {
         email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         }
        },
        messages: {
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


    $("#add_team_frm, #edit_team_frm").validate({
      ignore: "",
      rules: {
         teamname: {
              required: true, 
              lettersonly: true,
              minlength: 2,
              maxlength: 25
         },
         selected_users: { required : true, minteamMembers : true }
        },
        messages: {
          teamname: {
            required: "Please enter team name", 
            lettersonly: "Enter only alphanumeric values", 
            minlength: "Team name should be at-least 2 characters",
            maxlength: "Team name can not be greater than {0} characters"
          },
          selected_users: { 
            required: "Please add atleast one team member(s)", 
            minteamMembers: "Please add atleast "+min_team_size+" team member(s)"
          }
        },
        submitHandler: function(form) {
          form.submit();
        }
   
   });

   $("#add_event_frm, #edit_event_frm").validate({
      rules: {
      	 eventname: {
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
              lettersonly: true,
              maxlength: 25
         },
         "teams[]": {required:true,
                      minteamsize:true
                    },
         startdate: { required: true },
         starttime: { required: true },
         endtime: { required: true }
        },
        messages: {
        	eventname: {required: "Please enter event name", lettersonly: "Enter only alphanumeric values", maxlength: 'Event name can not be greater than {0} characters'},
          "teams[]": {required: "Please select atleast "+minTeamsForEvent+" teams", minteamsize:"Please select atleast "+minTeamsForEvent+" teams"},
          startdate: {required: "Please select start date"},
          starttime: {required: "Please select start time"},
          endtime: {required: "Please select end time"}
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
              lettersonly: true,
              maxlength: 50
         },
         email: {
            required: true,
            email: true,  //add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         }
        },
        messages: {
          fullname: {required: "Please enter full name", lettersonly: "Enter only alphanumeric values", maxlength: "Full name can not be greater than {0} characters"},
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


    var last_valid_selection = null;
    $('#selected,#items').change(function(event) {

      if ($(this).val().length > 5) {
        $(this).val(last_valid_selection);
      } else {
        last_valid_selection = $(this).val();
      }
    });

    // var dateToday = new Date();
    var dateToday = new Date();
    dateToday.setDate(dateToday.getDate() - 1);

    $('#eventStartDate').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        startDate: '-0m',
        minDate: dateToday
    });

    $('#eventStartTime,#eventEndTime').timepicker(); 
    

});


function getTeamMembers(team_id){

    var getTeamMembersUrl = $("#getTeamMembersUrl").attr('url');var token = $('input[name="_token"]').val();
    $.ajax({
      type:'POST',
      url: getTeamMembersUrl,
      data: {"_token": token, "team_id":team_id},
      success:function(data){            
        $("#teamMembers").html(data);  
        $("#teamMembersModal").modal('show');
      }

    });
}

function activeInactiveState(affected_id, status){
    
    let affected_data_model = $("#data_model").val(); 
    let setActiveInactiveUrl = $("#setActiveInactiveUrl").attr('url');let token = $('input[name="_token"]').val();
    
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
              userTable.ajax.reload(); teamTable.ajax.reload(); eventTable.ajax.reload();

              setTimeout(function(){ 
                swal("Done!", obj.message, "success"); 
              }, 100);

              // swal("Done!", obj.message, "success");
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


    