$(function () {
    $('.thumbnail img').click(function (e) {
        e.preventDefault();
        $('#image-modal .modal-body img').attr('src', $(this).attr('src'));
        $("#image-modal").modal('show');
    });
    $('#image-modal .modal-body img').on('click', function () {
        $("#image-modal").modal('hide');
    });
});