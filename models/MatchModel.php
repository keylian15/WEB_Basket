<?php
/**
 * Modèle pour la gestion des matchs
 */
class MatchModel extends Model {
    /**
     * Obtenir tous les matchs
     * 
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des matchs
     */
    public function getAllMatches($limit = null, $offset = null) {
        $sql = "SELECT * FROM statistisque_match";
        
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
     * Obtenir un match par son ID
     * 
     * @param int $id ID du match
     * @return array|false Détails du match ou false si non trouvé
     */
    public function getMatchById($id) {
        $sql = "SELECT * FROM statistisque_match WHERE id_stat_match = :id";
        $params = [':id' => $id];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Obtenir les prochains matchs
     * 
     * @param int $limit Nombre de matchs à récupérer
     * @return array Liste des prochains matchs
     */
    public function getUpcomingMatches($limit = 3) {
        // Dans une application réelle, nous aurions une colonne date_match
        // Ici, nous supposons que les derniers matchs ajoutés sont les prochains
        $sql = "SELECT 
                    sm.*,
                    p.probabilite_victoire_domicile,
                    p.probabilite_victoire_exterieure
                FROM 
                    statistisque_match sm
                LEFT JOIN 
                    predictions p ON sm.id_equipe = p.id_equipe_domicile AND sm.id_équipe_extérieure = p.id_equipe_exterieure
                ORDER BY 
                    sm.id_stat_match DESC
                LIMIT :limit";
        
        $params = [':limit' => $limit];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir les statistiques d'un match
     * 
     * @param int $id ID du match
     * @return array Statistiques du match
     */
    public function getMatchStats($id) {
        $sql = "SELECT * FROM statistisque_match WHERE id_stat_match = :id";
        $params = [':id' => $id];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Compter le nombre total de matchs
     * 
     * @return int Nombre de matchs
     */
    public function countMatches() {
        $sql = "SELECT COUNT(*) as count FROM statistisque_match";
        $result = $this->single($sql);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Obtenir les matchs filtrés par équipe
     * 
     * @param int $teamId ID de l'équipe
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des matchs
     */
    public function getMatchesByTeam($teamId, $limit = null, $offset = null) {
        $sql = "SELECT * FROM statistisque_match 
                WHERE id_equipe = :team_id OR id_équipe_extérieure = :team_id
                ORDER BY id_stat_match DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = [':team_id' => $teamId];
        if ($limit !== null) {
            $params[':limit'] = $limit;
            if ($offset !== null) {
                $params[':offset'] = $offset;
            }
        }
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Ajouter un nouveau match
     * 
     * @param array $data Données du match
     * @return int ID du match inséré
     */
    public function addMatch($data) {
        $sql = "INSERT INTO statistisque_match (
                    id_ligue, id_équipe_extérieure, id_equipe, 
                    abreviation_équipe_domicile, ville_equipe_domicile, 
                    points_peinture_domicile, points_2nde_chance_domicile, points_contrattaque_domicile,
                    plus_grande_avance_domicile, changements_avantage, égalités,
                    pertes_balle_equipe_domicile, pertes_balle_totales_domicile, rebonds_équipe_domicile,
                    points_pertes_balle_domicile, abreviation_equipe_extérieure, ville_equipe_extérieure,
                    points_peinture_extérieure, points_2nde_chance_extérieure, plus_grande_avance_exterieure,
                    pertes_balle_totales_extérieures, rebonds_équipe_extérieure, points_pertes_balle_extérieure
                ) VALUES (
                    :id_ligue, :id_equipe_exterieure, :id_equipe,
                    :abreviation_equipe_domicile, :ville_equipe_domicile,
                    :points_peinture_domicile, :points_2nde_chance_domicile, :points_contrattaque_domicile,
                    :plus_grande_avance_domicile, :changements_avantage, :egalites,
                    :pertes_balle_equipe_domicile, :pertes_balle_totales_domicile, :rebonds_equipe_domicile,
                    :points_pertes_balle_domicile, :abreviation_equipe_exterieure, :ville_equipe_exterieure,
                    :points_peinture_exterieure, :points_2nde_chance_exterieure, :plus_grande_avance_exterieure,
                    :pertes_balle_totales_exterieures, :rebonds_equipe_exterieure, :points_pertes_balle_exterieure
                )";
        
        $params = [
            ':id_ligue' => $data['id_ligue'],
            ':id_equipe_exterieure' => $data['id_equipe_exterieure'],
            ':id_equipe' => $data['id_equipe'],
            ':abreviation_equipe_domicile' => $data['abreviation_equipe_domicile'],
            ':ville_equipe_domicile' => $data['ville_equipe_domicile'],
            ':points_peinture_domicile' => $data['points_peinture_domicile'],
            ':points_2nde_chance_domicile' => $data['points_2nde_chance_domicile'],
            ':points_contrattaque_domicile' => $data['points_contrattaque_domicile'],
            ':plus_grande_avance_domicile' => $data['plus_grande_avance_domicile'],
            ':changements_avantage' => $data['changements_avantage'],
            ':egalites' => $data['egalites'],
            ':pertes_balle_equipe_domicile' => $data['pertes_balle_equipe_domicile'],
            ':pertes_balle_totales_domicile' => $data['pertes_balle_totales_domicile'],
            ':rebonds_equipe_domicile' => $data['rebonds_equipe_domicile'],
            ':points_pertes_balle_domicile' => $data['points_pertes_balle_domicile'],
            ':abreviation_equipe_exterieure' => $data['abreviation_equipe_exterieure'],
            ':ville_equipe_exterieure' => $data['ville_equipe_exterieure'],
            ':points_peinture_exterieure' => $data['points_peinture_exterieure'],
            ':points_2nde_chance_exterieure' => $data['points_2nde_chance_exterieure'],
            ':plus_grande_avance_exterieure' => $data['plus_grande_avance_exterieure'],
            ':pertes_balle_totales_exterieures' => $data['pertes_balle_totales_exterieures'],
            ':rebonds_equipe_exterieure' => $data['rebonds_equipe_exterieure'],
            ':points_pertes_balle_exterieure' => $data['points_pertes_balle_exterieure']
        ];
        
        $this->execute($sql, $params);
        return $this->lastInsertId();
    }
    
    /**
     * Mettre à jour un match existant
     * 
     * @param int $id ID du match
     * @param array $data Nouvelles données du match
     * @return bool Succès de la mise à jour
     */
    public function updateMatch($id, $data) {
        $sql = "UPDATE statistisque_match SET
                    id_ligue = :id_ligue,
                    id_équipe_extérieure = :id_equipe_exterieure,
                    id_equipe = :id_equipe,
                    abreviation_équipe_domicile = :abreviation_equipe_domicile,
                    ville_equipe_domicile = :ville_equipe_domicile,
                    points_peinture_domicile = :points_peinture_domicile,
                    points_2nde_chance_domicile = :points_2nde_chance_domicile,
                    points_contrattaque_domicile = :points_contrattaque_domicile,
                    plus_grande_avance_domicile = :plus_grande_avance_domicile,
                    changements_avantage = :changements_avantage,
                    égalités = :egalites,
                    pertes_balle_equipe_domicile = :pertes_balle_equipe_domicile,
                    pertes_balle_totales_domicile = :pertes_balle_totales_domicile,
                    rebonds_équipe_domicile = :rebonds_equipe_domicile,
                    points_pertes_balle_domicile = :points_pertes_balle_domicile,
                    abreviation_equipe_extérieure = :abreviation_equipe_exterieure,
                    ville_equipe_extérieure = :ville_equipe_exterieure,
                    points_peinture_extérieure = :points_peinture_exterieure,
                    points_2nde_chance_extérieure = :points_2nde_chance_exterieure,
                    plus_grande_avance_exterieure = :plus_grande_avance_exterieure,
                    pertes_balle_totales_extérieures = :pertes_balle_totales_exterieures,
                    rebonds_équipe_extérieure = :rebonds_equipe_exterieure,
                    points_pertes_balle_extérieure = :points_pertes_balle_exterieure
                WHERE id_stat_match = :id";
        
        $params = [
            ':id' => $id,
            ':id_ligue' => $data['id_ligue'],
            ':id_equipe_exterieure' => $data['id_equipe_exterieure'],
            ':id_equipe' => $data['id_equipe'],
            ':abreviation_equipe_domicile' => $data['abreviation_equipe_domicile'],
            ':ville_equipe_domicile' => $data['ville_equipe_domicile'],
            ':points_peinture_domicile' => $data['points_peinture_domicile'],
            ':points_2nde_chance_domicile' => $data['points_2nde_chance_domicile'],
            ':points_contrattaque_domicile' => $data['points_contrattaque_domicile'],
            ':plus_grande_avance_domicile' => $data['plus_grande_avance_domicile'],
            ':changements_avantage' => $data['changements_avantage'],
            ':egalites' => $data['egalites'],
            ':pertes_balle_equipe_domicile' => $data['pertes_balle_equipe_domicile'],
            ':pertes_balle_totales_domicile' => $data['pertes_balle_totales_domicile'],
            ':rebonds_equipe_domicile' => $data['rebonds_equipe_domicile'],
            ':points_pertes_balle_domicile' => $data['points_pertes_balle_domicile'],
            ':abreviation_equipe_exterieure' => $data['abreviation_equipe_exterieure'],
            ':ville_equipe_exterieure' => $data['ville_equipe_exterieure'],
            ':points_peinture_exterieure' => $data['points_peinture_exterieure'],
            ':points_2nde_chance_exterieure' => $data['points_2nde_chance_exterieure'],
            ':plus_grande_avance_exterieure' => $data['plus_grande_avance_exterieure'],
            ':pertes_balle_totales_exterieures' => $data['pertes_balle_totales_exterieures'],
            ':rebonds_equipe_exterieure' => $data['rebonds_equipe_exterieure'],
            ':points_pertes_balle_exterieure' => $data['points_pertes_balle_exterieure']
        ];
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Supprimer un match
     * 
     * @param int $id ID du match à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteMatch($id) {
        $sql = "DELETE FROM statistisque_match WHERE id_stat_match = :id";
        $params = [':id' => $id];
        
        return $this->execute($sql, $params);
    }
}