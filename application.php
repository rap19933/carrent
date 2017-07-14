<?php
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'carrentdb');
   $password1 ='';
  try {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


            $query = "SELECT `photo`FROM `a` WHERE `id`=12";
            $result = $pdo->query($query);
            $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);      

            if (!empty($resultUser)) {
                $password1 = 'src="data:image/jpeg;base64,'.$resultUser[0]['photo'].'"';
                
            } 
            else echo '0';
    } catch (PDOException $e) {
        echo '-1';
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
      <script type="text/javascript" src="navbar.js"></script>
    </head>
    <body>
<?php include 'header.php';?>
<img class="imgAdd" <?= $password1; ?> height="200" alt="Image preview...">
<?php include 'footer.php';?>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
   </body>
</html>