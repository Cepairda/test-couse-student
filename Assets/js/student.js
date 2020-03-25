document.getElementById('image').addEventListener('change', checkImage);

function addStudent(event, form, func)
{
    let student= form;

    let formData = new FormData(student);

    let request = new XMLHttpRequest();

    request.open('POST', '/student/' + func, true);
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

function checkImage() {
    let imageType = this.files.length > 0 ? this.files[0].type : false;

    if (imageType || imageType === '') {
        if (imageType != 'image/jpeg' && imageType != 'image/png') {
            this.setCustomValidity('Допустимый формат JPG и PNG');
            
            return;
        }
    }

    this.setCustomValidity('');
}