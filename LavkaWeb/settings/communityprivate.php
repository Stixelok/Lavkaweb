<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Приватность сообщества</title>
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
        <h1 class="main-text">Приватность</h1>
            <hr>
            <div style="position:relative; margin-top: 8px">
            ';
            if ($community['subscribers_hide'] == 0) {
                echo '
                <ul class="set-container">
                    <li>
                        <p class="slider-header">Скрыть подписчиков сообщества</p>
                    </li>
                    <li>
                        <div class="slider-container">
                            <label class="switch" for="subscribers-hide">
                                <input type="checkbox" id="subscribers-hide" />
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </li>
                    <li>
                        <p class="slider-text">Когда эта функция включена, подписчиков смогут увидеть лишь админы сообщества. По умолчании их видят все пользователи.</p>
                    </li>
                </ul>
                ';
            } else {
                echo '
                <ul class="set-container">
                    <li>
                        <p class="slider-header">Скрыть подписчиков сообщества</p>
                    </li>
                    <li>
                        <div class="slider-container">
                            <label class="switch" for="subscribers-hide">
                                <input type="checkbox" id="subscribers-hide" checked="checked"/>
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </li>
                    <li>
                        <p class="slider-text">Когда эта функция включена, подписчиков смогут увидеть лишь админы сообщества. По умолчании их видят все пользователи.</p>
                    </li>
                </ul>
                ';
            }
            echo '
            </div>';
        ?>
    <div class="message mt-2" id="message"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/settings/communityprivate.js?<?php echo time();?>"></script>
    </body>
</html>
