<?php
// Controller for adding a new team

// Initialize variables to store form data
$abr_equipe = '';
$saison = '';
$team_name = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $abr_equipe = isset($_POST['abr_equipe']) ? trim($_POST['abr_equipe']) : '';
    $saison = isset($_POST['saison']) ? (int)$_POST['saison'] : '';
    $team_name = isset($_POST['team_name']) ? trim($_POST['team_name']) : '';
    
    // Validate form data
    $errors = [];
    
    if (empty($abr_equipe)) {
        $errors[] = "L'abréviation de l'équipe est requise";
    } elseif (strlen($abr_equipe) > 3) {
        $errors[] = "L'abréviation de l'équipe ne doit pas dépasser 3 caractères";
    }
    
    if (empty($saison)) {
        $errors[] = "La saison est requise";
    }
    
    if (empty($team_name)) {
        $errors[] = "Le nom de l'équipe est requis";
    }
    
    // If no errors, insert data
    if (empty($errors)) {
        try {
            // Check if team already exists
            $check_sql = "SELECT COUNT(*) FROM team WHERE abr_equipe = :abr_equipe AND saison = :saison";
            $check_stmt = $db->prepare($check_sql);
            $check_stmt->bindParam(':abr_equipe', $abr_equipe);
            $check_stmt->bindParam(':saison', $saison);
            $check_stmt->execute();
            
            if ($check_stmt->fetchColumn() > 0) {
                $errors[] = "Cette équipe existe déjà pour cette saison";
            } else {
                // Insert new team
                $sql = "INSERT INTO team (abr_equipe, saison, team_name) VALUES (:abr_equipe, :saison, :team_name)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':abr_equipe', $abr_equipe);
                $stmt->bindParam(':saison', $saison);
                $stmt->bindParam(':team_name', $team_name);
                $stmt->execute();
                
                // Redirect to the team list with success message
                $_SESSION['flash_message'] = "L'équipe a été ajoutée avec succès";
                header('Location: index.php?element=equipes');
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'ajout de l'équipe: " . $e->getMessage();
        }
    }
    
    // If we're here, there were errors, store them in session
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = [
        'abr_equipe' => $abr_equipe,
        'saison' => $saison,
        'team_name' => $team_name
    ];
}
