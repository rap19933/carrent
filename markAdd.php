<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Добавление марки авто</title>
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
            <h3 class="text-center text-primary">Добавление марки авто</h3>
            <div class="alert alert-danger hidden" id="success-alert">
                <div>Ошибка подключения к БД.</div>
            </div>
        </div>
        <div class="modal-body">
            <form id="myForm" method="post" role="form" name="myForm">
                <div id="mark" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-cloud-upload"></i></span>
                        <input type="text" class="form-control" required="required" id="markAd" value=""
                               placeholder="Марка автомобиля">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="markAdd" type="button" class="btn btn-primary  btn-block">Добавить марку авто</button>
            </br>
            <a class="btn btn-default" data-dismiss="modal" href="add.php">Назад</a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="js/autoMarkAdd.js" type="text/javascript"></script>
</body>
</html>
