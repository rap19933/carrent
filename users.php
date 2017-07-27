<?php
session_start();
include 'php/connectDB.php';
if (isset($_SESSION['login']) && $_SESSION['login'] === 'admin') {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $query = "SELECT * FROM `user`";
        $result = $pdo->query($query);
        $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Ошибка при подключении к базе данных!';
    }
} else {
    header('Location: login.php?nav=8');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Пользователи</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <div class="row">
        <table class="table table-hover tablica">
            <caption>Список пользовательских учеток</caption>
            <thead>
            <tr class="mycolor">
                <th>Логин</th>
                <th>Email</th>
                <th>Пароль</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($resultUser)):
                foreach ($resultUser as $value): ?>
                    <tr>
                        <td><?=$value['Login'];?></td>
                        <td><?=$value['Email'];?></td>
                        <td><?=$value['Password'];?></td>
                        <?php if ($value['Login'] != 'admin'): ?>
                        <td>
                            <div class="form-actions no-color">
                			    <a class="btn btn-danger row-remove"  id="<?=$value['UserId'];?>">Удалить</a>
                            </div>
                        </td>
                        <?php else: ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
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
</script>
</body>
</html>