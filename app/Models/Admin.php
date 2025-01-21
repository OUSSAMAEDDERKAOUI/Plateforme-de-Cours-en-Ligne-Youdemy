<?php
require_once __DIR__ . './Users.php';
class Admin extends Users
{
    public function showTeachersAccount()
    {
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT * FROM users WHERE user_status ='en attente' AND role='enseignant'");
        try {
            $stmt->execute();
            $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }

        $teachersArray = [];
        foreach ($teachers as $teacher) {
            $teachersArray[] = new Enseignants(
                $teacher['user_id'],
                $teacher['first_name'],
                $teacher['last_name'],
                $teacher['email'],
                $teacher['password'],
                $teacher['role'],
                $teacher['user_status']
            );
        }
        return $teachersArray ;
    }
    public function approuveTeacher($teacher_id){
        $stmt = Database::getInstance()->getConnection()->prepare("UPDATE users SET user_status ='accepté'  WHERE user_id = :teacher_id");
        $stmt->bindParam(':teacher_id',$teacher_id,PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }
    }
    public function rejectTeacher($teacher_id){
        $stmt = Database::getInstance()->getConnection()->prepare("UPDATE users SET user_status ='refusé'  WHERE user_id = :teacher_id");
        $stmt->bindParam(':teacher_id',$teacher_id,PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }
    }
    public function countingTeacher(){
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT  COUNT(user_id) AS count  FROM users WHERE user_status ='accepté' AND role='enseignant'");
        try {
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }
        return $result;
    }
    public function countingStudents(){
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT  COUNT(user_id) AS count  FROM users WHERE user_status ='accepté' AND role='etudiant'");
        try {
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }
        return $result;
    }
    public function countingUsers(){
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT  COUNT(user_id) AS count  FROM users WHERE user_status ='accepté' ");
        try {
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }
        return $result;
    }
    public function countingCourses(){
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT COUNT(`course_id`) AS count  FROM `courses` WHERE `course_status`='accepté'");
        try {
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw ('erreur lors de la récupération des données' . $e->getMessage());
        }
        return $result;
    }
}
