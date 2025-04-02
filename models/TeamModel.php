<?php
/**
 * Modèle pour la gestion des équipes
 */
class TeamModel extends Model {
    /**
     * Obtenir toutes les équipes
     * 
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des équipes
     */
    public function getAllTeams($limit = null, $offset = null) {
        $sql = "SELECT 
                    hc.*, 
                    dc.abbreviation, 
                    dc.arena, 
                    dc.capacite_arena, 
                    dc.entraineur_principal
                FROM 
                    historie_club hc
                LEFT JOIN 
                    detail_club dc ON hc.id_club = dc.id_detail_club
                ORDER BY 
                    hc.ville_club ASC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
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
     * Obtenir une équipe par son ID
     * 
     * @param int $id ID de l'équipe
     * @return array|false Détails de l'équipe ou false si non trouvée
     */
    public function getTeamById($id) {
        $sql = "SELECT 
                    hc.*, 
                    dc.abbreviation, 
                    dc.arena, 
                    dc.capacite_arena, 
                    dc.entraineur_principal,
                    dc.proprietaire,
                    dc.directeur_general,
                    dc.affiliation_dleague
                FROM 
                    historie_club hc
                LEFT JOIN 
                    detail_club dc ON hc.id_club = dc.id_detail_club
                WHERE 
                    hc.id_club = :id";
        
        $params = [':id' => $id];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Rechercher des équipes par nom ou ville
     * 
     * @param string $search Terme de recherche
     * @param int $limit Limite de résultats
     * @return array Liste des équipes correspondantes
     */
    public function searchTeams($search, $limit = 10) {
        $sql = "SELECT 
                    hc.*, 
                    dc.abbreviation
                FROM 
                    historie_club hc
                LEFT JOIN 
                    detail_club dc ON hc.id_club = dc.id_detail_club
                WHERE 
                    hc.ville_club ILIKE :search 
                    OR hc.surnom_club ILIKE :search
                    OR dc.nickname ILIKE :search
                ORDER BY 
                    hc.ville_club ASC
                LIMIT :limit";
        
        $params = [
            ':search' => '%' . $search . '%',
            ':limit' => $limit
        ];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir les équipes par conférence
     * 
     * @param string $conference Conférence ('East' ou 'West')
     * @return array Liste des équipes
     */
    public function getTeamsByConference($conference) {
        $sql = "SELECT 
                    hc.*, 
                    dc.abbreviation, 
                    dc.arena, 
                    dc.capacite_arena
                FROM 
                    historie_club hc
                LEFT JOIN 
                    detail_club dc ON hc.id_club = dc.id_detail_club
                WHERE 
                    dc.conference = :conference
                ORDER BY 
                    hc.ville_club ASC";
        
        $params = [':conference' => $conference];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Compter le nombre total d'équipes
     * 
     * @return int Nombre d'équipes
     */
    public function countTeams() {
        $sql = "SELECT COUNT(*) as count FROM historie_club";
        $result = $this->single($sql);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Ajouter une nouvelle équipe
     * 
     * @param array $data Données de l'équipe
     * @return int ID de l'équipe insérée
     */
    public function addTeam($data) {
        // Commencer une transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans historie_club
            $sql1 = "INSERT INTO historie_club (
                        ville_club, 
                        surnom_club, 
                        annee_fondation, 
                        annee_active
                    ) VALUES (
                        :ville_club, 
                        :surnom_club, 
                        :annee_fondation, 
                        :annee_active
                    )";
            
            $params1 = [
                ':ville_club' => $data['ville_club'],
                ':surnom_club' => $data['surnom_club'],
                ':annee_fondation' => $data['annee_fondation'],
                ':annee_active' => $data['annee_active']
            ];
            
            $this->execute($sql1, $params1);
            $teamId = $this->lastInsertId();
            
            // Insérer dans detail_club
            $sql2 = "INSERT INTO detail_club (
                        id_detail_club,
                        abbreviation, 
                        nickname, 
                        annee_fondation, 
                        ville, 
                        arena, 
                        capacite_arena, 
                        proprietaire, 
                        directeur_general, 
                        entraineur_principal, 
                        affiliation_dleague
                    ) VALUES (
                        :id_detail_club,
                        :abbreviation, 
                        :nickname, 
                        :annee_fondation, 
                        :ville, 
                        :arena, 
                        :capacite_arena, 
                        :proprietaire, 
                        :directeur_general, 
                        :entraineur_principal, 
                        :affiliation_dleague
                    )";
            
            $params2 = [
                ':id_detail_club' => $teamId,
                ':abbreviation' => $data['abbreviation'],
                ':nickname' => $data['nickname'] ?? $data['surnom_club'],
                ':annee_fondation' => $data['annee_fondation'],
                ':ville' => $data['ville_club'],
                ':arena' => $data['arena'],
                ':capacite_arena' => $data['capacite_arena'],
                ':proprietaire' => $data['proprietaire'],
                ':directeur_general' => $data['directeur_general'],
                ':entraineur_principal' => $data['entraineur_principal'],
                ':affiliation_dleague' => $data['affiliation_dleague'] ?? null
            ];
            
            $this->execute($sql2, $params2);
            
            // Valider la transaction
            $this->db->commit();
            
            return $teamId;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollback();
            throw $e;
        }
    }
    
    /**
     * Mettre à jour une équipe existante
     * 
     * @param int $id ID de l'équipe
     * @param array $data Nouvelles données de l'équipe
     * @return bool Succès de la mise à jour
     */
    public function updateTeam($id, $data) {
        // Commencer une transaction
        $this->db->beginTransaction();
        
        try {
            // Mettre à jour historie_club
            $sql1 = "UPDATE historie_club SET
                        ville_club = :ville_club, 
                        surnom_club = :surnom_club, 
                        annee_fondation = :annee_fondation, 
                        annee_active = :annee_active
                    WHERE id_club = :id";
            
            $params1 = [
                ':id' => $id,
                ':ville_club' => $data['ville_club'],
                ':surnom_club' => $data['surnom_club'],
                ':annee_fondation' => $data['annee_fondation'],
                ':annee_active' => $data['annee_active']
            ];
            
            $this->execute($sql1, $params1);
            
            // Mettre à jour detail_club
            $sql2 = "UPDATE detail_club SET
                        abbreviation = :abbreviation, 
                        nickname = :nickname, 
                        annee_fondation = :annee_fondation, 
                        ville = :ville, 
                        arena = :arena, 
                        capacite_arena = :capacite_arena, 
                        proprietaire = :proprietaire, 
                        directeur_general = :directeur_general, 
                        entraineur_principal = :entraineur_principal, 
                        affiliation_dleague = :affiliation_dleague
                    WHERE id_detail_club = :id";
            
            $params2 = [
                ':id' => $id,
                ':abbreviation' => $data['abbreviation'],
                ':nickname' => $data['nickname'] ?? $data['surnom_club'],
                ':annee_fondation' => $data['annee_fondation'],
                ':ville' => $data['ville_club'],
                ':arena' => $data['arena'],
                ':capacite_arena' => $data['capacite_arena'],
                ':proprietaire' => $data['proprietaire'],
                ':directeur_general' => $data['directeur_general'],
                ':entraineur_principal' => $data['entraineur_principal'],
                ':affiliation_dleague' => $data['affiliation_dleague'] ?? null
            ];
            
            $this->execute($sql2, $params2);
            
            // Valider la transaction
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollback();
            throw $e;
        }
    }
    
    /**
     * Supprimer une équipe
     * 
     * @param int $id ID de l'équipe à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteTeam($id) {
        // Commencer une transaction
        $this->db->beginTransaction();
        
        try {
            // Supprimer de detail_club
            $sql1 = "DELETE FROM detail_club WHERE id_detail_club = :id";
            $params1 = [':id' => $id];
            $this->execute($sql1, $params1);
            
            // Supprimer de historie_club
            $sql2 = "DELETE FROM historie_club WHERE id_club = :id";
            $params2 = [':id' => $id];
            $this->execute($sql2, $params2);
            
            // Valider la transaction
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollback();
            throw $e;
        }
    }
}