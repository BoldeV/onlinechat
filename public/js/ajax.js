function ajaxPost(url, params, callback) {
    var callback = callback || function(data){};
    var request = new XMLHttpRequest;

    loader = document.getElementById('loader');
    loader.style.display = 'block';

    request.onreadystatechange = function() {
        /*
            при успешном выполнении, вызываем функцию callback
        */
        if (request.readyState == 4 && request.status == 200) {
            loader.style.display = 'none';
            callback(request.responseText);
        }
    }

    request.open('POST', url, true);
    request.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded'
    );

    request.send(params);
}