<?php
// Récupérer les paramètres
$playerName = isset($_GET['nom']) ? $_GET['nom'] : null;
$season = isset($_GET['season']) ? $_GET['season'] : null;

if (!$playerName) {
    header('Location: index.php?element=joueurs');
    exit;
}

// Si la saison n'est pas spécifiée, récupérer la dernière saison du joueur
if (!$season) {
    $sql_last_season = "SELECT MAX(saison) as derniere_saison FROM player_par_match WHERE nom_joueur = :nom";
    $stmt_last_season = $db->prepare($sql_last_season);
    $stmt_last_season->bindParam(':nom', $playerName);
    $stmt_last_season->execute();
    $last_season = $stmt_last_season->fetch(PDO::FETCH_ASSOC);
    $season = $last_season['derniere_saison'] ?? null;

    if (!$season) {
        header('Location: index.php?element=joueurs');
        exit;
    }
}

// Récupérer les informations du joueur pour la saison spécifiée
$sql = "SELECT p.*, t.team_name
         FROM player_par_match p
         LEFT JOIN team t ON p.abr_equipe = t.abr_equipe AND p.saison = t.saison
         WHERE p.nom_joueur = :nom AND p.saison = :season
         LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bindParam(':nom', $playerName);
$stmt->bindParam(':season', $season);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le joueur n'existe pas pour cette saison, rediriger
if (!$player) {
    header('Location: index.php?element=joueurs');
    exit;
}

// Récupérer toutes les saisons du joueur
$sql_seasons = "SELECT DISTINCT saison, abr_equipe FROM player_par_match 
              WHERE nom_joueur = :nom
              ORDER BY saison DESC";
$stmt_seasons = $db->prepare($sql_seasons);
$stmt_seasons->bindParam(':nom', $playerName);
$stmt_seasons->execute();
$playerSeasons = $stmt_seasons->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les matchs récents du joueur
$sql_games = "SELECT m.*, t1.team_name as home_team_name, t2.team_name as away_team_name,
               pstats.minutes_jouees as min, pstats.points as pts, 
               pstats.rebond as reb, pstats.passe as ast,
               pstats.interception as stl, pstats.contre as blk
               FROM match m
               LEFT JOIN team t1 ON t1.abr_equipe = m.team_abbreviation_home AND t1.saison = :saison
               LEFT JOIN team t2 ON t2.abr_equipe = m.team_abbreviation_away AND t2.saison = :saison
               LEFT JOIN player_par_match pstats ON pstats.game_id = m.game_id AND pstats.nom_joueur = :nom AND pstats.saison = :saison
               WHERE (m.team_abbreviation_home = :abbr OR m.team_abbreviation_away = :abbr)
               ORDER BY m.game_date_est DESC
               LIMIT 10";

// Gérer le cas où player_stats_par_match n'existe pas, essayer avec une autre approche
try {
    $stmt_games = $db->prepare($sql_games);
    $stmt_games->bindParam(':nom', $playerName);
    $stmt_games->bindParam(':abbr', $player['abr_equipe']);
    $stmt_games->bindParam(':saison', $season);
    $stmt_games->execute();
    $gameLogs = $stmt_games->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Si la table player_stats_par_match n'existe pas, récupérer juste les matchs
    $sql_games_fallback = "SELECT m.*, t1.team_name as home_team_name, t2.team_name as away_team_name
                         FROM match m
                         LEFT JOIN team t1 ON t1.abr_equipe = m.team_abbreviation_home AND t1.saison = :saison
                         LEFT JOIN team t2 ON t2.abr_equipe = m.team_abbreviation_away AND t2.saison = :saison
                         WHERE (m.team_abbreviation_home = :abbr OR m.team_abbreviation_away = :abbr)
                         ORDER BY m.game_date_est DESC
                         LIMIT 10";
    $stmt_games_fallback = $db->prepare($sql_games_fallback);
    $stmt_games_fallback->bindParam(':abbr', $player['abr_equipe']);
    $stmt_games_fallback->bindParam(':saison', $season);
    $stmt_games_fallback->execute();
    $gameLogs = $stmt_games_fallback->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les statistiques avancées du joueur si disponibles
$sql_advanced = "SELECT * FROM player_stat_avancee 
               WHERE nom_joueur = :nom AND saison = :saison 
               LIMIT 1";
try {
    $stmt_advanced = $db->prepare($sql_advanced);
    $stmt_advanced->bindParam(':nom', $playerName);
    $stmt_advanced->bindParam(':saison', $season);
    $stmt_advanced->execute();
    $advancedStats = $stmt_advanced->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $advancedStats = null;
}

// Récupérer des joueurs similaires (même équipe, stats similaires)
$sql_similar = "SELECT p.*, t.team_name
                FROM player_par_match p
                LEFT JOIN team t ON p.abr_equipe = t.abr_equipe AND p.saison = t.saison
                WHERE p.saison = :saison 
                AND p.nom_joueur != :nom
                AND (p.abr_equipe = :abbr OR 
                    (ABS(p.points - :points) < 5 AND 
                     ABS(p.rebond - :rebond) < 3 AND 
                     ABS(p.passe - :passe) < 3))
                ORDER BY 
                    CASE WHEN p.abr_equipe = :abbr THEN 0 ELSE 1 END,
                    ABS(p.points - :points) + ABS(p.rebond - :rebond) + ABS(p.passe - :passe)
                LIMIT 6";
$stmt_similar = $db->prepare($sql_similar);
$stmt_similar->bindParam(':saison', $season);
$stmt_similar->bindParam(':nom', $playerName);
$stmt_similar->bindParam(':abbr', $player['abr_equipe']);
$stmt_similar->bindParam(':points', $player['points']);
$stmt_similar->bindParam(':rebond', $player['rebond']);
$stmt_similar->bindParam(':passe', $player['passe']);
$stmt_similar->execute();
$similarPlayers = $stmt_similar->fetchAll(PDO::FETCH_ASSOC);
