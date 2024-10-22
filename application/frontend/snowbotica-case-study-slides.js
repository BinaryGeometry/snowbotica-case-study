(function( $ ) {
 
    "use strict";

	$('.make-this-slide.sub').slick({
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    arrows: false,
	    fade: true,
	    arrows:false,
	    bullets:false,
	    dots: true,
	    asNavFor: '.make-this-slide.top'
	});

	$('.make-this-slide.top').slick({
		// autoplay: true,
		autoplaySpeed: 1400,
		speed:800,
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    asNavFor: '.make-this-slide.sub',
	    dots: false,
	    centerMode: false,
	    arrows: false,
	    focusOnSelect: true
	});


})(jQuery);
