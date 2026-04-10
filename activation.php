<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Активация</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
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
                <h1 style="text-align: center; margin-top: 30px; margin-left: 15px; margin-right: 15px; margin-bottom: 15px; font-size: 36px">Активация</h1>
            </li>
        </ul>
        <div class="teachers">
            <form action="../php/settings.php" method="post" enctype="multipart/form-data" height="100%">
                    <?php
                    ini_set('display_errors', 'Off');
                        use PHPMailer\PHPMailer\PHPMailer;
                        use PHPMailer\PHPMailer\Exception;
                        require_once "php/vendor/autoload.php";
                        $id = $_COOKIE['id'];
                        $user = $_COOKIE['user'];
                        $mysql = new mysqli('localhost', 'root', '', 'register-bd');
                        $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
                        $user = $result->fetch_assoc();
                        if ($user['email'] != '' && $_GET['email'] == '') {
                            $email = $user['email'];
                            $mail = new PHPMailer;
                            // увеличиваем таймаут
                            $mail->CharSet = 'utf-8';
                            $mail->isSMTP();                                      // Set mailer to use SMTP
                            $mail->Host = '';  																							// Specify main and backup SMTP servers
                            $mail->SMTPAuth = true;                               // Enable SMTP authentication
                            $mail->Username = '';
                            $mail->Password = '';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                         // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров
                            $mail->setFrom(''); 
                            $mail->FromName = 'Lavkaweb';
                            $mail->addAddress($email);      
                            $mail->isHTML(true);                                 
                            $mail->Subject = 'Подтверждение адреса электронной почты';
                            $mail->Body    = '
                            <!DOCTYPE html>
                            <html lang="ru">
                                <head>
                                    <title>Лавкавэб</title>
                                    <meta charset="utf-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
                                    <style>
                                        html, body{
                                            width: 100%;
                                            height: 100%;
                                            margin: 0;
                                            font-family: sans-serif;
                                        }
                                        h1 {
                                            text-align: center;
                                            font-size: calc(20px + 1vw)
                                        }
                                        div {
                                            font-size: calc(6px + 1vw);
                                            margin: 5px;
                                            text-align: center;
                                        }
                                        table {
                                            text-align: center; 
                                            width: 60%;
                                            margin-left: 20%;
                                            margin-right: 20%;
                                            margin-top: 40px;
                                            margin-bottom: 40px;
                                        }
                                        a {
                                            color: white;
                                            text-decoration: none;
                                        }
                                        a:hover {
                                            color: white;
                                        }
                                        .button {
                                            text-align: center;
                                            font-size: calc(4px + 2vw);
                                            margin: 50px;
                                            margin-left: 120px;
                                            margin-right: 120px;
                                            width: 200px;
                                            height: 50px;
                                            background-color: #587be4;
                                            border-radius: 14px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h1>Здравствуйте!</h1>
                                    <div>Для активации вашего аккаунта в Лавкавэб необходимо подтвердить адрес электронной почты. Для подтверждения нажмите на кнопку ниже.</div>
                                    <table>
                                        <tr>
                                            <td class="button">
                                                <a style="color: white;" href="localhost/confirm.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '&email=' . md5($user['email']) .'">Подтвердить</a>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="margin-bottom: 5px;">Если вы не пытались активировать аккаунт в Лавкавэб и получили это письмо по ошибке, то просто проигнорируйте его.</div>
            <div>В письме нету кнопки? Нажмите <a href="localhost/confirm.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '&email=' . md5($user['email']) .'">сюда</a>.</div>
                                </body>
                            </html>
                            ';
                            $mail->AltBody = '';

                            if( !$mail->send() ) {
                                echo "Произошла неизвестная ошибка: ". $mail->ErrorInfo . ". Попробуйте связаться с администратором сети.";
                            } else {
                                echo 'Письмо отправлено!';
                            }
                        } else {
                            echo '
                            <p style="margin-bottom: 10px; font-size: 18px">Для активации вашего аккаунта в Лавкавэб необходимо подтвердить адрес электронной почты. Дальнейшие инструкции будут присланы вам на почту.</p>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Введите новый email" value="' . $_GET['email'] . '">
                            <button class="btn btn-success" type="submit" style="font-size: 1.15em; margin-top: 10px">Отправить</button>
                            ';
                        }
                    ?>
            </form>
            <div class="message mt-2" id="message"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="js/activate.js?<?php echo time();?>"></script>
    </body>
</html>