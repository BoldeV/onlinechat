// находим нужные элементы
send        = document.getElementById('send');
overlay     = document.getElementById('overlay');
close       = document.getElementById('close');
sendMessage = document.getElementById('sendMessage');
// вешаем событие на модальное окно
overlay.addEventListener('click', closeModal);
close.addEventListener('click', closeModal);

send.onclick = function() {
    // при клике на [написать] собираем данные с формы
    inp_message = document.querySelector('textarea[name=message]');
    inp_message.value = '';
    overlay.style.display     = 'block';
    sendMessage.style.display = 'block';
    but  = document.getElementById('sendBtn');
    url = but.parentElement.getAttribute('action');

    // при клике на [отправить]
    //формируем данные и отправляем на сервер
    //ajax с параметром сообщения
    but.onclick = function() {
        var params = 'message=' + inp_message.value;
        ajaxPost(url, params, function(data) {

            if (isJson(data)) {
                // в случаи ошибки
                var json = JSON.parse(data);
                console.log(json);
                h2 = document.querySelector('h2');
                h2.style.marginBottom = '20px';
                error = document.getElementById('error');
                error.innerHTML = json.status + json.message;
            } else {
                // при успешной отправки
                closeModal();
                messages = document.querySelector('#messages');
                otherMessages = messages.innerHTML;
                messages.innerHTML = data + otherMessages;

                /* вешаем события заного на все сообщения*/

                message = messages.getElementsByClassName('message');

                for (var i = message.length - 1; i >= 0; i--) {

                    message[i].addEventListener('click', function(e) {
                        // удаление
                        if (e.target.className == 'delete') {
                            id = e.currentTarget.getAttribute('data-id');
                            params = 'id=' + id;
                            ajaxPost('delete', params, function(data) {
                                json = JSON.parse(data);
                                curMessage = document.querySelector('div[data-id=\''+json.id+'\']');
                                curMessage.remove();
                            });
                        }
                        // лайк
                        if (e.target.className == 'fa fa-heart-o like') {
                            id = e.currentTarget.getAttribute('data-id');
                            params = 'id=' + id;
                            ajaxPost('like', params, function(data) {
                                anotherLike = e.target.nextElementSibling;
                                e.target.style.display = 'none';
                                anotherLike.style.display = 'inline-block';
                                likes = anotherLike.nextElementSibling;
                                likes.innerHTML = data;
                            });
                        }
                    });

                }
  
            }

        });
    }

}

function closeModal() {
    overlay.style.display     = 'none';
    sendMessage.style.display = 'none';
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}



