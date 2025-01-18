<?php
require_once __DIR__ . './Course.php';

class CourseVideo extends Course
{
    // Redéfinition de la méthode uploadFile pour les vidéos
    public function uploadFile()
    {
        // Upload de l'image de couverture
        if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
            $courseConverture = $_FILES['course_image'];
            $file_ext = strtolower(pathinfo($courseConverture['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_ext, $allowed_ext)) {
                throw new Exception("Format d'image non autorisé.");
            }

            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploadDir = "storage/uploads/images/";
            $this->courseConverture = $uploadDir . $unique_image;

            if (!move_uploaded_file($courseConverture['tmp_name'], __DIR__ . "/../../" . $this->courseConverture)) {
                throw new Exception("Échec du téléchargement de l'image.");
            }
        } else {
            throw new Exception("Aucune image téléchargée.");
        }

      



}

?>

