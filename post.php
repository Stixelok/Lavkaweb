<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Пост</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" href="css/post.css?<?php echo time();?>">
    </head>
    <body>
        <ul style="postition: relative;">
            <li>
                <?php
                    $backlink = "";
                    if (@$_SERVER['HTTP_REFERER'] != null) {
                        $backlink = $_SERVER['HTTP_REFERER'];
                    } else {                        
                        $backlink = "index.php";
                    }
                    if (((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] == $backlink) {
                        $backlink = "index.php";
                    }
                    echo '
                    <a href="' . $backlink . '" style="-webkit-tap-highlight-color: transparent;">
                        <ion-icon name="caret-back-circle-outline" style="color: black;"></ion-icon>
                    </a>  
                    '
                ?>
            </li>
            <li>
                <h1 class="title">Пост</h1>
            </li>
        </ul>
        <div class="message" style="color: black;"></div>
        <hr>
        <?php 
            include 'num_decline.php';
            ini_set('display_errors', 'Off');
            $id = $_GET['id'];
            $userid = $_COOKIE['id'];
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `posts` WHERE `id` = '$id'");
            $post = $result->fetch_assoc();
            $result = $mysql->query("SELECT * FROM `admin_rights` WHERE `user_id` = '$userid' AND `type` = 1");
            $isadmin = $result->fetch_assoc() != [];
            $creatorid = $post['creator_id'];
            $result = null;
            if ($post["is_community"] == 1) {
                $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$creatorid'");
            } else {
                $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$creatorid'");
            }
            $user = $result->fetch_assoc();
            if ($post == Array()) {
                echo '<p style="color: black; text-align: center;">Такого поста не существует.</p>';
            } else {
                    $postid = $post['id'];
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
                            <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
                        </li>
                        <li>
                            <p class="username">' . $post['creator_name'] . '</p>
                        </li> 
                        <li>';
                        if ($post['time'] != null) {
                            if (date("j", strtotime($post['time'])) == date(("j")) && translateTime(date('n', strtotime($post['time']) - 1)) == date(("n"))) {
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
                        </li>';
                        if ($isadmin) {
                            echo '
                            <li>
                                <div class="dropdown">
                                    <button class="dropbtn" id="' . $post['id'] . '">●●●</button>
                                    <div id="menu' . $post['id'] . '" class="dropdown-content">
                                        <button class="menu-item deletepost" id="' . $post['id'] . '">Удалить</button>
                                        <button class="menu-item close" id="' . $post['id'] . '">Свернуть</button>
                                    </div>
                                </div>
                            </li>';    
                        } 
                    echo '
                    </ul>
                    <p class="post-title">' . $post['title'] . '</p>';
                if (!is_bool(strpos($post['image'], '.mp4')) || !is_bool(strpos($post['image'], '.mov'))) {
                    echo '<div class="content"><video src="' . $post['image'] . '" class="post-image" controls width="100%" height="100%"></video></div>';
                } else if ($post['image'] != 'upload/') {
                    echo '<div class="content"><img src="' . $post['image'] . '" class="post-image" width="100%" height="100%"></div>';
                }
                echo '
                    <ul>
                        <li>
                            <button class="like-button ' . $isliked . '" id="like' . $post['id'] . '"  style="' . $style . '">
                                <ion-icon name="' . $name . '" id="icon-like' . $post['id'] . '" class="like"></ion-icon>
                                <p id="text-like' . $post['id'] . '" class="likes-text">' . $post['likes'] . '</p>
                            </button>
                        </li>
                        <li>
                            <button class="comment-button" id="comment">
                                <ion-icon name="chatbox-outline" class="comment-icon"></ion-icon>
                                <p id="text-comment" class="comments-text">' . $post['comments'] . '</p>
                            </button>
                        </li>
                    </ul>
                </div>';
            }
            if ($post != Array()) {
                $result = $mysql->query("SELECT * FROM `comments` WHERE `post_id` = '$postid'");
                $comments = $result->fetch_all();   
                if ($comments != Array()) {
                    echo '
                    <hr>
                    <div class="comments-container">';
                }
                $i = 0;
                foreach ($comments as $comment) { 
                    $commentuserid = $comment[2];
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$commentuserid'");
                    $user = $result->fetch_assoc();
                    $link = 'userpage.php?id=' . $user['id'];
                    $username = $user['name'];
                    echo '
                    <div class="comment-container">';
                    if ($i > 0) {
                        echo '<hr>';
                    }
                    $i++;
                    if ($_COOKIE['id'] != $user['id']) {
                    echo '
                        <ul>
                            <li>
                                <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
                            </li>
                            <li>
                                <div class="username"><a href="' . $link . '">' . $username . '</a></div>
                            </li> 
                            <li>';
                            if ($comment[4] != null) {
                                if (date("j", strtotime($comment[4])) == date(("j"))) {
                                    echo '<p class="time">' . date("сегодня в G:i", strtotime($comment[4])) . '</p>';
                                } else if (date("j", strtotime($comment[4])) == (date(("j")) - 1)) {
                                    echo '<p class="time">' . date("вчера в G:i", strtotime($comment[4])) . '</p>';
                                } else {
                                    echo '<p class="time">' . date("j " . translateTime(date('n', strtotime($comment[4]) - 1)) . " в G:i", strtotime($comment[4])) . '</p>';
                                }
                            } else {
                                echo '<p class="time">Очень давно</p>';
                            }
                            echo '
                            </li>';
                            if ($isadmin) {
                                echo '                              
                            <li>
                                <button class="post" id="' . $comment[1] . '">
                                    <ion-icon name="close-circle-outline" class="delete-post"></ion-icon>
                                </button>
                            </li>';
                            }
                        echo'  
                        </ul>
                        <p class="comment-text">' . $comment[3] . '</p>
                    </div>';
                    } else {
                        echo '
                            <ul>
                                <li>
                                    <img src="'. $user['profile_image'] . '?<?php echo time();?>" class="creator-image" width="30" height="30">
                                </li>
                                <li>
                                    <div class="username"><a href="' . $link . '">' . $username . '</a></div>
                                </li>  
                                <li>';
                                if ($comment[4] != null) {
                                    if (date("j", strtotime($comment[4])) == date(("j"))) {
                                        echo '<p class="time">' . date("сегодня в G:i", strtotime($comment[4])) . '</p>';
                                    } else if (date("j", strtotime($comment[4])) == (date(("j")) - 1)) {
                                        echo '<p class="time">' . date("вчера в G:i", strtotime($comment[4])) . '</p>';
                                    } else {
                                        echo '<p class="time">' . date("j " . translateTime(date('n', strtotime($comment[4]) - 1)) . " в G:i", strtotime($comment[4])) . '</p>';
                                    }
                                } else {
                                    echo '<p class="time">Очень давно</p>';
                                }
                                echo '
                                </li>  
                                <li>
                                    <button class="post" id="' . $comment[1] . '">
                                        <ion-icon name="close-circle-outline" class="delete-post"></ion-icon>
                                    </button>
                                </li>
                            </ul>
                            <p class="comment-text">' . $comment[3] . '</p>
                        </div>';
                    }
                } 
                if ($comments == Array()) {
                    echo '<br><br><br>';
                }
                echo '
                </div>
                <div class="write-comment">
                    <form enctype="multipart/form-data" action="php/addcomment.php" method="POST" id="' . $post['id'] . '">
                        <ul>
                            <li>
                                <input type="text" class="write-comment-text" name="comment-box" id="text-box" placeholder="Написать комментарий...">
                            </li>
                            <li>
                                <button id="upload" class="submit-button">
                                    <ion-icon name="caret-forward-outline" class="submit-icon"></ion-icon>
                                </button>
                            </li>
                        </ul>
                    </form>
                </div>
                ';
            }
            ?>
            <div class="btn-up btn-up_hide">
                <ion-icon name="chevron-up-outline" class="up-icon"></ion-icon>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
            <script type="text/javascript" src="js/post.js?<?php echo time();?>"></script>
    </body>
</html>