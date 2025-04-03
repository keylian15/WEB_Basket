<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Crée un nouvel utilisateur
     * 
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @param bool $isAdmin Statut admin (false par défaut)
     * @return bool Succès de l'opération
     */
    public function create($email, $password, $isAdmin = false) {
        try {
            // Vérifier si l'email existe déjà
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                return false; // L'email est déjà utilisé
            }
            
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insertion du nouvel utilisateur
            $stmt = $this->db->prepare("INSERT INTO users (email, password, is_admin) VALUES (:email, :password, :is_admin)");
            $stmt->execute([
                'email' => $email,
                'password' => $hashedPassword,
                'is_admin' => $isAdmin ? 1 : 0
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de l'utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Vérifie les informations de connexion
     * 
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe non haché
     * @return array|bool Données de l'utilisateur ou false si échec
     */
    public function login($email, $password) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            if ($stmt->rowCount() === 0) {
                return false; // Utilisateur non trouvé
            }
            
            $user = $stmt->fetch();
            
            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                // Suppression du mot de passe avant de retourner les données
                unset($user['password']);
                return $user;
            }
            
            return false; // Mot de passe incorrect
        } catch (PDOException $e) {
            error_log("Erreur lors de la connexion: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Récupère un utilisateur par son ID
     * 
     * @param int $id ID de l'utilisateur
     * @return array|bool Données de l'utilisateur ou false si non trouvé
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT id, email, is_admin FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            
            if ($stmt->rowCount() === 0) {
                return false;
            }
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Vérifie si un email existe déjà
     * 
     * @param string $email Email à vérifier
     * @return bool True si l'email existe, false sinon
     */
    public function emailExists($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification de l'email: " . $e->getMessage());
            return false;
        }
    }
}