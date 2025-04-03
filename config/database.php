<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        // Chargement des variables d'environnement depuis .env
        $env = parse_ini_file(__DIR__ . '/../.env');
        
        if ($env === false) {
            throw new Exception("Erreur lors du chargement du fichier .env");
        }
        
        $host = $env['DB_HOST'];
        $db = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASSWORD'];
        
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}