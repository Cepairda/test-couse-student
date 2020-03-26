<?php

namespace Application\Controllers;

use System\Base\Request;
use System\View;
use Application\Models\Course;

class IndexController
{
    public function actionIndex()
    {
        $course = new Course();
        $coursesWithStudents = $course->getCoursesWithStudents();
        $courses = $course->getAllCourseStudents($coursesWithStudents);


        View::render('index',[
            'getCourses' => $courses
        ]);
    }
}