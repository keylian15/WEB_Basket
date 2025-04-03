<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Affiche la page de connexion
     */
    public function showLoginForm() {
        // Vérifier si l'utilisateur est déjà connecté
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        
        $error = '';
        
        require_once __DIR__ . '/../views/templates/header.php';
        require_once __DIR__ . '/../views/auth/login.php';
        require_once __DIR__ . '/../views/templates/footer.php';
    }
    
    /**
     * Traite la soumission du formulaire de connexion
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=login');
            exit;
        }
        
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $error = "Tous les champs sont obligatoires.";
            
            require_once __DIR__ . '/../views/templates/header.php';
            require_once __DIR__ . '/../views/auth/login.php';
            require_once __DIR__ . '/../views/templates/footer.php';
            return;
        }
        
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            // Démarrer la session si ce n'est pas déjà fait
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Enregistrer les données utilisateur en session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            // Rediriger vers la page d'accueil
            header('Location: index.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
            
            require_once __DIR__ . '/../views/templates/header.php';
            require_once __DIR__ . '/../views/auth/login.php';
            require_once __DIR__ . '/../views/templates/footer.php';
        }
    }
    
    /**
     * Affiche la page d'inscription
     */
    public function showRegisterForm() {
        // Vérifier si l'utilisateur est déjà connecté
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        
        $error = '';
        
        require_once __DIR__ . '/../views/templates/header.php';
        require_once __DIR__ . '/../views/auth/register.php';
        require_once __DIR__ . '/../views/templates/footer.php';
    }
    
    /**
     * Traite la soumission du formulaire d'inscription
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=register');
            exit;
        }
        
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        
        $errors = [];
        
        // Validation des entrées
        if (empty($email)) {
            $errors[] = "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format d'email invalide.";
        }
        
        if (empty($password)) {
            $errors[] = "Le mot de passe est obligatoire.";
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }
        
        // Vérifier si l'email existe déjà
        if (!empty($email) && $this->userModel->emailExists($email)) {
            $errors[] = "Cet email est déjà utilisé.";
        }
        
        // S'il y a des erreurs, afficher le formulaire avec les erreurs
        if (!empty($errors)) {
            $error = implode("<br>", $errors);
            
            require_once __DIR__ . '/../views/templates/header.php';
            require_once __DIR__ . '/../views/auth/register.php';
            require_once __DIR__ . '/../views/templates/footer.php';
            return;
        }
        
        // Créer le nouvel utilisateur
        $result = $this->userModel->create($email, $password);
        
        if ($result) {
            // Rediriger vers la page de connexion avec un message de succès
            header('Location: index.php?page=login&registered=1');
            exit;
        } else {
            $error = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
            
            require_once __DIR__ . '/../views/templates/header.php';
            require_once __DIR__ . '/../views/auth/register.php';
            require_once __DIR__ . '/../views/templates/footer.php';
        }
    }
    
    /**
     * Déconnecte l'utilisateur
     */
    public function logout() {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Supprimer toutes les variables de session
        $_SESSION = [];
        
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit;
    }
}