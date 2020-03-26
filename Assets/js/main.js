document.forms.course.addEventListener('submit', addCourse);

function addCourse(event)
{
    let course = this;

    let formData = new FormData(course);

    let request = new XMLHttpRequest();

    request.open('POST', '/course/add', true);
    request.responseType = 'json';
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    request.onload = function (event) {
        if (request.status == 200) {
            alert(request.response.message);

            if (request.response.code == 1) {
                course.reset();
                document.location.href = '/';
            }
        } else {
            //Место для ошибок
        }

    };

    request.send(formData);

    event.preventDefault();
}