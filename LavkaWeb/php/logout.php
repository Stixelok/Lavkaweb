<?php
    setcookie('id', $user['id'], time() - 3600 * 24 * 30, '/');
    setcookie('user', $user['name'], time() - 3600 * 24 * 30, '/');
    setcookie('check', md5($user['id']."wofnmo1580".$user['name']), time() - 3600 * 24 * 30, '/');
    header("Location: /");
?>