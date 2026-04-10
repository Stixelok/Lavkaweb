<!DOCTYPE html>
<html lang="ru">
    <head>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" href="css/community.css?<?php echo time();?>">
        <?php
            include 'num_decline.php';
            ini_set('display_errors', 'Off');
            $id = $_GET['id'];
            $userid = $_COOKIE['id'];
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$id'");
            $community = $result->fetch_assoc();
            $result = $mysql->query("SELECT * FROM `user_rights` WHERE `community_id` = '$id' AND `user_id` = '$userid'");
            $user_right = $result->fetch_assoc();
            $isadmin = $user_right != [];
            echo '
        <title>' . $community['name'] . '</title>
    </head>
    <body>';
            $backlink = "";
            if (@$_SERVER['HTTP_REFERER'] != null) {
                $backlink = $_SERVER['HTTP_REFERER'];
            } else {                        
                $backlink = "communities.php";
            }
            if (strpos($_SERVER['HTTP_REFERER'], 'https://lavka.website/post.php') === 0 || strpos($_SERVER['HTTP_REFERER'], 'http://localhost/post.php') === 0) {
                $backlink = "communities.php";
            }
            if (strpos($_SERVER['HTTP_REFERER'], 'https://lavka.website/newcommunitypost.php') === 0 || strpos($_SERVER['HTTP_REFERER'], 'http://localhost/newcommunitypost.php') === 0) {
                $backlink = "communities.php";
            }
            if (strpos($_SERVER['HTTP_REFERER'], 'https://lavka.website/communitysettings.php') === 0 || strpos($_SERVER['HTTP_REFERER'], 'http://localhost/communitysettings.php') === 0) {
                $backlink = "communities.php";
            }
            if (strpos($_SERVER['HTTP_REFERER'], 'https://lavka.website/subscribers.php') === 0 || strpos($_SERVER['HTTP_REFERER'], 'http://localhost/subscribers.php') === 0) {
                $parts = parse_url($_SERVER['HTTP_REFERER']);
                parse_str($parts['query'], $get);
                if ($get['id'] == $_GET['id']) {
                    $backlink = "communities.php";
                }
            }
            if (((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] == $backlink) {
                $backlink = "communities.php";
            }
            echo '
            <ul>
                <li>
                    <a href="' . $backlink . '" style="-webkit-tap-highlight-color: transparent;">
                        <ion-icon name="caret-back-circle-outline" style="color: black;"></ion-icon>
                    </a>
                </li>';
            if ($isadmin) {
                echo '
                <li>
                    <a href="communitysettings.php?id=' . $community['id'] . '" style="-webkit-tap-highlight-color: transparent;">
                        <ion-icon name="settings-sharp" class="notifications"></ion-icon>
                    </a>
                </li>';
            }
            echo '
            </ul>
            ';
            $result = $mysql->query("SELECT * FROM `subscribers` WHERE `creator_id` = '$id' AND `user_id` = '$userid'");
            $subscriber = $result->fetch_assoc();
            $issubscribed = 'not-subscribed';
            $content = 'Подписаться';
            $style = '';
            if ($subscriber != Array()) {
                $issubscribed = "subscribed";
                $style = 'background-color: white; color: black; border: 1px solid rgba(0, 0, 0, 0.35);';
                $content = 'Вы подписаны';
            }
            
            echo '
            <div class="logo-container">
                <a href="index.php" style="-webkit-tap-highlight-color: transparent;" class="logo-container">
                    <img src="'. $community['profile_image'] . '?<?php echo time();?>" class="logo" width="140" height="140">
                    </a>';
                if ($user['official'] == 1 || $user['is_teacher'] == 1) {
                    echo '<ion-icon name="checkmark-circle" class="check-mark" id="check-mark"></ion-icon>';
                }
                echo '
            </div>
            <h2 class="name">' . $community['name'] . '</h2>
            <a href="subscribers.php?id=' . $community['id'] . '&is_community=1" style="color: black; :hover { color: black; }">
                <div class="user-info">
                    <p id="subscribers">' . $community['subscribers'] . '</p>
                    <p id="subscribers-text">' . num_decline($community['subscribers'], 'Подписчик, Подписчика, Подписчиков', 0) .'</p>
                </div>
            </a>
            <div style="text-align:center;">
                <button class="subscribe-button ' . $issubscribed . '" id="' . $community['id'] . '" style="' . $style . '">
                    <p>' . $content . '</p>
                </button>
            </div>';
            if ($isadmin) {
            echo '
            <ul class="actions-list">
                <li>
                    <div class="action">
                        <a href="newcommunitypost.php?id=' . $community['id'] . '" class="upload-link">Опубликовать</a>
                    </div>
                </li>
            </ul>';
            }
            echo '
            <div class="message" style="color: black;"></div>
            <div class="posts">';
            $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `is_community` = 1 AND `is_pinned` = 0");
            $posts = $result->fetch_all();
            $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `is_community` = 1 AND `is_pinned` = 1");
            $post = $result->fetch_assoc();
            $posts = array_reverse($posts);
            if ($posts == Array() && $post == Array()) {
                echo '<p style="color: black; text-align: center;">Похоже постов пока нет...</p>';
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
                            <img src="'. $community['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
                        </li>
                        <li>
                            <p class="username"><b>' . $post['creator_name'] . '</b></p>
                        </li>
                        <li>';
                        if ($post['time'] != null) {
                            if (date("j", strtotime($post['time'])) == date(("j"))) {
                                echo '<p class="time">' . date("сегодня в G:i", strtotime($post['time'])) . '</p>';
                            } else if (date("j", strtotime($post['time'])) == (date(("j")) - 1)) {
                                echo '<p class="time">' . date("вчера в G:i", strtotime($post['time'])) . '</p>';
                            } else {
                                echo '<p class="time">' . date("j " . translateTime(date('n', strtotime($post['time']) - 1)) . " в G:i", strtotime($post['time'])) . '</p>';
                            }
                        } else {
                            echo '<p class="time">Очень давно</p>';
                        }
                        echo '
                        </li>';
                    if ($isadmin) {
                        echo '
                        <li>
                            <img src="images/Star 1.png" class="pinned" style="right: 40px;" width=18 height=18>
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
                        </li>';
                    } else {
                        echo '
                        <li>
                            <img src="images/Star 1.png" class="pinned" "width=18 height=18>
                        </li>';
                    }
                    echo '
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
                    </div>';
                }
                foreach ($posts as $post) {
                    $postid = $post[0];
                    $result = $mysql->query("SELECT * FROM `likes` WHERE `post_id` = '$postid' AND `user_id` = '$userid'");
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
                                <img src="'. $community['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
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
                                <p class="username"><b>' . $post[3] . '</b></p>
                            </li>';
                            if ($isadmin) {
                                echo '
                                <li>
                                    <div class="dropdown">
                                        <button class="dropbtn" id="' . $post[0] . '">●●●</button>
                                        <div id="menu' . $post[0] . '" class="dropdown-content">
                                            <button class="menu-item pin" id="' . $post[0] . '">Закрепить</button>
                                            <button class="menu-item post" id="' . $post[0] . '">Удалить</button>
                                            <button class="menu-item close" id="' . $post[0] . '">Свернуть</button>
                                        </div>
                                    </div>
                                </li>';
                            }  
                            echo '    
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
                        <a href="post.php?id=' . $post[0] . '" style="padding-right: 55%;">
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
            <div class="btn-up btn-up_hide">
                <ion-icon name="chevron-up-outline" class="up-icon"></ion-icon>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
            <script type="text/javascript" src="js/userpage.js?<?php echo time();?>"></script>
    </body>
</html>