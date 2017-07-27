<?php
//if (session_id() == '') {
//    session_start();
//}

$navId = 1;
if (!empty($_GET['nav'])) $navId = $_GET['nav'];


if (isset($_SESSION['login'])) {
    $sessionLogin = $_SESSION['login'];
    echo $sessionLogin;
} else {
    $sessionLogin = '';
    echo 'неудача';
}


$arrayNav = array(
    'главная' => 'index.php?nav=1',
    'бронь' => 'reservation.php?nav=2',
    'заявки' => 'application.php?nav=3',
    'пользователи' => 'users.php?nav=4',
    'add' => 'add.php?nav=5'
);
?>
<header>
    <nav class="navbar navbar-default menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="img/logo.png"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $i = 1;
                    foreach ($arrayNav as $key => $value):
                        if ($i == $navId):?>
                            <li class="active-link">
                        <?php else: ?>
                            <li>
                        <?php endif; ?>
                                <a href="<?= $value; ?>"><?= $key; ?></a>
                            </li>

                    <?php
                        $i++;
                    endforeach; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right icons">
                    <?php
                    if ($sessionLogin === ''): ?>
                        <li id="6">
                            <a href="login.php?nav=8">
                                <i class="glyphicon glyphicon-log-in">
                                </i> войти
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="profile.php?nav=6"><?= $sessionLogin; ?></a>
                        </li>
                        <li>
                            <a href="out.php?nav=7">выйти</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>