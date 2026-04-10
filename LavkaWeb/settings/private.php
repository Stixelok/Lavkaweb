<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Профиль</title>
        <link rel="shortcut icon" href="../images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/settings.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <div class="container mt-4">
            <a href="../settings.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <h1 class="main-text">Приватность</h1>
                <?php
                ini_set('display_errors', 'Off');
                    $id = $_COOKIE['id'];
                    $user = $_COOKIE['user'];
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                    $user = $result->fetch_assoc();
                    echo '
                        <hr>
                        <div style="position:relative; margin-top: 8px">
                    ';
                    if ($user['search_hide'] == 0) {
                        echo '
                        <ul class="set-container">
                            <li>
                                <p class="slider-header">Скрыть аккаунт в поиске</p>
                            </li>
                            <li>
                                <div class="slider-container">
                                    <label class="switch" for="search-hide">
                                        <input type="checkbox" id="search-hide" />
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <p class="slider-text">Когда эта функция включена, ваш аккаунт можно будет найти используя только ID пользователя.</p>
                            </li>
                        </ul>
                        ';
                    } else {
                        echo '
                        <ul class="set-container">
                            <li>
                                <p class="slider-header">Скрыть аккаунт в поиске</p>
                            </li>
                            <li>
                                <div class="slider-container">
                                    <label class="switch" for="search-hide">
                                        <input type="checkbox" id="search-hide" checked="checked"/>
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <p class="slider-text">Когда эта функция включена, ваш аккаунт можно будет найти используя только ID пользователя.</p>
                            </li>
                        </ul>
                        ';
                    }
                    if ($user['subscribers_hide'] == 0) {
                        echo '
                        <ul class="set-container">
                            <li>
                                <p class="slider-header">Скрыть своих подписчиков</p>
                            </li>
                            <li>
                                <div class="slider-container">
                                    <label class="switch" for="subscribers-hide">
                                        <input type="checkbox" id="subscribers-hide" />
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <p class="slider-text">Когда эта функция включена, ваших подписчиков будете видеть только вы. По умолчании их видят все пользователи.</p>
                            </li>
                        </ul>
                        ';
                    } else {
                        echo '
                        <ul class="set-container">
                            <li>
                                <p class="slider-header">Скрыть своих подписчиков</p>
                            </li>
                            <li>
                                <div class="slider-container">
                                    <label class="switch" for="subscribers-hide">
                                        <input type="checkbox" id="subscribers-hide" checked="checked"/>
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <p class="slider-text">Когда эта функция включена, ваших подписчиков будете видеть только вы. По умолчании их видят все пользователи.</p>
                            </li>
                        </ul>
                        ';
                    }
                    echo '
                    <ul class="set-container">
                        <li>
                            <p class="slider-header" style="margin-right: 60px">Уведомления на почте</p>
                        </li>
                        <li>
                            <div class="slider-container">
                                <label class="switch" for="emailmessages-hide">';
                    if ($user['email_notifications'] == 0) {
                        echo '
                            <input type="checkbox" id="emailmessages-hide" />';
                    } else {
                        echo '
                            <input type="checkbox" id="emailmessages-hide" checked="checked"/>';
                    }
                    echo '                                       
                                        <div class="slider round"></div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <p class="slider-text">Когда эта функция включена, ваши уведомления будут также приходить на почту. Важные уведомления будут приходить на почту, даже если эта функция отключена.</p>
                            </li>
                        </ul>
                    </div>';
                ?>
        <div class="message mt-2" id="message"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="../js/settings/private.js?<?php echo time();?>"></script>
    </body>
</html>
    