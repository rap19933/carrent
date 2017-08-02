<?php include 'connectDB.php'; ?>
<?php
try {
    if (isset($_SESSION['login'])) {
        $newPasswordIn = md5($_POST["newPassword"]);
        $stmt = $pdo->prepare('SELECT `Password` FROM `user` WHERE `Login`=:login');
        $stmt->bindParam(':login', $_SESSION['login']);
        $stmt->execute();
        $resultUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultUser)) {
            if (md5($_POST["password"]) === $resultUser[0]['Password'] && $_POST["newPassword"] !== '') {
                $stmt = $pdo->prepare('UPDATE `user` SET `Password` =:newPass WHERE `user`.`UserId` =:userId');
                $stmt->bindParam(':newPass', $newPasswordIn);
                $stmt->bindParam(':userId', $_SESSION['userId']);
                $result = $stmt->execute();
                echo($result);
            } else echo '-3';
        } else echo '-2';
    } else header('Location: login.php');;
} catch (PDOException $e) {
    echo '-1';
}
