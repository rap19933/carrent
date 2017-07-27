<?php include 'php/connectDB.php'; ?>
<?php
session_start();

if ($_SESSION['login'] === 'admin') {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $query = "SELECT `user`.`Login`, `Name`, `PhoneNumber`, `DataStart`, `DataEnd`,`mark`.`Mark`, `auto`.`Model`,`auto`.`Price` 
            FROM `reservation` 
            INNER JOIN `user` ON `reservation`.`UserId`=`user`.`UserId`
             INNER JOIN `auto` ON `reservation`.`AutoId`=`auto`.`AutoId`
              INNER JOIN `mark` ON `auto`.`MarkId`=`mark`.`MarkId`
               WHERE `archive` = 0
               ORDER BY `reservation`.`DataStart` ASC";
        $result = $pdo->query($query);
        $resultRent = $result->fetchAll(PDO::FETCH_ASSOC);

        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $query = "SELECT `user`.`Login`, `Name`, `PhoneNumber`, `DataStart`, `DataEnd`,`mark`.`Mark`, `auto`.`Model`,`auto`.`Price` 
            FROM `reservation` 
            INNER JOIN `user` ON `reservation`.`UserId`=`user`.`UserId`
             INNER JOIN `auto` ON `reservation`.`AutoId`=`auto`.`AutoId`
              INNER JOIN `mark` ON `auto`.`MarkId`=`mark`.`MarkId`
               WHERE `archive` = 1
               ORDER BY `reservation`.`DataStart` ASC";
        $result = $pdo->query($query);
        $resultArchive = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Ошибка при подключении к базе данных!';
    }
} else {
    header('Location: login.php');
    exit();
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
<div class="container">
    <div class="row">
        <table class="table table-hover tablica">
            <caption>Список заявок</caption>
            <thead>
            <tr class="mycolor">
                <th>Логин</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Дата от</th>
                <th>Дата до</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($resultRent)) :
                foreach ($resultRent as $value): ?>
                    <tr>
                        <td><?=$value['Login'];?></td>
                        <td><?=$value['Name'];?></td>
                        <td><?=$value['PhoneNumber'];?></td>
                        <td><?=$value['DataStart'];?></td>
                        <td><?=$value['DataEnd'];?></td>
                        <td><?=$value['Mark'];?></td>
                        <td><?=$value['Model'];?></td>
                        <td><?=$value['Price'];?></td>
                        <?php if (empty($value['DataEnd'])) : ?>
                            <td><?=$value['Price'];?></td>
                        <?php else :
                            $start = new DateTime($value['DataStart']);
                            $interval = new DateInterval('P1D');
                            $end = new DateTime($value['DataEnd']);
                            $period = new DatePeriod($start, $interval, $end);
                            $i = 0;
                            foreach ($period as $date) {
                                $i++;
                            }?>
                            <td><?=$value['Price'] * $i ?></td>
                        <?php endif; ?>

                   </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <table class="table table-hover tablica">
            <caption>Список архивных заявок</caption>
            <thead>
            <tr class="mycolor">
                <th>Логин</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Дата от</th>
                <th>Дата до</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($resultArchive)) :
                foreach ($resultArchive as $value): ?>
                    <tr>
                        <td><?=$value['Login'];?></td>
                        <td><?=$value['Name'];?></td>
                        <td><?=$value['PhoneNumber'];?></td>
                        <td><?=$value['DataStart'];?></td>
                        <td><?=$value['DataEnd'];?></td>
                        <td><?=$value['Mark'];?></td>
                        <td><?=$value['Model'];?></td>
                        <td><?=$value['Price'];?></td>
                        <?php if (empty($value['DataEnd'])) : ?>
                            <td><?=$value['Price'];?></td>
                        <?php else :
                            $start = new DateTime($value['DataStart']);
                            $interval = new DateInterval('P1D');
                            $end = new DateTime($value['DataEnd']);
                            $period = new DatePeriod($start, $interval, $end);
                            $i = 0;
                            foreach ($period as $date) {
                                $i++;
                            }?>
                            <td><?=$value['Price'] * $i ?></td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>