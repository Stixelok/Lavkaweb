<?php 
    $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING); 
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `comments` WHERE `id` = '$id'");
    $comment = $result->fetch_assoc();   
    $postid = $comment['post_id'];
    $creatorid = $comment['user_id'];
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$creatorid'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        $mysql->query("DELETE FROM `comments` WHERE `id` = '$id'");
        if ($creatorid != $id) {
            $mysql->query("DELETE FROM `notifications` WHERE `creator_id` = '$creatorid', `type` = '2', `user_id` = '$id, `post_id` = '$postid'");
        }
        $result = $mysql->query("SELECT `comments` FROM `posts` WHERE `id` = '$postid'");
        $post = $result->fetch_assoc();
        $comments = $post['comments'] - 1;
        $mysql->query("UPDATE `posts` SET `comments` = '$comments' WHERE `id` = '$postid'");
        $mysql->close();
    } else {
        //exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>