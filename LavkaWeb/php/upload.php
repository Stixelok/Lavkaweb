<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING); 
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../upload/' . $_FILES['file']['name']);
    }
    $filename = 'upload/' . $_FILES['file']['name'];
    $id = $_COOKIE['id'];
    $name = $_COOKIE['user'];
    $time = date("Y-m-d H:i:s");
    $content = 'userprofile.php';
    $mysql = new mysqli('localhost', 'root', '', 'register-bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$id'");
    $user = $result->fetch_assoc();
    if ($user['activated'] == 1) { 
        if ($_POST['type'] == 1) {
            $mysql->query("INSERT INTO `posts` (`image`, `creator_id`, `creator_name`, `title`, `time`) VALUES('$filename', '$id', '$name', '$title', '$time')");
            $result = $mysql->query("SELECT * FROM `posts` WHERE `creator_id` = '$id' AND `title` = '$title'");
            $post = $result->fetch_assoc();
            $result = $mysql->query("SELECT * FROM `subscribers` WHERE `creator_id` = '$id'");
            $subscribers = $result->fetch_all();
            foreach ($subscribers as $subscriber) {
                $user_id = $subscriber[1];
                $post_id = $post['id'];
                $mysql->query("INSERT INTO `notifications`(`creator_id`, `type`, `user_id`, `post_id`, `time`) VALUES ('$user_id','4','$id','$post_id', '$time')");
                $result = $mysql->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
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
                    $mail->Subject = $user['name'] . ' выложил новый пост';
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
                            <h3>' . $user['name'] . ' выложил новый пост</h3>
                            <div>Перейти к аккаунту пользователя можно по кнопке ниже.</div>
                            <table>
                                <tr>
                                    <td class="button">
                                        <a style="color: white;" href="localhost/userpage.php?id=' . $user['id'] . '">Перейти</a>
                                    </td>
                                </tr>
                            </table>
                            <div>Отключить перессылку уведомлений на почту можно в настройках аккаунта.</div>
                            <div>В письме нету кнопки? Нажмите <a href="localhost/userpage.php?id=' . $user['id'] . '">сюда</a>.</div>
                        </body>
                    </html>
                    ';
                }
            }
        } else {
            $communityid = $_POST['community_id'];
            $result = $mysql->query("SELECT * FROM `communities` WHERE `id` = '$communityid'");
            $community = $result->fetch_assoc();
            $name = $community['name'];
            $mysql->query("INSERT INTO `posts` (`image`, `creator_id`, `creator_name`, `title`, `time`, `is_community`) VALUES('$filename', '$communityid', '$name', '$title', '$time', '1')");
            $content = "community.php?id=$communityid";
        }
        $mysql->close();
        echo 'Запись добавлена!';
        sleep(2);
        exit("<meta http-equiv='refresh' content='0; url= /../$content'>");
    } else {
        exit("<meta http-equiv='refresh' content='0; url= /../settings.php'>");
    }
?>