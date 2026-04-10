window.onload = function(){
    var sum_marks = 0;
    var num_marks = 0;
    var nikolotik_mode = false;
    const mark = document.getElementById('mark');
    const marks_list = document.getElementById('marks_list');
    const button = document.getElementsByClassName('mark');
    const button_5 = document.getElementById('button5');
    const button_4 = document.getElementById('button4');
    const button_3 = document.getElementById('button3');
    const button_2 = document.getElementById('button2');
    const slider = document.getElementById('checkbox');
    const loads = document.getElementsByClassName('panel-load');
    for (const load of loads) {
        load.addEventListener("click", loadMarks);
    }
    document.getElementById('save').addEventListener('click', showSavePage);
    document.getElementById('load').addEventListener('click', showLoadPage);
    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min; //Максимум и минимум включаются
    }

    function update (mark_point, amount) {
        num_marks += amount;
        sum_marks += mark_point;
        for (var i = 0 ; i < button.length; i++) {
            button[i].addEventListener('click' , deleteMark); 
        }
        if (num_marks != 0) {
            mark.innerHTML = (sum_marks / num_marks).toFixed(2);
        }
        else {
            mark.innerHTML = 0.00.toFixed(2);
        }
    }
    function addMark(event, num) {
        event.preventDefault();
        /*
        if (nikolotik_mode) {
            if (num != 2) {
                num = getRandomInt(num - 1, num);
            }
        }*/
        marks_list.insertAdjacentHTML('beforeend', `<button id="mark_button" class="mark">${num}</button>`)
        update(num, 1);
    }
    function deleteMark(event) {
        event.target.closest('.mark').remove()
        update(-(event.target.closest('.mark').innerHTML), -1);
    }
    /*
    slider.addEventListener('click', function(event) {
        nikolotik_mode = slider.checked;
    })
    */
    button_5.addEventListener('click', function(event) {
        addMark(event, 5);
    })
    button_4.addEventListener('click', function(event) {
        addMark(event, 4);
    })
    button_3.addEventListener('click', function(event) {
        addMark(event, 3);
    })
    button_2.addEventListener('click', function(event) {
        addMark(event, 2);
    })
    function loadMarks(event) {
        const load = event.currentTarget;
        for (var i = 0 ; i < load.dataset.indexNumber.length; i++) {
            addMark(event, Number(load.dataset.indexNumber[i]));
            console.log(load.dataset.indexNumber)
        }
        $('.js-overlay-panel').fadeOut();
        document.getElementById("panel").classList.remove('panel-final');
        const circle = document.createElement("span");
        const diameter = Math.max(load.clientWidth, load.clientHeight);
        const radius = diameter / 2;
        circle.style.left = `${event.clientX - (radius) - 92}px`;
        circle.style.top = `${event.clientY - (radius) - 73 - (Number(load.id) - 1) * 92}px`;
        //console.log(event.clientY, event.clientY - (radius) - 73  - (Number(load.id) - 1) * 92);
        //console.log(event.clientX, event.clientX - (radius) - 92);
        circle.style.width = circle.style.height = `${diameter}px`;
        circle.classList.add("ripple"); 
        const ripple = load.getElementsByClassName("ripple")[0];
        if (ripple) {
            ripple.remove();
        }
        load.appendChild(circle);
    }
    function showSavePage(event) { 
        event.preventDefault;
        //$('.load-page').fadeOut();
        $('.save-page').fadeIn();
        $('.load-page').addClass('load-final');
        $('.save-page').addClass('save-final');
    }
    function showLoadPage(event) { 
        event.preventDefault;
        $('.save-page').fadeOut();
        $('.load-page').fadeIn();
        document.getElementById("load-page").classList.remove('load-final');
        document.getElementById("save-page").classList.remove('save-final');
    }
}
var panelid = document.getElementById("panel");
$('.js-button-panel').click(function() { 
	$('.js-overlay-panel').fadeIn();
	$('.js-overlay-panel').addClass('disabled');
  $('.js-panel-campaign').addClass('panel-final');
});
$(document).mouseup(function (e) { 
    var panel = $('.js-panel-campaign');
    if (e.target!=panel&&panel.has(e.target).length === 0){
		$('.js-overlay-panel').fadeOut();
        panelid.classList.remove('panel-final');
        $('.save-page').fadeOut();
        $('.load-page').fadeIn();
        document.getElementById("load-page").classList.remove('load-final');
        document.getElementById("save-page").classList.remove('save-final');
	}
});

$('form').on('submit', function() {
    var name = $(this).find('input[name="name"]').val();
    const marksbuttons = document.getElementsByClassName('mark');
    var marks = '';
    const score = document.getElementById('mark');
    for (var i = 0 ; i < marksbuttons.length; i++) {
        marks += marksbuttons[i].innerHTML;
    }
    var form_data = new FormData();
    form_data.append('name', name);
    form_data.append('marks', marks);
    form_data.append('score', score.innerHTML);
    $.ajax({
        url: '../php/savemarks.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,               
        type: 'post',
        success:         
        function(data) {
            const count = document.getElementsByClassName('panel-load').length + 1;
            document.getElementById('load-page').insertAdjacentHTML('beforeend', `
            <div class="panel-load" id="` + count + `" data-index-number="'` + marks +`'">
                <p class="load-name">`+ name +`</p>
                <p class="load-score">Средний балл: ` + score.innerHTML + `</p>
            </div>`);
            const loads = document.getElementsByClassName('panel-load');
            for (const load of loads) {
                load.addEventListener("click", onload.loadMarks);
                console.log(load.id);
            }
            $('.save-page').fadeOut();
            $('.load-page').fadeIn();
            document.getElementById("load-page").classList.remove('load-final');
            document.getElementById("save-page").classList.remove('save-final');
        }
    });
    return false;
});