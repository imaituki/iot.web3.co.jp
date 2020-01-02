// slick
document.write('<script type="text/javascript" src="common/js/slick/slick.min.js"></script>');
document.write('<link rel="stylesheet" href="common/js/slick/slick.css" type="text/css">');

// for top
$(function(){
	// slick
	$('#main_image').slick({
		autoplay: true,
		dots: false,
		arrows: true,
		autoplaySpeed: 3000,
		speed: 3000,
		fade: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		pauseOnFocus: false,
		pauseOnHover: false,
		infinite: true
	});

	$('#banner').slick({
		autoplay: true,
		dots: false,
		infinite: true,
		autoplaySpeed: 3000,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
			{ breakpoint: 992,
			  settings: {
					slidesToShow: 3
				}
			},
			{ breakpoint: 576,
			  settings: {
					slidesToShow: 2
				}
			}
		]
	});

});
