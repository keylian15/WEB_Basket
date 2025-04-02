<?php
/**
 * Classe de base pour tous les modèles
 */
class Model {
    /**
     * Instance de la base de données
     * 
     * @var PDO
     */
    protected $db;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Exécuter une requête SELECT
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return PDOStatement Résultat de la requête
     */
    protected function query($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    /**
     * Exécuter une requête INSERT, UPDATE, DELETE
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return bool Succès de l'exécution
     */
    protected function execute($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    /**
     * Obtenir un seul enregistrement
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return array|false Enregistrement ou false si non trouvé
     */
    protected function single($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    /**
     * Obtenir tous les enregistrements
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return array Tableau d'enregistrements
     */
    protected function resultSet($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    /**
     * Obtenir le nombre de lignes affectées
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return int Nombre de lignes
     */
    protected function rowCount($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            die("Erreur d'exécution de requête: " . $e->getMessage());
        }
    }
    
    /**
     * Obtenir le dernier ID inséré
     * 
     * @return string ID inséré
     */
    protected function lastInsertId() {
        return $this->db->lastInsertId();
    }
}