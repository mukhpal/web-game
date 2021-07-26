(function( $ ){
    //slick slider
$('.profile_gallery').slick({
    rows: 2,
    dots: false,
    arrows: true,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [{
        breakpoint: 1024,
        settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
        }
    }, {
        breakpoint: 991,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
        }
    },
    {
        breakpoint: 767,
        settings: {
            rows: 4,
            slidesToShow: 1,
            slidesToScroll: 1,
        }
    },
    {
        breakpoint: 420,
        settings: {
        rows: 2,
            slidesToShow: 1,
            slidesToScroll: 1,
    }
    }]
}); 
})( jQuery );


const slider = $(".profile_gallery");
slider.on('wheel', (function(e) {
  e.preventDefault();

  if (e.originalEvent.deltaY < 0) {
    $(this).slick('slickNext');
  } else {
    $(this).slick('slickPrev');
  }
}));


    // method to Take interview of suspects
    $(".interview_btn").on('click', '.view_btn', function () {
        var s_id = $('.s_id').val();
        timerModel ( 'Taking interview..........', 10 );
        setTimeout(function(){

            $.ajax({
                type: "POST",
                url: $(".s_id").data('url'),
                data: { s_id : s_id, _token: $("input[name=_token]").val(), user_id:$("input[name=user_id]").val(), event_id:$("input[name=event_id]").val(), team_id:$("input[name=team_id]").val() },
                beforeSend:function(){},
                success: function (result) {
                    if(result.status == 1){
                        
                        $('.interview_detail').html(result.data);
                        $('.interview_detail').removeClass('detail_default');
                        $('.interview_btn').html($('.sname').val()).addClass('interviewer_name');
                        $(".gloves_suspect").removeClass('search_disable').addClass('search_enable');
                        
                    }else{
                        badluckmodel( result.msg );
                    }
                }
            });
        }, 9000);
    });

    // method to search the house of suspects
    $(".gloves").on('click', '.view_btn', function () {
        var s_id = $('.s_id').val();
        var encId = $('.encId').val();
        timerModel ( 'Searching house..........', 10 );

        setTimeout(function(){
            $.ajax({
                type: "POST",
                url: $("input[name=sname]").data('url'),
                data: { s_id : s_id, _token: $("input[name=_token]").val(), user_id:$("input[name=user_id]").val(), event_id:$("input[name=event_id]").val(), team_id:$("input[name=team_id]").val(), encId:encId },
                success: function (result) {
                    if(result.status == 1){

                            var link = result.link;
                            $(".gloves_suspect").removeClass('search_disable search_house_btn').addClass('gloves_show_img');
                            
                            if(result.shbit == 2){
                                //case:reporter found party photos
                                modelGlovesFound('Congratulations!', result.msg , 'party_photos_thumb.png');
                                var path = result.imgpath;
                                var html = '<a href="'+link+'"><img src="' + path + '" alt="" class="img-fluid" /></a>';
                                $(".gloves_suspect").addClass('search_house_btn');
                                $('.gloves').html( html );
                                addNotiMenu();
                            }else if (result.shbit == 3){
                                modelGlovesFound('Congratulations!', result.msg , 'gloves_black.png');
                                var path = result.imgpath;
                                var html = '<img data-status="4" src="' + path + '" alt="" class="img-fluid painted_gloves" />';
                                $('.gloves').html( html );
                                if( result.compareBtn == 1){
                                    $(".gloves_suspect").append('<a data-url="'+link+'" id="compare_gloves" href="javascript:void(0);" class="view_btn">compare Gloves</a>');
                                }
                            }else if (result.shbit == 4){
                                modelGlovesFound('Congratulations!',result.msg);
                                var path = result.imgpath;
                                var html = '<img data-status="7" src="' + path + '" alt="" class="img-fluid painted_gloves" />';
                                $('.gloves').html( html );
                                if( result.compareBtn == 1){
                                    $(".gloves_suspect").append('<a data-url="'+link+'" id="compare_gloves" href="javascript:void(0);" class="view_btn">compare Gloves</a>');
                                }
                            }else{
                                var path = result.imgpath;
                                var html = '<img src="' + path + '" alt="" class="img-fluid bad_luck" />';
                                $('.gloves').html( html );
                                badluckmodel( result.msg );
                            }
    
                            $('.search_house').html('');
    
                    }else{
                        badluckmodel( result.msg );
                    }
                }
            });
        }, 9000);
    });

    //get suspect finger prints
    $(".finger_prints").on('click', '.view_btn', function () {
        var s_id = $('.s_id').val();
        timerModel ( 'Taking fingerprints..........', 10 );
        setTimeout(function(){
            $.ajax({
                type: "POST",
                url: $(".f_url").data('url'),
                data: { s_id : s_id, _token: $("input[name=_token]").val(), user_id:$("input[name=user_id]").val(), event_id:$("input[name=event_id]").val(), team_id:$("input[name=team_id]").val() },
                beforeSend:function(){},
                success: function (result) {
                    if(result.status == 1){
                        var htm = '<h5 data-toggle="modal" data-target="#prnt_fingr" class="fingre_print_img"><img src="'+result.data+'" alt="" class="img-fluid" /></h5>';
                            $('.finger_prints').html(htm);
                            $('.getting_fingerprint').modal('hide');
    
                    }else{
                        badluckmodel( result.msg );
                    }
                }
            });
        }, 9000);
    });
    //compare gloves for professor and painter
    $('.gloves_suspect').on('click', '#compare_gloves' ,function(){
        var s_id = $('.s_id').val();
        timerModel ( 'Comparing gloves.........', 10 );
        setTimeout(function(){
            $.ajax({
                type: "POST",
                url: $("#compare_gloves").data('url'),
                data: { s_id : s_id, _token: $("input[name=_token]").val(), user_id:$("input[name=user_id]").val(), event_id:$("input[name=event_id]").val(), team_id:$("input[name=team_id]").val() },
                success: function (result) {
                    if(result.status == 1){
                        modelGlovesFound('Congratulations!', result.msg, 'evidence.png');
                        if(result.shbit == 1){
                            addNotiMenu();
                        }
                    }else{
                        badluckmodel( result.msg );
                    }
                }
            });
        }, 9000);
    });

    $(".gloves").on('click', '.painted_gloves', function () {
        var img = 'gloves.png';
        var congrates = 'Congratulations!';
        var msg     =   " Found Tim's gloves with stains of the paints used on the mansion's sconces.";

        if( $('.painted_gloves').attr('data-status') == 4 || $('.painted_gloves').attr('data-status') == 6){
            img = 'gloves_black.png';
            msg = "Found Professor's gloves with some paint stains on them";
        }
        modelGlovesFound(congrates,msg, img);
    });

    $(".gloves").on('click', '.bad_luck', function () {
        badluckmodel('Nothing useful was found for the case.');
    });

    $(".finger_prints").on('click', '.fingre_print_img', function () {
        fingerprintModel();
    });