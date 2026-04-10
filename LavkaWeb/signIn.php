<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Регистрация</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/userinterface.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <div class="container mt-4">
            <a href="index.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <h1>Регистрация</h1>
            <form method="post">
                <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
                <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль"><br>
                <input type="text" class="form-control" name="name" id="name" placeholder="Придумайте никнейм"><br>
                <input type="email" class="form-control" name="email" id="email" placeholder="Введите ваш email">
                <input type="checkbox" class="terms" id="terms" name="terms"> Я принимаю <a href="termsOfUse.php" style="color: blue; text-decoration: none;">условия пользования</a></input>
                <button class="button btn btn-success" type="submit">Зарегистрировать</button>
            </form>
            <div class="message mt-3"></div>
            <p class="text mt-3">Уже зарегистрированы? <a href="login.php" class="link">Войти</a></p>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="js/signin.js?<?php echo time();?>"></script>
    </body>
</html>