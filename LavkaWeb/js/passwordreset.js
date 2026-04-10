$('form').on('submit', function() {
    var params = window.location.search.replace('?','').split('&').reduce(function(p,e){var a = e.split('=');p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);return p;},{});
    var newpassword = $(this).find('input[name="new-password"]').val();
    var repeatpassword = $(this).find('input[name="repeat-password"]').val();
    $.post(
        'php/passwordreset.php',
        {'id': params['id'],'newpassword': newpassword, 'repeatpassword': repeatpassword},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
});