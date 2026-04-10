<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Настройки сообщества</title>
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
                <h1 class="main-text">Настройки сообщества</h1>
                <form action="../php/settings.php" method="post" enctype="multipart/form-data" height="100%">
                <div class="logo"><img src="../'. $community['profile_image'] . '?<?php echo time();?>" id="img1" class="logo-image" width="140" height="140"></div>
                <div><p class="settings-text">Изменить аватарку</p></div>
                <div class="new-logo"><input id="picture" type="file" name="sortpic" accept="image/*,video/*"/></div>
                <div><p class="settings-text">Изменить имя</p></div>
                <input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Введите новое имя" value="' . $community['name'] . '">
                <div><p class="settings-text mt-3">Изменить описание</p></div>
                <input type="text" class="form-control" name="bio" id="bio" placeholder="Введите новое описание" value="' . $community['bio'] . '">
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
        <script type="text/javascript" src="../js/settings/communityaccount.js?<?php echo time();?>"></script>
    </body>
</html>
