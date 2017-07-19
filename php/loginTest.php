<?php
 	session_start();
	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');
	try {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $loginIn = $_POST["login"];
            $passwordIn = md5($_POST["password"]);     

            $query = "SELECT `UserId`, `Login`, `Password` FROM `user` WHERE `Login`='$loginIn'";
            $result = $pdo->query($query);
            $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);      
            if (!empty($resultUser)) {
                $password1 = $resultUser[0]['Password'];
                $id = $resultUser[0]['UserId'];
                if ($passwordIn === $password1){
                    $_SESSION['userId'] = $id;
                    $_SESSION['login'] = $loginIn;
                    $_SESSION['password'] = $passwordIn;

                echo '1' ;
                }
                else echo '2';
            } 
            else echo '0';
    } catch (PDOException $e) {
        echo '-1';
    }
?>