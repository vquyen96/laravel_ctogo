$(document).ready(function(){
	var owl = $('.owl-carousel-1');
	owl.owlCarousel({
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:4,
            }
        },
		loop:true,
		nav:true,
		dots:false,
		autoplay:true,
		autoplayTimeout:2000,
		autoplayHoverPause:true
	});

	var owl = $('.owl-carousel-5');
	owl.owlCarousel({
        responsiveClass:true,
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
        },
		loop:true,
		dots:false,
		autoplay:true,
		autoplayTimeout:2000,
		autoplayHoverPause:true
	});
});

function add_order(id,price,homestay_id) {
	var html_id = "<input class='d-none' name=\"book[id_room]\" value=\""+id+"\">";
	var html_price = "<input class='d-none' name=\"book[price]\" value=\""+price+"\">";
	var html_homestay = "<input class='d-none' name=\"book[homestay_id]\" value=\""+homestay_id+"\">";
    $('#bedroom-check').append(html_id);
    $('#bedroom-check').append(html_price);
    $('#bedroom-check').append(html_homestay);
	$('#bedroom-check').submit();
}