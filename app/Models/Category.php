<?php
require_once __DIR__ . '/../../config/database.php';

class Category {
    protected $categoryId;            
    protected $categoryTitle;         
    protected $categoryDescription;   
    protected $creationDate;          
    protected $categoryStatus; 
    protected $categoryConverture   ;    

    public function __construct( $categoryId,$categoryTitle, $categoryDescription, $creationDate = null, $categoryStatus = null,$categoryConverture) {
        $this->categoryId = $categoryId;
        $this->categoryTitle = $categoryTitle;
        $this->categoryDescription = $categoryDescription;
        $this->creationDate = $creationDate ?? date('Y-m-d'); 
        $this->categoryStatus = $categoryStatus ?? 'actif';
        $this->categoryConverture = $categoryConverture;

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
    public function getCategoryConverture() {
        return $this->categoryConverture;
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
    public function setCategoryConverture($categoryConverture) {
        $this->categoryConverture = $categoryConverture;
    }
    


    public function addCategory() {
        echo 'testvalid1';
    
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
            $categoryConverture = $_FILES['category_image']; 
            $permited = array('jpg', 'png', 'jpeg', 'gif');
            $file_name = $categoryConverture['name'];
            $file_size = $categoryConverture['size'];
            $file_temp = $categoryConverture['tmp_name'];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
    
            if (in_array($file_ext, $permited) === false) {
                throw new Exception("Format d'image non autorisé. Autorisé : " . implode(', ', $permited));
            }
    
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    
            $uploadDir = "storage/uploads/";
            $this->categoryConverture = $uploadDir . $unique_image;
    
            if (!move_uploaded_file($file_temp, __DIR__ . "/../../" . $this->categoryConverture)) {
                throw new Exception("Échec du téléchargement de l'image.");
            }
        } else {
            throw new Exception("Aucune image à télécharger ou une erreur est survenue.");
        }
    
        $query = "INSERT INTO `categories`( `category_title`, `category_description`, `categoryCouverture`)
                  VALUES (:categoryTitle, :categoryDescription, :categoryConverture)";
    
        $stmt = Database::getInstance()->getConnection()->prepare($query);
    
        $stmt->bindValue(':categoryTitle', $this->categoryTitle, PDO::PARAM_STR);
        $stmt->bindValue(':categoryDescription', $this->categoryDescription, PDO::PARAM_STR);
        $stmt->bindValue(':categoryConverture', $this->categoryConverture, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
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
public static function showVisiteurCategories($depart,$limit) {
    $stmt = Database::getInstance()->getConnection()->prepare(" SELECT * FROM categories
        
        WHERE categories.category_status = 'actif' 
        order by category_title 
        LIMIT :limit OFFSET :depart " );
        $stmt->bindParam(':depart',$depart,PDO::PARAM_INT);
        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);

    try {
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($categories)) {
            $categoriesarray=[];
            foreach($categories as $Category){
                $categoriesarray[]=new self(
                    $Category['category_id'],
                    $Category['category_title'],
                    $Category['category_description'],
                    $Category['creation_date'],
                    $Category['category_status'],
                    $Category['categoryCouverture']
                );
            }
           
            return $categoriesarray;
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



public static function showVisiteurCategory() {
    $stmt = Database::getInstance()->getConnection()->prepare(" SELECT * FROM categories
        
        WHERE categories.category_status = 'actif' " );

    try {
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($categories)) {
            $categoriesarray=[];
            foreach($categories as $Category){
                $categoriesarray[]=new self(
                    $Category['category_id'],
                    $Category['category_title'],
                    $Category['category_description'],
                    $Category['creation_date'],
                    $Category['category_status'],
                    $Category['categoryCouverture']
                );
            }
           
            return $categoriesarray;
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


public static function countCategories(){
    try{
        $sql = "SELECT COUNT(*) AS nbr_categories FROM categories WHERE categories.category_status = 'actif'";
        $stmt = Database::getInstance()->getConnection()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count ;
    }catch (PDOException $e){
        throw new PDOException('Erreur lors de Récupération des Catégories : '. $e->getMessage());
    }
}


public function updateCategory() {
    if (empty($this->categoryTitle) || empty($this->categoryDescription) || empty($this->categoryId)) {
        throw new InvalidArgumentException("Les informations nécessaires sont manquantes.");
    }

    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] === UPLOAD_ERR_OK) {
        $categoryConverture = $_FILES['update_image']; 
        $permited = array('jpg', 'png', 'jpeg', 'gif');
        $file_name = $categoryConverture['name'];
        $file_size = $categoryConverture['size'];
        $file_temp = $categoryConverture['tmp_name'];
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));

        if (in_array($file_ext, $permited) === false) {
            throw new Exception("Format d'image non autorisé. Autorisé : " . implode(', ', $permited));
        }

        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;

        $uploadDir = "storage/uploads/";
        $this->categoryConverture = $uploadDir . $unique_image;

        if (!move_uploaded_file($file_temp, __DIR__ . "/../../" . $this->categoryConverture)) {
            throw new Exception("Échec du téléchargement de l'image.");
        }
    } else {
        throw new Exception("Aucune image à télécharger ou une erreur est survenue.");
    }
    $query = "UPDATE `categories`
              SET `category_title` = :categoryTitle, `category_description` = :categoryDescription ,categoryCouverture=:categoryCouverture
              WHERE `category_id` = :categoryId";

    $stmt = Database::getInstance()->getConnection()->prepare($query);

    $stmt->bindValue(':categoryTitle', $this->categoryTitle, PDO::PARAM_STR);
    $stmt->bindValue(':categoryDescription', $this->categoryDescription, PDO::PARAM_STR);
    $stmt->bindValue(':categoryCouverture', $this->categoryConverture, PDO::PARAM_STR);

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
