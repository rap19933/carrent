<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'carrentdb');

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $cookie_login = '';
    if (isset($_SESSION['login'])) {
        $cookie_login = $_SESSION['login'];
    } else exit();

    $passwordIn = md5($_POST["password"]);
    $newPasswordIn = md5($_POST["newPassword"]);

    $query = "SELECT `Password` FROM `user` WHERE `Login`='$cookie_login'";
    $result = $pdo1->query($query);
    $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);
    echo $resultUser[0]['Password'];
} catch (PDOException $e) {
    echo '-1';
}
?>