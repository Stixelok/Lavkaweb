<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING); 
    $newpassword = filter_var(trim($_POST['newpassword']), FILTER_SANITIZE_STRING); 
    $repeatpassword = filter_var(trim($_POST['repeatpassword']), FILTER_SANITIZE_STRING); 
    if (mb_strlen($newpassword) < 4 || mb_strlen($newpassword) > 90) {
        echo "Недопустимая длина пароля.";
        exit();
    } else if ($newpassword != $repeatpassword) {
        echo "Новые пароли не совпадают.";
        exit();
    }
    $password = md5($password."wofnmo1580");
    $id = $_COOKIE['id'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user != Array()) {
        $newpassword = md5($newpassword."wofnmo1580");
        $mysql->query("UPDATE `users` SET `password` = '$newpassword' WHERE `id` = '$id'");
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
                <div>Пароль вашего аккунта был изменен. Если это были не вы, то для сброса нажмите на кнопку ниже.</div>
                <table>
                    <tr>
                        <td class="button">
                            <a style="color: white;" href="localhost/passwordreset.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '">Сброс</a>
                        </td>
                    </tr>
                </table>
                <div>Если вы получили два оповещения о сбросе пароля, то нажмите на кнопку сброс в последнем сообщении.</div>
                <div>В письме нету кнопки? Нажмите <a href="localhost/passwordreset.php?id=' . $user['id'] . '&login=' . $user['login'] . '&check=' . md5($user['id']."actwof1580".$user['password']) . '">сюда</a>.</div>
            </body>
        </html>
        ';
        $mail->AltBody = '';

        if( !$mail->send() ) {
            echo "Произошла неизвестная ошибка: ". $mail->ErrorInfo . ". Попробуйте связаться с администратором сети.";
        }
        echo 'Пароль обновлён.';
        sleep(0.5);
    } else {
        echo "Введён неправильный пароль.";
    }
    exit("<meta http-equiv='refresh' content='0; url= /../login.php'>");
?>