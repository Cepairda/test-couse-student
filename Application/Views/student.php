<!DOCTYPE html>
<html lang="en" >
    <head>
      <meta charset="UTF-8">
      <title>CodePen - Building Responsive Forms With Flexbox</title>
      <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,300' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="/Assets/css/style.css">
    </head>
    <body class="container">
      <form name="student" action="/home/add" method="post" enctype="multipart/form-data">
        <ul class="flex-outer">
          <li>
            <label for="surname">Фамилия*</label>
            <input type="text" id="surname" name="surname" value="<?= $student['surname'] ?? ''; ?>" placeholder="Введите фамилию" maxlength="128" required>
          </li>
          <li>
          <label for="name">Имя*</label>
            <input type="text" id="name" name="name" value="<?= $student['name'] ?? ''; ?>" placeholder="Введите имя" maxlength="128" required>
          </li>
          <li>
            <label for="surname">Email*</label>
            <input type="email" id="email" name="email" value="<?= $student['email'] ?? ''; ?>" placeholder="Введите фамилию" maxlength="128" required>
          </li>
          <li>
            <label for="image">
                Изображение
                <?php if (isset($student['photo'])): ?>
                <span>Загружено:</span>
                <img src="/Uploads/images/<?= $student['photo'] ;?>" height="50">
                <?php endif; ?>
            </label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png">
          </li>
          <li>
            <?php if (isset($_GET['course'])): ?>
                <input type="hidden" name="course" value="<?= $_GET['course']; ?>">
            <?php else: ?>
                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                <input type="hidden" name="photo" value="<?= $student['photo']; ?>">
            <?php endif; ?>
            <button type="submit" id="submit"><?= $buttonName ?></button>
          </li>
        </ul>
      </form>
    <script src="/Assets/js/student.js" defer></script>
    <script defer>
        document.forms.student.addEventListener('submit', function(event) {addStudent(event, this,  '<?= isset($_GET['course']) ? 'add' : 'update'; ?>')});
    </script>
    </body>
</html>




