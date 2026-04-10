<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Безопасность сообщества</title>
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
            $result = $mysql->query("SELECT * FROM `user_rights` WHERE `community_id` = '$id'");
            $admins = $result->fetch_all();
            echo '
            <div class="container mt-5" style="margin-top: 32px!important;">
                <a href="../communitysettings.php?id=' . $id . '" style="position: absolute; top: 30px; left: 20px;">
                    <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
                </a>';
            if ($user_right['rights_type'] == 1) {
            echo '
                <a href="newadmin.php?id=' . $id . '" style="position: absolute; top: 34px; right: 20px;">
                    <ion-icon name="add-outline" class="return" style="font-size: 34px;"></ion-icon>
                </a>';
            }
            echo '
                <h1 class="main-text" style="margin-bottom: 16px;">Админы</h1>
                <hr>
                <div class="users">
            ';
            foreach ($admins as $admin) {
                $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '" . $admin[1] . "'");
                $user = $result->fetch_assoc();
                if ($user['id'] == $_COOKIE['id']) {
                    echo '<a href="../userprofile.php" style="-webkit-tap-highlight-color: transparent;">';
                } else {
                    echo '<a href="../userpage.php?id=' . $user['id'] . '" style="-webkit-tap-highlight-color: transparent;">';
                }
                echo '
                <div class="user">
                    <ul>
                        <li>
                            <img src="../' . $user['profile_image'] . '" width="60" height="60" class="user-image">
                        </li>
                        <li>
                            <p class="user-name">' . $user['name'] . '</p>
                        </li>';
                if ($admin[2] == 1) {
                    echo '
                    <li>
                        <p class="admin-text">Владелец сообщества</p>
                    </li>';
                } else {
                    echo '
                    <li>
                        <p class="admin-text">Администратор</p>
                    </li>';
                }
                echo '
                    </ul>
                </div>';
            }
    ?>