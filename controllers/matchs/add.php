<?php
// Controller for adding a new match

// Initialize variables to store form data
$game_id = '';
$game_date_est = '';
$team_abbreviation_home = '';
$pts_home = '';
$team_abbreviation_away = '';
$pts_away = '';

// Fetch teams for dropdown
$teams_query = "SELECT DISTINCT abr_equipe, team_name, saison FROM team ORDER BY team_name, saison DESC";
$teams_stmt = $db->prepare($teams_query);
$teams_stmt->execute();
$teams = $teams_stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $game_id = isset($_POST['game_id']) ? (int)$_POST['game_id'] : '';
    $game_date_est = isset($_POST['game_date_est']) ? trim($_POST['game_date_est']) : '';
    $team_abbreviation_home = isset($_POST['team_abbreviation_home']) ? trim($_POST['team_abbreviation_home']) : '';
    $pts_home = isset($_POST['pts_home']) ? (int)$_POST['pts_home'] : '';
    $team_abbreviation_away = isset($_POST['team_abbreviation_away']) ? trim($_POST['team_abbreviation_away']) : '';
    $pts_away = isset($_POST['pts_away']) ? (int)$_POST['pts_away'] : '';
    
    // Validate form data
    $errors = [];
    
    if (empty($game_id)) {
        $errors[] = "L'ID du match est requis";
    }
    
    if (empty($game_date_est)) {
        $errors[] = "La date du match est requise";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $game_date_est)) {
        $errors[] = "La date doit être au format YYYY-MM-DD";
    }
    
    if (empty($team_abbreviation_home)) {
        $errors[] = "L'équipe à domicile est requise";
    }
    
    if (!is_numeric($pts_home)) {
        $errors[] = "Les points de l'équipe à domicile doivent être un nombre";
    }
    
    if (empty($team_abbreviation_away)) {
        $errors[] = "L'équipe à l'extérieur est requise";
    }
    
    if (!is_numeric($pts_away)) {
        $errors[] = "Les points de l'équipe à l'extérieur doivent être un nombre";
    }
    
    if ($team_abbreviation_home === $team_abbreviation_away) {
        $errors[] = "Les équipes à domicile et à l'extérieur doivent être différentes";
    }
    
    // If no errors, insert data
    if (empty($errors)) {
        try {
            // Check if match already exists
            $check_sql = "SELECT COUNT(*) FROM match WHERE game_id = :game_id";
            $check_stmt = $db->prepare($check_sql);
            $check_stmt->bindParam(':game_id', $game_id);
            $check_stmt->execute();
            
            if ($check_stmt->fetchColumn() > 0) {
                $errors[] = "Un match avec cet ID existe déjà";
            } else {
                // Insert new match
                $sql = "INSERT INTO match (game_id, game_date_est, team_abbreviation_home, pts_home, team_abbreviation_away, pts_away) 
                        VALUES (:game_id, :game_date_est, :team_abbreviation_home, :pts_home, :team_abbreviation_away, :pts_away)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':game_id', $game_id);
                $stmt->bindParam(':game_date_est', $game_date_est);
                $stmt->bindParam(':team_abbreviation_home', $team_abbreviation_home);
                $stmt->bindParam(':pts_home', $pts_home);
                $stmt->bindParam(':team_abbreviation_away', $team_abbreviation_away);
                $stmt->bindParam(':pts_away', $pts_away);
                $stmt->execute();
                
                // Redirect to the match list with success message
                $_SESSION['flash_message'] = "Le match a été ajouté avec succès";
                header('Location: index.php?element=matchs');
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'ajout du match: " . $e->getMessage();
        }
    }
    
    // If we're here, there were errors, store them in session
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = [
        'game_id' => $game_id,
        'game_date_est' => $game_date_est,
        'team_abbreviation_home' => $team_abbreviation_home,
        'pts_home' => $pts_home,
        'team_abbreviation_away' => $team_abbreviation_away,
        'pts_away' => $pts_away
    ];
}
