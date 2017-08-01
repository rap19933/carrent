<?php include 'php/connectDB.php'; ?>
<?php
session_start();
if (isset($_POST['myData'])) {
    $myExplode = explode(".", $_POST['dateIn']);
    $myData = $myExplode[2] . '-' . $myExplode[1] . '-' . $myExplode[0];
    $myDataJS = $_POST['dateIn'];
} else {
    $myData = date('Y-m-d');
    $myDataJS = date('d.m.Y');
}

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
        DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $stmt = $pdo->prepare('SELECT `AutoId`, `mark`.`Mark`,`Model`, `Price`, `Photo` FROM `auto`
        INNER JOIN `mark` ON `auto`.`MarkId` = `mark`.`MarkId` WHERE `AutoId` NOT IN
            (SELECT `AutoId` FROM `reservation`
                WHERE `DataStart`<=:myData AND `DataEnd`>:myData  AND `archive` = :archive)');
    $stmt->bindParam(':myData',$myData);
    $stmt->bindValue(':archive',0);
    $stmt->execute();
    $resultAuto = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Ошибка при подключении к базе данных!';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Аренда авто</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <div class="modal-title">Просмотр изображения</div>
            </div>
            <div class="modal-body">
                <img class="img-responsive center-block" src="" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<main>
    <?php
    if ($sessionLogin === ''): ?>
        <div class="alert alert-danger erLogin">
                    <h4>Для бронирования автомобиля необходимо авторизоваться!</h4>
                </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <aside class="col-sm-3 col-md-3">
                <div class="row">
                    <h3>Подобрать авто по дате</h3>
                    <form name="myData" method="post" action="index.php">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" class="form-control" name="dateIn" value="<?=$myDataJS?>"/>
                                <span class="input-group-addon">
                              <span class="glyphicon-calendar glyphicon"></span>
                            </span>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-default" name="myData" value="Отобразить авто"/>
                    </form>
                    </br>
                </div>
            </aside>
            <article class="col-sm-9 col-md-9">
                <div class="row">
                    <form name="myData" method="post" action="reservation.php?nav=2">
                        <?php
                        if (!empty($resultAuto)):
                            foreach ($resultAuto as $value): ?>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail photo">
                                        <img class="photo" src="<?=$value['Photo']?>" alt="<?=$value['Model']?>">
                                            <div class="caption">
                                            <h2><?=$value['Mark']?>-<?=$value['Model']?></h2>
                                            <p>Цена: <?=$value['Price']?> руб.</p>
                                            <?php if ($sessionLogin !== ''):?>
                                                <button type="submit" class="btn btn-primary" name="rent"
                                                        value="<?=$value['AutoId']?> <?=$myData?>"> Оформить бронь</button>
                                            <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </form>
                </div>
            </article>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
<script src="js/changeRent.js" type="text/javascript"></script>
<script src="js/datetimepicker.js.js" type="text/javascript"></script>
<script src="js/viewImg.js.js" type="text/javascript"></script>

</body>
</html>