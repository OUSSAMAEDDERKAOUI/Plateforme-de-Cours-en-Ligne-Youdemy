<?php
require_once __DIR__ . '/../../config/database.php';

class Course
{
    protected $courseId;
    protected $courseTitle;
    protected $courseContent;
    protected $creationDate;
    protected $courseStatus;
    protected $courseConverture;
    protected $courses_description;
    protected $teacherId;
    protected $categoryId;


    public function __construct( $courseId ,$courseTitle, $courseContent, $teacherId, $courseStatus = 'active', $creationDate = null, $courseConverture, $courses_description, $categoryId = null)
    {
        $this->courseId = $courseId;
        $this->courseTitle = $courseTitle;
        $this->courseContent = $courseContent;
        $this->teacherId = $teacherId;
        $this->courseStatus = $courseStatus;
        $this->creationDate = $creationDate ?: date('Y-m-d');
        $this->courseConverture = $courseConverture;
        $this->courses_description = $courses_description;
        $this->categoryId = $categoryId;
    }

    // ------------------- Getters -------------------------

    public function getCourseId()
    {
        return $this->courseId;
    }

    public function getCourseTitle()
    {
        return $this->courseTitle;
    }

    public function getCourseContent()
    {
        return $this->courseContent;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getCourseStatus()
    {
        return $this->courseStatus;
    }

    public function getTeacherId()
    {
        return $this->teacherId;
    }

    public function getCourseConverture()
    {
        return $this->courseConverture;
    }

    public function getCoursesDescription()
    {
        return $this->courses_description;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    // ------------------- Setters -------------------------

    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
    }

    public function setCourseTitle($courseTitle)
    {
        $this->courseTitle = $courseTitle;
    }

    public function setCourseContent($courseContent)
    {
        $this->courseContent = $courseContent;
    }

    public function setCourseStatus($courseStatus)
    {
        $this->courseStatus = $courseStatus;
    }

    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setCourseConverture($courseConverture)
    {
        $this->courseConverture = $courseConverture;
    }

    public function setCoursesDescription($courses_description)
    {
        $this->courses_description = $courses_description;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }


    // ------------------- Méthodes supplémentaires -------------------------
    public function addCourse()
    {
        if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
            $courseConverture = $_FILES['course_image'];
            $permited = array('jpg', 'png', 'jpeg', 'gif');
            $file_name = $courseConverture['name'];
            $file_size = $courseConverture['size'];
            $file_temp = $courseConverture['tmp_name'];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));

            if (in_array($file_ext, $permited) === false) {
                throw new Exception("Format d'image non autorisé. Autorisé : " . implode(', ', $permited));
            }

            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;

            $uploadDir = "storage/uploads/";
            $this->courseConverture = $uploadDir . $unique_image;

            if (!move_uploaded_file($file_temp, __DIR__ . "/../../" . $this->courseConverture)) {
                throw new Exception("Échec du téléchargement de l'image.");
            }
        } else {
            throw new Exception("Aucune image à télécharger ou une erreur est survenue.");
        }




        $stmt = 'INSERT INTO `courses`(`course_title`, `course_content`,`teacher_id`, `couverture`, `courses_description`, `course_cat_id`) VALUES (:course_title,:course_content,:teacher_id,:couverture,:courses_description,:course_cat_id)';
        $stmt = Database::getInstance()->getConnection()->prepare($stmt);
        $stmt->bindParam(':course_title', $this->courseTitle, PDO::PARAM_STR);
        $stmt->bindParam(':course_content', $this->courseContent, PDO::PARAM_STR);
        $stmt->bindParam(':teacher_id', $this->teacherId, PDO::PARAM_INT);
        $stmt->bindParam(':couverture', $this->courseConverture, PDO::PARAM_STR);
        $stmt->bindParam(':courses_description', $this->courses_description, PDO::PARAM_STR);
        $stmt->bindParam(':course_cat_id', $this->categoryId, PDO::PARAM_INT);




        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public static function showCourses()
    {
        $pdo = Database::getInstance()->getConnection();
        $query = "SELECT `course_id`, `course_title`, `course_content`, `creation_date`, `course_status`, `teacher_id`, `couverture`, `courses_description`, `course_cat_id`
        FROM `courses` WHERE course_status ='accepté' ";

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

            );
        }

        return $courseObjects;
    }


    public static function getCategoryTitleById($categoryId)
    {
        $pdo = Database::getInstance()->getConnection(); // Connexion à la base de données
        $query = "SELECT category_title FROM categories WHERE category_id = :categoryId"; // Requête pour récupérer le titre de la catégorie
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ? $category['category_title'] : 'Inconnu';
        // Retourner le titre de la catégorie ou 'Inconnu' si non trouvé
    }


    public static function getTeacherNameById($teacherId)
    {
        $pdo = Database::getInstance()->getConnection(); // Connexion à la base de données
        $query = "SELECT teacher_name FROM teachers WHERE teacher_id = :teacherId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        return $teacher ? $teacher['teacher_name'] : 'Inconnu'; // Retourne le nom de l'enseignant ou 'Inconnu' si non trouvé
    }

    public static function deletecourse($course_id)
    {
        $stmt = Database::getInstance()->getConnection()->prepare("UPDATE `courses` SET `course_status`='refusé'  WHERE `course_id`=:course_id");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }





    //  récupérer la liste des étudiants inscrits à ce cours
    public function getEnrolledStudents()
    {
        return [];
    }

    //  changer le statut du cours (activer/désactiver)
    public function changeStatus($newStatus)
    {
        $this->courseStatus = $newStatus;
    }
}
