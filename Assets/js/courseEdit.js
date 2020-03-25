document.forms.course.addEventListener('submit', editCourse);
//document.getElementById('image').addEventListener('change', checkImage);

function editCourse(event)
{
    let course = this;

    let formData = new FormData(course);

    let request = new XMLHttpRequest();

    request.open('POST', '/course/update', true);
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