<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    $postid = filter_var(trim($_POST['post_id']), FILTER_SANITIZE_STRING);
    $text = filter_var(trim($_POST['text']), FILTER_SANITIZE_STRING);
    $id = $_COOKIE['id'];
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $time = date("Y-m-d H:i:s");
    $result = $mysql->query("SELECT * FROM `posts` WHERE `id` = '$postid'");
    $post = $result->fetch_assoc();
    $creatorid = $post['creator_id'];
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) {
        $mysql->query("INSERT INTO `comments` (`post_id`, `user_id`, `text`, `time`) VALUES('$postid', '$id', '$text', '$time')");
        if ($creatorid != $id) {
            $mysql->query("INSERT INTO `notifications`(`creator_id`, `type`, `user_id`, `post_id`, `time`) VALUES ('$creatorid','2','$id','$postid', '$time')");
            $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$creatorid'");
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
                $mail->Subject = '' . $user['name'] . ' оставил(а) комментарий к вашему посту';
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
                        <h3>' . $user['name'] . ' оставил(а) комментарий к вашему посту</h3>
                        <div>Перейти к посту можно по кнопке ниже.</div>
                        <table>
                            <tr>
                                <td class="button">
                                    <a style="color: white;" href="localhost/post.php?id=' . $post['id'] . '">Перейти</a>
                                </td>
                            </tr>
                        </table>
                        <div>Отключить перессылку уведомлений на почту можно в настройках аккаунта.</div>
                        <div>В письме нету кнопки? Нажмите <a href="localhost/post.php?id=' . $post['id'] . '">сюда</a>.</div>
                    </body>
                </html>
                ';
                $mail->AltBody = '';
        
                if(!$mail->send() ) {
                    echo "Произошла неизвестная ошибка: ". $mail->ErrorInfo . ". Попробуйте связаться с администратором сети.";
                }
            }
        }
        $result = $mysql->query("SELECT `comments` FROM `posts` WHERE `id` = '$postid'");
        $post = $result->fetch_assoc();
        $comments = $post['comments'] + 1;
        $mysql->query("UPDATE `posts` SET `comments` = '$comments' WHERE `id` = '$postid'");
        $mysql->close();
        exit("<meta http-equiv='refresh' content='0; url= /post.php?id=" . $postid . "'>");
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>