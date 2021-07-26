$(document).ready(function () {

  $.fn.exists = function () { return this.length > 0; };

  jQuery.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[0-9a-zA-Z\s]+$/i.test(value);
  }, "");

  $("#evntstart_frm").validate({
    rules: {
      fullname: {
        required: {
          depends: function () {
            if ( $.trim($(this).val()) ) {
              $(this).val($(this).val().replace(/  +/g, ' ') );
            }else{
              $(this).val($.trim($(this).val()));
            }
            return true;
          }
        },
        lettersonly: true,
        minlength: 2,
        maxlength: 25
      },
      avatar: {
        required: {
          depends: function () {
            $(this).val($.trim($(this).val()));
            return true;
          }
        },
      }
    },
    messages: {
      fullname: { required: "Please enter full name", lettersonly: "Enter only alphanumeric values", 
      minlength: "Name should be at-least 2 characters", maxlength: "Name can not be greater than {0} characters" },
      avatar: { required: "Please select avatar" }
    },
    submitHandler: function (form) {
      form.submit();
    }

  });

  $("#funfact_frm").validate({
    ignore: "",
    rules: {
      funfact1: {
        required: {
          depends: function () {
            if ( $.trim($(this).val()) ) {
              $(this).val($(this).val().replace(/  +/g, ' ') );
            }else{
              $(this).val($.trim($(this).val()));
            }
            return true;
          }
        }/*, 
              lettersonly: true*/
      },
      funfact2: {
        required: {
          depends: function () {
            if ( $.trim($(this).val()) ) {
              $(this).val($(this).val().replace(/  +/g, ' ') );
            }else{
              $(this).val($.trim($(this).val()));
            }
            return true;
          }
        }/*, 
              lettersonly: true*/
      },
      funfact3: {
        required: {
          depends: function () {
            if ( $.trim($(this).val()) ) {
              $(this).val($(this).val().replace(/  +/g, ' ') );
            }else{
              $(this).val($.trim($(this).val()));
            }
            return true;
          }
        }/*, 
              lettersonly: true*/
      }
    },
    messages: {
      funfact1: { required: "Please enter the first fun fact", lettersonly: "Enter only alphanumeric values" },
      funfact2: { required: "Please enter the second fun fact", lettersonly: "Enter only alphanumeric values" },
      funfact3: { required: "Please enter the third fun fact", lettersonly: "Enter only alphanumeric values" }
    },
    submitHandler: function (form) {
      $.ajax({
        type: 'POST', url: $("#funfact_frm").attr('action'), data: $("#funfact_frm").serialize(),
        success: function (data) {
          let obj = JSON.parse(data);
          if (obj.code == 200) {
            swal("Done!", obj.message, "success");
            $('textarea[name="funfact1"]').prop("disabled", true);
            $('textarea[name="funfact2"]').prop("disabled", true);
            $('textarea[name="funfact3"]').prop("disabled", true);

            $('input[name="statement1type"]').prop("disabled", true);
            $('input[name="statement2type"]').prop("disabled", true);
            $('input[name="statement3type"]').prop("disabled", true);
            $('#submitFunFact').hide();
          } else {
            swal("Error Occured!", obj.message, "error");
          }
        }
      });
      return false;
    }

  });


  $(".avatar-image li").click(function () {
    $(".fa").addClass("fa-user-circle-o");
    $("#avatar").val($(this).attr('value'));
    $("#fa" + $(this).attr('value')).removeClass("fa-user-circle-o");
    $("#fa" + $(this).attr('value')).addClass("fa-user-circle");
  });
  $(".avatar-image li").click(function () {
    $('.avatar-image li').removeClass("active");
    $(this).addClass("active");
  });

  var text_max = 100;
  $("textarea[name='funfact1']").keyup(function () {
    var text_length = $("textarea[name='funfact1']").val().length;
    var text_remaining = text_max - text_length;
    $('#count1').html(text_remaining + '/100');
  });
  $("textarea[name='funfact2']").keyup(function () {
    var text_length = $("textarea[name='funfact2']").val().length;
    var text_remaining = text_max - text_length;
    $('#count2').html(text_remaining + '/100');
  });
  $("textarea[name='funfact3']").keyup(function () {
    var text_length = $("textarea[name='funfact3']").val().length;
    var text_remaining = text_max - text_length;
    $('#count3').html(text_remaining + '/100');
  });


  $('#image-gallery').lightSlider({
    gallery: true,
    item: 1,
    thumbItem: 6,
    slideMargin: 0,
    speed: 500,
    auto: true,
    loop: true,
    pause: 20000,
    pager: false,
    onSliderLoad: function () {
      $('#image-gallery').removeClass('cS-hidden');
    }
  });

  $(".joined_member li:first-child").addClass("active");
  /*$(".btn-toggle").click(function () {
    var valnow
    if ($(this).val() == 1) {
      valnow = 0;
      $("#dark-camera").css("display", "inline-block"); $("#light-camera").css("display", "none");
      $(".joined_member li:first-child").addClass("active");
    } else {
      valnow = 1;
      $("#dark-camera").css("display", "none"); $("#light-camera").css("display", "inline-block");
      $(".joined_member li:first-child").removeClass("active");
    }
    $(".btn-toggle").val(valnow);
  })*/


});
