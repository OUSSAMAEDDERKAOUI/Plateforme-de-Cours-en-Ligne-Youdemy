<?php
require_once __DIR__.'./Users.php';
class Enseignants extends Users{




    public function nbrOfCourse($teacher_id){
        $stmt=Database::getInstance()->getConnection()->prepare("SELECT COUNT(course_id) AS nbrOfCourses  FROM courses WHERE teacher_id =:teacher_id");
    $stmt->bindParam(':teacher_id',$teacher_id,PDO::PARAM_INT);
    try{
        $stmt->execute();
      $resultat=$stmt->fetch(PDO::FETCH_ASSOC);
return $resultat;
    }catch(PDOException $e){
        throw ($e->getMessage());
    }
    
    }
    public static function nbrOfStudents($teacher_id)
{
    $pdo = Database::getInstance()->getConnection();
    $query = "SELECT COUNT(DISTINCT course_etudiant.student_id) AS nbrOfStudents
              FROM course_etudiant
              JOIN courses ON courses.course_id = course_etudiant.course_id
              WHERE courses.teacher_id = :teacher_id AND courses.course_status = 'accepté'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
}

}

?>