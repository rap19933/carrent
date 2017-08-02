<?php include 'connectDB.php'; ?>
<?php
if ($_POST["name"] !== '' && $_POST["phone"] !== '') {
    try {
        $stmt = $pdo->prepare('SELECT * FROM `reservation` WHERE `AutoId` = :autoId
        AND(
        (`DataStart` >= :dataStart  AND `DataStart` < :dataEnd)  /*смещение вперед*/
        OR
        (`DataEnd` <= :dataEnd AND `DataEnd` > :dataStart)  /*смещение назад*/
        OR
        (`DataStart` < :dataEnd AND `DataEnd` > :dataStart) /*вхождение*/
        OR
        (`DataStart` >= :dataStart AND `DataEnd` <= :dataEnd))/*поглощение и совпадение*/');

        $stmt->bindParam(':autoId', $_POST["autoId"]);
        $stmt->bindParam(':dataStart', $_POST["dataStart"]);
        $stmt->bindParam(':dataEnd', $_POST["dataEnd"]);
        $stmt->execute();
        $resultAuto = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($resultAuto)) {
            $stmt = $pdo->prepare('INSERT INTO `reservation`
            (`UserId`, `AutoId`, `DataStart`, `DataEnd`, `Name`, `PhoneNumber`, `Archive`)
                VALUES (:userId, :autoId, :dataStart, :dataEnd, :nameAuto, :phoneNumber, :archive)');

            $stmt->bindParam(':userId', $_SESSION["userId"]);
            $stmt->bindParam(':autoId', $_POST["autoId"]);
            $stmt->bindParam(':dataStart', $_POST["dataStart"]);
            $stmt->bindParam(':dataEnd', $_POST["dataEnd"]);
            $stmt->bindParam(':nameAuto', $_POST["name"]);
            $stmt->bindParam(':phoneNumber', $_POST["phone"]);
            $stmt->bindValue(':archive', 0, PDO::PARAM_INT);
            $result = $stmt->execute();
            echo $result;
        } else echo '-3';
    } catch (PDOException $e) {
        echo '-2';
    }
} else echo '-1';
