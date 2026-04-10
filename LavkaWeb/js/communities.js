$('form').on('submit', function() {
    var username = $(this).find('input[name="username"]').val();
    document.getElementById('users').innerHTML = '<div class="spinner"></div>';
    $.post(
        'php/search.php',
        {'username': username, 'type': 2},
        function(data) {
            $('.users').html(data);
        }
    );
    return false;
});