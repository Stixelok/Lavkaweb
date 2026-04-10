<!DOCTYPE html>
<html lang="ru" id="html">
    <head>
        <title>Лавкавэб</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.cdnfonts.com/css/gilroy-bold" rel="stylesheet">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/index.css?<?php echo time();?>">
    </head>
    <body>
                <?php
                ini_set('display_errors', 'Off');
                    include 'num_decline.php';
                    $id = $_COOKIE['id'];
                    $user = $_COOKIE['user'];
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    echo '      
                    <section id="main-section">';
                    if ($_COOKIE['user'] != '' && $_COOKIE['id'] != '' && $_COOKIE['check'] != '' && $_COOKIE['check'] == md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                        echo '
                        <div class="panel-button">
                            <div class="button-panel js-button-panel"><ion-icon class="return" name="menu-outline"></ion-icon></div>
                        </div>
                        ';
                    }
                    echo '
                    <div class="title">
                        <div class="button js-button-campaign"><img src="images/lavkalogo.png" width="222" height="39"></div>
                    </div>';
                    if ($_COOKIE['user'] != '' && $_COOKIE['id'] != '' && $_COOKIE['check'] != '' && $_COOKIE['check'] == md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {                    
                        $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                        $user = $result->fetch_assoc();
                        echo '
                        <div class="overlay js-overlay-panel">
                            <div class="panel js-panel-campaign panel-initial" id="panel">
                                <div style="height: 100vh">
                                    <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="user-panel-image" id="user-image" width="100" height="100">
                                    <p class="user-panel-text" id="user-text">' . $user['name'] . '</p>
                                    <ul class="user-panel-list">
                                        <li class="user-panel-item" id="1"><a href="userprofile.php" class="user-panel-link">Профиль</a></li>
                                        <li class="user-panel-item" id="2"><a href="newpost.php" class="user-panel-link">Создать пост</a></li>
                                        <li class="user-panel-item" id="3"><a href="communities.php" class="user-panel-link">Сообщества</a></li>
                                        <li class="user-panel-item" id="4"><a href="calculator.php" class="user-panel-link" id="panel-calculator">Калькулятор оценок</a></li>
                                        <li class="user-panel-item" id="5"><a href="settings.php" class="user-panel-link">Настройки</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>';
                    }
                    echo '
                    <div class="overlay js-overlay-campaign">
                        <div class="popup js-popup-campaign popup-initial" id="popup">
                            <img src="images/lavkalogo.png" width="234" height="41">
                            <h2 style="margin-bottom: 20px">Обновление 0.7<br>Beta-1</h2>
                            <a href="changelog.php">Список изменений</a>
                        </div>
                    </div>
                        <a href="lounge.php" style="-webkit-tap-highlight-color: transparent; display: flex; justify-content: center;">
                            <div class="event-container">
                                <img src="images/community.jpeg?<?php echo time();?>" class="event-image" id="event-image" width="100%" height="100%">
                                <div class="event-text">Лаунж</div>
                            </div>
                        </a>
                        <div class="user-teachers-container">';
                    if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                        echo '
                        <a href="login.php" style="-webkit-tap-highlight-color: transparent;">
                            <div class="user" id="user-box">
                                <img src="images/user.jpg" class="user-image" id="user-image" width="100%" height="100%">
                                <p class="user-text" id="user-text">Войти</p>
                            </div>
                        </a>';
                    } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                        echo '
                        <a href="login.php" style="-webkit-tap-highlight-color: transparent;">
                            <div class="user" id="user-box">
                                <img src="images/user.jpg" class="user-image" id="user-image" width="100%" height="100%">
                                <p class="user-text" id="user-text">Ошибка</p>
                            </div>
                        </a>';
                    } else {
                        $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                        $user = $result->fetch_assoc();
                        echo '
                        <a href="userprofile.php" style="-webkit-tap-highlight-color: transparent;">
                            <div class="user" id="user-box">
                                <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="user-image" id="user-image" width="100%" height="100%">
                                <p class="user-text" id="user-text">Я</p>
                            </div>
                        </a>';
                        $mysql->close();
                    }
                    echo '
                            <a href="teachers.php" style="-webkit-tap-highlight-color: transparent;">
                                <div class="video" id="video-box">
                                    <img src="images/teachers.jpg?<?php echo time();?>" class="video-image" id="teachers-image" width="100%" height="100%">
                                    <p class="video-text" id="video-text">Учителя</p>
                                </div>
                            </a>
                        </div>
                        <a href="search.php " style="-webkit-tap-highlight-color: transparent; display: flex; justify-content: center;">
                            <div class="newsline">
                                <p class="newsline-text">Поиск</p>
                            </div>
                        </a>
                        <div class="posts">';
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    $result = $mysql->query("SELECT * FROM `posts`");
                    $posts = $result->fetch_all();
                    $posts = array_reverse($posts);
                    if ($posts == Array()) {
                        echo '<p style="color: black;">Похоже постов пока нет...</p>';
                    } else {
                        foreach ($posts as $post) {
                            $user_id = $post[2];
                            $link = 'userpage.php?id=' . $user_id;
                            if ($user_id == $_COOKIE['id'] && $post[10] != 1) {
                                $link = 'userprofile.php';
                            } else if ($post[9] == 1){
                                $link = 'community.php?id=' . $user_id;
                            }
                            $result = null;
                            if ($post[9] == 1) {
                                $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$user_id'");
                            } else {
                                $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
                            }
                            $user = $result->fetch_assoc();
                            $postid = $post[0];
                            $result = $mysql->query("SELECT * FROM `likes` WHERE `post_id` = '$postid' AND `user_id` = '$id'");
                            $likes = $result->fetch_assoc();
                            $post_time = $post[5];
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
                                    <p class="username"><b><a href="' . $link . '">' . $post[3] . '</a></b></p>
                                </li>
                                <li>';
                                if ($post_time != null) {
                                    if (date("j", strtotime($post_time)) == date(("j")) && date('n', strtotime($post_time)) == date(("n")) && date('o', strtotime($post_time)) == date(("o"))) {
                                        echo '<p class="time">' . date("сегодня в G:i", strtotime($post_time)) . '</p>';
                                    } else if (date("j", strtotime($post_time)) == (date(("j")) - 1) && translateTime(date('n', strtotime($post_time) - 1)) == date(("n"))) {
                                        echo '<p class="time">' . date("вчера в G:i", strtotime($post_time)) . '</p>';
                                    } else {
                                        echo '<p class="time">' . date("j " . translateTime(date('n', strtotime($post_time) - 1)) . " в G:i", strtotime($post_time)) . '</p>';
                                    }
                                } else {
                                    echo '<p class="time">Очень давно</p>';
                                }
                                echo '
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
                                    <a href="post.php?id=' . $post[0] . '" style="padding-right: 30%;">
                                        <li>
                                            <button class="comment-button" id="comment">
                                                <ion-icon name="chatbox-outline" class="comment-icon"></ion-icon>
                                                <p id="text-comment" class="comments-text">' . $post[7] . '</p>
                                            </button>
                                        </li>
                                    </a>
                                </ul>
                            </div>';
                        }
                        unset($post);
                    }
                ?>
            </div>
        </section>
        <div class="btn-up btn-up_hide">
            <ion-icon name="chevron-up-outline" class="up-icon"></ion-icon>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/index.js?<?php echo time();?>"></script>
    </body>
</html>