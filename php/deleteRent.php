<?php
include 'connectDB.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
        DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $query = "SELECT `ReservationId` ,`DataEnd` FROM `reservation`";
    $result = $pdo->query($query);
    $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($resultUser)) {
        $datetime = date('Y-m-d');
        foreach ($resultUser as $value) {
            if (strtotime($value['DataEnd']) <= strtotime($datetime)) {
                $upd =$value['ReservationId'];
                $query = "UPDATE `reservation` SET `Archive` = 1 WHERE `reservation`.`ReservationId` = $upd";
                $result1 = $pdo->exec($query);
            }
        }
    } else echo '-2';
} catch (PDOException $e) {
    echo '-1';
}
?>