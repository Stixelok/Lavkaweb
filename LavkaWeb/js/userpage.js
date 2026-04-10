window.onload = function(){
    const likes = document.getElementsByClassName('like-button');
    const subscribes = document.getElementsByClassName("subscribe-button");
    const posts = document.getElementsByClassName('post');
    const pins = document.getElementsByClassName('pin');
    const menus = document.getElementsByClassName('dropbtn');
    subscribes[0].addEventListener('click', subscribe);
    for (var i = 0 ; i < likes.length; i++) {
        likes[i].addEventListener('click', addLike);
        try {
            menus[i].addEventListener('click' , showMenu);
            posts[i].addEventListener('click' , deletePost);
            pins[i].addEventListener('click' , pin);
        } catch (err) {}
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
function subscribe(event) {
    event.preventDefault;
    var type = 1;
    if (window.location.pathname == '/community.php') {
        type = 2;
    }
    var id = this.id;
    var newsubscribe = '';
    var subscribers = document.getElementById("subscribers");
    if (document.cookie.includes("id")) {
        if (this.className == 'subscribe-button not-subscribed') {
            this.className = 'subscribe-button subscribed';
            this.style = 'background-color: white; color: black; border: 1px solid rgba(0, 0, 0, 0.35);';
            this.textContent = "Вы подписаны";
            subscribers.textContent = parseInt(subscribers.textContent) + 1;
            newsubscribe = 'add';
        } else {
            this.className = 'subscribe-button not-subscribed';
            this.style = 'background-color: red; color: white; border: 1px solid red';
            this.textContent = "Подписаться";
            subscribers.textContent = parseInt(subscribers.textContent) - 1;
        }
        $.post(
            'php/subscribe.php',
            {'creator_id': id, 'newsubscribe': newsubscribe, 'type': type},
            function(data) {
                $('.message').html(data);
            }
        );
        return false;
    } else {
        alert("Вы не вошли в аккаунт.");
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
function pin(event) {
    event.preventDefault;
    var type = 2;
    var params = window.location.search.replace('?','').split('&').reduce(function(p,e){var a = e.split('=');p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);return p;},{});
    var id = this.id;
    var text = this.textContent;
    id = id.replace(/[^+\d]/g, '')
    $.post(
        'php/addpin.php',
        {'id': id, 'text': text, 'type': type, 'community_id': params['id']},
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