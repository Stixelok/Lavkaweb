$('form').on('submit', function() {
    var email = $(this).find('input[name="email"]').val();
    $.post(
        '../php/activation.php',
        {'email': email},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});