<?php
if(session_id() == '') {
    session_start();
}
    $cookie_navbar = 1;
    $nav1 = '';
    $nav2 = '';
    $nav3 = '';
    $nav4 = '';
    $nav5 = '';
    $cookie_login = '';
    if (isset($_SESSION['login'])) {
        $cookie_login = $_SESSION['login'];
        echo $cookie_login;
    }else
    echo 'неудача';
    if (isset($_COOKIE['cookie_navbar'])) {
        $cookie_navbar = $_COOKIE['cookie_navbar'];
    }
     switch ($cookie_navbar) {
         case "1":
             $nav1 = 'class="active-link"';
             break;
         case "2":
             $nav2 = 'class="active-link"';
             break;
         case "3":
             $nav3 = 'class="active-link"';
             break;
         case "4":
             $nav4 = 'class="active-link"';
             break;
         case "5":
             $nav5 = 'class="active-link"';
             break;         
     }
?>
<header>
    <nav class="navbar navbar-default menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                     <span class="sr-only">Toggle navigation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="img/logo.png"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                     <li id="1" <?= $nav1; ?>><a href="index.php">главная</a></li>
                     <li id="2" <?= $nav2; ?>><a href="reservation.php">бронь</a></li>
                     <li id="3" <?= $nav3; ?>><a href="application.php">заявки</a></li>
                     <li id="4" <?= $nav4; ?>><a href="users.php">пользователи</a></li>
                     <li id="5" <?= $nav5; ?>><a href="add.php">add</a></li>
                </ul>                  
                <ul class="nav navbar-nav navbar-right icons">
                     
                <?php 
                     if ($cookie_login === '')
                         echo '<li id="6"><a href="login.php"><i class="glyphicon glyphicon-log-in"></i> войти</a></li>';
                     else    echo '<li id="6"><a href="profile.php">'."$cookie_login".'</a></li>
                              <li id="7"><a href="out.php">выйти</a></li>';
                ?>
                 </ul>
            </div>
        </div>
    </nav>
</header>