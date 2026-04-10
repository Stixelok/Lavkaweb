<?php
ini_set('display_errors', 'Off');
    $postid = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING); 
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `posts` WHERE `id` = '$postid'");
    $post = $result->fetch_assoc();
    $id = $_COOKIE['id'];
    $name = $_COOKIE['user'];
    $time = date("Y-m-d H:i:s");
    $creatorid = $post['creator_id'];
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) {
        if ($_POST['newlike'] == 'add') {
            $mysql->query("INSERT INTO `likes` (`post_id`, `user_id`) VALUES('$postid', '$id')");
            if ($creatorid != $id) {
                $mysql->query("INSERT INTO `notifications`(`creator_id`, `type`, `user_id`, `post_id`, `time`) VALUES ('$creatorid','1','$id','$postid', '$time')");
            }
            $result = $mysql->query("SELECT `likes` FROM `posts` WHERE `id` = '$postid'");
            $post = $result->fetch_assoc();
            $likes = $post['likes'] + 1;
            $mysql->query("UPDATE `posts` SET `likes` = '$likes' WHERE `id` = '$postid'");
        } else {
            $mysql->query("DELETE FROM `likes` WHERE `post_id` = '$postid' AND `user_id` = '$id'");
            if ($creatorid != $id) {
                $mysql->query("DELETE FROM `notifications` WHERE `creator_id` = '$creatorid' AND `type` = '1' AND `user_id` = '$id' AND `post_id` = '$postid'");
            }
            $result = $mysql->query("SELECT `likes` FROM `posts` WHERE `id` = '$postid'");
            $post = $result->fetch_assoc();
            $likes = $post['likes'] - 1;
            $mysql->query("UPDATE `posts` SET `likes` = '$likes' WHERE `id` = '$postid'");
        }
        $mysql->close();
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>