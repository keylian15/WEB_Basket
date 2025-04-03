<?php
/**
 * Point d'entrée principal de l'application
 * Ce fichier joue le rôle de routeur frontal (front controller)
 */

// Chargement de la configuration
require_once 'config/config.php';

// Chargement des contrôleurs
require_once 'controllers/HomeController.php';

// Création de l'instance du contrôleur
$controller = new HomeController();

// Récupération du paramètre d'action dans l'URL (si présent)
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Vérifier si la méthode existe dans le contrôleur
if (method_exists($controller, $action)) {
    // Appeler la méthode du contrôleur
    $controller->$action();
} else {
    // Action non trouvée, rediriger vers la page d'accueil
    $controller->index();
}