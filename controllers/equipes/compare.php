<?php
// Récupérer les paramètres
$team1Abbr = isset($_GET['team1']) ? $_GET['team1'] : null;
$team2Abbr = isset($_GET['team2']) ? $_GET['team2'] : null;
$season = isset($_GET['season']) ? $_GET['season'] : null;

if (!$team1Abbr || !$team2Abbr || !$season) {
    header('Location: index.php?element=equipes');
    exit;
}

// Récupérer les informations de la première équipe
$sql_team1 = "SELECT * FROM team WHERE abr_equipe = :abbr AND saison = :season LIMIT 1";
$stmt_team1 = $db->prepare($sql_team1);
$stmt_team1->bindParam(':abbr', $team1Abbr);
$stmt_team1->bindParam(':season', $season);
$stmt_team1->execute();
$team1 = $stmt_team1->fetch(PDO::FETCH_ASSOC);

// Récupérer les informations de la deuxième équipe
$sql_team2 = "SELECT * FROM team WHERE abr_equipe = :abbr AND saison = :season LIMIT 1";
$stmt_team2 = $db->prepare($sql_team2);
$stmt_team2->bindParam(':abbr', $team2Abbr);
$stmt_team2->bindParam(':season', $season);
$stmt_team2->execute();
$team2 = $stmt_team2->fetch(PDO::FETCH_ASSOC);

if (!$team1 || !$team2) {
    header('Location: index.php?element=equipes');
    exit;
}

// Récupérer les statistiques de la première équipe
$sql_stats1 = "SELECT * FROM team_stats_par_match 
               WHERE abr_equipe = :abbr AND saison = :season 
               LIMIT 1";
$stmt_stats1 = $db->prepare($sql_stats1);
$stmt_stats1->bindParam(':abbr', $team1Abbr);
$stmt_stats1->bindParam(':season', $season);
$stmt_stats1->execute();
$team1Stats = $stmt_stats1->fetch(PDO::FETCH_ASSOC);

// Récupérer les statistiques de la deuxième équipe
$sql_stats2 = "SELECT * FROM team_stats_par_match 
               WHERE abr_equipe = :abbr AND saison = :season 
               LIMIT 1";
$stmt_stats2 = $db->prepare($sql_stats2);
$stmt_stats2->bindParam(':abbr', $team2Abbr);
$stmt_stats2->bindParam(':season', $season);
$stmt_stats2->execute();
$team2Stats = $stmt_stats2->fetch(PDO::FETCH_ASSOC);

// Récupérer les matchs directs entre les deux équipes
$sql_matches = "SELECT m.*, 
                t1.team_name as home_team_name, 
                t2.team_name as away_team_name 
                FROM match m
                LEFT JOIN team t1 ON t1.abr_equipe = m.team_abbreviation_home AND t1.saison = :season
                LEFT JOIN team t2 ON t2.abr_equipe = m.team_abbreviation_away AND t2.saison = :season
                WHERE (m.team_abbreviation_home = :team1 AND m.team_abbreviation_away = :team2)
                   OR (m.team_abbreviation_home = :team2 AND m.team_abbreviation_away = :team1)
                ORDER BY m.game_date_est DESC";
$stmt_matches = $db->prepare($sql_matches);
$stmt_matches->bindParam(':team1', $team1Abbr);
$stmt_matches->bindParam(':team2', $team2Abbr);
$stmt_matches->bindParam(':season', $season);
$stmt_matches->execute();
$directMatches = $stmt_matches->fetchAll(PDO::FETCH_ASSOC);

// Prédiction du match (simple, basée sur les moyennes de points)
$predictedWinner = null;
$winProbability = 0;

if ($team1Stats && $team2Stats) {
    // Calcul basé sur les points marqués et concédés
    $team1OffStrength = $team1Stats['pts_par_match'];
    $team1DefStrength = isset($team1Stats['opp_pts_per_game_']) ? $team1Stats['opp_pts_per_game_'] : 100; // Valeur par défaut si non disponible
    
    $team2OffStrength = $team2Stats['pts_par_match'];
    $team2DefStrength = isset($team2Stats['opp_pts_per_game_']) ? $team2Stats['opp_pts_per_game_'] : 100; // Valeur par défaut si non disponible
    
    // Prédiction simplifiée basée sur l'attaque et la défense
    $team1ExpectedScore = ($team1OffStrength + $team2DefStrength) / 2;
    $team2ExpectedScore = ($team2OffStrength + $team1DefStrength) / 2;
    
    if ($team1ExpectedScore > $team2ExpectedScore) {
        $predictedWinner = $team1;
        $scoreDiff = $team1ExpectedScore - $team2ExpectedScore;
        $winProbability = min(90, 50 + ($scoreDiff * 5)); // Limité à 90% max
    } else {
        $predictedWinner = $team2;
        $scoreDiff = $team2ExpectedScore - $team1ExpectedScore;
        $winProbability = min(90, 50 + ($scoreDiff * 5)); // Limité à 90% max
    }
}

// Obtenir toutes les équipes pour le formulaire de comparaison
$sql_all_teams = "SELECT abr_equipe, team_name FROM team WHERE saison = :season ORDER BY team_name";
$stmt_all_teams = $db->prepare($sql_all_teams);
$stmt_all_teams->bindParam(':season', $season);
$stmt_all_teams->execute();
$allTeams = $stmt_all_teams->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les saisons disponibles
$sql_seasons = "SELECT DISTINCT saison FROM team ORDER BY saison DESC";
$stmt_seasons = $db->prepare($sql_seasons);
$stmt_seasons->execute();
$seasons = $stmt_seasons->fetchAll(PDO::FETCH_COLUMN);
