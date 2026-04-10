<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Профиль</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/settings.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <?php // Проверка входа
        ini_set('display_errors', 'Off');   
            if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /login.html");
            }
        ?>
        <div class="container mt-4">
            <a href="userprofile.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
                <?php
                    $id = $_COOKIE['id'];
                    $user = $_COOKIE['user'];
                    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                    $user = $result->fetch_assoc();
                    echo '
                        <div class="logo"><img src="'. $user['profile_image'] . '?<?php echo time();?>" class="logo-image" width="140" height="140"></div>
                        <h1 class="main-text">' . $user['name'] . '</h1>
                        <a href="settings/account.php">
                            <div class="settings-tab">
                                <ul>
                                    <li>
                                        <ion-icon name="person-outline" class="settings-icon"></ion-icon>
                                    </li>
                                    <li>
                                        <p>Аккаунт</p>
                                    </li>
                                </ul>
                            </div>
                        </a>
                        <hr>
                        <a href="settings/private.php">
                            <div class="settings-tab">
                                <ul>
                                    <li>
                                        <ion-icon name="lock-closed-outline" class="settings-icon"></ion-icon>
                                    </li>
                                    <li>
                                        <p>Приватность</p>
                                    </li>
                                </ul>
                            </div>
                        </a>
                        <hr>';
                        /*
                        <hr>
                        <a href="settings/security.php">
                            <div class="settings-tab">
                                <ul>
                                    <li>
                                        <ion-icon name="finger-print-outline" class="settings-icon"></ion-icon>
                                    </li>
                                    <li>
                                        <p>Безопасность</p>
                                    </li>
                                </ul>
                            </div>
                        </a> */
                if ($user['activated'] == 0) {
                    echo '<div class="message mt-2" id="notacitve" style="font-size:20px;">Ваш аккаунт не активирован. Пока вы не подтвердите ваш email, вы не сможете выполнять какие-либо действия.</div>                       
                    <div style="margin-top: 23px; font-size: 0.9em;">
                        <a href="../activation.php" class="settings-button">Активировать</a>
                    </div>';
                }
                ?>
        </div>
        <div class="message mt-2" id="message"></div>
        <div style="position: absolute; bottom: 4%; width: 100%; margin: 0;">
            <div style="display: flex; justify-content: center;">
                <a href="php/logout.php" class="logout-link">Выйти</a>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    </body>
</html>