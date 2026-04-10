$('form').on('submit', function() {
    var login = $(this).find('input[name="login"]').val();
    $.post(
        '../php/passwordresetmail.php',
        {'login': login},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});