<?php
/**
 * Fonctions utilitaires pour l'application
 */

/**
 * Rediriger vers une URL
 * 
 * @param string $url URL à rediriger
 * @return void
 */
function redirect($url) {
    header('Location: ' . BASE_URL . $url);
    exit;
}

/**
 * Générer une URL complète
 * 
 * @param string $path Chemin relatif
 * @return string URL complète
 */
function url($path = '') {
    return BASE_URL . $path;
}

/**
 * Générer une URL pour un asset
 * 
 * @param string $path Chemin du fichier relatif au dossier assets
 * @return string URL complète de l'asset
 */
function asset($path) {
    return ASSETS_URL . $path;
}

/**
 * Échapper les données pour éviter les attaques XSS
 * 
 * @param string $data Données à échapper
 * @return string Données échappées
 */
function e($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Afficher un message flash
 * 
 * @return void
 */
function flash() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
        
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
        echo $message;
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>';
        echo '</div>';
        
        // Supprimer le message après l'avoir affiché
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}

/**
 * Définir un message flash
 * 
 * @param string $message Message à afficher
 * @param string $type Type de message (success, info, warning, danger)
 * @return void
 */
function setFlash($message, $type = 'info') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

/**
 * Vérifier si l'utilisateur est connecté
 * 
 * @return bool True si l'utilisateur est connecté, sinon False
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Vérifier si l'utilisateur est administrateur
 * 
 * @return bool True si l'utilisateur est administrateur, sinon False
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Formater une date en français
 * 
 * @param string $date Date au format MySQL/PostgreSQL
 * @param string $format Format de sortie
 * @return string Date formatée
 */
function formatDate($date, $format = 'j F Y') {
    setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
    $date = new DateTime($date);
    return $date->format($format);
}

/**
 * Tronquer un texte à une longueur spécifique
 * 
 * @param string $text Texte à tronquer
 * @param int $length Longueur maximale
 * @param string $append Texte à ajouter à la fin
 * @return string Texte tronqué
 */
function truncate($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Générer un jeton CSRF
 * 
 * @return string Jeton CSRF
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Vérifier un jeton CSRF
 * 
 * @param string $token Jeton CSRF à vérifier
 * @return bool True si le jeton est valide, sinon False
 */
function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Générer un champ CSRF pour un formulaire
 * 
 * @return string Champ CSRF HTML
 */
function csrfField() {
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}
