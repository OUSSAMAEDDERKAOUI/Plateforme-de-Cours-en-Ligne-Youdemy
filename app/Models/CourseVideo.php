<?php
require_once __DIR__ . './Course.php';

class CourseVideo extends Course
{
    // Redéfinition de la méthode uploadFile pour les vidéos
    public function uploadFile()
    {
        // Upload de l'image de couverture
        if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
            $courseConverture = $_FILES['course_image'];
            $file_ext = strtolower(pathinfo($courseConverture['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_ext, $allowed_ext)) {
                throw new Exception("Format d'image non autorisé.");
            }

            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploadDir = "storage/uploads/images/";
            $this->courseConverture = $uploadDir . $unique_image;

            if (!move_uploaded_file($courseConverture['tmp_name'], __DIR__ . "/../../" . $this->courseConverture)) {
                throw new Exception("Échec du téléchargement de l'image.");
            }
        } else {
            throw new Exception("Aucune image téléchargée.");
        }

        // Upload du fichier vidéo
        if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === UPLOAD_ERR_OK) {
            $courseVideo = $_FILES['course_file'];
            $file_ext_video = strtolower(pathinfo($courseVideo['name'], PATHINFO_EXTENSION));
            $allowed_ext_video = ['mp4', 'avi', 'mov', 'mkv'];

            if (!in_array($file_ext_video, $allowed_ext_video)) {
                throw new Exception("Format de fichier vidéo non autorisé.");
            }

            $unique_video = substr(md5(time()), 0, 10) . '.' . $file_ext_video;
            $uploadVideoDir = "storage/uploads/";
            $this->courseContent = $uploadVideoDir . $unique_video;

            if (!move_uploaded_file($courseVideo['tmp_name'], __DIR__ . "/../../" . $this->courseContent)) {
                throw new Exception("Échec du téléchargement de la vidéo.");
            }
        } else {
            throw new Exception("Aucune vidéo téléchargée.");
        }
    }
    public static function showCourses()
    {
        $pdo = Database::getInstance()->getConnection();
        $query = "SELECT `course_id`, `course_title`, `course_content`, `creation_date`, `course_status`, `teacher_id`, `couverture`, `courses_description`, `course_cat_id`, `course_type`
                  FROM `courses` WHERE course_status ='accepté' AND course_type = 'video'";

        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }

        $courseObjects = [];
        foreach ($courses as $course) {
            $courseObjects[] = new self(
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

        return $courseObjects;
    }

    // public static function getCourseById($courseId) {
    //     $pdo = Database::getInstance()->getConnection();
    //     $query = "SELECT * FROM courses WHERE course_id = :courseId AND course_type = 'video'";
    //     $stmt = $pdo->prepare($query);
    //     $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $course = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if ($course) {
    //         return new CourseVideo(
    //             $course['course_id'],
    //             $course['course_title'],
    //             $course['course_content'],
    //             $course['teacher_id'],
    //             $course['course_status'],
    //             $course['creation_date'],
    //             $course['couverture'],
    //             $course['courses_description'],
    //             $course['course_cat_id'],
    //             $course['course_type']
    //         );
    //     }
    //     return null;
    // }
}



?>

