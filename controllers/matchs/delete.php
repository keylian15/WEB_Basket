<?php
// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    $_SESSION['flash_message'] = "Vous n'avez pas les droits pour supprimer un match.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=matchs');
    exit;
}

// Récupérer l'ID du match
$game_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$game_id) {
    $_SESSION['flash_message'] = "ID du match manquant pour la suppression.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=matchs');
    exit;
}

// Vérifier si le match existe
$sql = "SELECT * FROM match WHERE game_id = :game_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':game_id', $game_id);
$stmt->execute();
$match = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$match) {
    $_SESSION['flash_message'] = "Le match demandé n'existe pas.";
    $_SESSION['flash_type'] = "danger";
    header('Location: index.php?element=matchs');
    exit;
}

try {
    // Supprimer le match
    $sql_delete = "DELETE FROM match WHERE game_id = :game_id";
    $stmt_delete = $db->prepare($sql_delete);
    $stmt_delete->bindParam(':game_id', $game_id);
    $stmt_delete->execute();
    
    $_SESSION['flash_message'] = "Le match a été supprimé avec succès.";
    $_SESSION['flash_type'] = "success";
    
} catch (Exception $e) {
    $_SESSION['flash_message'] = "Erreur lors de la suppression du match : " . $e->getMessage();
    $_SESSION['flash_type'] = "danger";
}

// Rediriger vers la liste des matchs
header('Location: index.php?element=matchs');
exit;
