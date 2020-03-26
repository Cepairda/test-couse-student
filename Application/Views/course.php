<!DOCTYPE html>
<html lang="en" >
    <head>
      <meta charset="UTF-8">
      <title>CodePen - Building Responsive Forms With Flexbox</title>
      <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,300' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="/Assets/css/style.css">
    </head>
    <body>
      <div class="container">
        <form name="course" action="/home/add" method="post" enctype="multipart/form-data">
        <ul class="flex-outer">
          <li>
            <label for="course_name">Название курса</label>
            <input type="text" id="course_name" name="course_name" value="<?= $course['name']; ?>" placeholder="Введите название курса" maxlength="128" required>
          </li>
          <li>
            <label for="teacher">ФИО*</label>
            <input type="text" id="teacher" name="teacher" value="<?= $course['teacher']; ?>" placeholder="Введите Ф.И.О преподавателя" maxlength="128" required>
          </li>
          <li>
            <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
            <button type="submit" id="submit">Редактировать</button>
          </li>
        </ul>
      </form>
      </div>
    <script src="/Assets/js/course.js" defer></script>
      <script defer>
          document.forms.course.addEventListener('submit', function(event) {addCourse(event, this,  'update')});
      </script>
    </body>
</html>




