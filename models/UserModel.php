<?php
/**
 * Modèle pour la gestion des utilisateurs
 */
class UserModel extends Model {
    /**
     * Obtenir tous les utilisateurs
     * 
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des utilisateurs
     */
    public function getAllUsers($limit = null, $offset = null) {
        $sql = "SELECT id_utilisateur, nom_utilisateur, email, est_admin, date_creation 
                FROM utilisateurs";
        
        if ($limit !== null) {
            $sql .= " ORDER BY nom_utilisateur ASC LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = [];
        if ($limit !== null) {
            $params[':limit'] = $limit;
            if ($offset !== null) {
                $params[':offset'] = $offset;
            }
        }
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir un utilisateur par son ID
     * 
     * @param int $id ID de l'utilisateur
     * @return array|false Détails de l'utilisateur ou false si non trouvé
     */
    public function getUserById($id) {
        $sql = "SELECT id_utilisateur, nom_utilisateur, email, est_admin, date_creation 
                FROM utilisateurs 
                WHERE id_utilisateur = :id";
        $params = [':id' => $id];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Obtenir un utilisateur par son nom d'utilisateur
     * 
     * @param string $username Nom d'utilisateur
     * @return array|false Détails de l'utilisateur ou false si non trouvé
     */
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = :username";
        $params = [':username' => $username];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Obtenir un utilisateur par son email
     * 
     * @param string $email Email de l'utilisateur
     * @return array|false Détails de l'utilisateur ou false si non trouvé
     */
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $params = [':email' => $email];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Créer un nouvel utilisateur
     * 
     * @param array $data Données de l'utilisateur
     * @return int|false ID de l'utilisateur créé ou false en cas d'erreur
     */
    public function createUser($data) {
        // Vérifier si le nom d'utilisateur ou l'email existe déjà
        if ($this->getUserByUsername($data['nom_utilisateur']) || $this->getUserByEmail($data['email'])) {
            return false;
        }
        
        // Hasher le mot de passe
        $hashedPassword = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        
        // Insérer l'utilisateur
        $sql = "INSERT INTO utilisateurs (
                    nom_utilisateur, 
                    mot_de_passe, 
                    email, 
                    est_admin, 
                    date_creation
                ) VALUES (
                    :nom_utilisateur, 
                    :mot_de_passe, 
                    :email, 
                    :est_admin, 
                    CURRENT_TIMESTAMP
                )";
        
        $params = [
            ':nom_utilisateur' => $data['nom_utilisateur'],
            ':mot_de_passe' => $hashedPassword,
            ':email' => $data['email'],
            ':est_admin' => $data['est_admin'] ?? false
        ];
        
        $this->execute($sql, $params);
        return $this->lastInsertId();
    }
    
    /**
     * Mettre à jour un utilisateur existant
     * 
     * @param int $id ID de l'utilisateur
     * @param array $data Nouvelles données de l'utilisateur
     * @return bool Succès de la mise à jour
     */
    public function updateUser($id, $data) {
        // Vérifier si le nom d'utilisateur existe déjà (pour un autre utilisateur)
        if (isset($data['nom_utilisateur'])) {
            $existingUser = $this->getUserByUsername($data['nom_utilisateur']);
            if ($existingUser && $existingUser['id_utilisateur'] != $id) {
                return false;
            }
        }
        
        // Vérifier si l'email existe déjà (pour un autre utilisateur)
        if (isset($data['email'])) {
            $existingUser = $this->getUserByEmail($data['email']);
            if ($existingUser && $existingUser['id_utilisateur'] != $id) {
                return false;
            }
        }
        
        // Construire la requête de mise à jour
        $sql = "UPDATE utilisateurs SET ";
        $params = [':id' => $id];
        
        $updateFields = [];
        
        if (isset($data['nom_utilisateur'])) {
            $updateFields[] = "nom_utilisateur = :nom_utilisateur";
            $params[':nom_utilisateur'] = $data['nom_utilisateur'];
        }
        
        if (isset($data['email'])) {
            $updateFields[] = "email = :email";
            $params[':email'] = $data['email'];
        }
        
        if (isset($data['mot_de_passe'])) {
            $updateFields[] = "mot_de_passe = :mot_de_passe";
            $params[':mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        }
        
        if (isset($data['est_admin'])) {
            $updateFields[] = "est_admin = :est_admin";
            $params[':est_admin'] = $data['est_admin'];
        }
        
        // Si aucun champ à mettre à jour, retourner true
        if (empty($updateFields)) {
            return true;
        }
        
        $sql .= implode(", ", $updateFields);
        $sql .= " WHERE id_utilisateur = :id";
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Supprimer un utilisateur
     * 
     * @param int $id ID de l'utilisateur à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteUser($id) {
        $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = :id";
        $params = [':id' => $id];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Vérifier les identifiants de connexion
     * 
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe
     * @return array|false Détails de l'utilisateur ou false si identifiants incorrects
     */
    public function login($username, $password) {
        // Récupérer l'utilisateur par son nom d'utilisateur
        $user = $this->getUserByUsername($username);
        
        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Ne pas retourner le mot de passe
            unset($user['mot_de_passe']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Vérifier si un utilisateur est administrateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool True si l'utilisateur est administrateur, sinon False
     */
    public function isAdmin($id) {
        $sql = "SELECT est_admin FROM utilisateurs WHERE id_utilisateur = :id";
        $params = [':id' => $id];
        
        $result = $this->single($sql, $params);
        
        return $result && $result['est_admin'];
    }
    
    /**
     * Mettre à jour le mot de passe d'un utilisateur
     * 
     * @param int $id ID de l'utilisateur
     * @param string $currentPassword Mot de passe actuel
     * @param string $newPassword Nouveau mot de passe
     * @return bool Succès de la mise à jour
     */
    public function updatePassword($id, $currentPassword, $newPassword) {
        // Récupérer l'utilisateur
        $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id";
        $params = [':id' => $id];
        
        $user = $this->single($sql, $params);
        
        // Vérifier si l'utilisateur existe et si le mot de passe actuel est correct
        if ($user && password_verify($currentPassword, $user['mot_de_passe'])) {
            // Hasher le nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Mettre à jour le mot de passe
            $sql = "UPDATE utilisateurs SET mot_de_passe = :mot_de_passe WHERE id_utilisateur = :id";
            $params = [
                ':id' => $id,
                ':mot_de_passe' => $hashedPassword
            ];
            
            return $this->execute($sql, $params);
        }
        
        return false;
    }
    
    /**
     * Compter le nombre total d'utilisateurs
     * 
     * @return int Nombre d'utilisateurs
     */
    public function countUsers() {
        $sql = "SELECT COUNT(*) as count FROM utilisateurs";
        $result = $this->single($sql);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Ajouter une équipe aux favoris d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @param int $teamId ID de l'équipe
     * @return bool Succès de l'ajout
     */
    public function addFavoriteTeam($userId, $teamId) {
        // Vérifier si la relation existe déjà
        $checkSql = "SELECT COUNT(*) as count FROM utilisateur_equipe_favorite 
                     WHERE id_utilisateur = :user_id AND id_equipe = :team_id";
        $checkParams = [
            ':user_id' => $userId,
            ':team_id' => $teamId
        ];
        
        $result = $this->single($checkSql, $checkParams);
        
        if ($result && $result['count'] > 0) {
            // La relation existe déjà
            return true;
        }
        
        // Ajouter la relation
        $sql = "INSERT INTO utilisateur_equipe_favorite (id_utilisateur, id_equipe, date_ajout) 
                VALUES (:user_id, :team_id, CURRENT_TIMESTAMP)";
        $params = [
            ':user_id' => $userId,
            ':team_id' => $teamId
        ];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Supprimer une équipe des favoris d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @param int $teamId ID de l'équipe
     * @return bool Succès de la suppression
     */
    public function removeFavoriteTeam($userId, $teamId) {
        $sql = "DELETE FROM utilisateur_equipe_favorite 
                WHERE id_utilisateur = :user_id AND id_equipe = :team_id";
        $params = [
            ':user_id' => $userId,
            ':team_id' => $teamId
        ];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Obtenir les équipes favorites d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @return array Liste des équipes favorites
     */
    public function getFavoriteTeams($userId) {
        $sql = "SELECT hc.*, dc.abbreviation, uef.date_ajout
                FROM utilisateur_equipe_favorite uef
                JOIN historie_club hc ON uef.id_equipe = hc.id_club
                LEFT JOIN detail_club dc ON hc.id_club = dc.id_detail_club
                WHERE uef.id_utilisateur = :user_id
                ORDER BY uef.date_ajout DESC";
        $params = [':user_id' => $userId];
        
        return $this->resultSet($sql, $params);
    }
}