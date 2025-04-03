<?php
/**
 * Contrôleur de la page d'accueil
 */

// Chargement du modèle
require_once 'models/MessageModel.php';

class HomeController {
    private $messageModel;
    
    /**
     * Constructeur du contrôleur
     */
    public function __construct() {
        $this->messageModel = new MessageModel();
    }
    
    /**
     * Méthode d'action par défaut pour la page d'accueil
     */
    public function index() {
        // Récupérer le message depuis le modèle
        $message = $this->messageModel->getMessage();
        
        // Charger la vue avec le message
        $this->loadView('home/index', ['message' => $message]);
    }
    
    /**
     * Méthode helper pour charger une vue avec des données
     *
     * @param string $view Chemin de la vue
     * @param array $data Données à passer à la vue
     */
    private function loadView($view, $data = []) {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Charger l'en-tête
        require_once BASE_PATH . '/views/templates/header.php';
        
        // Charger la vue principale
        require_once BASE_PATH . '/views/' . $view . '.php';
        
        // Charger le pied de page
        require_once BASE_PATH . '/views/templates/footer.php';
    }
}