<footer>
    <div>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-5 col-md-6 fontSize yearMy">
                        <p>
                            &copy; 2017
                            <?php
                            if (date("Y") > 2017):?>
                                - <?=date("Y")?>
                            <?php endif;?>
                            – приложение PHP
                        </p>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-3 fontSize">
                        Наши контакты в соцсетях:
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-3 footerImg">
                        <a href="https://vk.com/id82503326" target="_blank"><img src="img/vk1.png" height="40"
                                                                                 width="40" class="rightpic"></a>
                        <a href="https://www.facebook.com/profile.php?id=100009189670477" target="_blank"><img
                                    src="img/facebook1.png" height="40" width="40" class="rightpic"> </a>
                        <a href="https://ok.ru/" target="_blank"><img src="img/ok1.png" height="40" width="40"
                                                                      class="rightpic"></a>
                        <a href="https://plus.google.com/u/0/116169514578819969331" target="_blank"><img
                                    src="img/google_plus1.png" height="40" width="40" class="rightpic"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
if ($navId != 1): ?>
    <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<?php endif; ?>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
