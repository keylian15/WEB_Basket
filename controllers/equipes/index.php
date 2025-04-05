<?php
// Requête SQL pour récupérer toutes les équipes avec leur saison
$sql = "SELECT DISTINCT team.abr_equipe, team.team_name, team.saison 
        FROM team 
        ORDER BY team.saison DESC, team.team_name ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les saisons disponibles
$sql_seasons = "SELECT DISTINCT saison FROM team ORDER BY saison DESC";
$stmt_seasons = $db->prepare($sql_seasons);
$stmt_seasons->execute();
$seasons = $stmt_seasons->fetchAll(PDO::FETCH_COLUMN);

// Saison sélectionnée (par défaut, la plus récente)
$currentSeason = isset($_GET['season']) ? $_GET['season'] : (count($seasons) > 0 ? $seasons[0] : date('Y'));

// Filtrer les équipes par saison si une saison est sélectionnée
if ($currentSeason) {
    $filtered_teams = array_filter($teams, function($team) use ($currentSeason) {
        return $team['saison'] == $currentSeason;
    });
} else {
    $filtered_teams = $teams;
}
