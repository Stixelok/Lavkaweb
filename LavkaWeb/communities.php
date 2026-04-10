<!DOCTYPE html>
<html>
    <head>
        <title>Сообщества - Поиск</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/communities.css?<?php echo time();?>">
    </head>
    <body>
        <form action="php/search.php" method="post" enctype="multipart/form-data">        
        <ul class="search-list">
            <li>
                <a href="lounge.php" style="-webkit-tap-highlight-color: transparent;">
                    <ion-icon name="caret-back-circle-outline" class="back-icon"></ion-icon>
                </a>
            </li>
            <li>
                <input type="search" name="username" placeholder="Поиск сообществ..." class="search-input"><br>  
            </li>   
            <li>
                <a href="newcommunity.php" class="search-button">
                    <ion-icon name="add-outline" class="search-icon"></ion-icon>
                </a>
            </li>
        </ul>
        </form>
        <hr>
        <div class="users" id="users">
        <?php
            ini_set('display_errors', 'Off');
                $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                $result = $mysql->query("SELECT * FROM `communities`");
                $users = $result->fetch_all();
                $count = 0;
                foreach ($users as $user) {
                    $count++;
                    echo '
                    <a href="community.php?id=' . $user[0] . '" style="-webkit-tap-highlight-color: transparent;">
                    <div class="user">
                        <ul>
                            <li>
                                <img src="' . $user[3] . '" width="100" height="100" class="user-image">
                            </li>
                            <li>
                                <p class="user-name"><b>' . $user[1] . '</b></p>
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
                if ($count == 0) {
                    echo '
                    <p style="text-align: center; font-size: 1.2em;">К сожалению, сообществ не найдено.</p>
                    ';
                }
            $mysql->close();
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/communities.js?<?php echo time();?>"></script>
    </body>
</html>