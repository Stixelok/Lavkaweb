
function addAdmin(id) {
    var params = window.location.search.replace('?','').split('&').reduce(function(p,e){var a = e.split('=');p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);return p;},{});
    var result = confirm('Вы хотите назначить этого пользователя администратором сообщества?');
    if (result) {
        $.post(
            '../php/settings/newadmin.php',
            {'id': id, 'community_id': params['id']},
            function(data) {
                $('.message').html(data);
            }
        );
        return false;
    }
}
$('form').on('submit', function() {
    var username = $(this).find('input[name="username"]').val();
    document.getElementById('users').innerHTML = '<div class="spinner"></div>';
    $.post(
        '../php/searchadmin.php',
        {'username': username, 'type': 1},
        function(data) {
            $('.users').html(data);
        }
    );
    return false;
});