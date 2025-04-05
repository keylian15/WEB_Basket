<?php
// Récupérer les paramètres
$abbr = isset($_GET['abbr']) ? $_GET['abbr'] : null;
$season = isset($_GET['season']) ? $_GET['season'] : null;

if (!$abbr) {
    header('Location: index.php?element=equipes');
    exit;
}

// Récupérer les informations de l'équipe
$sql = "SELECT * FROM team WHERE abr_equipe = :abbr";
if ($season) {
    $sql .= " AND saison = :season";
}
$sql .= " LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->bindParam(':abbr', $abbr);
if ($season) {
    $stmt->bindParam(':season', $season);
}
$stmt->execute();
$team = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$team) {
    header('Location: index.php?element=equipes');
    exit;
}

// Récupérer les statistiques de l'équipe
$sql_stats = "SELECT * FROM team_stats_par_match 
              WHERE abr_equipe = :abbr AND saison = :saison 
              LIMIT 1";
$stmt_stats = $db->prepare($sql_stats);
$stmt_stats->bindParam(':abbr', $abbr);
$stmt_stats->bindParam(':saison', $team['saison']);
$stmt_stats->execute();
$teamStats = $stmt_stats->fetch(PDO::FETCH_ASSOC);

// Récupérer les statistiques de l'équipe adverse
$sql_opp_stats = "SELECT * FROM opponent_stats_par_match 
                 WHERE abr_equipe = :abbr AND saison = :saison 
                 LIMIT 1";
$stmt_opp_stats = $db->prepare($sql_opp_stats);
$stmt_opp_stats->bindParam(':abbr', $abbr);
$stmt_opp_stats->bindParam(':saison', $team['saison']);
$stmt_opp_stats->execute();
$teamOppStats = $stmt_opp_stats->fetch(PDO::FETCH_ASSOC);

// Récupérer les joueurs de l'équipe
$sql_players = "SELECT DISTINCT p.nom_joueur, p.saison, p.minutes_jouees, p.points, p.rebond, p.passe 
                FROM player_par_match p 
                WHERE p.abr_equipe = :abbr AND p.saison = :saison 
                ORDER BY p.points DESC, p.minutes_jouees DESC";
$stmt_players = $db->prepare($sql_players);
$stmt_players->bindParam(':abbr', $abbr);
$stmt_players->bindParam(':saison', $team['saison']);
$stmt_players->execute();
$players = $stmt_players->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les matchs récents de l'équipe
$sql_matches = "SELECT m.*, 
                t1.team_name as home_team_name, 
                t2.team_name as away_team_name 
                FROM match m
                LEFT JOIN team t1 ON t1.abr_equipe = m.team_abbreviation_home AND t1.saison = :saison
                LEFT JOIN team t2 ON t2.abr_equipe = m.team_abbreviation_away AND t2.saison = :saison
                WHERE (m.team_abbreviation_home = :abbr OR m.team_abbreviation_away = :abbr)
                ORDER BY m.game_date_est DESC
                LIMIT 10";
$stmt_matches = $db->prepare($sql_matches);
$stmt_matches->bindParam(':abbr', $abbr);
$stmt_matches->bindParam(':saison', $team['saison']);
$stmt_matches->execute();
$matches = $stmt_matches->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les saisons disponibles pour cette équipe
$sql_seasons = "SELECT DISTINCT saison FROM team WHERE abr_equipe = :abbr ORDER BY saison DESC";
$stmt_seasons = $db->prepare($sql_seasons);
$stmt_seasons->bindParam(':abbr', $abbr);
$stmt_seasons->execute();
$seasons = $stmt_seasons->fetchAll(PDO::FETCH_COLUMN);
