window.onload = function(){
    const posts = document.getElementsByClassName('post');
    const pins = document.getElementsByClassName('pin');
    const likes = document.getElementsByClassName('like-button');
    const menus = document.getElementsByClassName('dropbtn');
    for (var i = 0 ; i < posts.length; i++) {
        menus[i].addEventListener('click' , showMenu);
        posts[i].addEventListener('click' , deletePost);
        likes[i].addEventListener('click', addLike);
        pins[i].addEventListener('click' , pin);
    }
    if (window.innerWidth < 400) {
      document.getElementsByClassName('action')[0].style = "width: 150px; font-size: 0.9em; margin-top: 20px; background-color:rgb(254, 202, 0); border: 1px solid rgb(254, 202, 0);";
      document.getElementsByClassName('action')[1].style = "width: 150px; font-size: 0.9em; margin-bottom: 6px";
    }
    try {
      document.getElementById("check-mark").style = "left: " + (window.innerWidth + 66) / 2 + "px;";
    } catch (err) {
      console.log("Check-mark not found");
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
function deletePost(event) {
    event.preventDefault();
    var id = this.id;
    var result = confirm('Удалить этот пост?');
    if (result) {
        event.target.closest('.post-container').remove();
        $.post(
            'php/deletepost.php',
            {'id': id},
            function(data) {
                $('.message').html(data);
            }
        );
        return false;
    }
}
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
function pin(event) {
    event.preventDefault;
    var id = this.id;
    var text = this.textContent;
    id = id.replace(/[^+\d]/g, '')
    $.post(
        'php/addpin.php',
        {'id': id, 'text': text, 'type': 1},
        function(data) {
            $('.message').html(data);
        }
    );
    return false;
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