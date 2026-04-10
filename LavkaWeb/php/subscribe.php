<?php
ini_set('display_errors', 'Off');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    if ($_COOKIE['id'] != '') {
        $userid = filter_var(trim($_POST['creator_id']), FILTER_SANITIZE_STRING); 
        $type = $_POST['type'];
        $mysql = new mysqli('localhost', 'root', '', 'register-bd');
        $id = $_COOKIE['id'];
        $time = date("Y-m-d H:i:s");
        $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
        $user = $result->fetch_assoc();
        if ($user['activated'] == 1) {
            if ($_POST['newsubscribe'] == 'add') {
                $mysql->query("INSERT INTO `subscribers` (`creator_id`, `user_id`, `type`, `time`) VALUES('$userid', '$id', '$type', '$time')");
                if ($type == '1') {
                    $mysql->query("INSERT INTO `notifications`(`creator_id`, `type`, `user_id`, `time`) VALUES ('$userid','3','$id', '$time')");
                    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$userid'");
                    $creator = $result->fetch_assoc();
                    if ($creator['email'] != '' && $creator['email_notifications'] == 1) {
                        $email = $creator['email'];
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
                        $mail->Subject = '' . $user['name'] . ' подписался(ась) на вас';
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
                                <h3>' . $user['name'] . ' подписался(ась) на вас</h3>
                                <div>Перейти к аккаунту пользователя можно по кнопке ниже.</div>
                                <table>
                                    <tr>
                                        <td class="button">
                                            <a style="color: white;" href=localhost/userpage.php?id=' . $user['id'] . '">Перейти</a>
                                        </td>
                                    </tr>
                                </table>
                                <div>Отключить перессылку уведомлений на почту можно в настройках аккаунта.</div>
                                <div>В письме нету кнопки? Нажмите <a href="localhost/userpage.php?id=' . $user['id'] . '">сюда</a>.</div>
                            </body>
                        </html>
                        ';
                        $mail->AltBody = '';
                
                        if(!$mail->send() ) {
                            echo "Произошла неизвестная ошибка: ". $mail->ErrorInfo . ". Попробуйте связаться с администратором сети.";
                        }
                    }
                    $result = $mysql->query("SELECT `subscribers` FROM `users` WHERE `id` = '$userid'");
                    $user = $result->fetch_assoc();
                    $subscribers = $user['subscribers'] + 1;
                    $mysql->query("UPDATE `users` SET `subscribers` = '$subscribers' WHERE `id` = '$userid'");
                } else {
                    $result = $mysql->query("SELECT `subscribers` FROM `communities` WHERE `id` = '$userid'");
                    $community = $result->fetch_assoc();
                    $subscribers = $community['subscribers'] + 1;
                    $mysql->query("UPDATE `communities` SET `subscribers` = '$subscribers' WHERE `id` = '$userid'");  
                }
            } else {
                $mysql->query("DELETE FROM `subscribers` WHERE `creator_id` = '$userid' AND `user_id` = '$id' AND `type` = $type");
                if ($type == '1') { 
                    $mysql->query("DELETE FROM `notifications` WHERE `creator_id` = '$userid', `type` = '3', `user_id` = '$id')");
                    $result = $mysql->query("SELECT `subscribers` FROM `users` WHERE `id` = '$userid'");
                    $user = $result->fetch_assoc();
                    $subscribers = $user['subscribers'] - 1;
                    $mysql->query("UPDATE `users` SET `subscribers` = '$subscribers' WHERE `id` = '$userid'");
                } else {
                    $result = $mysql->query("SELECT `subscribers` FROM `communities` WHERE `id` = '$userid'");
                    $community = $result->fetch_assoc();
                    $subscribers = $community['subscribers'] - 1;
                    $mysql->query("UPDATE `communities` SET `subscribers` = '$subscribers' WHERE `id` = '$userid'");  
                }
            }
            $mysql->close();
        } else {
            exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
        }
    }
?>