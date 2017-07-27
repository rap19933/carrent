<?php
include 'connectDB.php';
$cookie_mark = $_POST["mark"];
if (!empty($_POST["mark"])){

    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER,
            DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $pdo->prepare('INSERT INTO `mark` (`Mark`) VALUES (:mark)');
        $stmt->bindParam(':mark',$_POST["mark"]);
        $result = $stmt->execute();
        echo $result;
    } catch (PDOException $e) {
        echo '-1';
    }
} else  echo '0';
?>