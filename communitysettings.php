<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Настройки сообщества</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/settings.css?<?php echo time();?>">
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
                header("Location: /community.php?id=$id");
            } if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /login.html");
            }
            echo '
        <div class="container mt-4">
            <a href="community.php?id=' . $id . '">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>';
            echo '
                <div class="logo"><img src="'. $community['profile_image'] . '?<?php echo time();?>" class="logo-image" width="140" height="140"></div>
                <h1 class="main-text">' . $community['name'] . '</h1>
                <a href="settings/communityaccount.php?id=' . $community['id'] . '">
                    <div class="settings-tab">
                        <ul>
                            <li>
                                <ion-icon name="person-outline" class="settings-icon"></ion-icon>
                            </li>
                            <li>
                                <p>Аккаунт</p>
                            </li>
                        </ul>
                    </div>
                </a>
                <hr>
                <a href="settings/communityprivate.php?id=' . $community['id'] . '">
                    <div class="settings-tab">
                        <ul>
                            <li>
                                <ion-icon name="lock-closed-outline" class="settings-icon"></ion-icon>
                            </li>
                            <li>
                                <p>Приватность</p>
                            </li>
                        </ul>
                    </div>
                </a>
                <hr>
                <a href="settings/communitysecurity.php?id=' . $community['id'] . '">
                    <div class="settings-tab">
                        <ul>
                            <li>
                                <ion-icon name="finger-print-outline" class="settings-icon"></ion-icon>
                            </li>
                            <li>
                                <p>Безопасность</p>
                            </li>
                        </ul>
                    </div>
                </a>
                <hr>
            </div>
            <div class="message mt-2" id="message"></div>';
        if ($user_right['rights_type'] == 1) {
            echo '
            <div style="position: absolute; bottom: 4%; width: 100%; margin: 0;">
                <div style="display: flex; justify-content: center;">
                    <button class="logout-link" id="deletebutton" style="border: 0px;">Удалить сообщество</button>
                </div>
            </div>
            ';    
        }        
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/settings/communitysettings.js?<?php echo time();?>"></script>
    </body>
</html>