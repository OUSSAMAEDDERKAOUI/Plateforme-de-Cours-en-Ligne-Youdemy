<?php 

class Category {
    protected $tagId;
    protected $tagTitle;
    protected $creationDate;
    protected $tagStatus;

    public function __construct($tagTitle, $creationDate, $tagStatus) {
        $this->tagTitle = $tagTitle;
        $this->creationDate = $creationDate;
        $this->tagStatus = $tagStatus;
    }

    // ------------------- Getters -------------------------

    public function gettagId() {
        return $this->tagId;
    }

    public function gettagTitle() {
        return $this->tagTitle;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function gettagStatus() {
        return $this->tagStatus;
    }

    // ------------------- Setters -------------------------

   
    public function settagTitle($tagTitle) {
        $this->tagTitle = $tagTitle;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function settagStatus($tagStatus) {
        $this->tagStatus = $tagStatus;
    }
}

 
?>