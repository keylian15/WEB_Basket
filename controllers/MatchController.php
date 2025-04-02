<?php
/**
 * Contrôleur pour la gestion des matchs
 */
class MatchesController extends Controller {
    /**
     * Modèle de match
     * 
     * @var MatchModel
     */
    private $matchModel;
    
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
        $this->matchModel = $this->model('MatchModel');
        $this->teamModel = $this->model('TeamModel');
    }
    
    /**
     * Page d'index des matchs
     * 
     * @return void
     */
    public function index() {
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        // Récupérer les matchs avec pagination
        $matches = $this->matchModel->getAllMatches($perPage, $offset);
        
        // Compter le nombre total de matchs pour la pagination
        $totalMatches = $this->matchModel->countMatches();
        $totalPages = ceil($totalMatches / $perPage);
        
        // Charger la vue
        $this->view('matches/index', [
            'title' => 'Matchs NBA | ' . APP_NAME,
            'matches' => $matches,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalMatches' => $totalMatches
        ]);
    }
    
    /**
     * Afficher les détails d'un match
     * 
     * @param int $id ID du match
     * @return void
     */
    public function view($id) {
        // Récupérer les détails du match
        $match = $this->matchModel->getMatchById($id);
        
        // Vérifier si le match existe
        if (!$match) {
            $this->setFlash('Match non trouvé.', 'danger');
            redirect('matches');
            return;
        }
        
        // Récupérer les statistiques du match
        $stats = $this->matchModel->getMatchStats($id);
        
        // Récupérer les détails des équipes
        $homeTeam = $this->teamModel->getTeamById($match['id_equipe']);
        $awayTeam = $this->teamModel->getTeamById($match['id_équipe_extérieure']);
        
        // Charger la vue
        $this->view('matches/view', [
            'title' => $match['ville_equipe_domicile'] . ' vs ' . $match['ville_equipe_extérieure'] . ' | ' . APP_NAME,
            'match' => $match,
            'stats' => $stats,
            'homeTeam' => $homeTeam,
            'awayTeam' => $awayTeam
        ]);
    }
    
    /**
     * Page des matchs d'une équipe
     * 
     * @param int $teamId ID de l'équipe
     * @return void
     */
    public function team($teamId) {
        // Récupérer les détails de l'équipe
        $team = $this->teamModel->getTeamById($teamId);
        
        // Vérifier si l'équipe existe
        if (!$team) {
            $this->setFlash('Équipe non trouvée.', 'danger');
            redirect('teams');
            return;
        }
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        // Récupérer les matchs de l'équipe avec pagination
        $matches = $this->matchModel->getMatchesByTeam($teamId, $perPage, $offset);
        
        // Compter le nombre total de matchs pour la pagination
        // On simplifierait avec une requête COUNT(*) spécifique dans une application réelle
        $totalMatches = count($this->matchModel->getMatchesByTeam($teamId));
        $totalPages = ceil($totalMatches / $perPage);
        
        // Charger la vue
        $this->view('matches/team', [
            'title' => 'Matchs de ' . $team['ville_club'] . ' | ' . APP_NAME,
            'team' => $team,
            'matches' => $matches,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalMatches' => $totalMatches
        ]);
    }
    
    /**
     * Afficher le formulaire d'ajout de match
     * 
     * @return void
     */
    public function add() {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('matches');
            return;
        }
        
        // Récupérer la liste des équipes pour le formulaire
        $teams = $this->teamModel->getAllTeams();
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            // ...
            
            // Ajouter le match
            $matchId = $this->matchModel->addMatch($_POST);
            
            if ($matchId) {
                $this->setFlash('Match ajouté avec succès.', 'success');
                redirect('matches/view/' . $matchId);
            } else {
                $this->setFlash('Erreur lors de l\'ajout du match.', 'danger');
            }
        }
        
        // Charger la vue
        $this->view('matches/add', [
            'title' => 'Ajouter un match | ' . APP_NAME,
            'teams' => $teams
        ]);
    }
    
    /**
     * Afficher le formulaire de modification de match
     * 
     * @param int $id ID du match
     * @return void
     */
    public function edit($id) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('matches');
            return;
        }
        
        // Récupérer les détails du match
        $match = $this->matchModel->getMatchById($id);
        
        // Vérifier si le match existe
        if (!$match) {
            $this->setFlash('Match non trouvé.', 'danger');
            redirect('matches');
            return;
        }
        
        // Récupérer la liste des équipes pour le formulaire
        $teams = $this->teamModel->getAllTeams();
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            // ...
            
            // Mettre à jour le match
            $success = $this->matchModel->updateMatch($id, $_POST);
            
            if ($success) {
                $this->setFlash('Match mis à jour avec succès.', 'success');
                redirect('matches/view/' . $id);
            } else {
                $this->setFlash('Erreur lors de la mise à jour du match.', 'danger');
            }
        }
        
        // Charger la vue
        $this->view('matches/edit', [
            'title' => 'Modifier le match | ' . APP_NAME,
            'match' => $match,
            'teams' => $teams
        ]);
    }
    
    /**
     * Supprimer un match
     * 
     * @param int $id ID du match
     * @return void
     */
    public function delete($id) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('matches');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('matches');
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('matches');
            return;
        }
        
        // Supprimer le match
        $success = $this->matchModel->deleteMatch($id);
        
        if ($success) {
            $this->setFlash('Match supprimé avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors de la suppression du match.', 'danger');
        }
        
        redirect('matches');
    }
    
    /**
     * Rechercher des matchs
     * 
     * @return void
     */
    public function search() {
        // Récupérer le terme de recherche
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($search)) {
            redirect('matches');
            return;
        }
        
        // Effectuer la recherche
        $matches = []; // Méthode à implémenter
        
        // Charger la vue
        $this->view('matches/search', [
            'title' => 'Recherche de matchs | ' . APP_NAME,
            'matches' => $matches,
            'search' => $search
        ]);
    }
}