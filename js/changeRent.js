function changeRent()
{
    var date = new Date();
    if (date.getHours() >=00 && date.getHours() <=9) {
        $.ajax({
            type: "POST",
            url: "php/deleteRent.php",
            success: function (result) {
                if (result === "1") {
                    alert(result);
                    document.location.replace("index.php?nav=1");
                }
            }
        });
    }
}
$(document).ready(function () {
    changeRent();
    setInterval('changeRent()', 1000*60*60);
});