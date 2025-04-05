<?php
// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    $_SESSION['flash_message'] = "Vous n'avez pas les droits pour supprimer un joueur.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=joueurs');
    exit;
}

// Récupérer les paramètres
$id_joueur = isset($_GET['id_joueur']) ? $_GET['id_joueur'] : null;
$nom_joueur = isset($_GET['nom_joueur']) ? $_GET['nom_joueur'] : null;
$abr_equipe = isset($_GET['abr_equipe']) ? $_GET['abr_equipe'] : null;
$saison = isset($_GET['saison']) ? $_GET['saison'] : null;

if ((!$id_joueur && !$nom_joueur) || !$abr_equipe || !$saison) {
    $_SESSION['flash_message'] = "Paramètres manquants pour la suppression.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=joueurs');
    exit;
}

// Construire la requête en fonction des paramètres disponibles
$sql = "SELECT * FROM player_par_match WHERE ";
$params = [];

if ($id_joueur) {
    $sql .= "id_joueur = :id_joueur AND ";
    $params[':id_joueur'] = $id_joueur;
}

if ($nom_joueur) {
    $sql .= "nom_joueur = :nom_joueur AND ";
    $params[':nom_joueur'] = $nom_joueur;
}

$sql .= "abr_equipe = :abr_equipe AND saison = :saison";
$params[':abr_equipe'] = $abr_equipe;
$params[':saison'] = $saison;

// Vérifier si le joueur existe
$stmt = $db->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$player) {
    $_SESSION['flash_message'] = "Le joueur demandé n'existe pas.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=joueurs');
    exit;
}

try {
    // Supprimer le joueur
    $delete_sql = "DELETE FROM player_par_match WHERE ";
    
    if ($id_joueur) {
        $delete_sql .= "id_joueur = :id_joueur AND ";
    }
    
    if ($nom_joueur) {
        $delete_sql .= "nom_joueur = :nom_joueur AND ";
    }
    
    $delete_sql .= "abr_equipe = :abr_equipe AND saison = :saison";
    
    $delete_stmt = $db->prepare($delete_sql);
    foreach ($params as $key => $value) {
        $delete_stmt->bindValue($key, $value);
    }
    $delete_stmt->execute();
    
    $_SESSION['flash_message'] = "Le joueur " . htmlspecialchars($player['nom_joueur']) . " a été supprimé avec succès.";
    $_SESSION['flash_type'] = "success";
    
} catch (Exception $e) {
    $_SESSION['flash_message'] = "Erreur lors de la suppression du joueur : " . $e->getMessage();
    $_SESSION['flash_type'] = "danger";
}

// Rediriger vers la liste des joueurs
header('Location: index.php?element=joueurs');
exit;
