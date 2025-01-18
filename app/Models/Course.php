<?php
require_once __DIR__ . '/../../config/database.php';

abstract class Course
{
    protected $courseId;
    protected $courseTitle;
    protected $courseContent;
    protected $creationDate;
    protected $courseStatus;
    protected $courseConverture;
    protected $courseDescription;
    protected $teacherId;
    protected $categoryId;
    protected $courseType;



    public function __construct( $courseId ,$courseTitle, $courseContent, $teacherId, $courseStatus = null, $creationDate = null, $courseConverture, $courseDescription, $categoryId = null,$courseType)
    {
        $this->courseId = $courseId;
        $this->courseTitle = $courseTitle;
        $this->courseContent = $courseContent;
        $this->teacherId = $teacherId;
        $this->courseStatus = $courseStatus ?:'accepté';
        $this->creationDate = $creationDate ?: date('Y-m-d');
        $this->courseConverture = $courseConverture;
        $this->courseDescription = $courseDescription;
        $this->categoryId = $categoryId;
        $this->courseType = $courseType;



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
        return $this->courseDescription;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public function getCourseType()
    {
        return $this->courseType;
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

    public function setCoursesDescription($courseDescription)
    {
        $this->courseDescription = $courseDescription;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    public function setCourseType($courseType)
    {
        $this->courseType = $courseType;
    }


    // ------------------- Méthodes supplémentaires -------------------------
    abstract public function uploadFile();

    // Insertion du cours dans la base de données
    public function addCourse()
    {
        // Upload du fichier spécifique à chaque sous-classe
        $this->uploadFile();

        // Insertion dans la base de données
        $pdo = Database::getInstance()->getConnection();
        $query = "INSERT INTO courses (`course_title`, `course_content`, `teacher_id`, `couverture`, `courses_description`, `course_cat_id`, `course_type`) 
                  VALUES (:courseTitle, :courseContent, :teacherId, :courseCover, :coursesDescription, :categoryId, :courseType)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':courseTitle', $this->courseTitle);
        $stmt->bindParam(':courseContent', $this->courseContent);
        $stmt->bindParam(':teacherId', $this->teacherId);
        $stmt->bindParam(':courseCover', $this->courseConverture);
        $stmt->bindParam(':coursesDescription', $this->courseDescription);
        $stmt->bindParam(':categoryId', $this->categoryId);
        $stmt->bindParam(':courseType', $this->courseType);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Erreur lors de l'ajout du cours dans la base de données.");
        }
    }



    abstract public static function showCourses();



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

    public static function getCourseById($courseId) {
       
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
