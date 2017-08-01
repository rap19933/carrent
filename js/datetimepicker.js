$(function () {
    $('#datetimepicker').datetimepicker({
        language: 'ru',
        pickTime: false,
    });
    $("#getDate").click(function () {
        alert($('#datetimepicker').data("DateTimePicker").getDate());
    });
});