function addCourse(event, form, func)
{
    let course = form;

    let formData = new FormData(course);

    let request = new XMLHttpRequest();

    request.open('POST', '/course/' + func, true);
    request.responseType = 'json';
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    request.onload = function (event) {
        if (request.status == 200) {
            alert(request.response.message);

            if (request.response.code == 1) {
                document.location.href = '/';
            }
        } else {
            //Место для ошибок
        }

    };

    request.send(formData);

    event.preventDefault();
}