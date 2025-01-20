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
    protected $courseTags;



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
    public function getCourseTags()
    {
        return $this->courseTags;
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
    public function setcourseTags($CourseTags)
    {
        $this->courseTags = $CourseTags;
    }


    // ------------------- Méthodes supplémentaires -------------------------
    abstract public function uploadFile();

    public function addCourse()
    {
        $this->uploadFile();

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

    public static function addCourseTags($tags)
    {
        $id_course = Database::getInstance()->getConnection()->lastInsertId();
        echo 'test1' . $id_course; 
    
        $stmt = Database::getInstance()->getConnection()->prepare("INSERT INTO `course_tags`(`tag_id`, `course_id`) VALUES (:id_tag, :id_course)");
    
        foreach ($tags as $id_tag) {
            $stmt->bindParam(':id_course', $id_course, PDO::PARAM_INT);  
            $stmt->bindParam(':id_tag', $id_tag, PDO::PARAM_INT);  
            try {
                $stmt->execute();  
                echo "Tag ID $id_tag inserted successfully.<br>";
            } catch (PDOException $e) {
                echo "Error inserting tag ID $id_tag: " . $e->getMessage() . "<br>";
            }
        }
    }

    


    public function updateCourse()
    {
        $this->uploadFile();

        $pdo = Database::getInstance()->getConnection();
        $query ="UPDATE `courses` SET `course_title`=:course_title,`course_content`=:course_content,`couverture`=:courseCover,
        `courses_description`=:courses_description,`course_cat_id`=:course_cat_id,`course_type`=:course_type 
        WHERE `course_id`=:course_id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':course_title', $this->courseTitle);
        $stmt->bindParam(':course_content', $this->courseContent);
        $stmt->bindParam(':courseCover', $this->courseConverture);
        $stmt->bindParam(':courses_description', $this->courseDescription);
        $stmt->bindParam(':course_cat_id', $this->categoryId);
        $stmt->bindParam(':course_type', $this->courseType);
        $stmt->bindParam(':course_id', $this->courseId);
        echo('test valid 2');


        if ($stmt->execute()) {
            echo('test valid 1');

            return true;
        } else {
            throw new Exception("Erreur lors de l'ajout du cours dans la base de données.");
        }
    }

    abstract public static function showCourses();



    public static function getCategoryTitleById($categoryId)
    {
        $pdo = Database::getInstance()->getConnection(); 
        $query = "SELECT category_title FROM categories WHERE category_id = :categoryId"; 
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ? $category['category_title'] : 'Inconnu';
    }


    public static function getTeacherNameById($teacherId)
    {
        $pdo = Database::getInstance()->getConnection(); 
        $query = "SELECT teacher_name FROM teachers WHERE teacher_id = :teacherId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        return $teacher ? $teacher['teacher_name'] : 'Inconnu';
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
        $pdo = Database::getInstance()->getConnection();
        $query = "SELECT * FROM courses WHERE course_id = :courseId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($course) {
             if ($course['course_type'] === 'vidéo') {
                return new CourseVideo(
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
            }else if ($course['course_type'] === 'document') {
                return new CourseDocument(
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
    
        return null;  
    }
    

    






    public function getEnrolledStudents()
    {
        return [];
    }

    public function changeStatus($newStatus)
    {
        $this->courseStatus = $newStatus;
    }
}
