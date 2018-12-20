$(document).ready(function(){

    var $input = $('#star_input');
    $('#star1').starrr({
        change: function(e, value){
            if (value) {
                $('.your-choice-was').show();
                $('.choice').text(value);
            } else {
                $('.your-choice-was').hide();
            }
            $input.val(value).trigger('input');
        }
    });
});