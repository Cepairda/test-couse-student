<?php

namespace Application\Controllers;

use System\Base\Request;
use System\View;
use Application\Models\Course;

class IndexController {
    public function actionIndex()
    {
        /*$subjects = new Student();
        $allSubjects = $subjects->getAllSubjects();

        $totalSubjectsGroup = $subjects->getGroupCountSubject();

        $reviews = new Course();
        $totalReviews = $c->getCountReviews();

        $allReviews = $reviews->getAllReviews($currentPage, $limit, $sort);*/

        $course = new Course();
        $coursesWithStudents = $course->getCoursesWithStudents();
        $courses = $course->getCourses($coursesWithStudents);


        View::render('index',[
            //'coursesWithStudents' => $coursesWithStudents,
            //'allReviews' => $allReviews,
            //'totalReviews' => $totalReviews,
            'getCourses' => $courses
        ]);
    }

    protected function createLinkLimit($newLimit)
    {
        parse_str($_SERVER['QUERY_STRING'], $queryVars );

        $queryVars['page'] = 1;
        $queryVars['limit'] = $newLimit;

        $link = http_build_query($queryVars);

        return $link;
    }

    public function actionAdd()
    {
        if (Request::isAjax() && Request::isPost()) {
            try {
                    $courseName = $_POST['course_name'];
                    $teacher = $_POST['teacher'];

                    if (empty($courseNameName) && empty($teacher)) {
                        throw new \Exception(serialize(['message' => 'Заполните все обязательные поля']));
                    }

                    $course = new Course();
                    $newCourse = $course->addCourse($courseName, $teacher);

                    if (!$newCourse) {
                        throw new \Exception('Что-то пошло не так');
                    }

                    echo json_encode(['code' => 1, 'message' => 'Отзыв успешно добавлен']);
            } catch (\Exception $e) {
                $data = unserialize($e->getMessage());
                $code = $data['code'] ?? 0;
                echo json_encode(['code' => $code, 'message' => $data['message']]);
            }
        }
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
}