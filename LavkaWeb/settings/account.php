<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Профиль</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/settings.css?<?php echo time();?>">
        <link rel="shortcut icon" href="../images/logo.png?<?php echo time();?>" size="25x25">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <div class="container mt-4">
            <a href="../settings.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <h1 class="main-text">Аккаунт</h1>
            <form action="../php/settings.php" method="post" enctype="multipart/form-data" height="100%">
                <?php
                ini_set('display_errors', 'Off'); 
                    $id = $_COOKIE['id'];
                    $user = $_COOKIE['user'];
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                    $user = $result->fetch_assoc();
                    echo '
                        <div class="logo"><img src="../'. $user['profile_image'] . '?<?php echo time();?>" id="img1" class="logo-image" width="140" height="140"></div>
                        <div><p class="settings-text">Изменить аватарку</p></div>
                        <div class="new-logo" style="margin-bottom: 5px;"><input id="picture" type="file" name="sortpic" accept="image/*,video/*"/></div>';
                    /* if ($user['official'] == 1 || $user['is_teacher'] == 1) {
                        echo '
                        <div><p class="settings-text">Изменить галочку</p></div>
                        <div class="new-logo"><input id="checkmark" type="file" name="sortpic" accept="image/*,video/*"/></div>';
                        <div style="margin-top: 23px; font-size: 0.9em;">
                            <a href="deleteaccount.php" class="settings-button">Удалить аккаунт</a>
                        </div>
                    } */
                    echo '
                        <div><p class="settings-text">Имя</p></div>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Введите новое имя" value="' . $user['name'] . '">
                        <div><p class="settings-text">Email</p></div>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Введите новый email" value="' . $user['email'] . '">
                        <div style="margin-top: 23px; font-size: 0.9em;">
                            <a href="passwordchange.php" class="settings-button">Изменить пароль</a>
                        </div>';
                    echo '
                        <div style="position: absolute; bottom: 4%; width: 95%"> 
                            <div style="display: flex; justify-content: center;">
                                <button class="btn btn-success" type="submit" style="font-size: 1.2em">Сохранить</button>
                            </div>
                        </div>
                        ';
                ?>
            </form>
            <div class="message mt-2" id="message"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="../js/settings/account.js?<?php echo time();?>"></script>
    </body>
</html>
    