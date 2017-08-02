<?php include 'connectDB.php'; ?>
<?php
try {
    $stmt = $pdo->prepare('SELECT `ReservationId` ,`DataEnd` FROM `reservation` WHERE `Archive` =:archive');
    $stmt->bindValue(':archive', 0, PDO::PARAM_INT);
    $stmt->execute();
    $resultRent = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($resultRent);
    if (!empty($resultRent)) {
        $datetime = date('Y-m-d');
        foreach ($resultRent as $value) {
            if (strtotime($value['DataEnd']) <= strtotime($datetime)) {
                $stmt = $pdo->prepare('UPDATE `reservation` SET `Archive` =:archive 
                    WHERE `reservation`.`ReservationId` =:reservationId');
                $stmt->bindValue(':archive', 1, PDO::PARAM_INT);
                $stmt->bindParam(':reservationId', $value['ReservationId']);
                $result = $stmt->execute();
                echo ($result);
            } else echo '-3';

        }
    } else echo '-2';
} catch (PDOException $e) {
    echo '-1';
}
