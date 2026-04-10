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
        <link rel="stylesheet" type="text/css" href="css/calculator.css?<?php echo time();?>">
    </head>
    <body>
        <section>
        <section>
            <ul>
                <li>
                    <a href="index.php">
                        <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
                    </a>
                </li>
                <li>
                    <div class="title">
                        <h1>Калькулятор</h1>
                    </div>
                </li>
                <li>
                    <div class="panel-button">
                        <div class="button-panel js-button-panel"><ion-icon class="panel-icon" name="menu-outline"></ion-icon></div>
                    </div>
                </li>
            </ul>
            <?php
            $id = $_COOKIE['id'];
            $user = $_COOKIE['user'];
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
            $user = $result->fetch_assoc();
            function update($user) {
                $dir = '/' . $user['user_folder'] . '/'; // Папка с изображениями на сервере
                $f = scandir($_SERVER['DOCUMENT_ROOT'].$dir);
                $count = 1;
                foreach ($f as $file){
                    if(preg_match('/\.(txt)/', $file)){ // Выводим только .png
                        $s = file_get_contents(substr($dir.$file, 1));
                        echo '
                        <div class="panel-load" id="' . $count . '" data-index-number="' . substr($s, 5) . '">
                            <p class="load-name">' . substr($file, 0, -4) . '</p>
                            <p class="load-score">Средний балл: ' . substr($s, 0, 4) . '</p>
                        </div>
                        ';
                        $count += 1;
                    }
                }
            }
            echo '
            <div class="overlay js-overlay-panel">
                <div class="panel js-panel-campaign panel-initial" id="panel">
                    <div class="main-panel">
                        <div class="load-page load-initial" id="load-page"> 
                            <p class="panel-title">Загрузить</p>
                            <button class="create-button" id="save"><ion-icon class="button-icon" name="add-outline"></ion-icon></button>
                            <hr>';
                            update($user);
                            echo '
                        </div>  
                        <div class="save-page save-initial" id="save-page">
                        <button class="return-button" id="load"><ion-icon class="button-icon" name="caret-back-circle-outline"></ion-icon></button>
                            <form action="php/savemarks.php" method="post" enctype="multipart/form-data">
                                <p class="panel-title">Сохранить</p>
                                <button class="create-button" id="save-button"><ion-icon class="button-icon" name="add-outline"></ion-icon></button>
                                <hr>
                                <input class="name-form" type="text" class="form-control" name="name" id="name" placeholder="Придумайте название">
                            </form>
                            <div class="message mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>';
            ?>
            <ul style="list-style: none; margin: 0;">
                <li><button id="button5" class="button">5</button></li>
                <li><button id="button4" class="button">4</button></li>
                <li><button id="button3" class="button">3</button></li>
                <li><button id="button2" class="button">2</button></li>
            </ul>
            <!-- <p class="nikolotik-mode">Режим Николоточки</p> 
            <label class="switch">
                <input type="checkbox" id="checkbox">
                <span class="slider round"></span>
            </label> -->
            <ul class="info-list">
                <li>
                    <p style="margin-left: 15px;">Средний балл: </p>
                </li>
                <li>
                    <p id="mark" class="mark-num">0.00</p>
                </li>
            </ul>
            <ul id="marks_list" class="marks-list"></ul>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/calculator.js?<?php echo time();?>"></script>
    </body>
</html>