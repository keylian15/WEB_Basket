<?php
/**
 * Controller for the prediction page
 */

// Assurer que la session est démarrée
session_start();

// Check if user is logged in
include 'check_login.php';

// Get the action to perform
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// API endpoints
define('API_PREDICTION_URL', 'http://62.72.18.63:11042/prediction/team');

// Variables for prediction form
$prediction_result = null;
$error_message = '';
$home_team = isset($_POST['home_team']) ? $_POST['home_team'] : '';
$away_team = isset($_POST['away_team']) ? $_POST['away_team'] : '';

// Fetch teams for dropdown selection
$sql_teams = "SELECT DISTINCT abr_equipe, team_name FROM team WHERE saison = (SELECT MAX(saison) FROM team WHERE saison < 2026) ORDER BY team_name";
$stmt_teams = $db->prepare($sql_teams);
$stmt_teams->execute();
$teams = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);

// Function to get prediction
function getPrediction($home_team, $away_team, $token) {
    if (empty($home_team) || empty($away_team)) {
        return null;
    }
    
    $prediction_url = API_PREDICTION_URL . "/{$home_team}/{$away_team}";
    
    $ch = curl_init($prediction_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: Bearer {$token}"
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Debug information
    if ($http_code !== 200) {
        error_log("API Prediction Error: HTTP Code $http_code, Response: $response");
    }
    
    curl_close($ch);
    
    if ($http_code === 200) {
        return json_decode($response, true);
    }
    
    return null;
}

switch ($action) {
    default:
        // Default action - show prediction form and results
        $pageTitle = "Prédiction de matchs";
        $element = "prediction";
        
        // Process prediction request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['predict'])) {
            // Check if we have a token in session
            if (isset($_SESSION['token_api']) && !empty($_SESSION['token_api'])) {
                // Get prediction with token from session
                $prediction_result = getPrediction($home_team, $away_team, $_SESSION['token_api']);
                
                if (!$prediction_result) {
                    $error_message = "Erreur lors de la récupération de la prédiction.";
                }
            } else {
                $error_message = "Token d'authentification manquant. Veuillez vous reconnecter.";
            }
        }
        
        break;
}
?>