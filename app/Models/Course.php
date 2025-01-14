<?php 
abstract class Course {
    protected $courseId;
    protected $courseTitle;
    protected $courseContent;
    protected $creationDate;
    protected $courseStatus;
    protected $teacherId;  

    
    public function __construct($courseTitle, $courseContent, $teacherId, $courseStatus = 'active', $creationDate = null) {
        $this->courseTitle = $courseTitle;
        $this->courseContent = $courseContent;
        $this->teacherId = $teacherId;
        $this->courseStatus = $courseStatus;
        $this->creationDate = $creationDate ?: date('Y-m-d'); 
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

    // ------------------- Setters -------------------------

   

 

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

    // ------------------- Méthodes supplémentaires -------------------------

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