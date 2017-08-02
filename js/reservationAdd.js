$(function () {
    $('#rent').click(function () {
        var dataString = 'dataEnd=' + $(".selectId option:selected").attr('id')
            + '&dataStart=' + $(".dataStart").attr('id')
            + '&autoId=' + $(".AutoId").attr('id')
            + '&name=' + $("#name1").val()
            + '&phone=' + encodeURIComponent($("#phone").val());
        $.ajax({
            type: "POST",
            data: dataString,
            url: "php/reservationAdd.php",
            success: function (result) {
                if (result === "-1") {
                    $('.has-feedback').addClass('has-error');
                }
                else if (result === "1") {
                    alert('Бронирование прошло успешно!');
                }
                else if (result === "-2") {
                    $('#success-alert').removeClass('hidden');
                }
                else if (result === "-3") {
                    alert('Выбраный интервал бронирования уже занет((( Выберете другое доступное авто!');
                    document.location.replace("index.php?nav=1");
                }
                else {
                    alert(result);
                }
            }
        });
    });
});