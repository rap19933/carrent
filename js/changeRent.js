function changeRent()
{
    var date = new Date();
    if (date.getHours() >=00 && date.getHours() <=23){
        $.ajax({
            type: "POST",
            url: "php/deleteRent.php",
            success: function (result) {
            }
        });
    }
}
$(document).ready(function () {
    changeRent();
    setInterval('changeRent()', 1000*60*60);
});