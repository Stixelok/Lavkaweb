<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Уведомления</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" href="css/notifications.css?<?php echo time();?>">
    </head>
    <body>
        <?php
            if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /login.html");
            }
        ?>
        <ul class="menu">
            <li>
                <a href="userprofile.php" style="-webkit-tap-highlight-color: transparent;">
                    <ion-icon name="caret-back-circle-outline" class="back-link"></ion-icon>
                </a>
            </li>
            <li>
                <h1>Уведомления</h1>
            </li>
        </ul>
        <div class="notifications">
            <?php
                include 'num_decline.php';
                $id = $_COOKIE['id'];
                $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                $result = $mysql->query("SELECT * FROM `notifications` WHERE `creator_id` = '$id'");
                $notifications = $result->fetch_all();
                $notifications = array_reverse($notifications);
                if ($notifications != Array()) {
                    foreach ($notifications as $notification) {
                        if ($notification[5] == '0') {
                            $mysql->query("UPDATE `notifications` SET `is_seen` = '1' WHERE `creator_id` = '$id'");
                        }
                        $user_id = $notification[2];
                        $post_id = $notification[3];
                        $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
                        $user = $result->fetch_assoc();
                        $result = $mysql->query("SELECT * FROM `posts` WHERE `id` = '$post_id'");
                        $post = $result->fetch_assoc();
                        echo '
                        <div class="notification">
                            <ul>
                                <li>
                                    <img src="' . $user['profile_image'] . '" width="60" height="60" class="notification-image">
                                </li>';
                        if ($notification[1] == 1) {
                            echo '<li>';
                            if (strlen($user['name']) > 15) { 
                                echo '<p class="notification-text" style="font-size: 1.1em; top: 10px;"><a href="userpage.php?id=' . $user['id'] . '">' . $user['name'] . '</a> поставил(а) лайк на ваш ';
                            } else {
                                echo '<p class="notification-text"><a href="userpage.php?id=' . $user['id'] . '">' . $user['name'] . '</a> поставил(а) лайк на ваш ';
                            }
                            if ($post['title'] != '' && strlen($user['name']) < 16 && strlen($post['title']) < 8) {
                                echo 'пост <a href="post.php?id=' . $post['id'] . '">' . $post['title'] . '';
                            } else {
                                echo '<a href="post.php?id=' . $post['id'] . '">пост';
                            }
                            echo '</a></p>';
                            echo '                                    
                            </li>
                            <li>';
                            if ($notification[4] != null) {
                                if (date("j", strtotime($notification[4])) == date(("j")) && date('n', strtotime($notification[4]) - 1) == date(("n"))) {
                                    echo '<p class="notification-text-time">' . date("сегодня в G:i", strtotime($notification[4])) . '</p>';
                                } else if (date("j", strtotime($notification[4])) == (date(("j")) - 1) && translateTime(date('n', strtotime($notification[4]) - 1)) == date(("n"))) {
                                    echo '<p class="notification-text-time">' . date("вчера в G:i", strtotime($notification[4])) . '</p>';
                                } else {
                                    echo '<p class="notification-text-time">' . date("j " . translateTime(date('n', strtotime($notification[4]) - 1)) . " в G:i", strtotime($notification[4])) . '</p>';
                                }
                            } else {
                                echo '<p class="notification-text-time">Очень давно</p>';
                            }
                        } else if ($notification[1] == 2) {
                            echo '<li>'; 
                            if (strlen($user['name']) > 15) { 
                                echo '<p class="notification-text" style="font-size: 1.1em; top: 10px;"><a href="userpage.php?id=' . $user['id'] . '">' . $user['name'] . '</a> оставил(а) комментарий к вашему ';
                            } else {
                                echo '<p class="notification-text"><a href="userpage.php?id=' . $user['id'] . '">' . $user['name'] . '</a> оставил(а) комментарий к вашему ';
                            }
                            if ($post['title'] != '' && strlen($user['name']) < 16 && strlen($post['title']) < 8) {
                                echo 'посту <a href="post.php?id=' . $post['id'] . '">' . $post['title'];
                            } else {
                                echo '<a href="post.php?id=' . $post['id'] . '">посту';
                            }
                            echo '</a></p>';
                            echo '                                    
                            </li>
                            <li>';
                            if ($notification[4] != null) {
                                if (date("j", strtotime($notification[4])) == date(("j")) && date('n', strtotime($notification[4]) - 1) == date(("n"))) {
                                    echo '<p class="notification-text-time">' . date("сегодня в G:i", strtotime($notification[4])) . '</p>';
                                } else if (date("j", strtotime($notification[4])) == (date(("j")) - 1) && translateTime(date('n', strtotime($notification[4]) - 1)) == date(("n"))) {
                                    echo '<p class="notification-text-time">' . date("вчера в G:i", strtotime($notification[4])) . '</p>';
                                } else {
                                    echo '<p class="notification-text-time">' . date("j " . translateTime(date('n', strtotime($notification[4]) - 1)) . " в G:i", strtotime($notification[4])) . '</p>';
                                }
                            } else {
                                echo '<p class="notification-text-time">Очень давно</p>';
                            }
                        } else if ($notification[1] == 3) {
                            echo '
                                    <li>
                                        <p class="notification-text"><a href="userpage.php?id=' . $user['id'] . '">' . $user['name'] . '</a> подписался(ась) на вас</p>
                                    </li>
                                    <li>';
                                    if ($notification[4] != null) {
                                        if (date("j", strtotime($notification[4])) == date(("j")) && date('n', strtotime($notification[4]) - 1) == date(("n"))) {
                                            echo '<p class="notification-text-time">' . date("сегодня в G:i", strtotime($notification[4])) . '</p>';
                                        } else if (date("j", strtotime($notification[4])) == (date(("j")) - 1) && translateTime(date('n', strtotime($notification[4]) - 1)) == date(("n"))) {
                                            echo '<p class="notification-text-time">' . date("вчера в G:i", strtotime($notification[4])) . '</p>';
                                        } else {
                                            echo '<p class="notification-text-time">' . date("j " . translateTime(date('n', strtotime($notification[4]) - 1)) . " в G:i", strtotime($notification[4])) . '</p>';
                                        }
                                    } else {
                                        echo '<p class="notification-text-time">Очень давно</p>';
                                    }
                        } else if ($notification[1] == 4) {
                            echo '  <li>
                                        <p class="notification-text"><a href="userpage.php?id=' . $user['id'] . '">' . $user['name'] . '</a> опубликовал(а) новый ';
                            if ($post['title'] != '' && strlen($user['name']) < 16 && strlen($post['title']) < 8) {
                                echo 'пост <a href="post.php?id=' . $post['id'] . '">' . $post['title'];
                            }
                            else {
                                echo '<a href="post.php?id=' . $post['id'] . '">пост';
                            }
                            echo '</a></p>';
                            echo '                                    
                            </li>
                            <li>';
                            if ($notification[4] != null) {
                                if (date("j", strtotime($notification[4])) == date(("j")) && date('n', strtotime($notification[4]) - 1) == date(("n"))) {
                                    echo '<p class="notification-text-time">' . date("сегодня в G:i", strtotime($notification[4])) . '</p>';
                                } else if (date("j", strtotime($notification[4])) == (date(("j")) - 1) && translateTime(date('n', strtotime($notification[4]) - 1)) == date(("n"))) {
                                    echo '<p class="notification-text-time">' . date("вчера в G:i", strtotime($notification[4])) . '</p>';
                                } else {
                                    echo '<p class="notification-text-time">' . date("j " . translateTime(date('n', strtotime($notification[4]) - 1)) . " в G:i", strtotime($notification[4])) . '</p>';
                                }
                            } else {
                                echo '<p class="notification-text-time">Очень давно</p>';
                            }
                        }
                        echo '
                                </li>
                            </ul>
                        </div>
                        ';
                    }
                } else {
                    echo '
                    <p>Похоже, у вас нет уведомлений</p>
                    ';
                }
            ?>
        </div>
    </body>
</html>