<?php
include 'connectDB.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $stmt = $pdo->prepare('DELETE FROM `user` WHERE `UserId`=:userId');
    $stmt->bindParam(':userId',$_POST["id"]);
    $result = $stmt->execute();
    echo $result;
} catch (PDOException $e) {
    echo '-1';
}
?>