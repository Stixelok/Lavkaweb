<?php
    function createImage($init, $filename, $w, $h,$endName){
        $info = new SplFileInfo($init);
        $im = null;
        if ($info->getExtension() == 'png') {
            $im = imagecreatefrompng($filename);
        } elseif ($info->getExtension() == 'gif')
            $im = imagecreatefromgif($filename);
        else {
            $im = imagecreatefromjpeg($filename);
        }
        $size = min(imagesx($im), imagesy($im));
        $max = max(imagesx($im), imagesy($im));
        $x = 0;
        $y = 0;
        if (imagesx($im) > imagesy($im)) {
            $x = ($max - $size) / 2;
        } else {
            $y = ($max - $size) / 2;
        }
        $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $size, 'height' => $size]);
        if ($im2 !== FALSE) {                    
            imagepng($im2, $endName);
            imagedestroy($im2);
        } else {
            return false;
        }
        imagedestroy($im);
        return true;
    }
    $id = $_COOKIE['id'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING); 
    if ($name != $_COOKIE['user'] || $email != $user['email'] || (sizeof($_FILES) != 0)) {
        if (mb_strlen($name) < 2 || mb_strlen($name) > 25) {
            echo "Недопустимая длина имени";
            exit();
        }
        $filename = 'upload/' . $_FILES['file']['name'];
        $checkmark_filename = 'upload/' . $_FILES['checkmark_file']['name'];
        if (sizeof($_FILES) != 0) {
            if ( 0 < $_FILES['file']['error'] ) {
                echo 'Error: ' . $_FILES['file']['error'] . '<br>';
            }
            if ( 0 < $_FILES['checkmark_file']['error'] ) {
                echo 'Error: ' . $_FILES['checkmark_file']['error'] . '<br>';
            }
            else {
                $image = $_FILES['file']['tmp_name'];
                $imageinit = $_FILES['file']['name'];
                $size = getimagesize($image);
                if ($size[0] != $size[1]) {
                    if (min($size[0], $size[1]) < 275) {
                        echo 'Ошибка сохранения файла, высота и ширина картинки должны быть больше 275 пикселей, у картинки: ' . min($size[0], $size[1]) . '.';
                        exit();
                    }
                    if (!createImage($imageinit, $image, min($size[0], $size[1]), min($size[0], $size[1]), $image)) {
                        echo 'Ошибка сохранения файла, попробуйте обрезать картинку до соотношения 1:1.';
                        exit();
                    }
                }
                move_uploaded_file($image, '../' . $user['user_folder'] . '/' . $_FILES['file']['name']);
                $image_path = $user['user_folder'] . '/' . $_FILES['file']['name'];
                $mysql->query("UPDATE `users` SET `name` = '$name', `profile_image` = '$image_path' WHERE `id` = '$id'");
            }
        } else {
            $mysql->query("UPDATE `users` SET `name` = '$name' WHERE `id` = '$id'");
        }
        $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id'");
        $posts = $result->fetch_all();
        foreach ($posts as $post) {
            $post_id = $post[0];
            $mysql->query("UPDATE `posts` SET `creator_name` = '$name' WHERE `id` = '$post_id'");
        }
        $mysql->close();
        setcookie('user', $name, time() + 3600 * 24, '/');
        setcookie('check', md5($id."wofnmo1580".$name), time() + 3600 * 24, '/');
        echo 'Данные сохранены!';
        sleep(0.5);
        if ($email != $user['email']) {
            exit("<meta http-equiv='refresh' content='0; url= /../activation.php?email=" . $email . "'>");    
        } else {
            exit("<meta http-equiv='refresh' content='0; url= /../userprofile.php'>");
        }
    }
?>