$(document).ready(function(){
    var owl_banner = $('.owl-banner');
    owl_banner.owlCarousel({
        items:1,
        loop:true,
        autoplay:true,
        dots: false
    });

	var owl = $('.owl-carousel-1');
	owl.owlCarousel({
		items:3,
		loop:true,
		margin:10,
		autoplay:true,
		autoplayTimeout:2000,
		autoplayHoverPause:true,
        responsiveClass:true,
        nav: true,
        dots: false,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:3,
            }
        }
	});

	var owl = $('.owl-carousel-4');
	owl.owlCarousel({
		loop:true,
		margin:10,
		autoplay:true,
		autoplayTimeout:2000,
		autoplayHoverPause:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:4,
            },
            1000:{
                items:6,
            }
        },
        touchDrag: false,
        mouseDrag: false,
        nav: false
	});

	$('.input-daterange').datepicker({
		format: "dd/mm/yyyy",
		todayHighlight: true
	});

	var owl_partner = $('.partner-carousel');
	owl_partner.owlCarousel({
		loop:true,
		margin:100,
		autoplay:true,
		autoplayHoverPause:true,
		slideTransition: 'linear',
		autoplayTimeout: 5000,
		autoplaySpeed: 6000,
        responsiveClass:true,
        responsive:{
            0:{
                items:3,
                nav:false
            },
            600:{
                items:4,
                nav:false
            },
            1000:{
                items:5,
                nav:false,
                loop:false
            }
        }
	})

	owl_partner.trigger('play.owl.autoplay');

	owl.on('translated.owl.carousel', function(){
	    $('.owl-carousel-4 .active:first .slide-image-4').click();
    });
});