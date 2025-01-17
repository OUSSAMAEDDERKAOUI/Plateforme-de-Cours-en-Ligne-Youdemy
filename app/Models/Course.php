<?php 
require_once __DIR__ . '/../../config/database.php';

 class Course {
    protected $courseId;
    protected $courseTitle;
    protected $courseContent;
    protected $creationDate;
    protected $courseStatus;
    protected $courseConverture;
    protected $courses_description;

    protected $teacherId;  

    
    public function __construct($courseTitle, $courseContent, $teacherId, $courseStatus = 'active', $creationDate = null,$courseConverture,$courses_description) {
        $this->courseTitle = $courseTitle;
        $this->courseContent = $courseContent;
        $this->teacherId = $teacherId;
        $this->courseStatus = $courseStatus;
        $this->creationDate = $creationDate ?: date('Y-m-d'); 
        $this->creationDate = $courseConverture ;
        $this->courses_description = $courses_description ; 


    }

    // ------------------- Getters -------------------------

    public function getCourseId() {
        return $this->courseId;
    }

    public function getCourseTitle() {
        return $this->courseTitle;
    }

    public function getCoursecontent() {
        return $this->courseContent;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getCourseStatus() {
        return $this->courseStatus;
    }

    public function getTeacherId() {
        return $this->teacherId;
    }
    public function getCourseConverture() {
        return $this->courseConverture;
    }
    public function getCourses_description() {
        return $this->courses_description;
    }

    // ------------------- Setters -------------------------

    public function setCourseId($courseId) {
        $this->courseId = $courseId;
    }

    public function setCourseTitle($courseTitle) {
        $this->courseTitle = $courseTitle;
    }

    public function setCoursecontent($coursecontent) {
        $this->courseContent = $coursecontent;
    }

    public function setCourseStatus($courseStatus) {
        $this->courseStatus = $courseStatus;
    }

    public function setTeacherId($teacherId) {
        $this->teacherId = $teacherId;
    }


    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    public function setCourseConverture($courseConverture) {
        $this->courseConverture = $courseConverture;
    }
    public function setCourses_description($courses_description) {
        $this->courses_description = $courses_description;
    }

    // ------------------- Méthodes supplémentaires -------------------------
    public function addCourse(){
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
    



        $stmt='INSERT INTO `courses`( `course_title`, `course_content`, `teacher_id`, `couverture`,`courses_description`) VALUES (:course_title,:course_content,:teacher_id,:couverture,:courses_description)';
        $stmt=Database::getInstance()->getConnection()->prepare($stmt);
        $stmt->bindParam(':course_title',$this->courseTitle,PDO::PARAM_STR);
        $stmt->bindParam(':course_content',$this->courseContent,PDO::PARAM_STR);
        $stmt->bindParam(':teacher_id',$this->teacherId,PDO::PARAM_INT);
        $stmt->bindParam(':couverture',$this->courseConverture,PDO::PARAM_STR);
        $stmt->bindParam(':courses_description',$this->courses_description,PDO::PARAM_STR);



        try{
            $stmt->execute();
        }catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public static function showCourses() {
        $pdo = Database::getInstance()->getConnection(); // Connexion à la base de données
        $query = "SELECT `course_id`, `course_title`, `course_content`, `creation_date`, `course_status`, `teacher_id`, `couverture`, `courses_description` 
        FROM `courses` "; 

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer les résultats

        $courseObjects = [];
        foreach ($courses as $course) {
            // Créer des objets Course à partir des données de la base de données
            $courseObjects[] = new self(
                $course['course_title'], 
                $course['course_content'], 
                $course['teacher_id'], 
                $course['course_status'], 
                $course['creation_date'], 
                $course['course_id'],
                $course['courses_description'],

            );
        }

        return $courseObjects;
    }









    //  récupérer la liste des étudiants inscrits à ce cours
    public function getEnrolledStudents() {
        return []; 
    }

    //  changer le statut du cours (activer/désactiver)
    public function changeStatus($newStatus) {
        $this->courseStatus = $newStatus;
    }
}

?>