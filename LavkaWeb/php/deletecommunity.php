<?php
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 
    $password = md5($password."wofnmo1580");
    $userid = $_COOKIE['id'];
    $id = $_POST['id'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$userid' AND `password` = '$password'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) {
        if ($user == []) {
            echo "Неправильный пароль.";
            exit();
        }
        $mysql->query("DELETE FROM `communities` WHERE `id` = '$id'");
        $mysql->query("DELETE FROM `user_rights` WHERE `community_id` = '$id'");
        $mysql->query("DELETE FROM `subscribers` WHERE `creator_id` = '$id' AND `type` = 2");
        $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `is_community` = 1");
        $posts = $result->fetch_assoc();
        $mysql->query("DELETE FROM `posts` WHERE `creator_id` = '$id' AND `is_community` = 1");
        foreach ($posts as $post) {
            $mysql->query("DELETE FROM `likes` WHERE `post_id` = '" . $post[0] . "'");
            $mysql->query("DELETE FROM `comments` WHERE `post_id` = '" . $post[0] . "'");
            $mysql->query("DELETE FROM `notifications` WHERE `post_id` = '" . $post[0] . "'");
        }
        $mysql->close();
        echo "Сообщество удалено.";
        exit("<meta http-equiv='refresh' content='0; url= /communities.php'>");
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>