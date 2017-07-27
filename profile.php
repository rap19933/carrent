<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Аренда авто</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-center text-success">Смена пароля</h3>
            <div class="alert alert-danger hidden" id="success-alert">
                <div>Ошибка подключения к БД.</div>
            </div>
        </div>
        <div class="modal-body">
            <form id="myForm" method="post" role="form" name="myForm">
                <div id="pas" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>
                        <input type="password" class="form-control" required="required" id="password" value=""
                               placeholder="Старый пароль">
                    </div>
                </div>
                <div id="newPas" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" required="required" id="newPassword" value=""
                               placeholder="Новый пароль">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="сhangePassword" type="button" class="btn btn-success  btn-block">Сменить пароль</button>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
    $(function () {
        $('#сhangePassword').click(function () {
            var password = $("#password").val();
            var newPassword = $("#newPassword").val();
            var dataString = 'password=' + password + '&newPassword=' + newPassword;
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
                       // document.cookie = "cookie_navbar=1";
                        alert("Пароль успешно изменен!");
                        document.location.replace("index.php?nav=1");
                    }
                    else {
                        $('#success-alert').removeClass('hidden');
                        alert(result);
                    }
                }
            });
        });
    });
</script>
</body>
</html>