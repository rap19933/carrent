$(function () {
    $('#markAdd').click(function () {
        var mark = 'mark=' + $("#markAd").val();
        $.ajax({
            type: "POST",
            url: "php/autoMarkAdd.php",
            data: mark,
            success: function (result) {
                if (result === "0") {
                    $('#mark').addClass('has-error');
                }
                else if (result === "1") {
                    document.location.replace("add.php?nav=7");
                }
                else {
                    alert(result);
                }
            }
        });
    });
});