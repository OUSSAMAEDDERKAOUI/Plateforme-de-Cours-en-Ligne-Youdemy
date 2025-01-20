<?php 
require_once __DIR__ . '/../../config/database.php';

class Tags {
    protected $tagId;
    protected $tagName;
    protected $tagDescription;
    protected $creationDate;
    protected $tagStatus;

    public function __construct($tagId,$tagName, $tagDescription,$creationDate=null, $tagStatus=null) {
        $this->tagId = $tagId ;
        $this->tagName = $tagName;
        $this->tagDescription = $tagDescription;
        $this->creationDate = $creationDate ?? date('Y-m-d');
        $this->tagStatus = $tagStatus ?? 'actif';
    }

    // ------------------- Getters -------------------------

    public function gettagId() {
        return $this->tagId;
    }

    public function gettagName() {
        return $this->tagName;
    }
    public function getDescription() {
        return $this->tagDescription;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function gettagStatus() {
        return $this->tagStatus;
    }

    // ------------------- Setters -------------------------

    public function setId($tagId) {
        $this->tagId = $tagId;
    }  


    public function settagName($tagName) {
        $this->tagName = $tagName;
    }



    public function setDescription($tagDescription) {
        $this->tagDescription = $tagDescription;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function settagStatus($tagStatus) {
        $this->tagStatus = $tagStatus;
    }

public function addTag() {
    if (empty($this->tagName) || empty($this->tagDescription)) {
        throw new InvalidArgumentException("Le nom ou la description du tag sont manquants.");
    }
    
    if (!preg_match('/^[a-zA-Z0-9\s]{3,50}$/', $this->tagName)) {
        throw new InvalidArgumentException("Le nom du tag doit contenir entre 3 et 50 caractères, avec des lettres, des chiffres et des espaces.");
    }

    if (!preg_match('/^[a-zA-Z0-9\s,.;!?\'"()-]{10,300}$/', $this->tagDescription)) {
        throw new InvalidArgumentException("La description du tag doit contenir entre 10 et 300 caractères, avec des lettres, des chiffres, et des espaces.");
    }


    $query = "INSERT INTO `tags` (`tag_name`, `tag_description`)
              VALUES (:tagName, :tagDescription)";

    $stmt = Database::getInstance()->getConnection()->prepare($query);

    $stmt->bindValue(':tagName', $this->tagName, PDO::PARAM_STR);
    $stmt->bindValue(':tagDescription', $this->tagDescription, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo 'Tag ajouté avec succès.';
    } catch (PDOException $e) {
        throw new PDOException("Erreur lors de l'ajout du tag: " . $e->getMessage(), (int) $e->getCode());
    }
}

public function showTags() {
    $stmt = Database::getInstance()->getConnection()->prepare("SELECT * FROM `tags`");

    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            $resultsArray=[];

            foreach($results as $result){
                $resultsArray[]=new self(
                    $result['tag_id'],
                    $result['tag_name'],
                    $result['tag_description'],
                    $result['creation_date']
                );
            }
            return $resultsArray;
        } else {
            throw new Exception("Aucun tag trouvé.");
        }

    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        return null;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}

public function getTagById($tagId) {
    $sql = "SELECT * FROM `tags` WHERE `tag_id` = :tagId";
    $stmt = Database::getInstance()->getConnection()->prepare($sql);
    $stmt->bindValue(':tagId', $tagId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new PDOException("Erreur lors de la récupération du tag: " . $e->getMessage(), (int) $e->getCode());
    }
}




public function updateTag() {
    if (empty($this->tagName) || empty($this->tagDescription) || empty($this->tagId)) {
        throw new InvalidArgumentException("Les informations nécessaires sont manquantes.");
    }

    $query = "UPDATE `tags`
              SET `tag_name` = :tagName, `tag_description` = :tagDescription
              WHERE `tag_id` = :tagId";

    $stmt = Database::getInstance()->getConnection()->prepare($query);

    $stmt->bindValue(':tagName', $this->tagName, PDO::PARAM_STR);
    $stmt->bindValue(':tagDescription', $this->tagDescription, PDO::PARAM_STR);
    $stmt->bindValue(':tagId', $this->tagId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo 'Le tag a été mis à jour avec succès.';
    } catch (PDOException $e) {
        throw new PDOException("Erreur lors de la mise à jour du tag: " . $e->getMessage(), (int) $e->getCode());
    }
}



public function deleteTag($tagId) {
    $query = "DELETE FROM `tags`
              WHERE `tag_id` = :tagId";

    $stmt = Database::getInstance()->getConnection()->prepare($query);

    // Bind du paramètre
    $stmt->bindValue(':tagId', $tagId, PDO::PARAM_INT);

    try {
        // Exécuter la requête
        $stmt->execute();
        echo 'Tag supprimé avec succès.';
    } catch (PDOException $e) {
        throw new PDOException("Erreur lors de la suppression du tag: " . $e->getMessage(), (int) $e->getCode());
    }
}









}

?>