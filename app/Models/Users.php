<?php
require_once __DIR__ . '/../../config/database.php';
 class Users{

protected $userId;
protected $fName;
protected $lName;
protected $email;
protected $password;
protected $role;
protected $status;


public function __construct($userId,$fName,$lName,$email,$password,$role,$status){
    $this->userId=$userId;
    $this->fName=$fName;
    $this->lName=$lName;
    $this->email=$email;
    $this->password=$password;
    $this->role=$role;
    $this->status=$status;

}

// -------------------Getters-------------------------

public function getidUser(){
    return $this->userId;
}
public function getfName(){
    return $this->fName;
}
public function getlName(){
    return $this->lName;
}
public function getEmail(){
    return $this->email;
}
public function getpassword(){
    return $this->password;
}
public function getRole(){
    return $this->role;
}
public function getStatus(){
    return $this->status;
}



// -------------------Setters-------------------------

public function setfName($fName){
    $this->fName=$fName;
}

public function setlName($lName){
    $this->lName=$lName;
}
public function setemail($email){
    $this->email=$email;
}
public function setpassword($password){
    $this->password = $password;
}
public function setRole($role){
    $this->role =$role;
}
public function setStatus($status){
    $this->status =$status;
}

public function signup()
{
    if (empty($this->fName) || empty($this->lName) || empty($this->email) || empty($this->password) || empty($this->role) || empty($this->status)) {
        echo "Tous les champs sont obligatoires";
        return;
    }

    $nameRegex = '/^[A-Za-zÀ-ÿÉéÈèÊêËëÏïÎîÔôÖöÙùÜüÇç\' -]+$/';

    if (!preg_match($nameRegex, $this->fName)) {
        echo "Le prénom n'est pas valide. Il ne doit contenir que des lettres, des espaces, des apostrophes et des tirets.";
        return;
    }

    if (!preg_match($nameRegex, $this->lName)) {
        echo "Le nom n'est pas valide. Il ne doit contenir que des lettres, des espaces, des apostrophes et des tirets.";
        return;
    }

    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        echo "L'email fourni n'est pas valide.";
        return;
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $this->password)) {
        echo "Le mot de passe doit comporter au moins 8 caractères, une majuscule, une minuscule et un chiffre.";
        return;
    }

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = Database::getInstance()->getConnection()->prepare($sql);
    $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Un utilisateur avec cet email existe déjà.";
        return;
    } else {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `role`,`user_status`) 
                  VALUES (:nom, :prenom, :email, :password, :role, :status)";
        $stmt = Database::getInstance()->getConnection()->prepare($query);

        $stmt->bindParam(":nom", $this->lName, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $this->fName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Une erreur est survenue lors de l\'inscription : ' . $e->getMessage(), (int)$e->getCode());
        }
    }
}


public  function login($postEmail , $postPassword){

    $stmt= Database::getInstance()->getConnection()->prepare(" SELECT * FROM users WHERE users.email=:email AND user_status='accepté'");

    $stmt->bindParam(':email',$postEmail,PDO::PARAM_STR);
    try {
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if (empty($result)) {
          throw new Exception('Aucun résultat trouvé.'); 
      } else {
        
          if (password_verify($postPassword, $result['password'])) {
            $this->userId = $result['user_id'];
            $this->lName =$result['last_name'];
            $this->fName=$result['first_name'];
            $this->email=$result['email'];
            $this->role=$result['role'];
            echo'ZZZZZZ';

            return $this;
          }
      }
      }
   catch (PDOException $e) {
      throw new Exception('Erreur de base de données : ' . $e->getMessage());
  } catch (Exception $e) {
      throw new Exception($e->getMessage());
  }
    



   }



private function setPasswordHash($password) {
    $this->password = password_hash($password, PASSWORD_BCRYPT);
}


public static function isAuth($role)
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
        return $_SESSION['user_role'] == $role;
    } else if ($role == 'autre') {
        return true;
    }

    return false;
}


    
public function getUserById($id)
{
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return new Users(
            $result['id'],
            $result['nom'],
            $result['prenom'],
            $result['email'],
            $result['password'],
            $result['role'],
            $result['status']

        );
    }

    return null; 
}








 }

























?>