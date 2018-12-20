$(document).ready(function(){
    $('#menu-button').click(function(e){
        $('.menu-mobile').slideToggle();
    });

	$('.to-top').click(function(){
		$('html, body').animate({scrollTop: "0px"});
	});

	$('.user-tab').click(function(){
		$('.dropdown-user').slideToggle();
	});

	$('#destinations').click(function(e){
		e.preventDefault();
		$('.dropdown-destination').slideToggle();
	});

	$('.language').click(function(){
		$('ul', this).slideToggle();
	});
});