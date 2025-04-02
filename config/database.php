<?php
/**
 * Configuration de la base de données
 */

// Paramètres de connexion à la base de données PostgreSQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'nba_predictor');
define('DB_USER', 'postgres');
define('DB_PASS', 'password'); // À modifier selon votre configuration
define('DB_PORT', '5432');

/**
 * Classe de connexion à la base de données
 */
class Database {
    private static $instance = null;
    private $conn;
    
    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {
        try {
            $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    
    // Méthode pour obtenir l'instance unique (Singleton)
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    // Méthode pour obtenir la connexion
    public function getConnection() {
        return $this->conn;
    }
    
    // Exécuter une requête SELECT
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    // Exécuter une requête INSERT, UPDATE, DELETE
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    // Obtenir un seul enregistrement
    public function single($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    // Obtenir tous les enregistrements
    public function resultSet($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    // Obtenir le nombre de lignes affectées
    public function rowCount($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    // Obtenir le dernier ID inséré
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}