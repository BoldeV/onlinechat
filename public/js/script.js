function ajaxPost(url, params, callback) {
    var callback = callback || function(data){};
    var request = new XMLHttpRequest;

    request.onreadystatechange = function() {
        /*
            при успешном выполнении, вызываем функцию callback
        */
        if (request.readyState == 4 && request.status == 200) {
                // window.location = 'http://forum/main/index';
                callback(request.responseText);

        }
    }

    request.open('POST', url, true);
    request.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded',
    );

    request.send(params);
}

/*
    находим эллемент input[button],
    затем обращаемся к тегу form
    из него получаем url по action
*/

but = document.querySelector('input[type=button]');
form = but.parentElement;
url = form.getAttribute('action');

inp_name = document.querySelector('input[name=name]');

// inp_email = document.querySelector('input[name=email]');
// inp_phone = document.querySelector('input[name=phone]');

/*
    событие при клике на input[button]
    выполняется ajax запрос
*/

but.onclick = function() {
    var params = 'name=' + inp_name.value;
    ajaxPost(url, params, function(data){
        var json = JSON.parse(data);
        if ( json.url ) {
            window.location.href = '/' + json.url;
        } else {
            h1 = document.querySelector('h1');
            h1.style.marginBottom = '20px';
            error = document.getElementById('error');
            error.innerHTML = json.status + json.message;
        }
    });
}