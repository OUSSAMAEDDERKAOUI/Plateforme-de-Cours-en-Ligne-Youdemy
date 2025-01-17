<?php
require_once __DIR__ . '/../../config/database.php';

class Category {
    protected $categoryId;            
    protected $categoryTitle;         
    protected $categoryDescription;   
    protected $creationDate;          
    protected $categoryStatus;        

    public function __construct( $categoryTitle, $categoryDescription, $creationDate = null, $categoryStatus = null) {
        $this->categoryTitle = $categoryTitle;
        $this->categoryDescription = $categoryDescription;
        $this->creationDate = $creationDate ?? date('Y-m-d'); 
        $this->categoryStatus = $categoryStatus ?? 'actif';
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
    


    public function addCategory() {
        echo 'testvalid1';
    
        $query = "INSERT INTO `categories`( `category_title`, `category_description`)
                  VALUES (:categoryTitle, :categoryDescription)";
    
        $stmt =Database::getInstance()->getConnection()->prepare($query);
        echo 'testvalid2';
    
        $stmt->bindValue(':categoryTitle', $this->categoryTitle, PDO::PARAM_STR);
        $stmt->bindValue(':categoryDescription',$this->categoryDescription, PDO::PARAM_STR);
        echo 'testvalid3';
    
        try {

            $stmt->execute();
            echo 'testvalid3';

        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
    
public function showCategory() {
    $stmt = Database::getInstance()->getConnection()->prepare(" SELECT * FROM categories
        
        WHERE categories.category_status = 'actif'" );

    try {
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            return $result;
        } else {
            throw new Exception("Aucune catégorie trouvée.");
        }

    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        return null;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}


public function updateCategory() {
    if (empty($this->categoryTitle) || empty($this->categoryDescription) || empty($this->categoryId)) {
        throw new InvalidArgumentException("Les informations nécessaires sont manquantes.");
    }

    $query = "UPDATE `categories`
              SET `category_title` = :categoryTitle, `category_description` = :categoryDescription
              WHERE `category_id` = :categoryId";

    $stmt = Database::getInstance()->getConnection()->prepare($query);

    $stmt->bindValue(':categoryTitle', $this->categoryTitle, PDO::PARAM_STR);
    $stmt->bindValue(':categoryDescription', $this->categoryDescription, PDO::PARAM_STR);
    $stmt->bindValue(':categoryId', $this->categoryId, PDO::PARAM_INT); 

    try {
        $stmt->execute();
        echo 'La catégorie a été mise à jour avec succès.'; 
    } catch (PDOException $e) {
        throw new PDOException("Erreur lors de la mise à jour de la catégorie: " . $e->getMessage(), (int) $e->getCode());
    }
}





public function deleteCategory($categoryId) {
    $query = "UPDATE `categories`
              SET `category_status` = 'inactif'
              WHERE `category_id` = :categoryId";

    $stmt = Database::getInstance()->getConnection()->prepare($query);
    echo '1';

    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    echo '2';

    try {
        $stmt->execute();
        echo '3';

    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
}

public function getCategoryById($categoryId) {
    $sql = "SELECT * FROM categories WHERE category_id = :id";
    $stmt = Database::getInstance()->getConnection()->prepare($sql);
    $stmt->bindParam(':id', $categoryId);
    echo $categoryId;
    $stmt->execute();
    return $stmt->fetch();
}


}


?>
