<!DOCTYPE html>
  <html lang="ru">
    <head>
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Аренда авто</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/bootstrap-select.min.css">  

      <script type="text/javascript" src="navbar.js"></script>
    </head>
    <body>
<?php include 'header.php';?>
<?php include 'php/connectDB.php';?>
<?php
  if (isset($_SESSION['login']) && $_SESSION['login'] === 'admin') {
    try {
            $pdo1 = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $query = "SELECT * FROM `user`";
            $result = $pdo1->query($query);
            $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Ошибка при подключении к базе данных!';
        }
    }
    else{
      header ('Location: login.php'); 
      exit();  
  }
?>
<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center text-success">Добавление автомобиля</h3>
              <div class="alert alert-danger hidden" id="success-alert">
                  <div>Ошибка подключения к БД.</div>
            </div>
              </div>
                <div class="modal-body">
                    <form id="myForm" method="post" role="form" name="myForm">
                         <div id="pas" class="form-group has-feedback">
                              <select class="selectpicker show-tick form-control">
                                 <option>1</option>
                                 <option>2</option>
                                 <option>3</option>
                              </select>       
                        </div>
                        <div id="pas" class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>
                                <input type="password" class="form-control" required="required" id="password" value=""  placeholder="Старый пароль">
                            </div>
                        </div>
                        <div id="newPas" class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control" required="required" id="newPassword" value=""  placeholder="Новый пароль">
                            </div>
                        </div>
                        <div id="newPas" class="form-group has-feedback">
                            <div class="input-group">
                               

                                <input type="file"  class="btn btn-success  btn-block" onchange="previewFile()"><br>
                                <img class="imgAdd" src="" height="200" >

                                <!-- <input type="password" class="form-control" required="required" id="newPassword" value=""  placeholder="Новый пароль"> -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="save" type="button" class="btn btn-primary  btn-block">Добавить авто</button>
                    </br>
                    <a class="btn btn-success" data-dismiss="modal" href="markAdd.php">Добавить марку авто</a>
                </div>
            </div>
</div>


<input type="file" onchange="previewFile()"><br>
<img class="imgAdd" src="" height="200" alt="Image preview...">

<?php include 'footer.php';?>
      <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-select.min.js" type="text/javascript"></script>
        
<script>
  $(function() {
        $('#save').click(function() {
          
            var image = $('.imgAdd').attr('src').split(',');
                $.ajax({
                  type: "POST",
                  data: { image: image[1] },
                  url: "php/autoAdd.php",
                  success: function(result) {
                    if (result === "-1") {
                      $('#success-alert').removeClass('hidden');
                    }
                    else if (result === "1"){
                      alert('Данные успешно добавлены!');
                    }
                    else {
                      alert(result);
                    } 
                  }
                });
        });
    });
    </script>
        <script>
        function previewFile() {
       var preview = document.querySelector('.imgAdd');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();     
        reader.onloadend = function () {
          preview.src = reader.result;
        }     

        if (file) {
          reader.readAsDataURL(file);
        } else {
          preview.src = "";
        }
      }
    </script>

   </body>
</html>

