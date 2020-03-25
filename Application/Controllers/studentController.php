<?php

namespace Application\Controllers;

use System\Base\Request;
use System\Helpers\FileHelper;
use System\View;
use Application\Models\Course;
use Application\Models\Student;
use Application\Models\courseStudent;

class StudentController
{
    public function actionNew()
    {
        View::render('student',[
            'buttonName' => 'Добавить',
        ]);
    }

    public function actionAdd()
    {
        $this->addOrUpdate('add', 'Ученик успешно добавлен');
    }

    public function actionEdit()
    {
        if (isset($_GET['id'])) {
            $student = (new Student())->getStudent($_GET['id']);

            if (!$student) {
                Request::redirect();
            }
        } else {
            Request::redirect();
        }

        View::render('student',[
            'student' => $student,
            'buttonName' => 'Редактировать',
        ]);
    }

    public function actionUpdate()
    {
        $this->addOrUpdate('update', 'Ученик успешно обновлен');
    }

    public function actionDelete()
    {
        if (Request::isPost()) {
            $id = $_POST['id'];

            if (isset($id) && !empty($id)) {
                $student = new Student();
                $student->deleteStudent($id);
            }
        }

        Request::redirect();
    }

    protected function addOrUpdate($function, $message)
    {
        if (Request::isAjax() && Request::isPost()) {
            try {
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                } else {
                    $courseId = $_POST['course'];
                }

                $surName = $_POST['surname'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $image = null;

                if (empty($surName) && empty($name) && empty($email)) {
                    throw new \Exception(serialize(['message' => 'Заполните все обязательные поля']));
                }

                if (isset($_POST['photo']) && !empty($_POST['photo']) && isset($_POST['image'])) {
                    if (file_exists('/Uploads/images/' . $_POST['photo'])) {
                        unlink('/Uploads/images/' . $_POST['photo']);
                    }
                } elseif (isset($_POST['photo']) && !empty($_POST['photo'])) {
                    $image = $_POST[''];
                }

                $imgExt = ['image/jpeg', 'image/png'];

                $filePath = $_FILES['image']['tmp_name'];
                $errorCode = $_FILES['image']['error'];

                if ($errorCode === UPLOAD_ERR_OK && is_uploaded_file($filePath)) {

                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = (string)finfo_file($fi, $filePath);

                    if (in_array($mime, $imgExt)) {
                        $ext = explode('/', $mime);
                        $ext = $ext['1'] == 'jpeg' ? 'jpg' : 'png';

                        $image = FileHelper::getRandomFileName('Uploads/images', $ext);
                        $image .= '.' . $ext;

                        if (!move_uploaded_file($filePath, 'Uploads/images/' . $image)) {
                            throw new \Exception(serialize(['message' => 'Что-то пошло не так. Обратитесь к администратору']));
                        }
                    } else {
                        throw new \Exception(serialize(['message' => 'Допустимый формат JPG и PNG']));
                    }
                }

                $student = new Student();

                if ($function == 'add') {
                    $newStudent = $student->addStudent($surName, $name, $email, $image);

                    $studentId = $student->getStudentLastId();

                    $courseStudent = new CourseStudent();
                    $courseStudent->addCourseStudent($courseId, $studentId);
                } elseif ($function == 'update') {
                    $newStudent = $student->updateStudent($id, $surName, $name, $email, $image);
                }

                if (!$newStudent) {
                    throw new \Exception('Что-то пошло не так');
                }

                echo json_encode(['code' => 1, 'message' => $message]);
            } catch (\Exception $e) {
                $data = unserialize($e->getMessage());
                $code = $data['code'] ?? 0;
                echo json_encode(['code' => $code, 'message' => $data['message']]);
            }
        }
    }
}