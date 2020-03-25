<?php

namespace Application\Models;

use System\Base\Model;
use PDO;

class CourseStudent extends Model
{
    public function addCourseStudent($courseId, $studentId)
    {
        $query = $this->db->prepare("
            INSERT INTO course_student
            (`course_id`, `student_id`)
            VALUES
            (:courseId, :studentId)
        ");

        $query->bindValue(':courseId', $courseId, PDO::PARAM_INT);
        $query->bindValue(':studentId', $studentId, PDO::PARAM_INT);

        return $query->execute();
    }
}