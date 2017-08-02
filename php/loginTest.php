<?php include 'connectDB.php'; ?>
<?php
try {
    $stmt = $pdo->prepare('SELECT `UserId`, `Login`, `Password` FROM `user` WHERE `Login`=:login');
    $stmt->bindParam(':login', $_POST["login"]);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result && $_POST["password"]) {
        if ($result[0]['Password'] === md5($_POST["password"])) {
            $_SESSION['userId'] = $result[0]['UserId'];
            $_SESSION['login'] = $result[0]['Login'];
            echo '1';
        } else echo '2';
    } else echo '0';
} catch (PDOException $e) {
    echo '-1';
}
