$(function () {
    $(document).ready(function () {
        $('.row-remove').click(function (e) {
            var user = 'id=' + $(this).attr('id');
            e.preventDefault();
            $(this).closest('tr').remove();
            $.ajax({
                type: "POST",
                url: "php/deleteUser.php",
                data: user,
                success: function (result) {
                    if (result !== "1") {
                        alert('Ошибка удаления');
                        document.location.replace("users.php");
                    }
                }
            });
        });
    });
});