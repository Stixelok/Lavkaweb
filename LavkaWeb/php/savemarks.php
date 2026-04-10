<?php
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING); 
    $marks = filter_var(trim($_POST['marks']), FILTER_SANITIZE_STRING); 
    $score = filter_var(trim($_POST['score']), FILTER_SANITIZE_STRING);
    $id = $_COOKIE['id'];
    $user = $_COOKIE['user'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    $dir = '.../' . $user['user_folder'] . '/'; // Папка с изображениями на сервере
    $str = $score . ' ' . $marks;
    $fd = fopen(substr($dir, 1) . $name . ".txt", 'w') or die("не удалось создать файл");
    fwrite($fd, $str);
    fclose($fd);
    echo substr($dir, 1) . $name . ".txt";
?>