<!DOCTYPE html>
<html>
    <head>
        <title>Лаунж</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="stylesheet" type="text/css" href="css/lounge.css?<?php echo time();?>">
    </head>
    <body>
        <section>
            <ul>
                <li>
                    <a href="index.php">
                        <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
                    </a>
                </li>
                <li>
                    <div class="title">
                        <h1>Лаунж</h1>
                    </div>
                </li>
            </ul>
        </section>
        <section class="tabs">
            <div class="tab">
                <a href="communities.php">
                    <div class="community-container">
                        <img src="images/community.jpeg?<?php echo time();?>" class="community-image" id="community-image" width="100%" height="100%">
                        <p class="community-text" id="community-text">Сообщества</p>
                    </div>
                </a>
            </div>
            <!-- <div class="tab">
                <a href="stickers.php">
                    <div class="community-container">
                        <img src="images/stickers.jpg" class="community-image" id="community-image" width="100%" height="100%">
                        <p class="community-text" id="community-text">Стикеры</p>
                    </div>
                </a>
            </div> -->
            <div class="tab">
                <a href="calculator.php">
                    <div class="community-container">
                        <img src="images/calculator_old1.jpg" class="community-image" id="community-image" width="100%" height="100%">
                        <p class="community-text" id="community-text" style="font-size: 2.1em">Калькулятор оценок</p>
                    </div>
                </a>
            </div>
        </section>
    </body>
</html>