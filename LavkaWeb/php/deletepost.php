<?php 
    ini_set('display_errors', 'Off');
    $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING); 
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $userid = $_COOKIE['id'];
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$userid'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        $mysql->query("DELETE FROM `likes` WHERE `post_id` = '$id'");
        $mysql->query("DELETE FROM `comments` WHERE `post_id` = '$id'");
        $mysql->query("DELETE FROM `notifications` WHERE `post_id` = '$id'");
        $mysql->query("DELETE FROM `posts` WHERE `id` = '$id'");
        $mysql->close();
        if ($_POST['type'] == '1') {
            exit("<meta http-equiv='refresh' content='0; url= /../index.php'>");
        }
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>