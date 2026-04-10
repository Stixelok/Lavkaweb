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
    document.getElementById('picture-box').style = "margin-bottom: 8px; margin-top: 8px;";
}