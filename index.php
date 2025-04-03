<?php
// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement des contrôleurs
require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';

// Création des instances de contrôleurs
$homeController = new HomeController();
$authController = new AuthController();

// Routage simple basé sur le paramètre 'page' dans l'URL
$page = $_GET['page'] ?? '';

// Gestion des routes
switch ($page) {
    // Routes d'authentification
    case 'login':
        $authController->showLoginForm();
        break;
    
    case 'login-process':
        $authController->login();
        break;
    
    case 'register':
        $authController->showRegisterForm();
        break;
    
    case 'register-process':
        $authController->register();
        break;
    
    case 'logout':
        $authController->logout();
        break;
    
    // Page d'accueil par défaut
    default:
        $homeController->index();
        break;
}