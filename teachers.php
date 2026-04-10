<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Учителя</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" href="css/teachers.css?<?php echo time();?>">
        <link rel="stylesheet" href="css/search.css?<?php echo time();?>">
    </head>
    <body>
    <ul class="menu">
            <li>
                <a href="index.php" style="-webkit-tap-highlight-color: transparent;">
                    <ion-icon name="caret-back-circle-outline" style="position: absolute; margin:0; top: 30px; left: 20px"></ion-icon>
                </a>
            </li>
            <li>
                <h1 style="text-align: center; margin-top: 30px; margin-left: 15px; margin-right: 15px; margin-bottom: 15px">Учителя</h1>
            </li>
        </ul>
        <div class="teachers">
        <?php
            $mysql = new mysqli('localhost', 'root', '', 'register-bd'); 
            $result = $mysql->query("SELECT * FROM `users` WHERE `is_teacher` = 1");
            $users = $result->fetch_all();
            foreach ($users as $user) {
                echo '
                <a href="userpage.php?id=' . $user[0] . '" style="-webkit-tap-highlight-color: transparent;">
                <div class="user">
                    <ul>
                        <li>
                            <img src="' . $user[5] . '" width="100" height="100" class="user-image">
                        </li>
                        <li>
                            <p class="user-name"><b>' . $user[3] . '</b></p>
                        </li>';
                if ($user[9] == 1 || $user[8] == 1) {
                    echo '
                        <li>
                            <ion-icon name="checkmark-circle" class="check-mark"></ion-icon>
                        </li>';
                }
                echo '
                    </ul>
                </div>
                </a>';
            }
        ?>
        </div>
    </body>
</html>