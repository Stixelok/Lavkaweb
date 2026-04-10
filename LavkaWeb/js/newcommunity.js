window.onload = function(){
    const picture = document.getElementById("picture");
    picture.addEventListener('change', fileUploaded);
}
function fileUploaded(event) {
    var target = event.target;

    if (!FileReader || !target.files.length) {
        return;
    }
    var fileReader = new FileReader();
    fileReader.onload = function() {
        img1.src = fileReader.result;
    }

    fileReader.readAsDataURL(target.files[0]);
}
$('form').on('submit', function() {
    try {
    var name = $(this).find('input[name="name"]').val();
    var bio = $(this).find('input[name="bio"]').val();
    var file_data = $('#picture').prop('files')[0];
    document.getElementById("upload").disabled = 'true';
    var form_data = new FormData();
    form_data.append('name', name);
    form_data.append('bio', bio);
    form_data.append('file', file_data);
    $.ajax({
        url: '../php/newcommunity.php', // <-- point to server-side PHP script 
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
    } catch (err) {
        console.log(err);
    }
});