window.onload = function(){
    document.getElementById("subscribers-hide").addEventListener('change', checkBoxSubscribersChanged);
}
function checkBoxSubscribersChanged(event) {
    event.preventDefault;
    var params = window.location.search.replace('?','').split('&').reduce(function(p,e){var a = e.split('=');p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);return p;},{});
    $.post(
        '../php/settings/subscribershide.php',
        {'ischecked': this.checked, 'id': params['id'], 'type': 2},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
}