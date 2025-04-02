<?php
/**
 * Modèle pour la gestion des joueurs
 */
class PlayerModel extends Model {
    /**
     * Obtenir tous les joueurs
     * 
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des joueurs
     */
    public function getAllPlayers($limit = null, $offset = null) {
        $sql = "SELECT * FROM joueur";
        
        if ($limit !== null) {
            $sql .= " ORDER BY full_name ASC LIMIT :limit";
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
     * Obtenir un joueur par son ID
     * 
     * @param int $id ID du joueur
     * @return array|false Détails du joueur ou false si non trouvé
     */
    public function getPlayerById($id) {
        $sql = "SELECT j.*, dh.* FROM joueur j
                LEFT JOIN draft_history dh ON j.id_joueur = dh.player_id
                WHERE j.id_joueur = :id";
        $params = [':id' => $id];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Obtenir les joueurs actifs
     * 
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des joueurs actifs
     */
    public function getActivePlayers($limit = null, $offset = null) {
        $sql = "SELECT * FROM joueur WHERE est_actif = true";
        
        if ($limit !== null) {
            $sql .= " ORDER BY full_name ASC LIMIT :limit";
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
     * Rechercher des joueurs par nom
     * 
     * @param string $search Terme de recherche
     * @param int $limit Limite de résultats
     * @return array Liste des joueurs correspondants
     */
    public function searchPlayers($search, $limit = 10) {
        $sql = "SELECT * FROM joueur
                WHERE full_name ILIKE :search
                OR prenom_joueur ILIKE :search
                OR nom_joueur ILIKE :search
                ORDER BY full_name ASC
                LIMIT :limit";
        
        $params = [
            ':search' => '%' . $search . '%',
            ':limit' => $limit
        ];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir les joueurs d'une équipe
     * 
     * @param int $teamId ID de l'équipe
     * @return array Liste des joueurs de l'équipe
     */
    public function getPlayersByTeam($teamId) {
        $sql = "SELECT j.*, ip.numero_maillot_joueur
                FROM joueur j
                JOIN inactif_player ip ON j.id_joueur = ip.id_joueur
                WHERE ip.id_equipe = :team_id
                ORDER BY j.full_name ASC";
        
        $params = [':team_id' => $teamId];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir les joueurs en vedette
     * 
     * @param int $limit Nombre de joueurs à récupérer
     * @return array Liste des joueurs en vedette
     */
    public function getFeaturedPlayers($limit = 4) {
        // Dans une application réelle, nous pourrions avoir une colonne 'is_featured'
        // Ici, nous prenons simplement les joueurs actifs avec des ID spécifiques
        $sql = "SELECT j.*, ip.numero_maillot_joueur, hc.ville_club as equipe
                FROM joueur j
                LEFT JOIN inactif_player ip ON j.id_joueur = ip.id_joueur
                LEFT JOIN historie_club hc ON ip.id_equipe = hc.id_club
                WHERE j.est_actif = true
                ORDER BY random()
                LIMIT :limit";
        
        $params = [':limit' => $limit];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Compter le nombre total de joueurs
     * 
     * @return int Nombre de joueurs
     */
    public function countPlayers() {
        $sql = "SELECT COUNT(*) as count FROM joueur";
        $result = $this->single($sql);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Compter le nombre de joueurs actifs
     * 
     * @return int Nombre de joueurs actifs
     */
    public function countActivePlayers() {
        $sql = "SELECT COUNT(*) as count FROM joueur WHERE est_actif = true";
        $result = $this->single($sql);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Ajouter un nouveau joueur
     * 
     * @param array $data Données du joueur
     * @return int ID du joueur inséré
     */
    public function addPlayer($data) {
        $sql = "INSERT INTO joueur (
                    prenom_joueur,
                    nom_joueur,
                    est_actif,
                    full_name
                ) VALUES (
                    :prenom_joueur,
                    :nom_joueur,
                    :est_actif,
                    :full_name
                )";
        
        $params = [
            ':prenom_joueur' => $data['prenom_joueur'],
            ':nom_joueur' => $data['nom_joueur'],
            ':est_actif' => $data['est_actif'] ?? true,
            ':full_name' => $data['prenom_joueur'] . ' ' . $data['nom_joueur']
        ];
        
        $this->execute($sql, $params);
        return $this->lastInsertId();
    }
    
    /**
     * Mettre à jour un joueur existant
     * 
     * @param int $id ID du joueur
     * @param array $data Nouvelles données du joueur
     * @return bool Succès de la mise à jour
     */
    public function updatePlayer($id, $data) {
        $sql = "UPDATE joueur SET
                    prenom_joueur = :prenom_joueur,
                    nom_joueur = :nom_joueur,
                    est_actif = :est_actif,
                    full_name = :full_name
                WHERE id_joueur = :id";
        
        $params = [
            ':id' => $id,
            ':prenom_joueur' => $data['prenom_joueur'],
            ':nom_joueur' => $data['nom_joueur'],
            ':est_actif' => $data['est_actif'] ?? true,
            ':full_name' => $data['prenom_joueur'] . ' ' . $data['nom_joueur']
        ];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Supprimer un joueur
     * 
     * @param int $id ID du joueur à supprimer
     * @return bool Succès de la suppression
     */
    public function deletePlayer($id) {
        $sql = "DELETE FROM joueur WHERE id_joueur = :id";
        $params = [':id' => $id];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Ajouter un joueur à une équipe
     * 
     * @param int $playerId ID du joueur
     * @param int $teamId ID de l'équipe
     * @param int $jerseyNumber Numéro de maillot
     * @return bool Succès de l'ajout
     */
    public function addPlayerToTeam($playerId, $teamId, $jerseyNumber) {
        // Vérifier si l'association existe déjà
        $checkSql = "SELECT COUNT(*) as count FROM inactif_player
                    WHERE id_joueur = :player_id AND id_equipe = :team_id";
        $checkParams = [
            ':player_id' => $playerId,
            ':team_id' => $teamId
        ];
        
        $result = $this->single($checkSql, $checkParams);
        
        if ($result['count'] > 0) {
            // Mettre à jour l'association existante
            $sql = "UPDATE inactif_player SET
                        numero_maillot_joueur = :jersey_number
                    WHERE id_joueur = :player_id AND id_equipe = :team_id";
        } else {
            // Créer une nouvelle association
            $sql = "INSERT INTO inactif_player (
                        id_joueur,
                        id_equipe,
                        prenom_joueur,
                        nom_joueur,
                        numero_maillot_joueur,
                        nom_équipe,
                        abréviation_équipe,
                        ville_équipe
                    ) VALUES (
                        :player_id,
                        :team_id,
                        (SELECT prenom_joueur FROM joueur WHERE id_joueur = :player_id),
                        (SELECT nom_joueur FROM joueur WHERE id_joueur = :player_id),
                        :jersey_number,
                        (SELECT surnom_club FROM historie_club WHERE id_club = :team_id),
                        (SELECT abbreviation FROM detail_club WHERE id_detail_club = :team_id),
                        (SELECT ville_club FROM historie_club WHERE id_club = :team_id)
                    )";
        }
        
        $params = [
            ':player_id' => $playerId,
            ':team_id' => $teamId,
            ':jersey_number' => $jerseyNumber
        ];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Retirer un joueur d'une équipe
     * 
     * @param int $playerId ID du joueur
     * @param int $teamId ID de l'équipe
     * @return bool Succès du retrait
     */
    public function removePlayerFromTeam($playerId, $teamId) {
        $sql = "DELETE FROM inactif_player
                WHERE id_joueur = :player_id AND id_equipe = :team_id";
        
        $params = [
            ':player_id' => $playerId,
            ':team_id' => $teamId
        ];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Ajouter une entrée dans l'historique de draft
     * 
     * @param array $data Données de draft
     * @return bool Succès de l'ajout
     */
    public function addDraftHistory($data) {
        $sql = "INSERT INTO draft_history (
                    person_id,
                    player_id,
                    nom_joueur,
                    saison,
                    numero_tour,
                    choix_tour,
                    choix_total,
                    type_draft,
                    player_profile
                ) VALUES (
                    :person_id,
                    :player_id,
                    :nom_joueur,
                    :saison,
                    :numero_tour,
                    :choix_tour,
                    :choix_total,
                    :type_draft,
                    :player_profile
                )";
        
        $params = [
            ':person_id' => $data['person_id'],
            ':player_id' => $data['player_id'],
            ':nom_joueur' => $data['nom_joueur'],
            ':saison' => $data['saison'],
            ':numero_tour' => $data['numero_tour'],
            ':choix_tour' => $data['choix_tour'],
            ':choix_total' => $data['choix_total'],
            ':type_draft' => $data['type_draft'],
            ':player_profile' => $data['player_profile'] ?? null
        ];
        
        return $this->execute($sql, $params);
    }
}