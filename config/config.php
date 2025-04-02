<?php
/**
 * Fichier de configuration générale
 */

// Informations sur l'application
define('APP_NAME', 'NBA Predictor');
define('APP_VERSION', '1.0.0');

// URLs et chemins
define('BASE_URL', 'http://localhost/nba-predictor/');
define('ASSETS_URL', BASE_URL . 'assets/');

// Autres constantes
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_METHOD', 'index');

// Gestion des erreurs
define('DISPLAY_ERRORS', true);
if (DISPLAY_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}