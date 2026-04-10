<?php
ini_set('display_errors', 'Off');
    $isshow = filter_var(trim($_POST['ischecked']), FILTER_SANITIZE_STRING); 
    $id = $_COOKIE['id'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        if ($isshow == 'true') {
            $mysql->query("UPDATE `users` SET `email_notifications` = '1' WHERE `id` = '$id'");
        } else {
            $mysql->query("UPDATE `users` SET `email_notifications` = '0' WHERE `id` = '$id'");
        }
        $mysql->close();
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>