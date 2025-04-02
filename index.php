<?php
/**
 * NBA Predictor - Point d'entrée principal de l'application
 * 
 * Ce fichier sert de contrôleur frontal pour toutes les requêtes.
 * Il initialise l'application et redirige vers les contrôleurs appropriés.
 */

// Démarrer la session
session_start();

// Définir la racine de l'application
define('ROOT_PATH', __DIR__);

// Charger les fichiers de configuration
require_once 'config/config.php';
require_once 'config/database.php';

// Charger les fonctions utilitaires
require_once 'includes/functions.php';

// Charger l'autoloader pour les classes
require_once 'autoload.php';

// Obtenir l'URL demandée
$request = isset($_GET['url']) ? $_GET['url'] : '';
$url = trim($request, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Déterminer le contrôleur à charger
$controller = !empty($url[0]) ? $url[0] : 'home';
$method = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Formater le nom du contrôleur
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

// Vérifier si le contrôleur existe
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Instancier le contrôleur
    $controllerInstance = new $controllerName();
    
    // Vérifier si la méthode existe
    if (method_exists($controllerInstance, $method)) {
        // Appeler la méthode avec les paramètres
        call_user_func_array([$controllerInstance, $method], $params);
    } else {
        // Méthode non trouvée, rediriger vers la page 404
        require_once 'controllers/ErrorController.php';
        $errorController = new ErrorController();
        $errorController->notFound();
    }
} else {
    // Contrôleur non trouvé, rediriger vers la page 404
    require_once 'controllers/ErrorController.php';
    $errorController = new ErrorController();
    $errorController->notFound();
}