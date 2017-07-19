<?php include 'php/connectDB.php';?>
<?php

    if (isset($_POST['rent'])) {
      $myExplode = explode("-", $_POST['rent']);
      $myData = explode(".", $myExplode[1]);
      $myDataStart = $myData[2].'-'.$myData[1].'-'.$myData[0];
      $date = date_create_from_format('Y-m-d', $myDataStart);
      $date = ($date->modify('+1 day'));
      $myDataStartFrom = $date->format('Y-m-d');
      $date = ($date->modify('+7 day'));
      $myDataStartTo = $date->format('Y-m-d');
        try {
                $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $query = "SELECT `DataStart` FROM `reservation` WHERE `AutoId` = '$myExplode[0]'";

                $result = $pdo->query($query);
                $resultRent = $result->fetchAll(PDO::FETCH_ASSOC);
                $queryAuto = "SELECT `auto`.`AutoId`, `Model`, `Price`, `Number`, `ReleaseData`, `mark`.`Mark` 
                FROM `auto` INNER JOIN `mark` ON `auto`.`MarkId` = `mark`.`MarkId` WHERE `AutoId` = '$myExplode[0]'";
                $result1 = $pdo->query($queryAuto);
                $resultAuto = $result1->fetchAll(PDO::FETCH_ASSOC);
            } 
        catch (PDOException $e) 
        {
           echo 'Ошибка при подключении к базе данных!';
        }
    }
    else {
     header ('Location: index.php');
    }
?>
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
      <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
            <script type="text/javascript" src="js/navbar.js"></script>
    </head>
    <body>
<?php include 'header.php';?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center text-primary AutoId" id="<?=$resultAuto[0]['AutoId']?>"><?php echo 'Форма бронирования "'.$resultAuto[0]['Mark'].': '.$resultAuto[0]['Model'].'"'; ?></h3>
                    <h4 class="text-center text-primary"><?php echo $resultAuto[0]['ReleaseData'].' года выпуска с номером "'.$resultAuto[0]['Number'].'" по цене='.$resultAuto[0]['Price'].'руб.'; ?></h4>
                    <div class="alert alert-danger hidden" id="success-alert">
                          <div>Ошибка подключения к БД.</div>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="post" role="form" name="myForm" action="index.php">
                        <div id="markAuto" class="form-group">
                         <label class="control-label"><h4>Выберите на сколько дней арендуете авто:</h4></label>
                         <div class="btn-toolbar">
                          <div class="btn-group">
                            <a class="btn btn-warning dataStart" id="<?= $myDataStart; ?>">Срок аренды с <?= $myDataStart; ?> до </a>
                          </div>

                          <div class="btn-group">
                            <select class="selectpicker btn-warning show-tick form-control selectId">
                               <?php
                                  $start = new DateTime($myDataStartFrom);
                                  $interval = new DateInterval('P1D');
                                  $end = new DateTime($myDataStartTo);
                                  $period = new DatePeriod($start, $interval, $end);  
                                  $i = 1;  
                                  $day;
                                  if (empty($resultRent)) {
                                    foreach ($period as $date) {
                                      if($i == 1) {
                                        $day = 'день';
                                      }
                                      else if ($i == 2 || $i == 3 || $i == 4) {
                                        $day = 'дня';
                                      }
                                      else $day = 'дней';
                                      echo '<option id="'.$date->format('Y-m-d').'i'.$i.'">'.$date->format('Y-m-d').'  на '.$i.' '.$day. '</option>';
                                      $i++;
                                    }    
                                  }
                                  else {
                                    foreach ($period as $date) {
                                      if ($date->format('Y-m-d') === $resultRent[0]['DataStart']) {
                                         echo '<option id="'.$date->format('Y-m-d').'i'.$i.'">'.$date->format('Y-m-d').'  на '.$i.' '.$day. '</option>';
                                        break;
                                      }
                                      if($i == 1) {
                                        $day = 'день';
                                      }
                                      else if ($i == 2 || $i == 3 || $i == 4) {
                                        $day = 'дня';
                                      }
                                      else $day = 'дней';
                                      echo '<option id="'.$date->format('Y-m-d').'i'.$i.'">'.$date->format('Y-m-d').'  на '.$i.' '.$day. '</option>';
                                      $i++;
                                    }    
                                  }
                                ?>   
                            </select>     
                          </div>

                        </div>    
                        </div>
                        <div id="name" class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="name1" type="text" class="form-control" required="required" placeholder="Имя">
                            </div>
                        </div>

                        <div id="number" class="form-group has-feedback">
                          <div class="input-group">
                           <span class="input-group-addon "><i class="glyphicon glyphicon-phone"></i></span>
                              <div class="btn-toolbar">
                                <div class="btn-group">
                                    <select id="country" class="form-control">
                                      <option value="ru">Россия +7</option>
                                      <option value="ua">Украина +380</option>
                                      <option value="by">Белоруссия +375</option>
                                    </select>
                                </div>
                                <div class="btn-group">
                                    <input id="phone" type="text" class="form-control" required="required" placeholder="Номер телефона">
                                </div>
                              </div> 
                          </div>   
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                     <button id="rent" type="submit" type="button" class="btn btn-primary  btn-block">Забронировать</button>
                </div>
            </div>
        </div>


<?php include 'footer.php';?>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
     
    <script type="text/javascript">
      $(function() {
            $('#rent').click(function() {
                var selectId = $(".selectId option:selected").attr('id').split('i');
                var res = encodeURIComponent($("#phone").val());
                var dataString = 'selectId=' + selectId[0]
                + '&dataStart=' + $(".dataStart").attr('id')
                + '&days=' + selectId[1]
                + '&autoId=' + $(".AutoId").attr('id')
                + '&name=' + $("#name1").val()
                + '&phone=' + res;
                    $.ajax({
                      type: "POST",
                      data: dataString,
                      url: "php/reservationAdd.php",
                      success: function(result) {
                        if (result === "-1") {
                          $('.has-feedback').addClass('has-error');
                        }
                        else if (result === "1"){
                          alert('Бронирование прошло успешно!');
                        }
                        else if (result === "-2"){
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
    <script type="text/javascript">
         $(function() {
            function maskPhone() {
              var country = $('#country option:selected').val();
              switch (country) {
                case "ru":
                  $("#phone").mask("+7(999) 999-99-99");
                  break;
                case "ua":
                  $("#phone").mask("+380(999) 999-99-99");
                  break;
                case "by":
                  $("#phone").mask("+375(999) 999-99-99");
                  break;          
              }    
            }
            maskPhone();
            $('#country').change(function() {
              maskPhone();
            });
          });
    </script>
   </body>
</html>