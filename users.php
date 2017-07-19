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
<?php include 'php/connectDB.php';?>
<?php
	if (isset($_SESSION['login']) && $_SESSION['login'] === 'admin') {
		try {
		        $pdo1 = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $query = "SELECT * FROM `user`";
            $result = $pdo1->query($query);
            $resultUser = $result->fetchAll(PDO::FETCH_ASSOC);
		    }
    catch (PDOException $e) {
		  echo 'Ошибка при подключении к базе данных!';
		}
  }
  else{
    header ('Location: login.php'); 
    exit();  
	}
?>

<div class="container">
    <div class="row">
        <table class="table table-hover tablica">
            <caption>Список пользовательских учеток</caption>
                <thead>
                    <tr class="mycolor">
                        <th>Логин</th>
                        <th>Email</th>
                        <th>Пароль</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                  if (!empty($resultUser))
                  {
             				foreach ($resultUser as $value){
            			 		echo '<tr><td>'.$value['Login'].'</td>';
            			 		echo '<td>'.$value['Email'].'</td>';
            			 		echo '<td>'.$value['Password'].'</td>';
            			 		if ($value['Login'] != 'admin') 
                				echo '<td>
                					<div class="form-actions no-color">	
                					  <a class="btn btn-danger row-remove"  id="'.$value['UserId'].'">Удалить</a>
                					</div>
                					</td>';
                			else echo '<td></td>';		
         					  }
         					  echo '</tr>';	
                  }
                ?>   
                </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php';?>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
	      $(function() {
      		$(document).ready(function() {
            $('.row-remove').click(function(e) {
              var user = 'id=' + $(this).attr('id');
              e.preventDefault();
      				$(this).closest('tr').remove(); 
      	        $.ajax({
      	          type: "POST",
      	          url: "php/deleteUser.php",
      	          data: user,
      	            success: function(result) {
      	              if (result !== "1") {
      	                alert ('Ошибка удаления');
      	        				document.location.replace("users.php");	
      	        			}		
      	            }
      	        });
            });
         	});
        });
    </script>
   </body>
</html>