<?php
// Récupérer l'identifiant du match
$matchId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$matchId) {
    header('Location: index.php?element=matchs');
    exit;
}

// Récupérer les informations du match
$sql = "SELECT m.*, 
          t1.team_name as home_team_name, 
          t2.team_name as away_team_name
        FROM match m
        LEFT JOIN team t1 ON t1.abr_equipe = m.team_abbreviation_home
        LEFT JOIN team t2 ON t2.abr_equipe = m.team_abbreviation_away
        WHERE m.game_id = :id
        LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $matchId);
$stmt->execute();
$match = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le match n'existe pas, rediriger
if (!$match) {
    header('Location: index.php?element=matchs');
    exit;
}

// Récupérer la saison du match (en utilisant la table team)
$sql_season = "SELECT saison FROM team WHERE abr_equipe = :team_abbr AND saison IN 
              (SELECT MAX(saison) FROM team WHERE abr_equipe = :team_abbr AND DATE(CONCAT(saison, '-01-01')) <= :match_date)
              LIMIT 1";
$stmt_season = $db->prepare($sql_season);
$stmt_season->bindParam(':team_abbr', $match['team_abbreviation_home']);
$stmt_season->bindParam(':match_date', $match['game_date_est']);
$stmt_season->execute();
$seasonData = $stmt_season->fetch(PDO::FETCH_ASSOC);
$season = $seasonData ? $seasonData['saison'] : null;

// Récupérer les statistiques de l'équipe domicile pour ce match
$sql_home_stats = "SELECT * FROM team_stats_par_match 
                  WHERE abr_equipe = :team_abbr AND saison = :saison
                  LIMIT 1";
try {
    $stmt_home_stats = $db->prepare($sql_home_stats);
    $stmt_home_stats->bindParam(':team_abbr', $match['team_abbreviation_home']);
    $stmt_home_stats->bindParam(':saison', $season);
    $stmt_home_stats->execute();
    $homeStats = $stmt_home_stats->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $homeStats = null;
}

// Récupérer les statistiques de l'équipe extérieur pour ce match
$sql_away_stats = "SELECT * FROM team_stats_par_match 
                  WHERE abr_equipe = :team_abbr AND saison = :saison
                  LIMIT 1";
try {
    $stmt_away_stats = $db->prepare($sql_away_stats);
    $stmt_away_stats->bindParam(':team_abbr', $match['team_abbreviation_away']);
    $stmt_away_stats->bindParam(':saison', $season);
    $stmt_away_stats->execute();
    $awayStats = $stmt_away_stats->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $awayStats = null;
}

// Récupérer les performances des joueurs pour ce match
$sql_players = "SELECT p.*, t.team_name
               FROM player_par_match p
               LEFT JOIN team t ON t.abr_equipe = p.abr_equipe AND t.saison = p.saison
               WHERE p.game_id = :game_id
               ORDER BY p.points DESC, p.minutes_jouees DESC";
try {
    $stmt_players = $db->prepare($sql_players);
    $stmt_players->bindParam(':game_id', $matchId);
    $stmt_players->execute();
    $players = $stmt_players->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $players = [];
}

// Diviser les joueurs par équipe
$homePlayers = [];
$awayPlayers = [];

foreach ($players as $player) {
    if ($player['abr_equipe'] === $match['team_abbreviation_home']) {
        $homePlayers[] = $player;
    } else if ($player['abr_equipe'] === $match['team_abbreviation_away']) {
        $awayPlayers[] = $player;
    }
}
