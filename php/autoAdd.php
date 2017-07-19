<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');
    define('DB_CHARSET', 'utf8');

    if ($_POST["image"] !== 'undefined' && $_POST["model"] !== '' && $_POST["number"] !== '' && $_POST["releaseData"] !== '' && $_POST["price"] !== '')
    {    
        try {
            $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            $markId = $_POST['selectId']; 
            $model = $_POST['model']; 
            $number = $_POST['number']; 
            $releaseData = $_POST['releaseData']; 
            $price = $_POST['price']; 
            $image = $_POST['image']; 
            $query = "INSERT INTO `auto` (`MarkId`, `ReservationId`, `Model`, `Number`, `ReleaseData`, `Price`, `Photo`) 
                                 VALUES ('$markId', NULL, '$model', '$number', '$releaseData', '$price', '$image')";  
            $result = $pdo->exec($query);
            if ($result == '1') {
                echo '1' ;
            } 
            else echo '0';  
        } catch (PDOException $e) {
            echo '-1';
        }
    } 
    else echo '3';   
?>