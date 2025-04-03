<?php
class HomeController {
    /**
     * Affiche la page d'accueil
     */
    public function index() {
        require_once __DIR__ . '/../views/templates/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/templates/footer.php';
    }
}