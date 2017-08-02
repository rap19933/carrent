$(function () {
    $('#save').click(function () {
        var selectId = $(".selectId option:selected").attr('id');
        var image = $('.imgAdd').attr('src');
        var res = encodeURIComponent(image);
        var dataString = 'selectId=' + selectId
            + '&model=' + $("#model").val()
            + '&number=' + $("#number").val()
            + '&releaseData=' + $("#releaseData").val()
            + '&price=' + $("#price").val()
            + '&image=' + res;
        $.ajax({
            type: "POST",
            data: dataString,
            url: "php/autoAdd.php",
            success: function (result) {
                if (result === "-3") {
                    $('.has-feedback').addClass('has-error');
                }
                else if (result === "-2") {
                    $('.has-feedback').removeClass('has-error');
                    $('.number').addClass('has-error');
                }
                else if (result === "1") {
                    $('.has-feedback').removeClass('has-error');
                    alert('Данные успешно добавлены!');
                }
                else if (result === "-1") {
                    $('#success-alert').removeClass('hidden');
                }
                else {
                    alert(result);
                }
            }
        });
    });
});