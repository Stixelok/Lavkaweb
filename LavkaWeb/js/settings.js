window.onload = function(){
    document.getElementById("search-hide").addEventListener('change', checkBoxSearchChanged);
    document.getElementById("subscribers-hide").addEventListener('change', checkBoxSubscribersChanged);
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
        'php/settings/subscribershide.php',
        {'ischecked': this.checked},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
}
$('form').on('submit', function() {
    var name = $(this).find('input[name="name"]').val();
    var file_data = $('#picture').prop('files')[0];
    var form_data = new FormData();
    form_data.append('name', name);
    form_data.append('file', file_data);
    $.ajax({
        url: 'php/settings.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,               
        type: 'post',
        success:         
        function(data) {
            $('.message').html(data);
        }
    });
    return false;
});