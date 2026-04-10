<?php
    $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING); 
    $communityid = filter_var(trim($_POST['community_id']), FILTER_SANITIZE_STRING); 
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $userid = $_COOKIE['id'];
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$userid'");
    $useracc = $result->fetch_assoc();
    if ($useracc['activated'] == 1) {
        $mysql->query("INSERT INTO `user_rights`(`community_id`, `user_id`, `rights_type`) VALUES ('$communityid','$id','2')");
        exit("<meta http-equiv='refresh' content='0; url= /../communities.php'>");
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>