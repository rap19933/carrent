<?php session_start(); ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include 'header.php'; ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-center text-primary">Авторизация</h3>
            <div class="alert alert-danger hidden" id="success-alert">
                <div>Ошибка подключения к БД.</div>
            </div>
        </div>
        <div class="modal-body">
            <form id="myForm" method="post" role="form" name="myForm">
                <div id="log" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" id="login" placeholder="Логин">
                    </div>
                </div>
                <div id="pas" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="password" placeholder="Пароль">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="register" type="button" class="btn btn-primary  btn-block">Войти</button>
            </br>
            <a class="btn btn-success" data-dismiss="modal" href="register.php">Регистрация</a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/loginTest.js" type="text/javascript"></script>
</body>
</html>
