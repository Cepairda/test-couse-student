<?php

namespace Application\Models;

use System\Base\Model;
use PDO;

class Course extends Model {
    public function getAllReviews($startPage = 1, $limit = 7, $sort = 'ASC')
    {
        $query = $this->db->prepare("
            SELECT *,review.id AS review_id FROM review INNER JOIN subject 
            ON review.subject_id = subject.id
            ORDER BY date {$sort}
            LIMIT :limit
            OFFSET :offset
        ");

        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', ($startPage - 1) * $limit, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountReviews()
    {
        $query = $this->db->query('SELECT COUNT(*) FROM review');

        return $query->fetchColumn();
    }

    public function addCourse($courseName, $teacher)
    {
        $query = $this->db->prepare("
            INSERT INTO course
            (`name`, `teacher`)
            VALUES
            (:courseName, :teacher)
        ");

        $query->bindValue(':courseName', $courseName, PDO::PARAM_STR);
        $query->bindValue(':teacher', $teacher, PDO::PARAM_STR);

        return $query->execute();
    }

    public function updateCourse($id, $courseName, $teacher) {
        $query = $this->db->prepare('UPDATE course SET name = :course, teacher = :teacher WHERE id = :id');

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':course', $courseName, PDO::PARAM_STR);
        $query->bindValue(':teacher', $teacher, PDO::PARAM_STR);

        return $query->execute();
    }

    public function deleteCourse($id) {
        $query = $this->db->prepare('DELETE FROM course WHERE id=:id');

        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();
    }

    public function getCourse($id)
    {
        $query = $this->db->prepare("
            SELECT * FROM course WHERE id = :id 
        ");

        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getCoursesWithStudents()
    {
        $query = $this->db->prepare(" 
            SELECT 
                course.id AS courseId,
                course.name AS courseName,
                course.teacher,
                student.*
            FROM course 
            LEFT JOIN course_student
            ON course.id = course_student .course_id
            LEFT JOIN student
            ON student.id= course_student.student_id
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourses($coursesWithStudents)
    {
        $result = [];

        foreach ($coursesWithStudents as $courseWithStudent) {
            $course = [];

            ///$course['id'] = $courseWithStudent['courseId'];
            //$course['name'] = $courseWithStudent['courseName'];
            //$course['teacher'] = $courseWithStudent['teacher'];

            $result[$courseWithStudent['courseId']]['id'] = $courseWithStudent['courseId'];
            $result[$courseWithStudent['courseId']]['name'] = $courseWithStudent['courseName'];
            $result[$courseWithStudent['courseId']]['teacher'] = $courseWithStudent['teacher'];

            if ($courseWithStudent['surname'] && $courseWithStudent['name'] && $courseWithStudent['email']) {
                $student['id'] = $courseWithStudent['id'];
                $student['surname'] = $courseWithStudent['surname'];
                $student['name'] = $courseWithStudent['name'];
                $student['email'] = $courseWithStudent['email'];
                $student['photo'] = $courseWithStudent['photo'];

                $result[$courseWithStudent['courseId']]['students'][] = $student;
            }
        }

        return $result;
    }
}

