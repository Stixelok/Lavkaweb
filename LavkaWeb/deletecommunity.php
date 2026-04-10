<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Удаление сообщества</title>
        <link rel="shortcut icon" href="../images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/settings.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <?php // Проверка входа
            $id = $_GET['id'];
            $userid = $_COOKIE['id'];
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `user_rights` WHERE `community_id` = '$id' AND `user_id` = '$userid'");
            $user_right = $result->fetch_assoc();
            $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$id'");
            $community = $result->fetch_assoc();
            if ($user_right == Array()) {
                header("Location: /../community.php?id=$id");
            } if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /../login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /../login.html");
            }
            echo '
            <div class="container mt-4">
                <a href="../communitysettings.php?id=' . $community['id'] . '">
                    <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
                </a>
                <form action="../php/settings.php" method="post" enctype="multipart/form-data" height="100%">
                <h1 class="main-text">Удаление сообщества</h1>
                <div class="logo"><img src="../'. $community['profile_image'] . '?<?php echo time();?>" id="img1" class="logo-image" width="140" height="140"></div>
                <div><p class="settings-text" style="font-size: 1.05em">Чтобы подтвердить, что вы хотите <b>удалить</b> сообщество <b>' . $community['name'] . '</b>, пожалуйста введите <b>пароль</b> от вашего аккаунта.</p></div>
                <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль"><br>
                <div style="position: absolute; bottom: 4%; width: 95%"> 
                    <div style="display: flex; justify-content: center;">
                        <button class="btn btn-success logout-link" type="submit" id="delete" style="font-size: 1.3em">Удалить</button>
                    </div>
                </div>
                </form>
            ';
            ?>
            </form>
            <div class="message mt-2" id="message"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="../js/deletecommunity.js?<?php echo time();?>"></script>
    </body>
</html>
