<?php
/**
 * Contrôleur de la page d'accueil
 */
class HomeController extends Controller {
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
     * Modèle de joueur
     * 
     * @var PlayerModel
     */
    private $playerModel;
    
    /**
     * Modèle de prédiction
     * 
     * @var PredictionModel
     */
    private $predictionModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        // Charger les modèles nécessaires
        $this->matchModel = $this->model('MatchModel');
        $this->teamModel = $this->model('TeamModel');
        $this->playerModel = $this->model('PlayerModel');
        $this->predictionModel = $this->model('PredictionModel');
    }
    
    /**
     * Page d'accueil
     * 
     * @return void
     */
    public function index() {
        // Récupérer les prochains matchs
        $upcomingMatches = $this->matchModel->getUpcomingMatches(3);
        
        // Récupérer les équipes pour les statistiques
        $teamCount = $this->teamModel->countTeams();
        
        // Récupérer les joueurs en vedette
        $featuredPlayers = $this->playerModel->getFeaturedPlayers(4);
        
        // Récupérer les prédictions récentes
        $recentPredictions = $this->predictionModel->getRecentPredictions(5);
        
        // Récupérer les statistiques générales
        $stats = [
            'teamCount' => $teamCount,
            'playerCount' => $this->playerModel->countPlayers(),
            'matchCount' => $this->matchModel->countMatches()
        ];
        
        // Charger la vue
        $this->view('home/index', [
            'title' => APP_NAME . ' - Prédictions NBA',
            'upcomingMatches' => $upcomingMatches,
            'featuredPlayers' => $featuredPlayers,
            'recentPredictions' => $recentPredictions,
            'stats' => $stats
        ]);
    }
    
    /**
     * Page À propos
     * 
     * @return void
     */
    public function about() {
        $this->view('home/about', [
            'title' => 'À propos | ' . APP_NAME
        ]);
    }
    
    /**
     * Page de contact
     * 
     * @return void
     */
    public function contact() {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider et traiter les données du formulaire
            // ...
            
            // Rediriger avec un message
            $this->setFlash('Votre message a été envoyé avec succès!', 'success');
            $this->redirect('home/contact');
        }
        
        $this->view('home/contact', [
            'title' => 'Contact | ' . APP_NAME
        ]);
    }
}