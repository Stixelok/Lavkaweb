<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Новый пост</title>
        <link rel="shortcut icon" href="images/logo.png?<?php echo time();?>" size="25x25">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/userinterface.css?<?php echo time();?>">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <?php // Проверка входа
            if ($_COOKIE['user'] == '' || $_COOKIE['id'] == '' || $_COOKIE['check'] == '') {
                header("Location: /login.html");
            } else if ($_COOKIE['check'] != md5($_COOKIE['id']."wofnmo1580".$_COOKIE['user'])) {
                header("Location: /login.html");
            }
        ?>
        <div class="container mt-4">
            <a href="userprofile.php">
                <ion-icon class="return" name="caret-back-circle-outline"></ion-icon>
            </a>
            <?php
                echo '<h1>'. $_COOKIE['user'] . '</h1>'
            ?>
    <form action="php/upload.php" method="post" enctype="multipart/form-data">
        <input type="text" class="form-control" name="title" id="title" placeholder="Введите название">
        <div id="picture-box" class="picture">
            <img src="" id="img1" width="100%" style="border-radius: 5px 5px 5px 5px;"> 
        </div>
        <input id="picture" type="file" name="sortpic" accept="image/*,video/*"/>
        <button id="upload" class="btn btn-success" style="margin-top: 10px; text-align: center;">Опубликовать</button>
    </form>
    <div class="message mt-2" id="message"></div>
  <!-- Ajax JavaScript File Upload Logic -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script>
    $('form').on('submit', function() {
        var title = $(this).find('input[name="title"]').val();
        document.getElementById("upload").disabled = 'true';
        document.getElementById("message").textContent = 'Загрузка...';
        var type = 1;
        var file_data = $('#picture').prop('files')[0];
        var form_data = new FormData();
        form_data.append('title', title);
        form_data.append('file', file_data);
        form_data.append('type', type);
        $.ajax({
            url: 'php/upload.php', // <-- point to server-side PHP script 
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,               
            type: 'post',
            success:         
            function(data) {
                $('.message').html(data);
            }
        });
        return false;
    });
  </script>
  <script type="text/javascript" src="js/upload.js?<?php echo time();?>"></script>
    </body>
</html>