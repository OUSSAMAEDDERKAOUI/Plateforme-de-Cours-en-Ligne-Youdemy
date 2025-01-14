<?php
class Enrollment {
    protected $enrollmentId;
    protected $courseId;
    protected $userId;  // L'ID de l'étudiant
    protected $enrollmentDate;

    // Constructeur
    public function __construct($courseId, $userId, $enrollmentDate = null) {
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->enrollmentDate = $enrollmentDate ?: date('Y-m-d'); 
    }

    // ------------------- Getters -------------------------

    public function getEnrollmentId() {
        return $this->enrollmentId;
    }

    public function getCourseId() {
        return $this->courseId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getEnrollmentDate() {
        return $this->enrollmentDate;
    }

    // ------------------- Setters -------------------------

    public function setEnrollmentId($enrollmentId) {
        $this->enrollmentId = $enrollmentId;
    }

    public function setCourseId($courseId) {
        $this->courseId = $courseId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setEnrollmentDate($enrollmentDate) {
        $this->enrollmentDate = $enrollmentDate;
    }

    // ------------------- Méthodes -------------------------

    //  vérifier si  l'étudiant est déjà inscrit 
    public function isAlreadyEnrolled($courseId, $userId) {
        
        return false;  
    }

    //  supprimer l'inscription d'un étudiant
    public function withdraw($enrollmentId) {
        
    }

    //  récupérer les cours d'un étudiant
    public function getCoursesByUser($userId) {
       
    }
}



?>