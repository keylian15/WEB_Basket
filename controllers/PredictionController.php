<?php
/**
 * Contrôleur pour la gestion des prédictions
 */
class PredictionsController extends Controller {
    /**
     * Modèle de prédiction
     * 
     * @var PredictionModel
     */
    private $predictionModel;
    
    /**
     * Modèle d'équipe
     * 
     * @var TeamModel
     */
    private $teamModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        // Charger les modèles nécessaires
        $this->predictionModel = $this->model('PredictionModel');
        $this->teamModel = $this->model('TeamModel');
    }
    
    /**
     * Page d'index des prédictions
     * 
     * @return void
     */
    public function index() {
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        // Filtrage
        $teamId = isset($_GET['team_id']) ? $_GET['team_id'] : null;
        $confidence = isset($_GET['confidence']) ? $_GET['confidence'] : null;
        
        // Récupérer les prédictions avec pagination et filtrage
        $predictions = $this->predictionModel->getAllPredictions($perPage, $offset);
        
        // Compter le nombre total de prédictions pour la pagination
        $totalPredictions = $this->predictionModel->countPredictions();
        $totalPages = ceil($totalPredictions / $perPage);
        
        // Récupérer la liste des équipes pour le filtre
        $teams = $this->teamModel->getAllTeams();
        
        // Charger la vue
        $this->view('predictions/index', [
            'title' => 'Prédictions NBA | ' . APP_NAME,
            'predictions' => $predictions,
            'teams' => $teams,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPredictions' => $totalPredictions,
            'teamId' => $teamId,
            'confidence' => $confidence
        ]);
    }
    
    /**
     * Afficher les détails d'une prédiction
     * 
     * @param int $id ID de la prédiction
     * @return void
     */
    public function view($id) {
        // Récupérer les détails de la prédiction
        $prediction = $this->predictionModel->getPredictionById($id);
        
        // Vérifier si la prédiction existe
        if (!$prediction) {
            $this->setFlash('Prédiction non trouvée.', 'danger');
            redirect('predictions');
            return;
        }
        
        // Récupérer les détails des équipes
        $homeTeam = $this->teamModel->getTeamById($prediction['id_equipe_domicile']);
        $awayTeam = $this->teamModel->getTeamById($prediction['id_equipe_exterieure']);
        
        // Charger la vue
        $this->view('predictions/view', [
            'title' => 'Prédiction: ' . $prediction['equipe_domicile'] . ' vs ' . $prediction['equipe_exterieure'] . ' | ' . APP_NAME,
            'prediction' => $prediction,
            'homeTeam' => $homeTeam,
            'awayTeam' => $awayTeam
        ]);
    }
    
    /**
     * Générer une nouvelle prédiction
     * 
     * @return void
     */
    public function generate() {
        // Récupérer les IDs des équipes
        $homeTeamId = isset($_GET['home_team']) ? $_GET['home_team'] : null;
        $awayTeamId = isset($_GET['away_team']) ? $_GET['away_team'] : null;
        
        // Récupérer la liste de toutes les équipes pour le formulaire
        $teams = $this->teamModel->getAllTeams();
        
        // Si les équipes sont spécifiées, générer la prédiction
        $prediction = null;
        if ($homeTeamId && $awayTeamId) {
            // Vérifier que les équipes existent
            $homeTeam = $this->teamModel->getTeamById($homeTeamId);
            $awayTeam = $this->teamModel->getTeamById($awayTeamId);
            
            if (!$homeTeam || !$awayTeam) {
                $this->setFlash('Équipe non trouvée.', 'danger');
                redirect('predictions/generate');
                return;
            }
            
            // Vérifier que les équipes sont différentes
            if ($homeTeamId === $awayTeamId) {
                $this->setFlash('Veuillez sélectionner deux équipes différentes.', 'danger');
                redirect('predictions/generate');
                return;
            }
            
            // Générer la prédiction
            $userId = isLoggedIn() ? $_SESSION['user_id'] : null;
            $prediction = $this->predictionModel->generatePrediction($homeTeamId, $awayTeamId, $userId);
            
            // Si l'utilisateur est connecté, rediriger vers la prédiction sauvegardée
            if (isLoggedIn() && isset($prediction['id_prediction'])) {
                $this->setFlash('Prédiction générée avec succès.', 'success');
                redirect('predictions/view/' . $prediction['id_prediction']);
                return;
            }
        }
        
        // Charger la vue
        $this->view('predictions/generate', [
            'title' => 'Générer une prédiction | ' . APP_NAME,
            'teams' => $teams,
            'homeTeamId' => $homeTeamId,
            'awayTeamId' => $awayTeamId,
            'prediction' => $prediction
        ]);
    }
    
    /**
     * Afficher les prédictions d'un utilisateur
     * 
     * @return void
     */
    public function user() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour voir vos prédictions.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        // Récupérer les prédictions de l'utilisateur avec pagination
        $predictions = $this->predictionModel->getUserPredictions($_SESSION['user_id'], $perPage, $offset);
        
        // Compter le nombre total de prédictions pour la pagination
        $totalPredictions = $this->predictionModel->countUserPredictions($_SESSION['user_id']);
        $totalPages = ceil($totalPredictions / $perPage);
        
        // Récupérer les statistiques de précision
        $accuracy = $this->predictionModel->getUserPredictionAccuracy($_SESSION['user_id']);
        
        // Charger la vue
        $this->view('predictions/user', [
            'title' => 'Mes prédictions | ' . APP_NAME,
            'predictions' => $predictions,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPredictions' => $totalPredictions,
            'accuracy' => $accuracy
        ]);
    }
    
    /**
     * Supprimer une prédiction
     * 
     * @param int $id ID de la prédiction
     * @return void
     */
    public function delete($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour supprimer une prédiction.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('predictions');
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('predictions');
            return;
        }
        
        // Récupérer les détails de la prédiction
        $prediction = $this->predictionModel->getPredictionById($id);
        
        // Vérifier si la prédiction existe et appartient à l'utilisateur
        if (!$prediction || $prediction['id_utilisateur'] != $_SESSION['user_id']) {
            $this->setFlash('Prédiction non trouvée ou vous n\'êtes pas autorisé à la supprimer.', 'danger');
            redirect('predictions');
            return;
        }
        
        // Supprimer la prédiction
        $success = $this->predictionModel->deletePrediction($id, $_SESSION['user_id']);
        
        if ($success) {
            $this->setFlash('Prédiction supprimée avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors de la suppression de la prédiction.', 'danger');
        }
        
        redirect('predictions/user');
    }
    
    /**
     * Afficher le tableau de bord de prédictions
     * 
     * @return void
     */
    public function dashboard() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour accéder au tableau de bord.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Récupérer les prédictions récentes de l'utilisateur
        $recentPredictions = $this->predictionModel->getUserPredictions($_SESSION['user_id'], 5);
        
        // Récupérer les statistiques de précision
        $accuracy = $this->predictionModel->getUserPredictionAccuracy($_SESSION['user_id']);
        
        // Récupérer les équipes favorites
        $favoriteTeams = (new UserModel())->getFavoriteTeams($_SESSION['user_id']);
        
        // Charger la vue
        $this->view('predictions/dashboard', [
            'title' => 'Tableau de bord des prédictions | ' . APP_NAME,
            'recentPredictions' => $recentPredictions,
            'accuracy' => $accuracy,
            'favoriteTeams' => $favoriteTeams
        ]);
    }
}