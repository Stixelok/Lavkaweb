<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Добавить админа</title>
        <link rel="shortcut icon" href="../images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/settings.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
    <?php // Проверка входа
            $id = $_GET['id'];
            $userid = $_COOKIE['id'];
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `user_rights` WHERE `community_id` = '$id' AND `user_id` = '$userid' AND `rights_type` = 1");
            $user_right = $result->fetch_assoc();
            $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$id'");
            $community = $result->fetch_assoc();
            if ($user_right == Array()) {
                header("Location: /../community.php?id=$id");
            } if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /../login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /../login.html");
            }
            echo '
            <form action="php/search.php" method="post" enctype="multipart/form-data">        
            <ul class="search-list">
                <li>
                    <a href="communitysecurity.php?id=' . $community['id'] . '" style="-webkit-tap-highlight-color: transparent;">
                        <ion-icon name="caret-back-circle-outline" class="back-icon"></ion-icon>
                    </a>
                </li>
                <li>
                    <input type="text" name="username" placeholder="Поиск..." class="search-input"><br>  
                </li>   
            </ul>
            </form>
            <hr>
            <div class="users" id="users">
                <div style="text-align: center; margin-top: 10vh;">
                    <img src="../images/user.jpg" style="border-radius: 40px 40px 40px 40px;" width="100">
                    <div class="title">
                        <img src="../images/lavkalogo.png" width="158" height="28">
                    </div>
                </div>
            </div>
            ';
            ?>
        <div class="message"></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="../js/settings/newadmin.js?<?php echo time();?>"></script>
    </body>
</html>