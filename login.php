<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include 'header.php';?>

    <!-- Модальное окно -->
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
              		  <h3 class="text-center text-primary">Авторизация</h3>
			        <div class="alert alert-danger hidden" id="success-alert">
			            <div>Ошибка подключения к БД.</div>
			   		</div>
            	</div>
                <!-- Основная часть модального окна, содержащая форму для регистрации -->
                <div class="modal-body">
                    <!-- Форма для регистрации -->
                    <form id="myForm" method="post" role="form" name="myForm">
                        <!-- Блок для ввода логина -->
                        <div id="log" class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" required="required" id="login" pattern="&#91;A-Za-z&#93;{6,}" value="" placeholder="Логин">
                            </div>
                        </div>
                        <!-- Блок для ввода пароля -->
                        <div id="pas" class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control" required="required" id="password" value=""  placeholder="Пароль">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Нижняя часть модального окна -->
                <div class="modal-footer">
                     <button id="register" type="button" class="btn btn-primary  btn-block">Войти</button>
                     </br>
                	 <a class="btn btn-success" data-dismiss="modal" href="register.php">Регистрация</a>
                </div>
            </div>
        </div>
<?php include 'footer.php';?>
    <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script>
	$(function() {
        $('#register').click(function() {
            var login = $("#login").val();
            var password = $("#password").val();
			var dataString = 'login=' + login + '&password=' + password;
            $.ajax({
                type: "POST",
                url: "php/loginTest.php",
                data: dataString,
                success: function(result) {
                    if (result === "0") {
						$('#log').addClass('has-error');
 						$('#pas').addClass('has-error');
                    }
                    else if (result === "1"){
                    	document.cookie = "cookie_navbar=1";
                    	document.location.replace("index.php");
                    }
                    else if (result === "2"){
                    	$('#log').removeClass('has-error');
                    	$('#log').addClass('has-success');
 						$('#pas').addClass('has-error');
                    }
                    else {
                        $('#success-alert').removeClass('hidden');
                    	alert("-1");
                    }	
                }
            });
        });
    });
    </script>
   </body>
</html>