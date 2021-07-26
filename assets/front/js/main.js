(function ( $ ) { 
	$( document ).ready(function( ){ 

		$('[data-toggle="sidebar"]').click(function(event) {
			event.preventDefault();
			$('.app').toggleClass('sidenav-toggled');
		});

		var treeviewMenu = $('.app-menu');
		$("[data-toggle='treeview']").click(function(event) {
			event.preventDefault();
			if(!$(this).parent().hasClass('is-expanded')) {
				treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
			}
			$(this).parent().toggleClass('is-expanded');
		});

		$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

		$("[data-toggle='tooltip']").tooltip();

		$(window).scroll(function() {
			if ($(this).scrollTop() > 60) {
				$('.back-to-top').fadeIn('slow');
			} else {
				$('.back-to-top').fadeOut('slow');
			}
		});
		
		$('.back-to-top').click(function(){
			$('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
			return true;
		});

		try{ 
			new WOW().init();
		} catch( e ) {
			console.log( e.message );
		}

		$(window).scroll(function() {
			if ($(this).scrollTop() > 60) {
				$('#header').addClass('header-scrolled');
			} else {
				$('#header').removeClass('header-scrolled');
			}
		});

		$('.main-nav a, .mobile-nav a').on('click', function() {
		
			var target = $(this.hash);
			if (target.length) {
				var top_space = 0;

				if ($('#header').length) {
					top_space = $('#header').outerHeight();

					if (! $('#header').hasClass('header-scrolled')) {
						top_space = top_space - 40;
					}
				}

				$('html, body').animate({
					scrollTop: target.offset().top - top_space
				}, 1500, 'easeInOutExpo');

				if ($(this).parents('.main-nav, .mobile-nav').length) {
					$('.main-nav .active, .mobile-nav .active').removeClass('active');
					$(this).closest('li').addClass('active');
				}

				if ($('body').hasClass('mobile-nav-active')) {
					$('body').removeClass('mobile-nav-active');
					$('.mobile-nav-toggle i, body').toggleClass('fa-close hamburger_icon');
					$('.mobile-nav-overly').fadeOut();
				}
				return false;
				
			}
		});
	
		try{
			if( $('.slider-nav').length > 0 ){
				$('.slider-nav').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					speed: 350,
					infinite: true,
					arrows: true,
					dots: false,
					responsive: [{
						breakpoint: 991,
						settings: {
						dots: true,
							arrows: false,
						}
					}]
				});
			}
			$('[data-toggle="counter-up"]').counterUp({
				delay: 10,
				time: 1000
			});
		} catch(e) { 
			console.log( e.message );
		}
	});

})(jQuery);
