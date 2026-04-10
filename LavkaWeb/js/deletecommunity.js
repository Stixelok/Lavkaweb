$('form').on('submit', function() {
    var params = window.location.search.replace('?','').split('&').reduce(function(p,e){var a = e.split('=');p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);return p;},{});
    var password = $(this).find('input[name="password"]').val();
    $.post(
        '../php/deletecommunity.php',
        {'id': params['id'], 'password': password},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});