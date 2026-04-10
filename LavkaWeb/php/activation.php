<?php
ini_set('display_errors', 'Off');
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING); 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    $id = $_COOKIE['id'];
    $user = $_COOKIE['user'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $mysql->query("UPDATE `users` SET `email` = '$email' WHERE `id` = '$id'");
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    $mail = new PHPMailer;
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
    $mail->Body = '
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
                        <a style="color: white;" href="localhost/confirm.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '&email=' . $user['email'] .'">Подтвердить</a>
                    </td>
                </tr>
            </table>
            <div style="margin-bottom: 5px;">Если вы не пытались активировать аккаунт в Лавкавэб и получили это письмо по ошибке, то просто проигнорируйте его.</div>
            <div>В письме нету кнопки? Нажмите <a href="localhost/confirm.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '&email=' . $user['email'] .'">сюда</a>.</div>
        </body>
    </html>
    ';
    $mail->AltBody = '';

    if( !$mail->send() ) {
        echo "Произошла неизвестная ошибка: ". $mail->ErrorInfo . ". Попробуйте связаться с администратором сети.";
    } else {
        $mysql->query("UPDATE `users` SET `email`='$email' WHERE `id` = '$id'");
        $mysql->query("UPDATE `users` SET `activated`= 0 WHERE `id` = '$id'");
        echo 'Письмо отправлено!';
    }
?>