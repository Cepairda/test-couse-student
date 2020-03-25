<?php

namespace Application\Models;

use System\Base\Model;
use PDO;

class Student extends Model
{
    public function getAllSubjects()
    {
        $query = $this->db->query('SELECT * FROM subject');

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGroupCountSubject()
    {
        $query = $this->db->query('SELECT subject_id, COUNT(*) AS count FROM review GROUP BY subject_id');

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addStudent($surname, $name, $email, $photo)
    {
        $query = $this->db->prepare("
            INSERT INTO student
            (`surname`, `name`, `email`, `photo`)
            VALUES
            (:surname, :name, :email, :photo)
        ");

        $query->bindValue(':surname', $surname, PDO::PARAM_STR);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':photo', $photo, PDO::PARAM_STR);

        return $query->execute();
    }

    public function updateStudent($id, $surname, $name, $email, $photo) {
        $query = $this->db->prepare('
            UPDATE student 
            SET 
                surname = :surname, 
                name = :name,
                email = :email,
                photo = :photo
            WHERE id=:id');

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':surname', $surname, PDO::PARAM_STR);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':photo', $photo, PDO::PARAM_STR);

        return $query->execute();
    }

    public function deleteStudent($id) {
        $query = $this->db->prepare('DELETE FROM student WHERE id=:id');

        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();
    }

    public function getStudent($id)
    {
        $query = $this->db->prepare("
            SELECT * FROM student WHERE id = :id 
        ");

        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentLastId()
    {
        return $this->db->lastInsertId();
    }
}

