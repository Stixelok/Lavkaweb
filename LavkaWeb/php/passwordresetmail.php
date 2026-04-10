<?php
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING); 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login'");
    $user = $result->fetch_assoc();
    if ($user != null && $user['id'] != '' && $user['email'] != '') {
        $email = $user['email'];
        $mail = new PHPMailer;
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
        $mail->Subject = 'Сброс пароля от аккаунта';
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
                <div>Для вашего аккаунта был запрошен сброс пароля. Для сброса нажмите на кнопку ниже.</div>
                <table>
                    <tr>
                        <td class="button">
                            <a style="color: white;" href="localhost/passwordreset.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '">Сброс</a>
                        </td>
                    </tr>
                </table>
                <div>Если вы не пытались сбросить пароль от аккаунта в Лавкавэб и получили это письмо по ошибке, то просто проигнорируйте его.</div>
                <div>В письме нету кнопки? Нажмите <a href="localhost/passwordreset.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '">сюда</a>.</div>
            </body>
        </html>
        ';
        $mail->AltBody = '';

        if( !$mail->send() ) {
            echo "Произошла неизвестная ошибка: ". $mail->ErrorInfo . ". Попробуйте связаться с администратором сети.";
        } else {
            echo 'Письмо отправлено!';
        }
    } else if ($user != null && $user['id'] != '' && $user['email'] != '') {
        echo 'Email для восстановления не найден. Невозможно сбросить пароль от данного аккаунта. Попытайтесь вспомнить пароль или обратитесь в службу поддержки.';
    } else {
        echo 'Неправильный логин.';
    }
?>