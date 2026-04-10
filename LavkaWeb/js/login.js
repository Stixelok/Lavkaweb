$('form').on('submit', function() {
    var login = $(this).find('input[name="login"]').val();
    var password = $(this).find('input[name="password"]').val();
    $.post(
        '../php/auth.php',
        {'login': login, 'password': password},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});