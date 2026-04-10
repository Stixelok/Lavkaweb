window.onload = function(){
    try {
    document.getElementById('deletebutton').addEventListener('click' , deletePost);
    } catch {}
}
function deletePost(event) {
    event.preventDefault();
    var params = window.location.search.replace('?','').split('&').reduce(function(p,e){var a = e.split('=');p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);return p;},{});
    var id = this.id;
    var result = confirm('Вы уверены, что хотите удалить это сообщество?');
    if (result) {
        window.location.href = 'deletecommunity.php?id=' + params['id'];
    }
}