$(function () {
    function maskPhone() {
        var country = $('#country option:selected').val();
        switch (country) {
            case "ru":
                $("#phone").mask("+7(999) 999-99-99");
                break;
            case "ua":
                $("#phone").mask("+380(999) 999-99-99");
                break;
            case "by":
                $("#phone").mask("+375(999) 999-99-99");
                break;
        }
    }

    maskPhone();
    $('#country').change(function () {
        maskPhone();
    });
});