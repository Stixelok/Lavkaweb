<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Активация</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" href="css/teachers.css?<?php echo time();?>">
        <link rel="stylesheet" href="css/search.css?<?php echo time();?>">
    </head>
    <body>
    <ul class="menu">
            <li>
                <a href="index.php" style="-webkit-tap-highlight-color: transparent;">
                    <ion-icon name="caret-back-circle-outline" style="position: absolute; margin:0; top: 30px; left: 20px"></ion-icon>
                </a>
            </li>
            <li>
                <h1 style="text-align: center; margin-top: 30px; margin-left: 15px; margin-right: 15px; margin-bottom: 15px; font-size: 36px">Активация</h1>
            </li>
        </ul>
        <div class="teachers">
                <?php
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '" . $_GET['id']. "' AND `login` = '" . $_GET['login'] . "'");
                    $user = $result->fetch_assoc();
                    if ($user != null && $_GET['check'] == md5($user['id']."actwof1580".$user['password']) && $user['email'] != '' && $_GET['email'] == md5($user['email'])) {
                        $id = $user['id'];
                        $mysql->query("UPDATE `users` SET `activated` = 1 WHERE `id` = '$id'");
                        echo '
                            <p style="margin-top: 14px; font-size: 22px; text-align: center;">Ваш аккаунт успешно активирован! <br><br></p>
                            <p style="margin-top: 2px; font-size: 17px; text-align: center;">Эту страницу можно закрыть.</p>
                        ';
                    } else {
                        echo '
                            <p style="margin-bottom: 10px; font-size: 18px">Ошибка активации аккаунта. Повторите попытку активировать аккаунт через ссылку из нового письма. <br><br>Эту вкладку можно закрыть.</p>
                        ';
                    }
                ?>
            <div class="message mt-2" id="message"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="js/activate.js?<?php echo time();?>"></script>
    </body>
</html>