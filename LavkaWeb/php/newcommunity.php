<?php
    ini_set('display_errors', 'Off');
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING); 
    $bio = filter_var(trim($_POST['bio']), FILTER_SANITIZE_STRING); 
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../upload/' . $_FILES['file']['name']);
    }
    $filename = 'upload/' . $_FILES['file']['name'];
    if ($filename == 'upload/') { 
        $filename = 'images/defaultuserimage.jpg'; 
    } 
    $id = $_COOKIE['id'];
    $owner = $id;
    if ($id == null) {
        exit("<meta http-equiv='refresh' content='0; url= /../login.php'>");
    }
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        $ownder = $id;
        $mysql->query("INSERT INTO `communities` (`name`, `bio`, `profile_image`, `owner`) VALUES('$name', '$bio', '$filename', '$owner')");
        $result = $mysql->query("SELECT * FROM `communities` WHERE `name` = '$name' AND `owner` = '$owner' AND `bio` = '$bio'");
        $community = $result->fetch_assoc();
        $communityid = $community['id'];
        $mysql->query("INSERT INTO `user_rights`(`community_id`, `user_id`, `rights_type`) VALUES ('$communityid','$owner','1')");
        $mysql->close();
        echo 'Сообщество создано!';
        sleep(1);
        exit("<meta http-equiv='refresh' content='0; url= /../communities.php'>");
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>