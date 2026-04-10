<!DOCTYPE html>
<html>
    <head>
        <title>Поиск</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/search.css?<?php echo time();?>">
    </head>
    <body>
        <form action="php/search.php" method="post" enctype="multipart/form-data">        
        <ul class="search-list">
            <li>
                <a href="index.php" style="-webkit-tap-highlight-color: transparent;">
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
                <img src="images/user.jpg" style="border-radius: 40px 40px 40px 40px;" width="100">
                <div class="title">
                    <img src="images/lavkalogo.png" width="158" height="28">
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/search.js?<?php echo time();?>"></script>
    </body>
</html>