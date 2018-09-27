messages = document.getElementsByClassName('message');
for (var i = messages.length - 1; i >= 0; i--) {
    messages[i].addEventListener('click', function (e) {
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
        if (e.target.className == 'delete') {;
            id = e.currentTarget.getAttribute('data-id');
            params = 'id=' + id;
            ajaxPost('delete', params, function(data) {
                // json = JSON.parse(data);
                message = document.querySelector('[data-id=\''+id+'\']');
                message.remove();
            });
        }

    })
}
// like = document.getElementsByClassName('like');
// for (var i = like.length - 1; i >= 0; i--) {
//     like[i].addEventListener('click', function (e) {
//         anotherLike = e.target.nextElementSibling;
//         id = e.target.getAttribute('data-id');
//         params = 'id=' + id;
//         ajaxPost('like', params, function(data) {
//             likes = document.querySelector('.message-info__like span');
//             console.log(e.target);

//             e.target.style.display = 'none';
//             anotherLike.style.display = 'inline-block';
//         });
//     });
// }
