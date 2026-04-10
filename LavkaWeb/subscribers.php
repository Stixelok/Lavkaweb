<!DOCTYPE html>
<html>
    <head>
        <title>Подписчики</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/subscribers.css?<?php echo time();?>">
    </head>
    <body>      
        <ul class="search-list">
            <li>
            <?php
            ini_set('display_errors', 'Off');
                $backlink = "";
                $iscommunity = $_GET['is_community'];
                if (@$_SERVER['HTTP_REFERER'] != null) {
                    $backlink = $_SERVER['HTTP_REFERER'];
                } else {                        
                    $backlink = "index.php";
                } 
                if ($_COOKIE['id'] == $_GET['id'] && $iscommunity != 1) {
                    $backlink = "userprofile.php";
                } else if (((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] == $backlink) {
                    $backlink = "index.php";
                }
                echo '
                <a href="' . $backlink . '" style="-webkit-tap-highlight-color: transparent;">
                    <ion-icon name="caret-back-circle-outline" style="color: black;"></ion-icon>
                </a>  
                ';
            ?>
            </li>
            <div class="main-title">
                <li>
                    <h1>Подписчики</h1>
                </li>
            </div>
        </ul>
        <hr>
        <div class="users" id="users">
            <?php 
                ini_set('display_errors', 'Off');
                $id = $_GET['id'];
                $userid = $_COOKIE['id'];
                $iscommunity = $_GET['is_community'];
                $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                $result = $mysql->query("SELECT * FROM `user_rights` WHERE `community_id` = '$id' AND `user_id` = '$userid'");
                $user_right = $result->fetch_assoc();
                $result = null;
                if ($iscommunity == 1) {
                    $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$id'");
                } else {
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                }
                $user = $result->fetch_assoc();
                if ($user == Array()) {
                    echo '<p style="color: black; text-align: center;">Такого пользователя не существует.</p>';
                } else if ($user['subscribers_hide'] == 1 && $user['id'] != $_COOKIE['id'] && $user_right == []) {
                    if ($iscommunity != 1) {
                        echo '<p style="color: black; text-align: center;">Пользователь скрыл своих подписчиков.</p>';
                    } else {
                        echo '<p style="color: black; text-align: center;">Подписчики сообщества скрыты.</p>';
                    }
                } else {
                    $result = null;
                    if ($iscommunity == 1) {
                        $result = $mysql->query("SELECT * FROM `subscribers` WHERE `creator_id` = '$id' AND `type` = 2");
                    } else {
                        $result = $mysql->query("SELECT * FROM `subscribers` WHERE `creator_id` = '$id' AND `type` = 1");
                    }
                    $subscribers = $result->fetch_all();
                    if (count($subscribers) != $user['subscribers']) {
                        $user['subscribers'] = count($subscribers);
                        if ($iscommunity == 1) {
                            $mysql->query("UPDATE `communities` SET `subscribers` = '" . count($subscribers) . "' WHERE `id` = '$id'");
                        } else {
                            $mysql->query("UPDATE `users` SET `subscribers` = '" . count($subscribers) . "' WHERE `id` = '$id'");
                        }
                    }
                    if ($subscribers == []) {
                        if ($iscommunity == 1) {
                            echo '<p style="color: black; text-align: center;">Похоже на сообщество пока никто не подписался.</p>';
                        } else if ($_COOKIE['id'] == $_GET['id']) {
                            echo '<p style="color: black; text-align: center;">Похоже на вас пока никто не подписался.</p>';
                        } else {
                            echo '<p style="color: black; text-align: center;">Похоже на ' . $user['name'] . ' пока никто не подписался.</p>';
                        }
                    } else {
                        foreach ($subscribers as $subscriber) {
                            $subscriber_id = $subscriber[1];
                            $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$subscriber_id'");
                            $subuser = $result->fetch_assoc();
                            if ($subuser['id'] == $_COOKIE['id']) {
                                echo '<a href="userprofile.php" style="-webkit-tap-highlight-color: transparent;">';
                            } else {
                                echo '<a href="userpage.php?id=' . $subuser['id'] . '" style="-webkit-tap-highlight-color: transparent;">';
                            }
                            echo '
                            <div class="user">
                                <ul>
                                    <li>
                                        <img src="' . $subuser['profile_image'] . '" width="60" height="60" class="user-image">
                                    </li>
                                    <li>
                                        <p class="user-name"><b>' . $subuser['name'] . '</b></p>
                                    </li>';
                            if ($subuser['official'] == 1 || $subuser['is_teacher'] == 1) {
                                echo '
                                    <li>
                                        <ion-icon name="checkmark-circle" class="check-mark"></ion-icon>
                                    </li>';
                            }
                            echo '
                                </ul>
                            </div>
                            </a>';
                        }
                    }
                }
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    </body>
</html>