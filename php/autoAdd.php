<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');
    
    $cookie_login = $_POST["image"];   

    try {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $query = "INSERT INTO `a` (`photo`) VALUES ('$cookie_login')";
        $result = $pdo->exec($query);
       if ($result == '1') {
            echo '1' ;
        } 
        else echo '0';

    } catch (PDOException $e) {
        echo '-1';
    }
?>