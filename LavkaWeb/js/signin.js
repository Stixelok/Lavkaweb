$('form').on('submit', function() {
    var login = $(this).find('input[name="login"]').val();
    var password = $(this).find('input[name="password"]').val();
    var name = $(this).find('input[name="name"]').val();
    var email = $(this).find('input[name="email"]').val();
    var terms = document.getElementById("terms");
    $.post(
        '../php/check.php',
        {'login': login, 'name': name, 'password': password, 'email': email, 'terms': terms.checked},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});