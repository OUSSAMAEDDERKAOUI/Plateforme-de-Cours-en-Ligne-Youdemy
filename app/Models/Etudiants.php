<?php
require_once __DIR__ . './Users.php';
require_once __DIR__ . './CourseDocument.php';
require_once __DIR__ . './CourseVideo.php';

class Etudiants extends Users
{



    public function inscrire($student_id, $course_id)
    {
        $stmt = Database::getInstance()->getConnection()->prepare(
            "SELECT COUNT(*) FROM `course_etudiant` WHERE `student_id` = :student_id AND `course_id` = :course_id"
        );
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            header('location: ../etudiant/details.php?id=' . $course_id);
        }
        $stmt = Database::getInstance()->getConnection()->prepare("INSERT INTO `course_etudiant`(`student_id`, `course_id`) VALUES (:student_id,:course_id)");
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException  $e) {
            throw new Exception("Erreur lors de l'inscription :" .  $e->getMessage());
        }
    }




    public static function showMyCourses()
{
    $pdo = Database::getInstance()->getConnection();
    $query = "SELECT courses.`course_id`, `course_title`, `course_content`, courses.`creation_date`, `course_status`, `teacher_id`, `couverture`, `courses_description`, `course_cat_id`, `course_type`
              FROM `course_etudiant` 
              JOIN courses ON courses.course_id = course_etudiant.course_id
              JOIN users ON users.user_id = course_etudiant.student_id
              WHERE course_status = 'accepté'";

    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    $courseObjects = [];
    if ($courses) {
        foreach ($courses as $course) {
            if ($course['course_type'] === 'vidéo') {
                $courseObjects[] = new CourseVideo(
                    $course['course_id'],
                    $course['course_title'],
                    $course['course_content'],
                    $course['teacher_id'],
                    $course['course_status'],
                    $course['creation_date'],
                    $course['couverture'],
                    $course['courses_description'],
                    $course['course_cat_id'],
                    $course['course_type']
                );
            } else if ($course['course_type'] === 'document') {
                $courseObjects[] = new CourseDocument(
                    $course['course_id'],
                    $course['course_title'],
                    $course['course_content'],
                    $course['teacher_id'],
                    $course['course_status'],
                    $course['creation_date'],
                    $course['couverture'],
                    $course['courses_description'],
                    $course['course_cat_id'],
                    $course['course_type']
                );
            }
        }
    }

    return $courseObjects;
}
}