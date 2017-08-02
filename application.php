<?php include 'php/connectDB.php'; ?>
<?php
if ($_SESSION['login'] === 'admin') {
    try {
        $result = array();
        for ($i = 0; $i < 2; $i++) {
            $stmt = $pdo->prepare('SELECT `user`.`Login`, `Name`, `PhoneNumber`, `DataStart`, `DataEnd`,
                `mark`.`Mark`, `auto`.`Model`,`auto`.`Price` 
                    FROM `reservation` 
                        INNER JOIN `user` ON `reservation`.`UserId`=`user`.`UserId`
                            INNER JOIN `auto` ON `reservation`.`AutoId`=`auto`.`AutoId`
                                INNER JOIN `mark` ON `auto`.`MarkId`=`mark`.`MarkId`
                                    WHERE `archive`=:archive
                                        ORDER BY `reservation`.`DataStart` ASC');
            $stmt->bindParam(':archive', $i);
            $stmt->execute();
            $result[$i] = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        }
    } catch (PDOException $e) {
        echo 'Ошибка при подключении к базе данных!';
    }
} else {
    header('Location: login.php?nav=7');
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
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <?php
    $array = array("Список заявок", "Список архивных заявок");
    for ($i = 0; $i < 2; $i++):
        ?>
        <div class="row">
            <table class="table table-hover tablica">
                <caption><?= $array[$i]; ?></caption>
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
                if (!empty($result[$i])):
                    foreach ($result[$i] as $value):
                        ?>
                        <tr>
                            <td><?= $value['Login']; ?></td>
                            <td><?= $value['Name']; ?></td>
                            <td><?= $value['PhoneNumber']; ?></td>
                            <td><?= $value['DataStart']; ?></td>
                            <td><?= $value['DataEnd']; ?></td>
                            <td><?= $value['Mark']; ?></td>
                            <td><?= $value['Model']; ?></td>
                            <td><?= $value['Price']; ?></td>
                            <?php
                            $start = new DateTime($value['DataStart']);
                            $end = new DateTime($value['DataEnd']);
                            $nDay = $end->diff($start)->days;
                            ?>
                            <td><?= $value['Price'] * $nDay; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endfor; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
