<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    public static function getInstance($dsn = null, $username = null, $password = null) {
        if (self::$instance === null) {
            $dsn = $dsn ?? 'mysql:host=localhost;dbname=youdemy;charset=utf8mb4'; 
            $username = $username ?? 'root';
            $password = $password ?? '';
            self::$instance = new Database($dsn, $username, $password);

        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}













?>

<!-- MySQL utilise des codes comme :

1045 : "Access denied for user" (Accès refusé pour l'utilisateur - erreur d'authentification).
2002 : "Connection refused" (Connexion refusée - le serveur n'est pas accessible).
42S02 : "Table not found" (Table introuvable - la table que vous essayez d'interroger n'existe pas). -->

