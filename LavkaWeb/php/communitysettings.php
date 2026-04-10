<?php
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING); 
    $bio = filter_var(trim($_POST['bio']), FILTER_SANITIZE_STRING); 
    if ($name != $_COOKIE['user'] || (sizeof($_FILES) != 0)) {
        if (mb_strlen($name) < 2 || mb_strlen($name) > 25) {
            echo "Недопустимая длина имени сообщества.";
            exit();
        }
        $filename = 'upload/' . $_FILES['file']['name'];
        $id = $_POST['id'];
        $mysql = new mysqli('localhost', 'root', '', 'register-bd');
        $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$id'");
        $user = $result->fetch_assoc();
        $userid = $_COOKIE['id'];
        $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$userid'");
        $useracc = $result->fetch_assoc();
        if ($useracc['activated'] == 1) {
            if (sizeof($_FILES) != 0) {
                if ( 0 < $_FILES['file']['error'] ) {
                    echo 'Ошибка сохранения файла: ' . $_FILES['file']['error'] . '<br>';
                }
                else {
                    move_uploaded_file($_FILES['file']['tmp_name'], '../upload/' . $_FILES['file']['name']);
                    $image_path = 'upload/' . $_FILES['file']['name'];
                    $mysql->query("UPDATE `communities` SET `name` = '$name', `bio` = '$bio', `profile_image` = '$image_path' WHERE `id` = '$id'");
                }
            } else {
                $mysql->query("UPDATE `communities` SET `name` = '$name', `bio` = '$bio' WHERE `id` = '$id'");
            }
            $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `is_community` = 1");
            $posts = $result->fetch_all();
            foreach ($posts as $post) {
                $post_id = $post[0];
                $mysql->query("UPDATE `posts` SET `creator_name` = '$name' WHERE `id` = '$post_id' AND `is_community` = 1");
            }
            $mysql->close();
            echo 'Данные сохранены!';
            sleep(0.5);
            exit("<meta http-equiv='refresh' content='0; url= /../communitysettings.php?id=" . $user['id'] . "'>");
        } else {
            exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
        }
    }
?>