<?php
/**
 * Controller for the classement pages
 */

// Check if user is logged in
include 'check_login.php';

// Get the action to perform
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Number of entries per page
$per_page = 50;

switch ($action) {
    default:
        // Default action - show rankings page
        $pageTitle = "Classements";
        $element = "classement";
        
        // Active tab - Get it first so we can preserve it when changing season
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'teams';
        
        // Get current page numbers for each tab
        $teams_page = isset($_GET['teams_page']) ? intval($_GET['teams_page']) : 1;
        $points_page = isset($_GET['points_page']) ? intval($_GET['points_page']) : 1;
        $fg_page = isset($_GET['fg_page']) ? intval($_GET['fg_page']) : 1;
        $minutes_page = isset($_GET['minutes_page']) ? intval($_GET['minutes_page']) : 1;
        $shot_page = isset($_GET['shot_page']) ? intval($_GET['shot_page']) : 1;
        
        // Get available seasons from the database
        // Note: This query extracts unique season values from classement_team_pts
        $query = "SELECT DISTINCT saison as id, saison as nom FROM classement_team_pts ORDER BY saison DESC";
        $all_seasons = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        
        // If no seasons found, create a default one to avoid errors
        if (empty($all_seasons)) {
            $all_seasons = [['id' => 1, 'nom' => 'Saison 1']];
        }
        
        // Get the selected season (default to the most recent one)
        $default_season_id = $all_seasons[0]['id'];
        $selected_season = isset($_GET['season']) ? intval($_GET['season']) : $default_season_id;
        
        // Calculate offsets
        $teams_offset = ($teams_page - 1) * $per_page;
        $points_offset = ($points_page - 1) * $per_page;
        $fg_offset = ($fg_page - 1) * $per_page;
        $minutes_offset = ($minutes_page - 1) * $per_page;
        $shot_offset = ($shot_page - 1) * $per_page;
        
        // Get Teams Ranking Data - Count total
        $query = "SELECT COUNT(*) as total FROM classement_team_pts WHERE saison = :saison";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $teams_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $teams_total_pages = ceil($teams_total / $per_page);
        
        // Get Teams Ranking Data - Paginated
        $query = "SELECT * FROM classement_team_pts WHERE saison = :saison ORDER BY classement ASC LIMIT $per_page OFFSET $teams_offset";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $teams_ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get Players Points Ranking Data - Count total
        $query = "SELECT COUNT(*) as total FROM classement_joueurs_points WHERE saison = :saison";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $points_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $points_total_pages = ceil($points_total / $per_page);
        
        // Get Players Points Ranking Data - Paginated
        $query = "SELECT * FROM classement_joueurs_points WHERE saison = :saison ORDER BY position ASC LIMIT $per_page OFFSET $points_offset";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $players_points_ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get Players FG Ranking Data - Count total
        $query = "SELECT COUNT(*) as total FROM classement_joueurs_fg WHERE saison = :saison";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $fg_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $fg_total_pages = ceil($fg_total / $per_page);
        
        // Get Players FG Ranking Data - Paginated
        $query = "SELECT * FROM classement_joueurs_fg WHERE saison = :saison ORDER BY position ASC LIMIT $per_page OFFSET $fg_offset";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $players_fg_ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get Players Minutes Ranking Data - Count total
        $query = "SELECT COUNT(*) as total FROM classement_joueurs_minutes WHERE saison = :saison";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $minutes_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $minutes_total_pages = ceil($minutes_total / $per_page);
        
        // Get Players Minutes Ranking Data - Paginated
        $query = "SELECT * FROM classement_joueurs_minutes WHERE saison = :saison ORDER BY position ASC LIMIT $per_page OFFSET $minutes_offset";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $players_minutes_ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get Players Shot Ranking Data - Count total
        $query = "SELECT COUNT(*) as total FROM classement_joueurs_tir WHERE saison = :saison";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $shot_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $shot_total_pages = ceil($shot_total / $per_page);
        
        // Get Players Shot Ranking Data - Paginated
        $query = "SELECT * FROM classement_joueurs_tir WHERE saison = :saison ORDER BY position ASC LIMIT $per_page OFFSET $shot_offset";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':saison', $selected_season, PDO::PARAM_INT);
        $stmt->execute();
        $players_shot_ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Initialize variables used in the footer
        $confirm = $confirm ?? '';
        $errors = $errors ?? [];
        
        break;
}
?>