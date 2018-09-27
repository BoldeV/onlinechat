<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <?php 
        if ($this->route['action'] == 'register') {
            echo $content;
            ?> 
            <script src="/public/js/script.js"></script>
            <?php
        } else {
    ?>

        <header class="header">
            <div class="container-header">
                <div class="header__name"><?php echo $_COOKIE['name']['name']; ?></div>
                <a href="../main/logout" class="btn header__logout">Выход</a>
            </div>
        </header>

        <?php 
            echo $content;
        ?>
           
         <footer class="footer">
             <div class="container-footer">
                <div class="footer__name"><span>©2018</span>Boldakov</div>
                <div class="socials">
                    <a class="social" href="https://vk.com/vladik_stane" target="_blank">
                        <i class="fa fa-vk" aria-hidden="true"></i>
                    </a>
                    <a class="social" href="https://github.com/BoldeV" target="_blank">
                        <i class="fa fa-github" aria-hidden="true"></i>
                    </a>
                    <a class="social" href="#">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
         </footer>
         <script src="/public/js/ajax.js"></script>
         <script src="/public/js/like.js"></script>
         <script src="/public/js/send.js"></script>

    <?php } ?>

</body>
</html>