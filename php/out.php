<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['userId']);
header('Location: index.php?nav=1');
exit();
