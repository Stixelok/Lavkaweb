<?php
    ini_set('display_errors', 'Off');
    $postid = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING); 
    $text = filter_var(trim($_POST['text']), FILTER_SANITIZE_STRING); 
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $id = $_COOKIE['id'];
    $result = $mysql->query("SELECT `is_pinned` FROM `posts` WHERE `id` = '$postid'");
    $post = $result->fetch_assoc();
    $pin = 0;
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        if ($text == "Закрепить") {
            $pin = 1;
        }
        if ($_POST['type'] == '1') {
            $mysql->query("UPDATE `posts` SET `is_pinned` = 0 WHERE `creator_id` = '$id' AND `is_pinned` = 1");
            $mysql->query("UPDATE `posts` SET `is_pinned` = $pin WHERE `id` = '$postid'");
            $mysql->close();
            exit("<meta http-equiv='refresh' content='0; url= /../userprofile.php'>");
        } else {
            $communityid = $_POST['community_id'];
            $mysql->query("UPDATE `posts` SET `is_pinned` = 0 WHERE `creator_id` = '$communityid' AND `is_pinned` = 1 AND `is_community` = 1");
            $mysql->query("UPDATE `posts` SET `is_pinned` = $pin WHERE `id` = '$postid' AND `is_community` = 1");
            $mysql->close();
            exit("<meta http-equiv='refresh' content='0; url= /../community.php?id=$communityid'>");
        }
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>