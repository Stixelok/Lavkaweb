$('form').on('submit', function() {
    var password = $(this).find('input[name="password"]').val();
    var newpassword = $(this).find('input[name="new-password"]').val();
    var repeatpassword = $(this).find('input[name="repeat-password"]').val();
    $.post(
        '../php/settings/passwordchange.php',
        {'password': password, 'newpassword': newpassword, 'repeatpassword': repeatpassword},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});