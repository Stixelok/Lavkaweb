<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Сброс пароль</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/passwordchange.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <div class="container mt-4">
            <a href="index.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <h1>Сбросить пароль</h1>
            <form method="post">
                <?php
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '" . $_GET['id']. "' AND `login` = '" . $_GET['login'] . "'");
                    $user = $result->fetch_assoc();
                    if ($user != null && $_GET['check'] == md5($user['id']."actwof1580".$user['password']) && $user['email'] != '') {
                        echo '
                            <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Придумайте новый пароль"><br>
                            <input type="password" class="form-control" name="repeat-password" id="repeat-password" placeholder="Повторите новый пароль"><br>
                            <div style="text-align: center; margin-top: 10px;">
                                <button class="button btn btn-success" type="submit">Изменить пароль</button>
                            </div>
                        ';
                    } else {
                        echo '
                            <p style="margin-bottom: 10px; font-size: 18px">Ошибка сброса пароля. Повторите попытку сбросить пароль через ссылку из нового письма. <br><br>Эту вкладку можно закрыть.</p>
                        ';
                    }
                    echo '
            </form>
            <div class="message mt-3" style="text-align: center;"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>';
        if ($user != null && $_GET['check'] == md5($user['id']."actwof1580".$user['password']) && $user['email'] != '') {
            echo '<script src="../js/passwordreset.js?<?php echo time();?>"></script>';
        }
        ?>
    </body>
</html>