<?php

class Category {
    protected $categoryId;            
    protected $categoryTitle;         
    protected $categoryDescription;   
    protected $creationDate;          
    protected $categoryStatus;        

    public function __construct($categoryTitle, $categoryDescription, $creationDate = null, $categoryStatus = 'actif') {
        $this->categoryTitle = $categoryTitle;
        $this->categoryDescription = $categoryDescription;
        $this->creationDate = $creationDate ?? date('Y-m-d'); 
        $this->categoryStatus = $categoryStatus;
    }

    // ------------------- Getters -------------------------

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function getCategoryTitle() {
        return $this->categoryTitle;
    }

    public function getCategoryDescription() {
        return $this->categoryDescription;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getCategoryStatus() {
        return $this->categoryStatus;
    }

    // ------------------- Setters -------------------------

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    public function setCategoryTitle($categoryTitle) {
        $this->categoryTitle = $categoryTitle;
    }

    public function setCategoryDescription($categoryDescription) {
        $this->categoryDescription = $categoryDescription;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setCategoryStatus($categoryStatus) {
        $this->categoryStatus = $categoryStatus;
    }
    





}


?>
