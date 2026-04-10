window.onload = function(){
    const likes = document.getElementsByClassName('like-button');
    const buttons = document.getElementsByClassName("user-panel-item");
    for (const button of buttons) {
      button.addEventListener("click", createRipple);
    }
    for (var i = 0 ; i < likes.length; i++) {
        likes[i].addEventListener('click', addLike);
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
      if (document.documentElement.clientWidth < 390) {
        document.getElementById('panel-calculator').textContent = "Калькулятор";
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

// Модальное окно
var popupid = document.getElementById("popup");
var panelid = document.getElementById("panel");
// открыть по кнопке
$('.js-button-campaign').click(function() { 
	$('.js-overlay-campaign').fadeIn();
	$('.js-overlay-campaign').addClass('disabled');
  $('.js-popup-campaign').addClass('popup-final');
});
$('.js-button-panel').click(function() { 
	$('.js-overlay-panel').fadeIn();
	$('.js-overlay-panel').addClass('disabled');
  $('.js-panel-campaign').addClass('panel-final');
});

// закрыть на крестик
$('.js-close-campaign').click(function() { 
	$('.js-overlay-campaign').fadeOut();
  $('.js-overlay-panel').fadeOut();
});

// закрыть по клику вне окна
$(document).mouseup(function (e) { 
	var popup = $('.js-popup-campaign');
  var panel = $('.js-panel-campaign');
	if (e.target!=popup&&popup.has(e.target).length === 0){
		$('.js-overlay-campaign').fadeOut();
    popupid.classList.remove("popup-final");
	}
  if (e.target!=panel&&panel.has(e.target).length === 0){
		$('.js-overlay-panel').fadeOut();
    panelid.classList.remove('panel-final');
	}
});

function createRipple(event) {
  const button = event.currentTarget;
  const circle = document.createElement("span");
  const diameter = Math.max(button.clientWidth, button.clientHeight);
  const radius = diameter / 2;
  circle.style.left = `${event.clientX - (button.offsetLeft + radius)}px`;
  circle.style.top = `${event.clientY - (radius) - 178 - (Number(button.id) - 1) * 45}px`;
  // console.log(event.clientY, event.clientY - (radius) - 178  - (Number(button.id) - 1) * 45);
  circle.style.width = circle.style.height = `${diameter}px`;
  circle.classList.add("ripple"); 
  const ripple = button.getElementsByClassName("ripple")[0];
  if (ripple) {
    ripple.remove();
  }
  button.appendChild(circle);
}
