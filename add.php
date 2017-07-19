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

      <script type="text/javascript" src="js/navbar.js"></script>
    </head>
    <body>
<?php include 'header.php';?>
<?php include 'php/connectDB.php';?>
<?php
  if (isset($_SESSION['login']) && $_SESSION['login'] === 'admin') {
    try {
             $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $query = "SELECT * FROM `mark`";
            $result = $pdo->query($query);
            $resultAuto = $result->fetchAll(PDO::FETCH_ASSOC);
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
           <div id="markAuto" class="form-group">
           <label class="control-label">Выберите марку автомобиля или добавте новую:</label>
              <select class="selectpicker show-tick form-control selectId">
                 <?php
                   if (!empty($resultAuto)) {
                      foreach ($resultAuto as $value) {
                      echo '<option id="'.$value['MarkId'].'">'.$value['Mark'].'</option>';
                      }
                    }
                  ?>   
              </select>       
          </div>
          <div class="form-group has-feedback">
            <input type="text" id="model" class="form-control" required="required" placeholder="Модель автомобиля">
          </div>
          <div class="form-group has-feedback">
            <input type="text" id="number" class="form-control" required="required" placeholder="Гос.номер">
          </div>
          <div class="form-group has-feedback">
            <input type="text" id="releaseData" class="form-control" required="required" placeholder="Год выпуска">
          </div>   
          <div class="form-group has-feedback">
            <input type="text" id="price" class="form-control" required="required" placeholder="Стоимость аренды за сутки">
          </div>                        
          <div class="form-group has-feedback">
            <input type="file"  class="btn btn-success btn-block" onchange="previewFile()">
            <img class="imgAdd" src="" >
          </div>
      </form>
    </div>
    <div class="modal-footer">
      <button id="save" type="button" class="btn btn-primary btn-block">Добавить авто</button>
      </br>
      <a class="btn btn-success" data-dismiss="modal" href="markAdd.php">Добавить марку авто</a>
    </div>
  </div>
</div>

<?php include 'footer.php';?>
      <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/previewFile.js"></script>
      <script src="js/bootstrap-select.min.js" type="text/javascript"></script>
      
      <script>
        $(function() {
              $('#save').click(function() {
                  var selectId = $(".selectId option:selected").attr('id');
                  var image = $('.imgAdd').attr('src');
                  var res = encodeURIComponent(image);
                  var dataString = 'selectId=' + selectId
                  + '&model=' + $("#model").val()
                  + '&number=' + $("#number").val()
                  + '&releaseData=' + $("#releaseData").val()
                  + '&price=' + $("#price").val()
                  + '&image=' + res;
                      $.ajax({
                        type: "POST",
                        data: dataString,
                        url: "php/autoAdd.php",
                        success: function(result) {
                          if (result === "3") {
                            $('.has-feedback').addClass('has-error');
                          }
                          else if (result === "1"){
                            alert('Данные успешно добавлены!');
                          }
                          else if (result === "-1"){
                              $('#success-alert').removeClass('hidden');
                          } 
                          else {
                            alert(result);
                          } 
                        }
                      });
              });
        });
      </script>
   </body>
</html>

