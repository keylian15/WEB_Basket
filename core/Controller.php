<?php
/**
 * Classe de base pour tous les contrôleurs
 */
class Controller {
    /**
     * Charger un modèle
     * 
     * @param string $model Nom du modèle à charger
     * @return object Instance du modèle
     */
    protected function model($model) {
        // Charger le fichier du modèle
        require_once 'models/' . $model . '.php';
        
        // Instancier le modèle
        return new $model();
    }
    
    /**
     * Charger une vue
     * 
     * @param string $view Nom de la vue à charger
     * @param array $data Données à passer à la vue
     * @return void
     */
    protected function view($view, $data = []) {
        // Extraire les données pour les rendre disponibles dans la vue
        if (!empty($data)) {
            extract($data);
        }
        
        // Charger l'en-tête
        require_once 'views/includes/header.php';
        
        // Charger la navigation
        require_once 'views/includes/nav.php';
        
        // Charger la vue
        require_once 'views/' . $view . '.php';
        
        // Charger le pied de page
        require_once 'views/includes/footer.php';
    }
    
    /**
     * Charger une vue partielle (sans en-tête ni pied de page)
     * 
     * @param string $view Nom de la vue à charger
     * @param array $data Données à passer à la vue
     * @return void
     */
    protected function partial($view, $data = []) {
        // Extraire les données pour les rendre disponibles dans la vue
        if (!empty($data)) {
            extract($data);
        }
        
        // Charger la vue
        require_once 'views/' . $view . '.php';
    }
    
    /**
     * Charger une API (retourner JSON)
     * 
     * @param array $data Données à convertir en JSON
     * @param int $statusCode Code de statut HTTP
     * @return void
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Rediriger vers une URL
     * 
     * @param string $url URL à rediriger
     * @return void
     */
    protected function redirect($url) {
        redirect($url);
    }
    
    /**
     * Définir un message flash
     * 
     * @param string $message Message à afficher
     * @param string $type Type de message (success, info, warning, danger)
     * @return void
     */
    protected function setFlash($message, $type = 'info') {
        setFlash($message, $type);
    }
}