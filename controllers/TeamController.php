<?php
/**
 * Contrôleur pour la gestion des équipes
 */
class TeamsController extends Controller {
    /**
     * Modèle d'équipe
     * 
     * @var TeamModel
     */
    private $teamModel;
    
    /**
     * Modèle de joueur
     * 
     * @var PlayerModel
     */
    private $playerModel;
    
    /**
     * Modèle de match
     * 
     * @var MatchModel
     */
    private $matchModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        // Charger les modèles nécessaires
        $this->teamModel = $this->model('TeamModel');
        $this->playerModel = $this->model('PlayerModel');
        $this->matchModel = $this->model('MatchModel');
    }
    
    /**
     * Page d'index des équipes
     * 
     * @return void
     */
    public function index() {
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        // Récupérer les équipes avec pagination
        $teams = $this->teamModel->getAllTeams($perPage, $offset);
        
        // Compter le nombre total d'équipes pour la pagination
        $totalTeams = $this->teamModel->countTeams();
        $totalPages = ceil($totalTeams / $perPage);
        
        // Charger la vue
        $this->view('teams/index', [
            'title' => 'Équipes NBA | ' . APP_NAME,
            'teams' => $teams,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalTeams' => $totalTeams
        ]);
    }
    
    /**
     * Afficher les détails d'une équipe
     * 
     * @param int $id ID de l'équipe
     * @return void
     */
    public function view($id) {
        // Récupérer les détails de l'équipe
        $team = $this->teamModel->getTeamById($id);
        
        // Vérifier si l'équipe existe
        if (!$team) {
            $this->setFlash('Équipe non trouvée.', 'danger');
            redirect('teams');
            return;
        }
        
        // Récupérer les joueurs de l'équipe
        $players = $this->playerModel->getPlayersByTeam($id);
        
        // Récupérer les derniers matchs de l'équipe
        $recentMatches = $this->matchModel->getMatchesByTeam($id, 5);
        
        // Savoir si l'équipe est dans les favoris de l'utilisateur
        $isFavorite = false;
        if (isLoggedIn()) {
            $favoriteTeams = (new UserModel())->getFavoriteTeams($_SESSION['user_id']);
            $isFavorite = array_search($id, array_column($favoriteTeams, 'id_club')) !== false;
        }
        
        // Charger la vue
        $this->view('teams/view', [
            'title' => $team['ville_club'] . ' ' . $team['surnom_club'] . ' | ' . APP_NAME,
            'team' => $team,
            'players' => $players,
            'recentMatches' => $recentMatches,
            'isFavorite' => $isFavorite
        ]);
    }
    
    /**
     * Afficher les équipes par conférence
     * 
     * @param string $conference Conférence ('East' ou 'West')
     * @return void
     */
    public function conference($conference) {
        // Valider la conférence
        if ($conference !== 'East' && $conference !== 'West') {
            $this->setFlash('Conférence non valide.', 'danger');
            redirect('teams');
            return;
        }
        
        // Récupérer les équipes de la conférence
        $teams = $this->teamModel->getTeamsByConference($conference);
        
        // Charger la vue
        $this->view('teams/conference', [
            'title' => 'Équipes de la conférence ' . ($conference === 'East' ? 'Est' : 'Ouest') . ' | ' . APP_NAME,
            'teams' => $teams,
            'conference' => $conference
        ]);
    }
    
    /**
     * Ajouter une équipe aux favoris
     * 
     * @param int $id ID de l'équipe
     * @return void
     */
    public function favorite($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour ajouter une équipe aux favoris.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('teams/view/' . $id);
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('teams/view/' . $id);
            return;
        }
        
        // Récupérer les détails de l'équipe
        $team = $this->teamModel->getTeamById($id);
        
        // Vérifier si l'équipe existe
        if (!$team) {
            $this->setFlash('Équipe non trouvée.', 'danger');
            redirect('teams');
            return;
        }
        
        // Ajouter l'équipe aux favoris
        $success = (new UserModel())->addFavoriteTeam($_SESSION['user_id'], $id);
        
        if ($success) {
            $this->setFlash('Équipe ajoutée aux favoris.', 'success');
        } else {
            $this->setFlash('Erreur lors de l\'ajout de l\'équipe aux favoris.', 'danger');
        }
        
        redirect('teams/view/' . $id);
    }
    
    /**
     * Retirer une équipe des favoris
     * 
     * @param int $id ID de l'équipe
     * @return void
     */
    public function unfavorite($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour retirer une équipe des favoris.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('teams/view/' . $id);
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('teams/view/' . $id);
            return;
        }
        
        // Récupérer les détails de l'équipe
        $team = $this->teamModel->getTeamById($id);
        
        // Vérifier si l'équipe existe
        if (!$team) {
            $this->setFlash('Équipe non trouvée.', 'danger');
            redirect('teams');
            return;
        }
        
        // Retirer l'équipe des favoris
        $success = (new UserModel())->removeFavoriteTeam($_SESSION['user_id'], $id);
        
        if ($success) {
            $this->setFlash('Équipe retirée des favoris.', 'success');
        } else {
            $this->setFlash('Erreur lors du retrait de l\'équipe des favoris.', 'danger');
        }
        
        redirect('teams/view/' . $id);
    }
    
    /**
     * Afficher le formulaire d'ajout d'équipe
     * 
     * @return void
     */
    public function add() {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('teams');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            // ...
            
            // Ajouter l'équipe
            $teamId = $this->teamModel->addTeam($_POST);
            
            if ($teamId) {
                $this->setFlash('Équipe ajoutée avec succès.', 'success');
                redirect('teams/view/' . $teamId);
            } else {
                $this->setFlash('Erreur lors de l\'ajout de l\'équipe.', 'danger');
            }
        }
        
        // Charger la vue
        $this->view('teams/add', [
            'title' => 'Ajouter une équipe | ' . APP_NAME
        ]);
    }
    
    /**
     * Afficher le formulaire de modification d'équipe
     * 
     * @param int $id ID de l'équipe
     * @return void
     */
    public function edit($id) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('teams');
            return;
        }
        
        // Récupérer les détails de l'équipe
        $team = $this->teamModel->getTeamById($id);
        
        // Vérifier si l'équipe existe
        if (!$team) {
            $this->setFlash('Équipe non trouvée.', 'danger');
            redirect('teams');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            // ...
            
            // Mettre à jour l'équipe
            $success = $this->teamModel->updateTeam($id, $_POST);
            
            if ($success) {
                $this->setFlash('Équipe mise à jour avec succès.', 'success');
                redirect('teams/view/' . $id);
            } else {
                $this->setFlash('Erreur lors de la mise à jour de l\'équipe.', 'danger');
            }
        }
        
        // Charger la vue
        $this->view('teams/edit', [
            'title' => 'Modifier l\'équipe | ' . APP_NAME,
            'team' => $team
        ]);
    }
    
    /**
     * Supprimer une équipe
     * 
     * @param int $id ID de l'équipe
     * @return void
     */
    public function delete($id) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('teams');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('teams');
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('teams');
            return;
        }
        
        // Supprimer l'équipe
        $success = $this->teamModel->deleteTeam($id);
        
        if ($success) {
            $this->setFlash('Équipe supprimée avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors de la suppression de l\'équipe.', 'danger');
        }
        
        redirect('teams');
    }
    
    /**
     * Rechercher des équipes
     * 
     * @return void
     */
    public function search() {
        // Récupérer le terme de recherche
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($search)) {
            redirect('teams');
            return;
        }
        
        // Effectuer la recherche
        $teams = $this->teamModel->searchTeams($search);
        
        // Charger la vue
        $this->view('teams/search', [
            'title' => 'Recherche d\'équipes | ' . APP_NAME,
            'teams' => $teams,
            'search' => $search
        ]);
    }
    
    /**
     * Comparer deux équipes
     * 
     * @return void
     */
    public function compare() {
        // Récupérer les IDs des équipes à comparer
        $team1Id = isset($_GET['team1']) ? $_GET['team1'] : null;
        $team2Id = isset($_GET['team2']) ? $_GET['team2'] : null;
        
        // Récupérer la liste de toutes les équipes pour le formulaire
        $allTeams = $this->teamModel->getAllTeams();
        
        // Si les deux équipes sont spécifiées, charger leurs données
        $team1 = null;
        $team2 = null;
        $headToHead = null;
        
        if ($team1Id && $team2Id) {
            $team1 = $this->teamModel->getTeamById($team1Id);
            $team2 = $this->teamModel->getTeamById($team2Id);
            
            // Récupérer les confrontations directes (à implémenter)
            $headToHead = [];
        }
        
        // Charger la vue
        $this->view('teams/compare', [
            'title' => 'Comparer des équipes | ' . APP_NAME,
            'allTeams' => $allTeams,
            'team1' => $team1,
            'team2' => $team2,
            'headToHead' => $headToHead
        ]);
    }
}