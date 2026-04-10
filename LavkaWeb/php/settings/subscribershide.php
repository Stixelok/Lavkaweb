<?php
    ini_set('display_errors', 'Off');
    $isshow = filter_var(trim($_POST['ischecked']), FILTER_SANITIZE_STRING); 
    $id = $_COOKIE['id'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        if ($_POST['type'] == '1') {
            if ($isshow == 'true') {
                $mysql->query("UPDATE `users` SET `subscribers_hide` = '1' WHERE `id` = '$id'");
            } else {
                $mysql->query("UPDATE `users` SET `subscribers_hide` = '0' WHERE `id` = '$id'");
            }
        } else {
            $id = $_POST['id'];
            if ($isshow != 'false') {
                $mysql->query("UPDATE `communities` SET `subscribers_hide` = '1' WHERE `id` = '$id'");
            } else {
                $mysql->query("UPDATE `communities` SET `subscribers_hide` = '0' WHERE `id` = '$id'");
            }
        }
        $mysql->close();
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>