<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Создать сообщество</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/newcommunity.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <div class="container mt-4">
            <a href="communities.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <h1>Новое сообщество</h1>
            <form action="php/newcommunity.php" method="post" enctype="multipart/form-data">
                <div class="logo"><img src="images/defaultuserimage.jpg?<?php echo time();?>" id="img1" class="logo-image" width="140" height="140"></div>
                <div><p class="settings-text">Поставить аватарку</p></div>
                <div class="new-logo"><input id="picture" type="file" name="sortpic" accept="image/*,video/*"/></div>
                <input type="text" class="form-control" name="name" id="name" placeholder="Придумайте название"><br>
                <input type="text" class="form-control" name="bio" id="bio" placeholder="Придумайте описание"><br>
                <?php // Проверка входа
                    if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                        echo '
                        <div class="message mt-3" style="text-align:center;">Вы не вошли в свой аккаунт.</div>
                        <div class="button-container">
                            <a href="login.php" class="button btn btn-success" style="margin-top: 10px;">Войти</a>        
                        </div>
                        ';
                    } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                        echo '
                        <div class="message mt-3" style="text-align:center;">Вы не вошли в свой аккаунт.</div>
                        <div class="button-container">
                            <a href="login.php" class="button btn btn-success" style="margin-top: 10px;">Войти</a>        
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="button-container">
                            <button id="upload" class="button btn btn-success" type="submit">Создать</button>
                        </div>
                        ';
                    }
                ?>
            </form>
            <div class="message mt-3"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="js/newcommunity.js?<?php echo time();?>"></script>
    </body>
</html>