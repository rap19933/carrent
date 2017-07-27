<?php include 'php/connectDB.php'; ?>
<?php
session_start();
if (isset($_POST['rent'])) {
    $myExplode = explode(" ", $_POST['rent']);
    $autoId = $myExplode[0];
    $myData = $myExplode[1];
    $start = new DateTime($myData);
    $end = new DateTime($myData);
    $start = ($start->modify('+1 day'));
    $end = ($end->modify('+8 day'));
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end);
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_USER,DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $pdo->prepare('SELECT `DataStart` FROM `reservation` WHERE `AutoId` = :idAuto
            AND `DataStart` > :myData AND `archive` = :archive ORDER BY `DataStart` ASC LIMIT 1 ');
        $stmt->bindParam(':idAuto',$autoId);
        $stmt->bindParam(':myData',$myData);
        $stmt->bindValue(':archive',0);
        $stmt->execute();
        $resultRent = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare('SELECT `auto`.`AutoId`, `Model`, `Price`, `Number`, `ReleaseData`, `mark`.`Mark`
            FROM `auto` INNER JOIN `mark` ON `auto`.`MarkId` = `mark`.`MarkId` WHERE `AutoId` = :idAuto');
        $stmt->bindParam(':idAuto',$autoId);
        $stmt->execute();
        $resultAuto = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Ошибка при подключении к базе данных!';
    }
} else {
    header('Location: index.php?nav=1');
}
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
            <h3 class="text-center text-primary AutoId" id="<?= $resultAuto[0]['AutoId'] ?>">
                Форма бронирования "<?=$resultAuto[0]['Mark']?>: <?=$resultAuto[0]['Model']?>"
            </h3>
            <h4 class="text-center text-primary"><?php echo $resultAuto[0]['ReleaseData']?>
                года выпуска с номером "<?=$resultAuto[0]['Number']?>" по цене=<?=$resultAuto[0]['Price']?> руб.
            </h4>
            <div class="alert alert-danger hidden" id="success-alert">
                <div>Ошибка подключения к БД.</div>
            </div>
        </div>
        <div class="modal-body">
            <form id="myForm" method="post" role="form" name="myForm" action="index.php">
                <div id="markAuto" class="form-group">
                    <label class="control-label"><h4>Выберите на сколько дней арендуете авто:</h4></label>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <a class="btn btn-warning dataStart" id="<?= $myData; ?>">Срок аренды
                                с <?= $myData; ?> до
                            </a>
                        </div>

                        <div class="btn-group">
                            <select class="selectpicker btn-warning show-tick form-control selectId">
                                <?php
                                $i = 1;
                                function autoView($date, $day, $i){
                                    echo '<option id="'.$date.'">' .
                                        $date . '  на ' . $i . ' ' . $day . '</option>';
                                }
                                function day($i){
                                    if ($i == 1) {
                                        $day = 'день';
                                    } else if ($i == 2 || $i == 3 || $i == 4) {
                                        $day = 'дня';
                                    } else $day = 'дней';
                                    return $day;
                                }
                                if (!empty($resultRent)) {
                                    foreach ($period as $date) {
                                        if ($date->format('Y-m-d') === $resultRent[0]['DataStart']) {
                                            autoView($date->format('Y-m-d'),day($i), $i);
                                            break;
                                        } else
                                            autoView($date->format('Y-m-d'), day($i), $i);
                                        $i++;

                                    }
                                } else {
                                    foreach ($period as $date) {
                                        autoView($date->format('Y-m-d'), day($i), $i);
                                        $i++;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="name" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="name1" type="text" class="form-control" required="required" placeholder="Имя">
                    </div>
                </div>
                <div id="number" class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon "><i class="glyphicon glyphicon-phone"></i></span>
                        <div class="btn-toolbar">
                            <div class="btn-group">
                                <select id="country" class="form-control">
                                    <option value="ru">Россия +7</option>
                                    <option value="ua">Украина +380</option>
                                    <option value="by">Белоруссия +375</option>
                                </select>
                            </div>
                            <div class="btn-group">
                                <input id="phone" type="text" class="form-control" required="required"
                                       placeholder="Номер телефона">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="rent" type="submit" type="button" class="btn btn-primary  btn-block">Забронировать</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#rent').click(function () {
            var dataString = 'dataEnd=' + $(".selectId option:selected").attr('id')
                + '&dataStart=' + $(".dataStart").attr('id')
                + '&autoId=' + $(".AutoId").attr('id')
                + '&name=' + $("#name1").val()
                + '&phone=' + encodeURIComponent($("#phone").val());
            $.ajax({
                type: "POST",
                data: dataString,
                url: "php/reservationAdd.php",
                success: function (result) {
                    if (result === "-1") {
                        $('.has-feedback').addClass('has-error');
                    }
                    else if (result === "1") {
                        alert('Бронирование прошло успешно!');
                    }
                    else if (result === "-2") {
                        $('#success-alert').removeClass('hidden');
                    }
                    else if (result === "-3") {
                        alert('Выбраный интервал бронирования уже занет((( Выберете другое доступное авто!');
                        document.location.replace("index.php?nav=1");
                    }
                    else {
                        alert(result);
                    }
                }
            });
        });
    });
</script>
<script type="text/javascript">
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
</script>
</body>
</html>