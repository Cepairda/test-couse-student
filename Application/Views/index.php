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
            <input type="text" id="course_name" name="course_name" placeholder="Введите название курса" maxlength="128" required>
          </li>
          <li>
            <label for="teacher">ФИО*</label>
            <input type="text" id="teacher" name="teacher" placeholder="Введите Ф.И.О преподавателя" maxlength="128" required>
          </li>
          <li>
            <button type="submit" id="submit">Добавить</button>
          </li>
        </ul>
      </form>
      <?php print_r($getCourses) ?>
      <table class="courses">
        <thead>
          <th>Курс</th>
          <th>Преподователь</th>
          <th>Ученик</th>
        </thead>
        <tbody>
            <?php foreach ($getCourses as $course): ?>
            <tr>
              <td>
                  <?= $course['name']; ?>
                  <form action="/course/edit">
                      <input type="hidden" name="id" value="<?= $course['id']; ?>">
                      <button type="submit">Редактировать</button>
                  </form>
                  <form action="/course/delete" method="post">
                      <input type="hidden" name="id" value="<?= $course['id']; ?>">
                      <button type="submit">Удалить</button>
                  </form>
              </td>
              <td>
                  <?= $course['teacher'] ?>
              </td>
              <td>
                  <?php if (isset($course['students'])): ?>
                  <?php foreach ($course['students'] as $student): ?>
                      <div class="student">
                          <p>Фамилия: <?= $student['surname']; ?></p>
                          <p>Имя: <?= $student['name']; ?></p>
                          <p>Email: <?= $student['email']; ?></p>
                          <p>Фото:
                              <?php if ($student['photo']) :?>
                                  <img src="/Uploads/images/<?= $student['photo'] ?>" height="200">
                              <?php else: ?>
                                  <?= 'Фото отсутствует'; ?>
                              <?php endif; ?>
                          </p>
                          <form action="/student/edit">
                              <input type="hidden" name="id" value="<?= $student['id']; ?>">
                              <button type="submit">Редактировать</button>
                          </form>
                          <form action="/student/delete" method="post">
                              <input type="hidden" name="id" value="<?= $student['id']; ?>">
                              <button type="submit">Удалить</button>
                          </form>
                      </div>
                  <?php endforeach; ?>
                  <?php else: ?>
                  Учеников нет.
                  <form action="/student/new">
                      <input type="hidden" name="course" value="<?= $course['id']; ?>">
                      <button type="submit">Добавить</button>
                  </form>
                  <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <script src="/Assets/js/main.js"></script>
    </body>
</html>




