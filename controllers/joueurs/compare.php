<?php
// Récupérer les paramètres
$joueur1Nom = isset($_GET['joueur1']) ? $_GET['joueur1'] : null;
$joueur2Nom = isset($_GET['joueur2']) ? $_GET['joueur2'] : null;
$season = isset($_GET['season']) ? $_GET['season'] : null;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

// Vérifier que les deux joueurs sont spécifiés
if (!$joueur1Nom || !$joueur2Nom) {
    header('Location: index.php?element=joueurs');
    exit;
}

// Si la saison n'est pas spécifiée, récupérer la dernière saison commune aux deux joueurs
if (!$season) {
    $sql_last_season = "SELECT MAX(p1.saison) as derniere_saison 
                        FROM player_par_match p1 
                        JOIN player_par_match p2 ON p1.saison = p2.saison 
                        WHERE p1.nom_joueur = :nom1 AND p2.nom_joueur = :nom2";
    $stmt_last_season = $db->prepare($sql_last_season);
    $stmt_last_season->bindParam(':nom1', $joueur1Nom);
    $stmt_last_season->bindParam(':nom2', $joueur2Nom);
    $stmt_last_season->execute();
    $last_season = $stmt_last_season->fetch(PDO::FETCH_ASSOC);
    $season = $last_season['derniere_saison'] ?? null;

    if (!$season) {
        header('Location: index.php?element=joueurs');
        exit;
    }
}

// Récupérer les informations du joueur 1 pour la saison spécifiée
$sql = "SELECT p.*, t.team_name
         FROM player_par_match p
         LEFT JOIN team t ON p.abr_equipe = t.abr_equipe AND p.saison = t.saison
         WHERE p.nom_joueur = :nom AND p.saison = :season
         LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bindParam(':nom', $joueur1Nom);
$stmt->bindParam(':season', $season);
$stmt->execute();
$joueur1 = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les informations du joueur 2 pour la saison spécifiée
$stmt->bindParam(':nom', $joueur2Nom);
$stmt->execute();
$joueur2 = $stmt->fetch(PDO::FETCH_ASSOC);

// Si un des joueurs n'existe pas pour cette saison, rediriger
if (!$joueur1 || !$joueur2) {
    header('Location: index.php?element=joueurs');
    exit;
}

// Récupérer toutes les saisons communes aux deux joueurs
$sql_seasons = "SELECT DISTINCT p1.saison, p1.abr_equipe as equipe1, p2.abr_equipe as equipe2 
              FROM player_par_match p1
              JOIN player_par_match p2 ON p1.saison = p2.saison
              WHERE p1.nom_joueur = :nom1 AND p2.nom_joueur = :nom2
              ORDER BY p1.saison DESC";
$stmt_seasons = $db->prepare($sql_seasons);
$stmt_seasons->bindParam(':nom1', $joueur1Nom);
$stmt_seasons->bindParam(':nom2', $joueur2Nom);
$stmt_seasons->execute();
$commonSeasons = $stmt_seasons->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les statistiques avancées si disponibles
$sql_advanced = "SELECT * FROM player_stat_avancee 
               WHERE nom_joueur = :nom AND saison = :saison 
               LIMIT 1";

try {
    // Stats avancées joueur 1
    $stmt_advanced = $db->prepare($sql_advanced);
    $stmt_advanced->bindParam(':nom', $joueur1Nom);
    $stmt_advanced->bindParam(':saison', $season);
    $stmt_advanced->execute();
    $advancedStats1 = $stmt_advanced->fetch(PDO::FETCH_ASSOC);
    
    // Stats avancées joueur 2
    $stmt_advanced->bindParam(':nom', $joueur2Nom);
    $stmt_advanced->execute();
    $advancedStats2 = $stmt_advanced->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $advancedStats1 = null;
    $advancedStats2 = null;
}

// Récupérer la liste complète des joueurs pour les listes déroulantes
// Utiliser une saison récente par défaut si aucune n'est spécifiée
$searchSeason = $season ?: "2021";

// Construire la requête avec les filtres potentiels
$sql_all_players = "SELECT DISTINCT p.nom_joueur, t.team_name, p.abr_equipe 
                  FROM player_par_match p
                  LEFT JOIN team t ON p.abr_equipe = t.abr_equipe AND p.saison = t.saison
                  WHERE p.saison = :saison";

$params = [':saison' => $searchSeason];

// Ajouter un filtre de recherche si spécifié
if ($searchTerm) {
    $sql_all_players .= " AND p.nom_joueur LIKE :search";
    $params[':search'] = "%$searchTerm%";
}

$sql_all_players .= " ORDER BY p.nom_joueur";

$stmt_all_players = $db->prepare($sql_all_players);
foreach ($params as $key => $value) {
    $stmt_all_players->bindValue($key, $value);
}
$stmt_all_players->execute();
$allPlayers = $stmt_all_players->fetchAll(PDO::FETCH_ASSOC);

// On n'utilise pas de filtre par position car la colonne poste n'existe pas dans la table player_par_match
