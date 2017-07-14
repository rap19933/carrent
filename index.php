<!DOCTYPE html>
  <html lang="ru">
    <head>
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Аренда авто</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="css/bootstrap.min.css">
     <!--  <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
      <link rel="stylesheet" href="css/style.css">
          <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
      <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <!-- <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script> -->
    <script type="text/javascript" src="js/moment-with-locales.min.js"></script>
    <!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    

 

      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <!-- <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script> -->
      <script type="text/javascript">  
        $(document).ready(function() {
            $("li").on("click", function() { 
            var id = $(this).attr("id");
            document.cookie = "cookie_navbar=" + id;
            });
        });
      </script>
    </head>
    <body>
<?php include 'header.php';?>

 <main>
        <?php 
          if ($cookie_login === '') 
            echo '<div class="alert alert-danger erLogin">
                    <h4>Для бронирования автомобиля необходимо авторизоваться!</h4>
                </div>';
        ?>

        <div class="container">
            <div class="row">
                <!-- <article class="col-md-8 col-lg-9"></article> -->
                <article class="col-md-9">
                    <h2>Web камера в реальном времени:</h2>
                    <div id="wrap">
                        <div id="main">
                            <p id="status" style="height:1px; color:#c00;font-weight:bold;"></p>
                            <div id="webcam">
                                <span>Web-камера</span>
                            </div>
                        </div>
                    </div>
                </article>
                <aside  class="col-md-3">
                  <div class="row">
                    <h1 class="page-header">Виджет Bootstrap datetimepicker</h1>
                    <h2>datetimepicker1</h2>
                    <div class="form-group">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" class="form-control" />
                            <span class="input-group-addon">
                            <span class="glyphicon-calendar glyphicon"></span>
                            </span>
                        </div>
                    </div>
                    <button id="getDate" class="btn btn-default" title="Получить дату">getDate</button>
                    <button id="show" class="btn btn-default" title="Показать календарь">Show</button>
                    <button id="hide" class="btn btn-default" title="Скрыть календарь">Hide</button>
                    <script type="text/javascript">
                    $(function() {
                    var date = new Date();
                        $('#datetimepicker1').datetimepicker({
                            language: 'ru',
                            pickTime: false,
                            defaultDate: date
                        });
                        $("#getDate").click(function () {
                        alert($('#datetimepicker1').data("DateTimePicker").getDate());
                        });
                         $("#show").click(function () {
                         $('#datetimepicker3').data("DateTimePicker").show();
                        });
                        $("#hide").click(function () {
                          $('#datetimepicker3').data("DateTimePicker").hide();
                        });
                    });
                    </script>
                    </br>
                  </div>  
                </aside >
            </div>
        </div>
</main>

<?php include 'footer.php';?>
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
   </body>
</html>