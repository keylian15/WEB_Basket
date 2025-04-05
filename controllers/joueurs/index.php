<?php
// Récupérer les paramètres de recherche et de filtre
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$season = isset($_GET['season']) ? $_GET['season'] : null;
$team = isset($_GET['team']) ? $_GET['team'] : '';
$position = isset($_GET['position']) ? $_GET['position'] : '';

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 25;
$offset = ($page - 1) * $perPage;

// Construction de la requête de base
$sql = "SELECT DISTINCT p.id_joueur, p.nom_joueur, p.saison, p.abr_equipe, t.team_name, 
               p.minutes_jouees, p.pourcent_fg, p.pourcent_trois_pts, p.pourcent_ft, 
               p.rebond, p.passe, p.interception, p.contre, p.points
        FROM player_par_match p
        LEFT JOIN team t ON p.abr_equipe = t.abr_equipe AND p.saison = t.saison
        WHERE 1=1";

$countSql = "SELECT COUNT(DISTINCT p.id_joueur) as total
             FROM player_par_match p
             LEFT JOIN team t ON p.abr_equipe = t.abr_equipe AND p.saison = t.saison
             WHERE 1=1";

$params = [];

// Ajouter les conditions de recherche et filtres
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $sql .= " AND p.nom_joueur LIKE :search";
    $countSql .= " AND p.nom_joueur LIKE :search";
    $params[':search'] = $searchTerm;
}

if (!empty($season)) {
    $sql .= " AND p.saison = :season";
    $countSql .= " AND p.saison = :season";
    $params[':season'] = $season;
}

if (!empty($team)) {
    $sql .= " AND p.abr_equipe = :team";
    $countSql .= " AND p.abr_equipe = :team";
    $params[':team'] = $team;
}

if (!empty($position)) {
    $sql .= " AND p.poste = :position";
    $countSql .= " AND p.poste = :position";
    $params[':position'] = $position;
}

// Tri et pagination
$sql .= " ORDER BY p.points DESC, p.nom_joueur ASC LIMIT :limit OFFSET :offset";
$params[':limit'] = $perPage;
$params[':offset'] = $offset;

// Exécuter la requête pour récupérer les joueurs
$stmt = $db->prepare($sql);
foreach ($params as $key => $value) {
    if ($key == ':limit') {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } elseif ($key == ':offset') {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value);
    }
}
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exécuter la requête pour compter le nombre total de joueurs
$countStmt = $db->prepare($countSql);
foreach ($params as $key => $value) {
    if ($key != ':limit' && $key != ':offset') {
        $countStmt->bindValue($key, $value);
    }
}
$countStmt->execute();
$totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalCount / $perPage);

// Récupérer toutes les saisons disponibles
$seasonsSql = "SELECT DISTINCT saison FROM player_par_match ORDER BY saison DESC";
$seasonsStmt = $db->prepare($seasonsSql);
$seasonsStmt->execute();
$seasons = $seasonsStmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer toutes les équipes
$teamsSql = "SELECT DISTINCT t.abr_equipe, t.team_name 
             FROM team t 
             ORDER BY t.team_name ASC";
$teamsStmt = $db->prepare($teamsSql);
$teamsStmt->execute();
$teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les postes (si disponible dans la base de données)
$positions = ['PG', 'SG', 'SF', 'PF', 'C']; // Valeurs par défaut si non disponibles
