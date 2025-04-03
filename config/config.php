<?php
/**
 * Fichier de configuration de l'application
 */

// Définition du chemin de base
define('BASE_PATH', __DIR__ . '/..');

// Configuration de l'application
$config = [
    'app_name' => 'Hello World MVC',
    'debug' => true, // Activer/désactiver le mode débogage
];

// En mode débogage, afficher les erreurs
if ($config['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}