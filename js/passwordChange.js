$(function () {
    $('#сhangePassword').click(function () {
        var dataString = 'password=' + $("#password").val() + '&newPassword=' + $("#newPassword").val();
        $.ajax({
            type: "POST",
            url: "php/passwordChange.php",
            data: dataString,
            success: function (result) {
                if (result === "-1") {
                    $('#success-alert').removeClass('hidden');
                }
                else if (result === "-3") {
                    $('#pas').addClass('has-error');
                    $('#newPas').addClass('has-error');
                    alert("Ошибка при изменении пароля!");
                }
                else if (result === "1") {
                    alert("Пароль успешно изменен!");
                    document.location.replace("index.php?nav=1");
                }
                else {
                    $('#pas').addClass('has-error');
                    $('#newPas').addClass('has-error');
                    alert(result);
                }
            }
        });
    });
});