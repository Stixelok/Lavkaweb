<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Аккаунт</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" href="css/userprofile.css?<?php echo time();?>">
    </head>
    <body>
        <?php 
            include 'num_decline.php';
            $id = $_COOKIE['id'];
            $user = $_COOKIE['user'];
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `notifications` WHERE `creator_id` = '$id' AND `is_seen` = '0'");
            $notifications = $result->fetch_all();
            $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id' AND `name` = '$user'");
            $user = $result->fetch_assoc();
            echo '
                <ul style="position: relative;">
                    <li>
                        <a href="index.php" style="-webkit-tap-highlight-color: transparent;">
                            <ion-icon name="caret-back-circle-outline" style="color: black;"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="notifications.php" style="-webkit-tap-highlight-color: transparent;">
                            <ion-icon name="notifications-circle-outline" class="notifications"></ion-icon>';
                        if (count($notifications) != 0) {
                            echo '
                            <ion-icon name="ellipse" class="notifications-counter-icon"></ion-icon>';
                            if (count($notifications) > 9) {
                                echo '<p class="notification-counter" style="right: 19px; top: 52px;">9+</p>';
                            }
                            else {
                                echo '<p class="notification-counter">' . count($notifications) . '</p>';
                            }
                        }
                echo '  </a>
                    </li>
                </ul>';                 
            if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /login.html");
            } else {
                echo '
                <div class="logo-container">
                    <a href="settings/account.php" style="-webkit-tap-highlight-color: transparent;" class="logo-container">
                        <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="logo" width="140" height="140">
                    </a>';
                if ($user['official'] == 1 || $user['is_teacher'] == 1) {
                    echo '
                    <a href="settings/account.php" style="-webkit-tap-highlight-color: transparent;">
                        <ion-icon name="checkmark-circle" class="check-mark" id="check-mark"></ion-icon>    
                    </a>
                    ';
                }
                echo '
                </div>
                <h2 class="name">' . $user['name'] . '</h2>
                <a href="subscribers.php?id=' . $user['id'] . '" style="color: black; :hover { color: black; }">
                    <div class="user-info">
                        <p id="subscribers">' . $user['subscribers'] . '</p>
                        <p id="subscribers-text">' . num_decline($user['subscribers'], 'Подписчик, Подписчика, Подписчиков', 0) .'</p>
                    </div>
                </a>
                ';
            }
            echo '
                <ul class="actions-list">
                    <li>
                        <div class="action" style="margin-top: 20px; background-color:rgb(254, 202, 0); border: 1px solid rgb(254, 202, 0);">
                            <a href="newpost.php" class="upload-link">Опубликовать</a>
                        </div>
                    </li>
                    <li>
                        <div class="action" style="margin-bottom: 6px;">
                            <a href="settings.php" class="upload-link" style="color: black;">Настройки</a>
                        </div>
                    </li>
                </ul>
                <div class="message" style="color: black;"></div>
                <div class="posts">';
                $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `is_pinned` = 0 AND `is_community` = 0");
                $posts = $result->fetch_all();
                $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `is_pinned` = 1 AND `is_community` = 0");
                $post = $result->fetch_assoc();
                $posts = array_reverse($posts);
                if ($posts == Array() && $post == Array()) {
                    echo '<p style="color: black; text-align: center;">Похоже ваших постов пока нет...</p>';
                } else {
                    if ($post != Array()) {
                    $postid = $post['id'];
                    $result = $mysql->query("SELECT * FROM `likes` WHERE `post_id` = '$postid' AND `user_id` = '$id'");
                    $likes = $result->fetch_assoc();
                    $isliked = 'not-liked';
                    $style = '';
                    $name = 'heart-outline';
                    if ($likes != Array()) {
                        $style = 'color: red; border: 1px solid red; box-shadow: 2px 0px 20px rgba(0, 0, 0, 0.053)';
                        $name = 'heart';
                        $isliked = 'liked';
                    }
                    echo '
                    <div class="post-container">
                    <ul>
                        <li>
                            <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
                        </li>
                        <li>
                            <p class="username"><b>' . $post['creator_name'] . '</b></p>
                        </li>
                        <li>';
                        if ($post['time'] != null) {
                            if (date("j", strtotime($post['time'])) == date(("j")) && date('n', strtotime($post['time']) - 1) == date(("n"))) {
                                echo '<p class="time">' . date("сегодня в G:i", strtotime($post['time'])) . '</p>';
                            } else if (date("j", strtotime($post['time'])) == (date(("j")) - 1) && translateTime(date('n', strtotime($post['time']) - 1)) == date(("n"))) {
                                echo '<p class="time">' . date("вчера в G:i", strtotime($post['time'])) . '</p>';
                            } else {
                                echo '<p class="time">' . date("j " . translateTime(date('n', strtotime($post['time']) - 1)) . " в G:i", strtotime($post['time'])) . '</p>';
                            }
                        } else {
                            echo '<p class="time">Очень давно</p>';
                        }
                        echo '
                        </li>
                        <li>
                            <img src="images/Star 1.png" class="pinned" width=18 height=18>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="dropbtn" id="' . $post['id'] . '">●●●</button>
                                <div id="menu' . $post['id'] . '" class="dropdown-content">
                                    <button class="menu-item pin" id="' . $post['id'] . '">Открепить</button>
                                    <button class="menu-item post" id="' . $post['id'] . '">Удалить</button>
                                    <button class="menu-item close" id="' . $post['id'] . '">Свернуть</button>
                                </div>
                            </div>
                        </li>   
                    </ul>
                    <p class="post-title">' . $post['title'] . '</p>';
                    if (!is_bool(strpos($post['image'], '.mp4')) || !is_bool(strpos($post['image'], '.mov'))) {
                        echo '<video src="' . $post['image'] . '" class="post-image" controls width="100%" height="100%"></video>';
                    } else if ($post['image'] != 'upload/') {
                        echo '<img src="' . $post['image'] . '" class="post-image" width="100%" height="100%">';
                    }
                    echo '
                        <ul>
                            <li>
                                <button class="like-button ' . $isliked . '" id="like' . $post['id'] . '"  style="' . $style . '">
                                    <ion-icon name="' . $name . '" id="icon-like' . $post['id'] . '" class="like"></ion-icon>
                                    <p id="text-like' . $post['id'] . '" class="likes-text">' . $post['likes'] . '</p>
                                </button>
                            </li>
                            <a href="post.php?id=' . $post['id'] . '" style="padding-right: 55%">
                                <li>
                                    <button class="comment-button" id="comment">
                                        <ion-icon name="chatbox-outline" class="comment-icon"></ion-icon>
                                        <p id="text-comment" class="comments-text">' . $post['comments'] . '</p>
                                    </button>
                                </li>
                            </a>
                        </ul>
                    </div>'; /*                            <li>
                    <script src="https://yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-curtain data-shape="round" data-limit="0" data-more-button-type="short" data-services="vkontakte,telegram,whatsapp"></div>
                        <button class="repost-button" id="repost">
                            <ion-icon name="arrow-redo-outline" class="comment-icon"></ion-icon>
                            <p id="text-comment" class="comments-text">' . $post['reposts'] . '</p>
                        </button>
                    </li>*/
                    }
                    foreach ($posts as $post) {
                        $postid = $post[0];
                        $result = $mysql->query("SELECT * FROM `likes` WHERE `post_id` = '$postid' AND `user_id` = '$id'");
                        $likes = $result->fetch_assoc();
                        $isliked = 'not-liked';
                        $style = '';
                        $name = 'heart-outline';
                        if ($likes != Array()) {
                            $style = 'color: red; border: 1px solid red; box-shadow: 2px 0px 20px rgba(0, 0, 0, 0.053)';
                            $name = 'heart';
                            $isliked = 'liked';
                        }
                        echo '                    
                        <div class="post-container">
                        <ul>
                            <li>
                                <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
                            </li>
                            <li>
                                <p class="username"><b>' . $post[3] . '</b></p>
                            </li>
                            <li>';
                            if ($post[5] != null) {
                                if (date("j", strtotime($post[5])) == date(("j"))) {
                                    echo '<p class="time">' . date("сегодня в G:i", strtotime($post[5])) . '</p>';
                                } else if (date("j", strtotime($post[5])) == (date(("j")) - 1)) {
                                    echo '<p class="time">' . date("вчера в G:i", strtotime($post[5])) . '</p>';
                                } else {
                                    echo '<p class="time">' . date("j " . translateTime(date('n', strtotime($post[5]) - 1)) . " в G:i", strtotime($post[5])) . '</p>';
                                }
                            } else {
                                echo '<p class="time">Очень давно</p>';
                            }
                            echo '
                            </li>
                            <li>
                                <div class="dropdown">
                                    <button class="dropbtn" id="' . $post[0] . '">●●●</button>
                                    <div id="menu' . $post[0] . '" class="dropdown-content">
                                        <button class="menu-item pin" id="' . $post[0] . '">Закрепить</button>
                                        <button class="menu-item post" id="' . $post[0] . '">Удалить</button>
                                        <button class="menu-item close" id="' . $post[0] . '">Свернуть</button>
                                    </div>
                                </div>
                            </li>   
                        </ul>
                        <p class="post-title">' . $post[4] . '</p>';
                    if (!is_bool(strpos($post[1], '.mp4')) || !is_bool(strpos($post[1], '.mov'))) {
                        echo '<video src="' . $post[1] . '" class="post-image" controls width="100%" height="100%"></video>';
                    } else if ($post[1] != 'upload/') {
                        echo '<img src="' . $post[1] . '" class="post-image" width="100%" height="100%">';
                    }
                    echo '
                        <ul>
                            <li>
                                <button class="like-button ' . $isliked . '" id="like' . $post[0] . '"  style="' . $style . '">
                                    <ion-icon name="' . $name . '" id="icon-like' . $post[0] . '" class="like"></ion-icon>
                                    <p id="text-like' . $post[0] . '" class="likes-text">' . $post[6] . '</p>
                                </button>
                            </li>
                            <a href="post.php?id=' . $post[0] . '">
                                <li>
                                    <button class="comment-button" id="comment">
                                        <ion-icon name="chatbox-outline" class="comment-icon"></ion-icon>
                                        <p id="text-comment" class="comments-text">' . $post[7] . '</p>
                                    </button>
                                </li>
                            </a>
                        </ul>
                    </div>';
                    } /*                            <li>
                    <button class="repost-button" id="repost">
                        <ion-icon name="arrow-redo-outline" class="comment-icon"></ion-icon>
                        <p id="text-comment" class="comments-text">' . $post[7] . '</p>
                    </button>
                </li>*/
                    unset($post);
                }
                ?>
            </div>
            <div class="btn-up btn-up_hide">
                <ion-icon name="chevron-up-outline" class="up-icon"></ion-icon>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
            <script type="text/javascript" src="js/userprofile.js?<?php echo time();?>"></script>
    </body>
</html>