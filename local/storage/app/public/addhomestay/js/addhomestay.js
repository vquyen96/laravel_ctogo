$(document).ready(function(){
	$(document).on('click','.add-image-icon',function(){
		$(this).next('input.file').click();
	});

    $('.bedroom-img').hover(function(){
        $(this).find('.delete').slideDown();
    },function(){
        $(this).find('.delete').slideUp();
    });
});

function showYourHomestay(e){
    $('.nav-show').hide();
    $('#yourhomestay').show();
    $('.navigation a figure').removeClass('active');
    $('figure',e).addClass('active');
}

function showYourLocation(e){
    $('.nav-show').hide();
    $('#yourlocation').show();
    $('.navigation a figure').removeClass('active');
    $('figure',e).addClass('active');
}

function showYourBedroom(e){
    $('.nav-show').hide();
    $('#yourbedroom').show();
    $('.navigation a figure').removeClass('active');
    $('figure',e).addClass('active');
}

function showYourPhoto(e){
    $('.nav-show').hide();
    $('#yourphoto').show();
    $('.navigation a figure').removeClass('active');
    $('figure',e).addClass('active');
}