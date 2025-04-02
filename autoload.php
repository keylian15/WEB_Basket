<?php
/**
 * Autoloader pour charger automatiquement les classes
 */

spl_autoload_register(function ($class) {
    // Préfixes des namespaces avec leurs répertoires correspondants
    $prefixes = [
        'Controller' => 'controllers/',
        'Model' => 'models/',
        'Core' => 'core/'
    ];
    
    // Vérifier chaque préfixe
    foreach ($prefixes as $prefix => $dir) {
        // Si la classe contient le préfixe
        if (strpos($class, $prefix) !== false) {
            // Chemins possibles pour le fichier de classe
            $paths = [
                $dir . $class . '.php',
                $dir . str_replace($prefix, '', $class) . '.php'
            ];
            
            // Essayer chaque chemin
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    require_once $path;
                    return;
                }
            }
        }
    }
    
    // Si aucun préfixe ne correspond, essayer le répertoire racine
    $path = $class . '.php';
    if (file_exists($path)) {
        require_once $path;
        return;
    }
});