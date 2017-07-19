<?php
session_start();
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');
    define('DB_CHARSET', 'utf8');
    if ($_POST["name"] !== '' && $_POST["phone"] !== '')
    {    
        try {
            $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            $dataEnd = $_POST['selectId']; 
            $dataStart = $_POST['dataStart']; 
            $days = $_POST['days']; 
            $autoId = $_POST['autoId']; 
            $name = $_POST['name']; 
            $phone = $_POST['phone']; 
            $userId = $_SESSION['userId'];; 
            if ($days === '1') {
                $query = "INSERT INTO `reservation` 
                    (`UserId`, `AutoId`, `DataStart`, `DataEnd`, `Name`, `PhoneNumber`) 
                VALUES ('$userId', '$autoId', '$dataStart', NULL, '$name', ' $phone')";  
                $result = $pdo->exec($query);
                $last_id = $pdo->lastInsertId();
                $query1 = "UPDATE `auto` SET `ReservationId` = '$last_id' WHERE `AutoId` = '$autoId'";
                $result1 = $pdo->exec($query1);
                echo '1'; 
            } 
            else {
                $query = "INSERT INTO `reservation` 
                    (`UserId`, `AutoId`, `DataStart`, `DataEnd`, `Name`, `PhoneNumber`) 
                VALUES ('$userId', '$autoId', '$dataStart', '$dataEnd', '$name', ' $phone')";  
                $result = $pdo->exec($query);
                $last_id = $pdo->lastInsertId();
                $query1 = "UPDATE `auto` SET `ReservationId` = '$last_id' WHERE `AutoId` = '$autoId'";
                $result1 = $pdo->exec($query1);
                echo '1'; 
            }
        } catch (PDOException $e) {
            echo '-2';
        }
    } 
    else echo '-1';   
?>