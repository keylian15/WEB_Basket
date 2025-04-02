<?php
/**
 * Contrôleur pour la gestion des joueurs
 */
class PlayersController extends Controller {
    /**
     * Modèle de joueur
     * 
     * @var PlayerModel
     */
    private $playerModel;
    
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
        $this->playerModel = $this->model('PlayerModel');
        $this->teamModel = $this->model('TeamModel');
    }
    
    /**
     * Page d'index des joueurs
     * 
     * @return void
     */
    public function index() {
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        
        // Filtrage par statut (actif/inactif)
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        
        // Récupérer les joueurs avec pagination et filtrage
        if ($status === 'active') {
            $players = $this->playerModel->getActivePlayers($perPage, $offset);
            $totalPlayers = $this->playerModel->countActivePlayers();
        } else {
            $players = $this->playerModel->getAllPlayers($perPage, $offset);
            $totalPlayers = $this->playerModel->countPlayers();
        }
        
        // Calculer le nombre total de pages pour la pagination
        $totalPages = ceil($totalPlayers / $perPage);
        
        // Charger la vue
        $this->view('players/index', [
            'title' => 'Joueurs NBA | ' . APP_NAME,
            'players' => $players,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPlayers' => $totalPlayers,
            'status' => $status
        ]);
    }
    
    /**
     * Afficher les détails d'un joueur
     * 
     * @param int $id ID du joueur
     * @return void
     */
    public function view($id) {
        // Récupérer les détails du joueur
        $player = $this->playerModel->getPlayerById($id);
        
        // Vérifier si le joueur existe
        if (!$player) {
            $this->setFlash('Joueur non trouvé.', 'danger');
            redirect('players');
            return;
        }
        
        // Charger la vue
        $this->view('players/view', [
            'title' => $player['full_name'] . ' | ' . APP_NAME,
            'player' => $player
        ]);
    }
    
    /**
     * Afficher les joueurs par équipe
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
        
        // Récupérer les joueurs de l'équipe
        $players = $this->playerModel->getPlayersByTeam($teamId);
        
        // Charger la vue
        $this->view('players/team', [
            'title' => 'Joueurs de ' . $team['ville_club'] . ' ' . $team['surnom_club'] . ' | ' . APP_NAME,
            'team' => $team,
            'players' => $players
        ]);
    }
    
    /**
     * Rechercher des joueurs
     * 
     * @return void
     */
    public function search() {
        // Récupérer le terme de recherche
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($search)) {
            redirect('players');
            return;
        }
        
        // Effectuer la recherche
        $players = $this->playerModel->searchPlayers($search);
        
        // Charger la vue
        $this->view('players/search', [
            'title' => 'Recherche de joueurs | ' . APP_NAME,
            'players' => $players,
            'search' => $search
        ]);
    }
    
    /**
     * Afficher le formulaire d'ajout de joueur
     * 
     * @return void
     */
    public function add() {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('players');
            return;
        }
        
        // Récupérer la liste des équipes pour le formulaire
        $teams = $this->teamModel->getAllTeams();
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            $errors = [];
            
            // Valider le prénom
            if (empty($_POST['prenom_joueur'])) {
                $errors['prenom_joueur'] = 'Le prénom est requis';
            }
            
            // Valider le nom
            if (empty($_POST['nom_joueur'])) {
                $errors['nom_joueur'] = 'Le nom est requis';
            }
            
            // S'il n'y a pas d'erreurs, ajouter le joueur
            if (empty($errors)) {
                $playerData = [
                    'prenom_joueur' => $_POST['prenom_joueur'],
                    'nom_joueur' => $_POST['nom_joueur'],
                    'est_actif' => isset($_POST['est_actif']) ? true : false
                ];
                
                $playerId = $this->playerModel->addPlayer($playerData);
                
                if ($playerId) {
                    // Si un ID d'équipe est fourni, ajouter le joueur à l'équipe
                    if (!empty($_POST['id_equipe'])) {
                        $this->playerModel->addPlayerToTeam(
                            $playerId,
                            $_POST['id_equipe'],
                            $_POST['numero_maillot_joueur'] ?? 0
                        );
                    }
                    
                    $this->setFlash('Joueur ajouté avec succès.', 'success');
                    redirect('players/view/' . $playerId);
                } else {
                    $this->setFlash('Erreur lors de l\'ajout du joueur.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('players/add', [
            'title' => 'Ajouter un joueur | ' . APP_NAME,
            'teams' => $teams,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Afficher le formulaire de modification de joueur
     * 
     * @param int $id ID du joueur
     * @return void
     */
    public function edit($id) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('players');
            return;
        }
        
        // Récupérer les détails du joueur
        $player = $this->playerModel->getPlayerById($id);
        
        // Vérifier si le joueur existe
        if (!$player) {
            $this->setFlash('Joueur non trouvé.', 'danger');
            redirect('players');
            return;
        }
        
        // Récupérer la liste des équipes pour le formulaire
        $teams = $this->teamModel->getAllTeams();
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            $errors = [];
            
            // Valider le prénom
            if (empty($_POST['prenom_joueur'])) {
                $errors['prenom_joueur'] = 'Le prénom est requis';
            }
            
            // Valider le nom
            if (empty($_POST['nom_joueur'])) {
                $errors['nom_joueur'] = 'Le nom est requis';
            }
            
            // S'il n'y a pas d'erreurs, mettre à jour le joueur
            if (empty($errors)) {
                $playerData = [
                    'prenom_joueur' => $_POST['prenom_joueur'],
                    'nom_joueur' => $_POST['nom_joueur'],
                    'est_actif' => isset($_POST['est_actif']) ? true : false
                ];
                
                $success = $this->playerModel->updatePlayer($id, $playerData);
                
                if ($success) {
                    // Si un ID d'équipe est fourni, mettre à jour l'équipe du joueur
                    if (!empty($_POST['id_equipe'])) {
                        $this->playerModel->addPlayerToTeam(
                            $id,
                            $_POST['id_equipe'],
                            $_POST['numero_maillot_joueur'] ?? 0
                        );
                    }
                    
                    $this->setFlash('Joueur mis à jour avec succès.', 'success');
                    redirect('players/view/' . $id);
                } else {
                    $this->setFlash('Erreur lors de la mise à jour du joueur.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('players/edit', [
            'title' => 'Modifier le joueur | ' . APP_NAME,
            'player' => $player,
            'teams' => $teams,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Supprimer un joueur
     * 
     * @param int $id ID du joueur
     * @return void
     */
    public function delete($id) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('players');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('players');
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('players');
            return;
        }
        
        // Supprimer le joueur
        $success = $this->playerModel->deletePlayer($id);
        
        if ($success) {
            $this->setFlash('Joueur supprimé avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors de la suppression du joueur.', 'danger');
        }
        
        redirect('players');
    }
    
    /**
     * Ajouter un joueur à une équipe
     * 
     * @param int $playerId ID du joueur
     * @param int $teamId ID de l'équipe
     * @return void
     */
    public function addToTeam($playerId, $teamId) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('players');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('players/view/' . $playerId);
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('players/view/' . $playerId);
            return;
        }
        
        // Récupérer le numéro de maillot
        $jerseyNumber = isset($_POST['numero_maillot_joueur']) ? (int)$_POST['numero_maillot_joueur'] : 0;
        
        // Ajouter le joueur à l'équipe
        $success = $this->playerModel->addPlayerToTeam($playerId, $teamId, $jerseyNumber);
        
        if ($success) {
            $this->setFlash('Joueur ajouté à l\'équipe avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors de l\'ajout du joueur à l\'équipe.', 'danger');
        }
        
        redirect('players/view/' . $playerId);
    }
    
    /**
     * Retirer un joueur d'une équipe
     * 
     * @param int $playerId ID du joueur
     * @param int $teamId ID de l'équipe
     * @return void
     */
    public function removeFromTeam($playerId, $teamId) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('players');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('players/view/' . $playerId);
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('players/view/' . $playerId);
            return;
        }
        
        // Retirer le joueur de l'équipe
        $success = $this->playerModel->removePlayerFromTeam($playerId, $teamId);
        
        if ($success) {
            $this->setFlash('Joueur retiré de l\'équipe avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors du retrait du joueur de l\'équipe.', 'danger');
        }
        
        redirect('players/view/' . $playerId);
    }
    
    /**
     * Ajouter des informations de draft pour un joueur
     * 
     * @param int $playerId ID du joueur
     * @return void
     */
    public function addDraft($playerId) {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('players');
            return;
        }
        
        // Récupérer les détails du joueur
        $player = $this->playerModel->getPlayerById($playerId);
        
        // Vérifier si le joueur existe
        if (!$player) {
            $this->setFlash('Joueur non trouvé.', 'danger');
            redirect('players');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            $errors = [];
            
            // Valider la saison
            if (empty($_POST['saison'])) {
                $errors['saison'] = 'La saison est requise';
            }
            
            // S'il n'y a pas d'erreurs, ajouter les informations de draft
            if (empty($errors)) {
                $draftData = [
                    'person_id' => $_POST['person_id'] ?? $playerId,
                    'player_id' => $playerId,
                    'nom_joueur' => $player['full_name'],
                    'saison' => $_POST['saison'],
                    'numero_tour' => $_POST['numero_tour'] ?? 1,
                    'choix_tour' => $_POST['choix_tour'] ?? '',
                    'choix_total' => $_POST['choix_total'] ?? '',
                    'type_draft' => $_POST['type_draft'] ?? 'NBA',
                    'player_profile' => $_POST['player_profile'] ?? null
                ];
                
                $success = $this->playerModel->addDraftHistory($draftData);
                
                if ($success) {
                    $this->setFlash('Informations de draft ajoutées avec succès.', 'success');
                    redirect('players/view/' . $playerId);
                } else {
                    $this->setFlash('Erreur lors de l\'ajout des informations de draft.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('players/addDraft', [
            'title' => 'Ajouter des informations de draft | ' . APP_NAME,
            'player' => $player,
            'errors' => $errors ?? []
        ]);
    }
}