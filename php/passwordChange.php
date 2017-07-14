<?php
session_start();
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'carrentdb');

    try {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  		  	$cookie_login = '';
		    if (isset($_SESSION['login'])) {
		        $cookie_login = $_SESSION['login'];
		        $passwordIn = md5($_POST["password"]);
		    	$newPasswordIn = md5($_POST["newPassword"]);
		        	$query = "SELECT `UserId`, `Password` FROM `user` WHERE `Login`='$cookie_login'";
		   			$result = $pdo->query($query);
		    		$resultUser = $result->fetchAll(PDO::FETCH_ASSOC);

				    if (!empty($resultUser)) {
				        if ($passwordIn === $resultUser[0]['Password'] && $newPasswordIn !== md5('')){
				        	$pas = $resultUser[0]['UserId'];
							$query = "UPDATE `user` SET `Password` = '$newPasswordIn' WHERE `user`.`UserId` = '$pas'";
				            $result1 = $pdo->exec($query);
				            if($result1===1){
				                $_SESSION['password'] = $passwordIn;
				                echo '1' ;
				            }
				            else echo '-4';
				        } 
				        else echo '-3';
				    } 
				    else echo '-2';	
		    } 
		    else header ('Location: login.php'); ;		
    } catch (PDOException $e) {
        echo '-1';
    }
?>