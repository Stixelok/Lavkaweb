window.onload = function(){
    const comments = document.getElementsByClassName('post');
    const post = document.getElementsByClassName('deletepost');
    const button = document.getElementsByClassName('submit-button');
    const like = document.getElementsByClassName('like-button');
    const menus = document.getElementsByClassName('dropbtn');
    try { 
        menus[0].addEventListener('click' , showMenu);
        post[0].addEventListener('click' , deletePost); 
    } catch (err) {}
    button[0].addEventListener('click', comment);
    like[0].addEventListener('click', addLike);
    for (var i = 0 ; i < comments.length; i++) {
        comments[i].addEventListener('click' , deleteComment);
    }
    const btnUp = {
        el: document.querySelector('.btn-up'),
        show() {
          // удалим у кнопки класс btn-up_hide
          this.el.classList.remove('btn-up_hide');
        },
        hide() {
          // добавим к кнопке класс btn-up_hide
          this.el.classList.add('btn-up_hide');
        },
        addEventListener() {
          // при прокрутке содержимого страницы
          window.addEventListener('scroll', () => {
            // определяем величину прокрутки
            const scrollY = window.scrollY || document.documentElement.scrollTop;
            // если страница прокручена больше чем на 400px, то делаем кнопку видимой, иначе скрываем
            scrollY > 400 ? this.show() : this.hide();
          });
          // при нажатии на кнопку .btn-up
          document.querySelector('.btn-up').onclick = () => {
            // переместим в начало страницы
            window.scrollTo({
              top: 0,
              left: 0,
              behavior: 'smooth'
            });
          }
        }
      }
      
      btnUp.addEventListener();
}
$('form').on('submit', function() {
    var id = this.id;
    document.getElementById("upload").disabled = 'true';
    var comments = document.getElementById("text-comment");
    var text = $(this).find('input[name="comment-box"]').val();
    if (document.cookie.includes("id")) {
        if (text != '') {
            comments.textContent = parseInt(comments.textContent) + 1;
            $.post(
                'php/addcomment.php',
                {'post_id': id, 'text': text},
                function(data) {
                    $('.message').html(data);
                }
            );
            return false;
        } 
    } else {
        alert("Вы не вошли в аккаунт.");
    }
});
function addLike(event) {
    event.preventDefault;
    var id = this.id;
    var likes = document.getElementById('text-' + id);
    var icon = document.getElementById('icon-' + id);
    var newlike = '';
    if (document.cookie.includes("id")) {
        if (this.className != 'like-button liked') {
            this.className = 'like-button liked';
            this.style = 'color: red; border: 1px solid red; box-shadow: 2px 0px 20px rgba(0, 0, 0, 0.053)';
            icon.name = 'heart';
            likes.textContent = parseInt(likes.textContent) + 1;
            newlike = 'add';
        } else {
            this.className = 'like-button not-liked';
            icon.name = 'heart-outline';
            likes.textContent = parseInt(likes.textContent) - 1;
            this.style = '';
        }
        id = id.replace(/[^+\d]/g, '')
        $.post(
            'php/addlike.php',
            {'id': id, 'newlike': newlike},
            function(data) {
                $('.message').html(data);
            }
        );
        return false;
    } else {
        alert("Вы не вошли в аккаунт.");
    }
}
function deleteComment(event) {
    event.preventDefault();
    var id = this.id;
    var comments = document.getElementById("text-comment");
    var result = confirm('Удалить этот комментарий?');
    if (result) {
        comments.textContent = parseInt(comments.textContent) - 1;
        event.target.closest('.comment-container').remove();
        $.post(
            'php/deletecomment.php',
            {'id': id},
            function(data) {
                $('.message').html(data);
            }
        );
        return false;
    }
}
function deletePost(event) {
    event.preventDefault();
    var id = this.id;
    type = 1;
    var result = confirm('Удалить этот пост?');
    if (result) {
        event.target.closest('.post-container').remove();
        $.post(
            'php/deletepost.php',
            {'id': id, 'type': type},
            function(data) {
                $('.message').html(data);
            }
        );
        return false;
    }
}
function showMenu() {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
    document.getElementById("menu" + this.id).classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}