<?php
    ini_set('display_errors', 'Off');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING); 
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING); 
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING); 
    $terms = filter_var(trim($_POST['terms']), FILTER_SANITIZE_STRING);
    if ($terms == 'false') {
        echo 'Примите условия пользования.';
        exit();
    }
    if (mb_strlen($login) < 4 || mb_strlen($login) > 90) {
        echo "Недопустимая длина логина.";
        exit();
    } else if (mb_strlen($name) < 2 || mb_strlen($name) > 25) {
        echo "Недопустимая длина имени.";
        exit();
    } else if (mb_strlen($password) < 4 || mb_strlen($password) > 90) {
        echo "Недопустимая длина пароля.";
        exit();
    } else if (mb_strlen($email) < 5) {
        echo "Некорректный email.";
        exit();
    }
    $image = "images/defaultuserimage.jpg";
    $folder = "users/" . $login;
    $password = md5($password."wofnmo1580");
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $mysql->query("INSERT INTO `users` (`login`, `password`, `name`, `profile_image`, `user_folder`, `email`) VALUES('$login', '$password', '$name', '$image', '$folder', '$email')");
    $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    $mysql->close();
    $user = $result->fetch_assoc();
    setcookie('id', $user['id'], time() + 3600 * 24 * 30, '/');
    setcookie('user', $user['name'], time() + 3600 * 24 * 30, '/');
    setcookie('check', md5($user['id']."wofnmo1580".$user['name']), time() + 3600 * 24 * 30, '/');
    mkdir("../users/" . $login);
    echo 'Пользователь добавлен!';
    sleep(1);
    exit("<meta http-equiv='refresh' content='0; url= /'>");
?>