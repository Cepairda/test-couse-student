<?php

namespace Application\Controllers;

use System\Base\Request;
use System\View;
use Application\Models\Course;

class CourseController
{
    public function actionAdd()
    {
        $this->addOrUpdate('add', 'Курс успешно добавлен');
    }

    public function actionEdit()
    {
        if (isset($_GET['id'])) {
            $course = (new Course())->getCourse($_GET['id']);

            if (!$course) {
                Request::redirect();
            }
        } else {
            Request::redirect();
        }


        View::render('course',[
            //'coursesWithStudents' => $coursesWithStudents,
            //'allReviews' => $allReviews,
            //'totalReviews' => $totalReviews,
            'course' => $course
        ]);
    }

    public function actionUpdate()
    {
        $this->addOrUpdate('update', 'Курс успешно обновлен');
    }

    public function actionDelete()
    {
        if (Request::isPost()) {
            $id = $_POST['id'];

            if (isset($id) && !empty($id)) {
                $course = new Course();
                $course->deleteCourse($id);
            }
        }

        Request::redirect();
    }

    public function actionLike()
    {
        if (Request::isAjax() && Request::isPost()) {
            if (isset($_POST['like']) and isset($_POST['id'])) {
                $review = new Course();
                $review->like($_POST['id']);
            }
        }


    }

    protected function addOrUpdate($function, $message)
    {
        if (Request::isAjax() && Request::isPost()) {
            try {
                $id = $_POST['id'];
                $courseName = $_POST['course_name'];
                $teacher = $_POST['teacher'];

                if (empty($courseNameName) && empty($teacher)) {
                    throw new \Exception(serialize(['message' => 'Заполните все обязательные поля']));
                }

                $course = new Course();

                if ($function == 'add') {
                    $newCourse = $course->addCourse($courseName, $teacher);
                } elseif ($function == 'update') {
                    $newCourse = $course->updateCourse($id, $courseName, $teacher);
                }


                if (!$newCourse) {
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