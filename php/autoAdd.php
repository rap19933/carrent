<?php
include 'connectDB.php';
if ($_POST["image"] !== 'undefined' && $_POST["model"] !== '' && $_POST["number"] !== '' && $_POST["releaseData"]
    !== '' && $_POST["price"] !== '') {
    if (is_numeric($_POST["price"]) && is_numeric($_POST["releaseData"])) {
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
                DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $stmt = $pdo->prepare('INSERT INTO `auto`
                (`MarkId`, `Model`, `Number`, `ReleaseData`, `Price`, `Photo`)
                    VALUES (:markId, :model, :gosNumber, :releaseData, :price, :image)');
            $stmt->bindParam(':markId', $_POST["selectId"]);
            $stmt->bindParam(':model', $_POST["model"]);
            $stmt->bindParam(':gosNumber', $_POST["number"]);
            $stmt->bindParam(':releaseData', $_POST["releaseData"], PDO::PARAM_INT);
            $stmt->bindParam(':price', $_POST["price"]);
            $stmt->bindParam(':image', $_POST["image"]);

            $result = $stmt->execute();
            echo $result;
        } catch (PDOException $e) {
            echo '-1';
        }
    } else  echo '-2';
} else echo '-3';
?>