$(function () {
    $('#register').click(function () {
        var dataString = 'login=' + $("#login").val() + '&password=' + $("#password").val();
        $.ajax({
            type: "POST",
            url: "php/loginTest.php",
            data: dataString,
            success: function (result) {
                if (result === "0") {
                    $('#log').addClass('has-error');
                    $('#pas').addClass('has-error');
                }
                else if (result === "1") {
                    document.location.replace("index.php?nav=1");
                }
                else if (result === "-1") {
                    $('#success-alert').removeClass('hidden');
                }
                else if (result === "2") {
                    $('#log').removeClass('has-error');
                    $('#log').addClass('has-success');
                    $('#pas').addClass('has-error');
                }
            }
        });
    });
});