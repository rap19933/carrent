<?php include 'php/connectDB.php';?>
<?php
  session_start();
  if ($_SESSION['login'] === 'admin') {
    try {
             $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      $query = "SELECT `user`.`Login`, `Name`, `PhoneNumber`, `DataStart`, `DataEnd`,`mark`.`Mark`, `auto`.`Model`,`auto`.`Price` 
            FROM `reservation` 
            INNER JOIN `user` ON `reservation`.`UserId`=`user`.`UserId`
             INNER JOIN `auto` ON `reservation`.`AutoId`=`auto`.`AutoId`
              INNER JOIN `mark` ON `auto`.`MarkId`=`mark`.`MarkId`
               ORDER BY `reservation`.`DataStart` ASC";
            $result = $pdo->query($query);
            $resultRent = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Ошибка при подключении к базе данных!';
        }
   }
    else{
      header ('Location: login.php'); 
      exit();  
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
<div class="container">
    <div class="row">
        <table class="table table-hover tablica">
            <caption>Список заявок</caption>
                <thead>
                    <tr class="mycolor">
                        <th>Логин</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Дата от</th>
                        <th>Дата до</th>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    if (!empty($resultRent))
                    {
                      foreach ($resultRent as $value)
                      {
                        echo '<tr><td>'.$value['Login'].'</td>';
                        echo '<td>'.$value['Name'].'</td>';
                        echo '<td>'.$value['PhoneNumber'].'</td>';
                        echo '<td>'.$value['DataStart'].'</td>';
                        echo '<td>'.$value['DataEnd'].'</td>';
                        echo '<td>'.$value['Mark'].'</td>';
                        echo '<td>'.$value['Model'].'</td>';
                        echo '<td>'.$value['Price'].'</td>';
                        if (empty($value['DataEnd'])) {
                          echo '<td>'.$value['Price'].'</td>';
                        }
                        else{
                          $start = new DateTime($value['DataStart']);
                          $interval = new DateInterval('P1D');
                          $end = new DateTime($value['DataEnd']);
                          $period = new DatePeriod($start, $interval, $end); 
                          $i = 0;   
                          foreach ($period as $date) {
                                $i++;  
                          }  
                          echo '<td>'.$value['Price'] * $i.'</td>';  
                        }
                        echo '</tr>'; 
                      }
                    }
                  ?>   
                </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php';?>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
   </body>
</html>