<?php
/**
 * Contrôleur pour la gestion des erreurs
 */
class ErrorController extends Controller {
    /**
     * Page non trouvée (404)
     * 
     * @return void
     */
    public function notFound() {
        http_response_code(404);
        $this->view('errors/404', [
            'title' => 'Page non trouvée | ' . APP_NAME
        ]);
    }
    
    /**
     * Erreur serveur (500)
     * 
     * @return void
     */
    public function serverError() {
        http_response_code(500);
        $this->view('errors/500', [
            'title' => 'Erreur serveur | ' . APP_NAME
        ]);
    }
    
    /**
     * Accès refusé (403)
     * 
     * @return void
     */
    public function forbidden() {
        http_response_code(403);
        $this->view('errors/403', [
            'title' => 'Accès refusé | ' . APP_NAME
        ]);
    }
}