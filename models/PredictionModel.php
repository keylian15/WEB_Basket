<?php
/**
 * Modèle pour la gestion des prédictions
 */
class PredictionModel extends Model {
    /**
     * Obtenir toutes les prédictions
     * 
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des prédictions
     */
    public function getAllPredictions($limit = null, $offset = null) {
        $sql = "SELECT p.*, 
                    hc1.ville_club as equipe_domicile, 
                    dc1.abbreviation as abreviation_domicile,
                    hc2.ville_club as equipe_exterieure, 
                    dc2.abbreviation as abreviation_exterieure,
                    u.nom_utilisateur
                FROM predictions p
                LEFT JOIN historie_club hc1 ON p.id_equipe_domicile = hc1.id_club
                LEFT JOIN detail_club dc1 ON p.id_equipe_domicile = dc1.id_detail_club
                LEFT JOIN historie_club hc2 ON p.id_equipe_exterieure = hc2.id_club
                LEFT JOIN detail_club dc2 ON p.id_equipe_exterieure = dc2.id_detail_club
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur
                ORDER BY p.date_prediction DESC";
        
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
     * Obtenir une prédiction par son ID
     * 
     * @param int $id ID de la prédiction
     * @return array|false Détails de la prédiction ou false si non trouvée
     */
    public function getPredictionById($id) {
        $sql = "SELECT p.*, 
                    hc1.ville_club as equipe_domicile, 
                    dc1.abbreviation as abreviation_domicile,
                    hc2.ville_club as equipe_exterieure, 
                    dc2.abbreviation as abreviation_exterieure,
                    u.nom_utilisateur
                FROM predictions p
                LEFT JOIN historie_club hc1 ON p.id_equipe_domicile = hc1.id_club
                LEFT JOIN detail_club dc1 ON p.id_equipe_domicile = dc1.id_detail_club
                LEFT JOIN historie_club hc2 ON p.id_equipe_exterieure = hc2.id_club
                LEFT JOIN detail_club dc2 ON p.id_equipe_exterieure = dc2.id_detail_club
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur
                WHERE p.id_prediction = :id";
        
        $params = [':id' => $id];
        
        return $this->single($sql, $params);
    }
    
    /**
     * Obtenir les prédictions récentes
     * 
     * @param int $limit Nombre de prédictions à récupérer
     * @return array Liste des prédictions récentes
     */
    public function getRecentPredictions($limit = 5) {
        $sql = "SELECT p.*, 
                    hc1.ville_club as equipe_domicile, 
                    dc1.abbreviation as abreviation_domicile,
                    hc2.ville_club as equipe_exterieure, 
                    dc2.abbreviation as abreviation_exterieure,
                    u.nom_utilisateur
                FROM predictions p
                LEFT JOIN historie_club hc1 ON p.id_equipe_domicile = hc1.id_club
                LEFT JOIN detail_club dc1 ON p.id_equipe_domicile = dc1.id_detail_club
                LEFT JOIN historie_club hc2 ON p.id_equipe_exterieure = hc2.id_club
                LEFT JOIN detail_club dc2 ON p.id_equipe_exterieure = dc2.id_detail_club
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur
                ORDER BY p.date_prediction DESC
                LIMIT :limit";
        
        $params = [':limit' => $limit];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir les prédictions d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @param int $limit Limite de résultats
     * @param int $offset Décalage pour la pagination
     * @return array Liste des prédictions de l'utilisateur
     */
    public function getUserPredictions($userId, $limit = null, $offset = null) {
        $sql = "SELECT p.*, 
                    hc1.ville_club as equipe_domicile, 
                    dc1.abbreviation as abreviation_domicile,
                    hc2.ville_club as equipe_exterieure, 
                    dc2.abbreviation as abreviation_exterieure
                FROM predictions p
                LEFT JOIN historie_club hc1 ON p.id_equipe_domicile = hc1.id_club
                LEFT JOIN detail_club dc1 ON p.id_equipe_domicile = dc1.id_detail_club
                LEFT JOIN historie_club hc2 ON p.id_equipe_exterieure = hc2.id_club
                LEFT JOIN detail_club dc2 ON p.id_equipe_exterieure = dc2.id_detail_club
                WHERE p.id_utilisateur = :user_id
                ORDER BY p.date_prediction DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = [':user_id' => $userId];
        if ($limit !== null) {
            $params[':limit'] = $limit;
            if ($offset !== null) {
                $params[':offset'] = $offset;
            }
        }
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Obtenir les prédictions pour une équipe
     * 
     * @param int $teamId ID de l'équipe
     * @param int $limit Limite de résultats
     * @return array Liste des prédictions pour l'équipe
     */
    public function getTeamPredictions($teamId, $limit = 10) {
        $sql = "SELECT p.*, 
                    hc1.ville_club as equipe_domicile, 
                    dc1.abbreviation as abreviation_domicile,
                    hc2.ville_club as equipe_exterieure, 
                    dc2.abbreviation as abreviation_exterieure,
                    u.nom_utilisateur
                FROM predictions p
                LEFT JOIN historie_club hc1 ON p.id_equipe_domicile = hc1.id_club
                LEFT JOIN detail_club dc1 ON p.id_equipe_domicile = dc1.id_detail_club
                LEFT JOIN historie_club hc2 ON p.id_equipe_exterieure = hc2.id_club
                LEFT JOIN detail_club dc2 ON p.id_equipe_exterieure = dc2.id_detail_club
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur
                WHERE p.id_equipe_domicile = :team_id OR p.id_equipe_exterieure = :team_id
                ORDER BY p.date_prediction DESC
                LIMIT :limit";
        
        $params = [
            ':team_id' => $teamId,
            ':limit' => $limit
        ];
        
        return $this->resultSet($sql, $params);
    }
    
    /**
     * Générer une prédiction de match
     * 
     * @param int $homeTeamId ID de l'équipe à domicile
     * @param int $awayTeamId ID de l'équipe à l'extérieur
     * @param int $userId ID de l'utilisateur (optionnel)
     * @return array Détails de la prédiction générée
     */
    public function generatePrediction($homeTeamId, $awayTeamId, $userId = null) {
        // Appeler la fonction PL/pgSQL pour calculer les probabilités
        $sql = "SELECT * FROM calculer_probabilite_victoire(:home_team_id, :away_team_id)";
        $params = [
            ':home_team_id' => $homeTeamId,
            ':away_team_id' => $awayTeamId
        ];
        
        $probabilities = $this->single($sql, $params);
        
        if (!$probabilities) {
            // Valeurs par défaut si la fonction ne retourne rien
            $probabilities = [
                'prob_dom' => 0.5,
                'prob_ext' => 0.5
            ];
        }
        
        // Enregistrer la prédiction dans la base de données
        $insertSql = "INSERT INTO predictions (
                        id_equipe_domicile,
                        id_equipe_exterieure,
                        probabilite_victoire_domicile,
                        probabilite_victoire_exterieure,
                        date_prediction,
                        id_utilisateur
                    ) VALUES (
                        :home_team_id,
                        :away_team_id,
                        :home_probability,
                        :away_probability,
                        CURRENT_TIMESTAMP,
                        :user_id
                    ) RETURNING id_prediction";
        
        $insertParams = [
            ':home_team_id' => $homeTeamId,
            ':away_team_id' => $awayTeamId,
            ':home_probability' => $probabilities['prob_dom'],
            ':away_probability' => $probabilities['prob_ext'],
            ':user_id' => $userId
        ];
        
        $result = $this->single($insertSql, $insertParams);
        $predictionId = $result['id_prediction'] ?? null;
        
        // Récupérer la prédiction complète
        if ($predictionId) {
            return $this->getPredictionById($predictionId);
        }
        
        return [
            'id_equipe_domicile' => $homeTeamId,
            'id_equipe_exterieure' => $awayTeamId,
            'probabilite_victoire_domicile' => $probabilities['prob_dom'],
            'probabilite_victoire_exterieure' => $probabilities['prob_ext'],
            'date_prediction' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Supprimer une prédiction
     * 
     * @param int $id ID de la prédiction à supprimer
     * @param int $userId ID de l'utilisateur pour vérification
     * @return bool Succès de la suppression
     */
    public function deletePrediction($id, $userId = null) {
        $sql = "DELETE FROM predictions WHERE id_prediction = :id";
        $params = [':id' => $id];
        
        // Si un ID d'utilisateur est fourni, vérifier que la prédiction lui appartient
        if ($userId !== null) {
            $sql .= " AND id_utilisateur = :user_id";
            $params[':user_id'] = $userId;
        }
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Compter le nombre total de prédictions
     * 
     * @return int Nombre de prédictions
     */
    public function countPredictions() {
        $sql = "SELECT COUNT(*) as count FROM predictions";
        $result = $this->single($sql);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Compter le nombre de prédictions d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @return int Nombre de prédictions
     */
    public function countUserPredictions($userId) {
        $sql = "SELECT COUNT(*) as count FROM predictions WHERE id_utilisateur = :user_id";
        $params = [':user_id' => $userId];
        $result = $this->single($sql, $params);
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Obtenir les statistiques de précision des prédictions d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @return array Statistiques de précision
     */
    public function getUserPredictionAccuracy($userId) {
        // Cette fonction nécessiterait une table de résultats réels des matchs
        // pour comparer avec les prédictions et calculer la précision
        // Pour l'exemple, nous retournons des valeurs simulées
        
        return [
            'total' => 35,
            'correct' => 23,
            'accuracy_rate' => 65.7,
            'high_confidence' => [
                'total' => 18,
                'correct' => 14,
                'accuracy_rate' => 77.8
            ],
            'medium_confidence' => [
                'total' => 11,
                'correct' => 6,
                'accuracy_rate' => 54.5
            ],
            'low_confidence' => [
                'total' => 6,
                'correct' => 3,
                'accuracy_rate' => 33.3
            ]
        ];
    }
}