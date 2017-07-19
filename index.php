<?php include 'php/connectDB.php';?>
<?php
session_start();
    $myData;
    $myDataJS;
    if (isset($_POST['myData'])) {
      $myExplode = explode(".", $_POST['dateIn']);
      $myData = $myExplode[2].'-'.$myExplode[1].'-'.$myExplode[0];
      $_SESSION['dataCookie'] = $_POST['dateIn'];
      $myDataJS = $_POST['dateIn'];
    }
    else {
      $myData = date('Y-m-d');
      $myDataJS = date('d.m.Y');
      unset($_SESSION['dataCookie']);
    }


    try {
      $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      
      $queryDel = "SELECT `ReservationId`, `DataStart`, `DataEnd` FROM `reservation` ORDER BY `DataStart` ASC";
      $resultDel = $pdo->query($queryDel);
      $resultRentDel = $resultDel->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($resultRentDel)){
          $datetime2 = date('Y-m-d');
          foreach ($resultRentDel as $value){   
            if (!empty($value['DataEnd'])){           
              if (strtotime($value['DataEnd'])<=strtotime($datetime2)) {
                $del = $value['ReservationId'];
                $queryd = "DELETE FROM `reservation` WHERE `ReservationId`='$del'";
                $resultd = $pdo->exec($queryd);
              }   
            }
            else{
              if (strtotime($value['DataStart'])<strtotime($datetime2)) {
                $del = $value['ReservationId'];
                $queryd = "DELETE FROM `reservation` WHERE `ReservationId`='$del'";
                $resultd = $pdo->exec($queryd);
              }
            }
          }
        }

      $query = "SELECT `auto`.`AutoId`, `Model`, `Price`, `Photo`, `mark`.`Mark`, `reservation`.`DataStart`, `reservation`.`DataEnd` FROM `auto` INNER JOIN `mark` ON `auto`.`MarkId` = `mark`.`MarkId` LEFT JOIN `reservation` ON `auto`.`ReservationId` = `reservation`.`ReservationId`";
      $result = $pdo->query($query);
      $resultAuto = $result->fetchAll(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) {
       echo 'Ошибка при подключении к базе данных!';
    }
?>
<!DOCTYPE html>
  <html lang="ru">
    <head>
      
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Аренда авто</title>

      <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
          
      <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
      <script type="text/javascript" src="js/moment-with-locales.min.js"></script>
      <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
      <script type="text/javascript" src="js/navbar.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>

    </head>
    <body>
<?php include 'header.php';?>
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <div class="modal-title">Просмотр изображения</div>
      </div>
      <div class="modal-body">
        <img class="img-responsive center-block" src="" alt="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
  <main>
        <?php 
          if ($cookie_login === '') 
            echo '<div class="alert alert-danger erLogin">
                    <h4>Для бронирования автомобиля необходимо авторизоваться!</h4>
                </div>';
        ?>
        <div class="container">
            <div class="row">
                <aside  class="col-sm-3 col-md-3">
                  <div class="row">
                   <h3>Подобрать авто по дате</h3>
                    <form name="myData" method="post" action="index.php">
                      <div class="form-group">
                        <div class="input-group date" id="datetimepicker">
                          <input type="text" class="form-control" name="dateIn" value="<?="$myDataJS"?>"/>
                            <span class="input-group-addon">
                              <span class="glyphicon-calendar glyphicon"></span>
                            </span>
                        </div>
                      </div>
                      <input type="submit" class="btn btn-default" name="myData" value="Отобразить авто" />
                    </form>
                    </br>
                  </div>  
                </aside >
                <article class="col-sm-9 col-md-9">
                  <div class="row">
                    <form name="myData" method="post" action="reservation.php">
                     
                      <?php
                      if (!empty($resultAuto)){
                        foreach ($resultAuto as $value){ 
                          $showAuto = true; 
                          if (empty($value['DataStart'])){
                              $showAuto = true; 
                          }
                          else if (!empty($value['DataStart']) && empty($value['DataEnd'])) {
                              if($value['DataStart'] === $myData)
                              {
                                $showAuto = false; 
                              }
                          }
                          else{
                              $start = new DateTime($value['DataStart']);
                              $interval = new DateInterval('P1D');
                              $end = new DateTime($value['DataEnd']);
                              $period = new DatePeriod($start, $interval, $end);    
                                foreach ($period as $date) {
                                    if($date->format('Y-m-d') === $myData){
                                      $showAuto = false; 
                                    } 
                                }    
                          }
                          if ($showAuto){
                                echo '<div class="col-sm-6 col-md-4">';
                                 echo '<div class="thumbnail photo">';
                                   echo '<img class="photo" src="'.$value['Photo'].'" alt="'.$value['Model'].'">';
                                    echo '<div class="caption">';
                                      echo '<h2>'.$value['Mark'].'-'.$value['Model'].'</h2>';
                                        echo '<p>Цена: '.$value['Price'].'руб.</p>';
                                         if ($cookie_login !== '')
                                          echo '<button type="submit" class="btn btn-primary" name="rent" value="'.$value['AutoId'].'-'.$myDataJS.'"> Оформить бронь</button>';
                                echo '</div></div></div>';
                          }
                        }
                      }
                      ?>  
                    </form>
                  </div>                    
                </article>   
            </div>
        </div>
</main>

<?php include 'footer.php';?>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(function() {     
        $('.thumbnail img').click(function(e) {
          e.preventDefault();
          $('#image-modal .modal-body img').attr('src', $(this).attr('src'));
          $("#image-modal").modal('show');
        });
      $('#image-modal .modal-body img').on('click', function() {
        $("#image-modal").modal('hide');
      });
    });   
    </script>

    <script type="text/javascript">
      $(function() {
        $('#datetimepicker').datetimepicker({
          language: 'ru',
          pickTime: false,
        });
        $("#getDate").click(function () {
          alert($('#datetimepicker').data("DateTimePicker").getDate());
        });
      });
    </script>
   </body>
</html>