<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');
    define('DB_CHARSET', 'utf8');
    $cookie_mark = $_POST["mark"];   
    try {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $query = "INSERT INTO `mark` (`Mark`) VALUES ('$cookie_mark')";
        $result = $pdo->exec($query);
       if ($result == '1') {
            echo '1';
        } 
        else echo '0';

    } catch (PDOException $e) {
        echo '-1';
    }
?>