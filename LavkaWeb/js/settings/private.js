window.onload = function(){
    document.getElementById("search-hide").addEventListener('change', checkBoxSearchChanged);
    document.getElementById("subscribers-hide").addEventListener('change', checkBoxSubscribersChanged);
    document.getElementById("emailmessages-hide").addEventListener('change', checkBoxEmailMessagesChanged);
}
function checkBoxSearchChanged(event) {
    event.preventDefault;
    document.getElementById("message").textContent = "";
    $.post(
        '../php/settings/searchhide.php',
        {'ischecked': this.checked},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
}
function checkBoxSubscribersChanged(event) {
    event.preventDefault;
    document.getElementById("message").textContent = "";
    $.post(
        '../php/settings/subscribershide.php',
        {'ischecked': this.checked, 'type': 1},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
}
function checkBoxEmailMessagesChanged(event) {
    event.preventDefault;
    document.getElementById("message").textContent = "";
    $.post(
        '../php/settings/emailmessages.php',
        {'ischecked': this.checked},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
}