<?php
// Pagination et filtres
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;
$offset = ($page - 1) * $perPage;
$season = isset($_GET['season']) ? $_GET['season'] : null;
$team = isset($_GET['team']) ? $_GET['team'] : null;
$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : null;
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : null;

// Si aucune saison n'est spécifiée, utiliser la plus récente (avant 2026)
if (!$season) {
    $sql_last_season = "SELECT MAX(saison) as derniere_saison FROM team WHERE saison < 2026";
    $stmt_last_season = $db->prepare($sql_last_season);
    $stmt_last_season->execute();
    $last_season = $stmt_last_season->fetch(PDO::FETCH_ASSOC);
    $season = $last_season['derniere_saison'] ?? '2021';
}

// Construire la requête basique pour les matchs (en excluant la saison 2026)
$sql = "SELECT m.* FROM match m WHERE 1=1";

// Ajouter une condition pour exclure la saison 2026 si nécessaire
// Note: Cette condition suppose que la table match a une colonne pour filtrer par saison
// Si ce n'est pas le cas, le filtre sera appliqué uniquement dans l'interface utilisateur
$sqlCount = "SELECT COUNT(*) FROM match m WHERE 1=1";
$params = [];

// Ajouter les filtres à la requête
if ($team) {
    $sql .= " AND (m.team_abbreviation_home = :team OR m.team_abbreviation_away = :team)";
    $sqlCount .= " AND (m.team_abbreviation_home = :team OR m.team_abbreviation_away = :team)";
    $params[':team'] = $team;
}

if ($dateFrom) {
    $sql .= " AND m.game_date_est >= :date_from";
    $sqlCount .= " AND m.game_date_est >= :date_from";
    $params[':date_from'] = $dateFrom;
}

if ($dateTo) {
    $sql .= " AND m.game_date_est <= :date_to";
    $sqlCount .= " AND m.game_date_est <= :date_to";
    $params[':date_to'] = $dateTo;
}

// Ajouter order by et pagination
$sql .= " ORDER BY m.game_date_est DESC LIMIT :perPage OFFSET :offset";
$params[':offset'] = $offset;
$params[':perPage'] = $perPage;

// Exécuter la requête pour récupérer les matchs avec pagination
$stmt = $db->prepare($sql);
foreach ($params as $key => $value) {
    if ($key == ':offset' || $key == ':perPage') {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value);
    }
}
$stmt->execute();
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Enrichir les résultats avec les noms d'équipe
if (count($matchs) > 0) {
    // Récupérer les équipes pour cette saison
    $sql_team_names = "SELECT abr_equipe, team_name FROM team WHERE saison = :season";
    $stmt_team_names = $db->prepare($sql_team_names);
    $stmt_team_names->bindParam(':season', $season);
    $stmt_team_names->execute();
    $teamNames = [];
    while ($team = $stmt_team_names->fetch(PDO::FETCH_ASSOC)) {
        $teamNames[$team['abr_equipe']] = $team['team_name'];
    }
    
    // Ajouter les noms d'équipe à chaque match
    foreach ($matchs as &$match) {
        $match['home_team_name'] = $teamNames[$match['team_abbreviation_home']] ?? $match['team_abbreviation_home'];
        $match['away_team_name'] = $teamNames[$match['team_abbreviation_away']] ?? $match['team_abbreviation_away'];
    }
}

// Exécuter la requête pour compter le nombre total de matchs
$stmtCount = $db->prepare($sqlCount);
$countParams = [];
foreach ($params as $key => $value) {
    if ($key != ':offset' && $key != ':perPage') {
        $countParams[$key] = $value;
    }
}
foreach ($countParams as $key => $value) {
    $stmtCount->bindValue($key, $value);
}
$stmtCount->execute();
$totalCount = $stmtCount->fetchColumn();
$totalPages = ceil($totalCount / $perPage);

// Récupérer la liste des équipes pour le filtre
$sql_teams = "SELECT DISTINCT abr_equipe, team_name FROM team WHERE saison = :season ORDER BY team_name";
$stmt_teams = $db->prepare($sql_teams);
$stmt_teams->bindParam(':season', $searchSeason);
$stmt_teams->execute();
$teams = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);

// Récupérer la liste des saisons pour le filtre (en excluant 2026)
$sql_seasons = "SELECT DISTINCT saison FROM team WHERE saison < 2026 ORDER BY saison DESC";
$stmt_seasons = $db->prepare($sql_seasons);
$stmt_seasons->execute();
$seasons = $stmt_seasons->fetchAll(PDO::FETCH_COLUMN);

// Pour débogage
//error_log("Saison: " . $searchSeason);
//error_log("Paramètres: " . print_r($params, true));
