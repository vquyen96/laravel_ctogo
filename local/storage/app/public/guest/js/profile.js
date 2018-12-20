function seeDetailModal(id)
{
    $.ajax({
        url : "/user/seeDetailModal?id="+id,
        type : "get",
        success : function (result){
            $('#detailModal .modal-body').html(result);
            $('#detailModal').modal('show');
        }
    });
}

//hash on url
var hash = window.location.hash;
hash && $('ul.nav a[href="' + hash + '"]').tab('show');

$('.nav-tabs a').click(function (e) {
    $(this).tab('show');
    window.location.hash = this.hash;
});

$('.dropdown-user a').click(function () {
    var hash = $(this).attr('data-target');
    $('ul.nav a[href="' + hash + '"]').tab('show');
    $('.dropdown-user').hide(); //header
});