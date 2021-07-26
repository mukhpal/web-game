(function( $ ){
    //slick slider
	 $('.security_gallery').slick({
		rows: 2,
		dots: false,
		arrows: true,
		infinite: false,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 3,
		responsive: [{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
			}
		}, {
			breakpoint: 767,
			settings: {
			rows: 4,
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		}, {
			breakpoint: 420,
			settings: {
			rows: 4,
				slidesToShow: 1,
				slidesToScroll: 1,
		}
		}]
}); 
})( jQuery );
