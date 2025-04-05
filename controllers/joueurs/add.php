<?php
// Controller for adding a new player

// Initialize variables to store form data
$id_joueur = '';
$abr_equipe = '';
$saison = '';
$nom_joueur = '';
$annee_naissance = '';

// Fetch teams for dropdown
$teams_query = "SELECT DISTINCT abr_equipe, team_name, saison FROM team ORDER BY team_name, saison DESC";
$teams_stmt = $db->prepare($teams_query);
$teams_stmt->execute();
$teams = $teams_stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_joueur = isset($_POST['id_joueur']) ? (int)$_POST['id_joueur'] : '';
    $abr_equipe = isset($_POST['abr_equipe']) ? trim($_POST['abr_equipe']) : '';
    $saison = isset($_POST['saison']) ? (int)$_POST['saison'] : '';
    $nom_joueur = isset($_POST['nom_joueur']) ? trim($_POST['nom_joueur']) : '';
    $annee_naissance = isset($_POST['annee_naissance']) ? (int)$_POST['annee_naissance'] : '';
    $minutes_jouees = isset($_POST['minutes_jouees']) ? (float)$_POST['minutes_jouees'] : 0;
    $pourcent_fg = isset($_POST['pourcent_fg']) ? (float)$_POST['pourcent_fg'] : 0;
    $pourcent_trois_pts = isset($_POST['pourcent_trois_pts']) ? (float)$_POST['pourcent_trois_pts'] : 0;
    $pourcent_efg = isset($_POST['pourcent_efg']) ? (float)$_POST['pourcent_efg'] : 0;
    $pourcent_ft = isset($_POST['pourcent_ft']) ? (float)$_POST['pourcent_ft'] : 0;
    $rebond = isset($_POST['rebond']) ? (int)$_POST['rebond'] : 0;
    $passe = isset($_POST['passe']) ? (int)$_POST['passe'] : 0;
    $interception = isset($_POST['interception']) ? (int)$_POST['interception'] : 0;
    $contre = isset($_POST['contre']) ? (int)$_POST['contre'] : 0;
    $points = isset($_POST['points']) ? (int)$_POST['points'] : 0;
    
    // Validate form data
    $errors = [];
    
    if (empty($nom_joueur)) {
        $errors[] = "Le nom du joueur est requis";
    }
    
    if (empty($abr_equipe)) {
        $errors[] = "L'équipe est requise";
    }
    
    if (empty($saison)) {
        $errors[] = "La saison est requise";
    }
    
    // If no errors, insert data
    if (empty($errors)) {
        try {
            // Check if player already exists for this team and season
            $check_sql = "SELECT COUNT(*) FROM player_par_match WHERE nom_joueur = :nom_joueur AND abr_equipe = :abr_equipe AND saison = :saison";
            $check_stmt = $db->prepare($check_sql);
            $check_stmt->bindParam(':nom_joueur', $nom_joueur);
            $check_stmt->bindParam(':abr_equipe', $abr_equipe);
            $check_stmt->bindParam(':saison', $saison);
            $check_stmt->execute();
            
            if ($check_stmt->fetchColumn() > 0) {
                $errors[] = "Ce joueur existe déjà dans cette équipe pour cette saison";
            } else {
                // Insert new player
                $sql = "INSERT INTO player_par_match (id_joueur, abr_equipe, saison, nom_joueur, annee_naissance, 
                        minutes_jouees, pourcent_fg, pourcent_trois_pts, pourcent_efg, pourcent_ft, 
                        rebond, passe, interception, contre, points) 
                        VALUES (:id_joueur, :abr_equipe, :saison, :nom_joueur, :annee_naissance, 
                        :minutes_jouees, :pourcent_fg, :pourcent_trois_pts, :pourcent_efg, :pourcent_ft, 
                        :rebond, :passe, :interception, :contre, :points)";
                
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id_joueur', $id_joueur);
                $stmt->bindParam(':abr_equipe', $abr_equipe);
                $stmt->bindParam(':saison', $saison);
                $stmt->bindParam(':nom_joueur', $nom_joueur);
                $stmt->bindParam(':annee_naissance', $annee_naissance);
                $stmt->bindParam(':minutes_jouees', $minutes_jouees);
                $stmt->bindParam(':pourcent_fg', $pourcent_fg);
                $stmt->bindParam(':pourcent_trois_pts', $pourcent_trois_pts);
                $stmt->bindParam(':pourcent_efg', $pourcent_efg);
                $stmt->bindParam(':pourcent_ft', $pourcent_ft);
                $stmt->bindParam(':rebond', $rebond);
                $stmt->bindParam(':passe', $passe);
                $stmt->bindParam(':interception', $interception);
                $stmt->bindParam(':contre', $contre);
                $stmt->bindParam(':points', $points);
                $stmt->execute();
                
                // Redirect to the player list with success message
                $_SESSION['flash_message'] = "Le joueur a été ajouté avec succès";
                header('Location: index.php?element=joueurs');
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'ajout du joueur: " . $e->getMessage();
        }
    }
    
    // If we're here, there were errors, store them in session
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = [
        'id_joueur' => $id_joueur,
        'abr_equipe' => $abr_equipe,
        'saison' => $saison,
        'nom_joueur' => $nom_joueur,
        'annee_naissance' => $annee_naissance,
        'minutes_jouees' => $minutes_jouees,
        'pourcent_fg' => $pourcent_fg,
        'pourcent_trois_pts' => $pourcent_trois_pts,
        'pourcent_efg' => $pourcent_efg,
        'pourcent_ft' => $pourcent_ft,
        'rebond' => $rebond,
        'passe' => $passe,
        'interception' => $interception,
        'contre' => $contre,
        'points' => $points
    ];
}
