<?php
 	session_start();
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    unset($_SESSION['userId']);
    header ('Location: index.php'); 
    exit(); 
?>