<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Изменить пароль</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/passwordchange.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <div class="container mt-4">
            <a href="../settings.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <h1>Изменить пароль</h1>
            <form method="post">
                <input type="password" class="form-control" name="password" id="password" placeholder="Введите текущий пароль"><br>
                <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Придумайте новый пароль"><br>
                <input type="password" class="form-control" name="repeat-password" id="repeat-password" placeholder="Повторите новый пароль"><br>
                <a href="../passwordresetmail.php" style="font-size:18px; text-decoration: none; margin-left: 5px;">Забыли пароль?</a>
                <div style="text-align: center; margin-top: 10px">
                    <button class="button btn btn-success" type="submit">Изменить пароль</button>
                </div>
            </form>
            <div class="message mt-3" style="text-align: center;"></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="../js/passwordchange.js?<?php echo time();?>"></script>
    </body>
</html>