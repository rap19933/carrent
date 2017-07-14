<?php	
	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');
	try {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        echo '-1';
    }
	$userId = $_POST["id"];

	$query = "DELETE FROM `user` WHERE `userId`='$userId'";
    $result = $pdo->exec($query);
    echo $result;
?>