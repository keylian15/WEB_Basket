<?php
// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    $_SESSION['flash_message'] = "Vous n'avez pas les droits pour supprimer une équipe.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=equipes');
    exit;
}

// Récupérer les paramètres
$abbr = isset($_GET['abbr']) ? $_GET['abbr'] : null;
$saison = isset($_GET['saison']) ? $_GET['saison'] : null;

if (!$abbr || !$saison) {
    $_SESSION['flash_message'] = "Paramètres manquants pour la suppression.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=equipes');
    exit;
}

// Vérifier si l'équipe existe
$sql = "SELECT * FROM team WHERE abr_equipe = :abbr AND saison = :saison";
$stmt = $db->prepare($sql);
$stmt->bindParam(':abbr', $abbr);
$stmt->bindParam(':saison', $saison);
$stmt->execute();
$team = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$team) {
    $_SESSION['flash_message'] = "L'équipe demandée n'existe pas.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=equipes');
    exit;
}

try {
    // Commencer une transaction
    $db->beginTransaction();
    
    // Vérifier les contraintes d'intégrité 
    // 1. Vérifier s'il y a des matchs liés à cette équipe
    $sql_match = "SELECT COUNT(*) FROM match WHERE (team_abbreviation_home = :abbr OR team_abbreviation_away = :abbr)";
    $stmt_match = $db->prepare($sql_match);
    $stmt_match->bindParam(':abbr', $abbr);
    $stmt_match->execute();
    $match_count = $stmt_match->fetchColumn();
    
    // 2. Vérifier s'il y a des joueurs liés à cette équipe
    $sql_player = "SELECT COUNT(*) FROM player_par_match WHERE abr_equipe = :abbr AND saison = :saison";
    $stmt_player = $db->prepare($sql_player);
    $stmt_player->bindParam(':abbr', $abbr);
    $stmt_player->bindParam(':saison', $saison);
    $stmt_player->execute();
    $player_count = $stmt_player->fetchColumn();
    
    // 3. Vérifier s'il y a des statistiques d'équipe liées à cette équipe
    $sql_team_stats = "SELECT COUNT(*) FROM team_stats_par_match WHERE abr_equipe = :abbr AND saison = :saison";
    $stmt_team_stats = $db->prepare($sql_team_stats);
    $stmt_team_stats->bindParam(':abbr', $abbr);
    $stmt_team_stats->bindParam(':saison', $saison);
    $stmt_team_stats->execute();
    $team_stats_count = $stmt_team_stats->fetchColumn();
    
    // 4. Vérifier s'il y a des statistiques d'adversaire liées à cette équipe
    $sql_opp_stats = "SELECT COUNT(*) FROM opponent_stats_par_match WHERE abr_equipe = :abbr AND saison = :saison";
    $stmt_opp_stats = $db->prepare($sql_opp_stats);
    $stmt_opp_stats->bindParam(':abbr', $abbr);
    $stmt_opp_stats->bindParam(':saison', $saison);
    $stmt_opp_stats->execute();
    $opp_stats_count = $stmt_opp_stats->fetchColumn();
    
    // Si on trouve des données liées, on annule la suppression
    if ($match_count > 0 || $player_count > 0 || $team_stats_count > 0 || $opp_stats_count > 0) {
        throw new Exception("Impossible de supprimer cette équipe car elle est liée à d'autres données : " . 
            ($match_count > 0 ? "$match_count matchs, " : "") . 
            ($player_count > 0 ? "$player_count joueurs, " : "") . 
            ($team_stats_count > 0 ? "des statistiques d'équipe, " : "") . 
            ($opp_stats_count > 0 ? "des statistiques d'adversaires" : ""));
    }
    
    // Supprimer l'équipe
    $sql_delete = "DELETE FROM team WHERE abr_equipe = :abbr AND saison = :saison";
    $stmt_delete = $db->prepare($sql_delete);
    $stmt_delete->bindParam(':abbr', $abbr);
    $stmt_delete->bindParam(':saison', $saison);
    $stmt_delete->execute();
    
    // Valider la transaction
    $db->commit();
    
    $_SESSION['flash_message'] = "L'équipe " . htmlspecialchars($team['team_name']) . " a été supprimée avec succès.";
    $_SESSION['flash_type'] = "success";
    
} catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    $db->rollBack();
    
    $_SESSION['flash_message'] = "Erreur lors de la suppression de l'équipe : " . $e->getMessage();
    $_SESSION['flash_type'] = "danger";
}

// Rediriger vers la liste des équipes
header('Location: index.php?element=equipes');
exit;
