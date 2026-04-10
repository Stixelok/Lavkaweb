<?php
    ini_set('display_errors', 'Off');
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING); 
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 
    $password = md5($password."wofnmo1580");
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    $user = $result->fetch_assoc();
    if ($user == Array()) {
        echo "Неправильный логин или пароль. <a style='text-decoration: none' href='passwordresetmail.php'>Забыли пароль?</a>";
        exit();
    }
    setcookie('id', $user['id'], time() + 3600 * 24 * 30, '/');
    setcookie('user', $user['name'], time() + 3600 * 24 * 30, '/');
    setcookie('check', md5($user['id']."wofnmo1580".$user['name']), time() + 3600 * 24 * 30, '/');
    $mysql->close();
    exit("<meta http-equiv='refresh' content='0; url= /'>");
?>