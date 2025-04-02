<?php
/**
 * Contrôleur pour la gestion des utilisateurs
 */
class UsersController extends Controller {
    /**
     * Modèle d'utilisateur
     * 
     * @var UserModel
     */
    private $userModel;
    
    /**
     * Modèle de prédiction
     * 
     * @var PredictionModel
     */
    private $predictionModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        // Charger les modèles nécessaires
        $this->userModel = $this->model('UserModel');
        $this->predictionModel = $this->model('PredictionModel');
    }
    
    /**
     * Afficher le formulaire d'inscription
     * 
     * @return void
     */
    public function register() {
        // Vérifier si l'utilisateur est déjà connecté
        if (isLoggedIn()) {
            redirect('users/dashboard');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider les données du formulaire
            $errors = [];
            
            // Valider le nom d'utilisateur
            if (empty($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur est requis';
            } elseif (strlen($_POST['nom_utilisateur']) < 3 || strlen($_POST['nom_utilisateur']) > 50) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur doit comporter entre 3 et 50 caractères';
            } elseif ($this->userModel->getUserByUsername($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Ce nom d\'utilisateur est déjà utilisé';
            }
            
            // Valider l'email
            if (empty($_POST['email'])) {
                $errors['email'] = 'L\'email est requis';
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email n\'est pas valide';
            } elseif ($this->userModel->getUserByEmail($_POST['email'])) {
                $errors['email'] = 'Cet email est déjà utilisé';
            }
            
            // Valider le mot de passe
            if (empty($_POST['mot_de_passe'])) {
                $errors['mot_de_passe'] = 'Le mot de passe est requis';
            } elseif (strlen($_POST['mot_de_passe']) < 8) {
                $errors['mot_de_passe'] = 'Le mot de passe doit comporter au moins 8 caractères';
            }
            
            // Valider la confirmation du mot de passe
            if (empty($_POST['confirmer_mot_de_passe'])) {
                $errors['confirmer_mot_de_passe'] = 'La confirmation du mot de passe est requise';
            } elseif ($_POST['mot_de_passe'] !== $_POST['confirmer_mot_de_passe']) {
                $errors['confirmer_mot_de_passe'] = 'Les mots de passe ne correspondent pas';
            }
            
            // S'il n'y a pas d'erreurs, créer l'utilisateur
            if (empty($errors)) {
                $userData = [
                    'nom_utilisateur' => $_POST['nom_utilisateur'],
                    'email' => $_POST['email'],
                    'mot_de_passe' => $_POST['mot_de_passe'],
                    'est_admin' => false
                ];
                
                $userId = $this->userModel->createUser($userData);
                
                if ($userId) {
                    $this->setFlash('Inscription réussie ! Vous pouvez maintenant vous connecter.', 'success');
                    redirect('users/login');
                } else {
                    $this->setFlash('Erreur lors de l\'inscription. Veuillez réessayer.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('users/register', [
            'title' => 'Inscription | ' . APP_NAME,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Afficher le formulaire de connexion
     * 
     * @return void
     */
    public function login() {
        // Vérifier si l'utilisateur est déjà connecté
        if (isLoggedIn()) {
            redirect('users/dashboard');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider les données du formulaire
            $errors = [];
            
            // Valider le nom d'utilisateur
            if (empty($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur est requis';
            }
            
            // Valider le mot de passe
            if (empty($_POST['mot_de_passe'])) {
                $errors['mot_de_passe'] = 'Le mot de passe est requis';
            }
            
            // S'il n'y a pas d'erreurs, connecter l'utilisateur
            if (empty($errors)) {
                $user = $this->userModel->login($_POST['nom_utilisateur'], $_POST['mot_de_passe']);
                
                if ($user) {
                    // Créer les variables de session
                    $_SESSION['user_id'] = $user['id_utilisateur'];
                    $_SESSION['user_name'] = $user['nom_utilisateur'];
                    $_SESSION['is_admin'] = $user['est_admin'];
                    
                    $this->setFlash('Connexion réussie !', 'success');
                    redirect('users/dashboard');
                } else {
                    $this->setFlash('Nom d\'utilisateur ou mot de passe incorrect.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('users/login', [
            'title' => 'Connexion | ' . APP_NAME,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Déconnecter l'utilisateur
     * 
     * @return void
     */
    public function logout() {
        // Supprimer les variables de session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['is_admin']);
        
        // Détruire la session
        session_destroy();
        
        $this->setFlash('Vous êtes maintenant déconnecté.', 'success');
        redirect('users/login');
    }
    
    /**
     * Afficher le tableau de bord de l'utilisateur
     * 
     * @return void
     */
    public function dashboard() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour accéder à cette page.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Récupérer les informations de l'utilisateur
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        // Récupérer les prédictions récentes de l'utilisateur
        $recentPredictions = $this->predictionModel->getUserPredictions($_SESSION['user_id'], 3);
        
        // Récupérer les statistiques de précision
        $accuracy = $this->predictionModel->getUserPredictionAccuracy($_SESSION['user_id']);
        
        // Récupérer les équipes favorites
        $favoriteTeams = $this->userModel->getFavoriteTeams($_SESSION['user_id']);
        
        // Charger la vue
        $this->view('users/dashboard', [
            'title' => 'Tableau de bord | ' . APP_NAME,
            'user' => $user,
            'recentPredictions' => $recentPredictions,
            'accuracy' => $accuracy,
            'favoriteTeams' => $favoriteTeams
        ]);
    }
    
    /**
     * Afficher et modifier le profil de l'utilisateur
     * 
     * @return void
     */
    public function profile() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour accéder à cette page.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Récupérer les informations de l'utilisateur
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider les données du formulaire
            $errors = [];
            
            // Valider le nom d'utilisateur
            if (empty($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur est requis';
            } elseif (strlen($_POST['nom_utilisateur']) < 3 || strlen($_POST['nom_utilisateur']) > 50) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur doit comporter entre 3 et 50 caractères';
            } elseif ($_POST['nom_utilisateur'] !== $user['nom_utilisateur'] && $this->userModel->getUserByUsername($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Ce nom d\'utilisateur est déjà utilisé';
            }
            
            // Valider l'email
            if (empty($_POST['email'])) {
                $errors['email'] = 'L\'email est requis';
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email n\'est pas valide';
            } elseif ($_POST['email'] !== $user['email'] && $this->userModel->getUserByEmail($_POST['email'])) {
                $errors['email'] = 'Cet email est déjà utilisé';
            }
            
            // S'il n'y a pas d'erreurs, mettre à jour le profil
            if (empty($errors)) {
                $userData = [
                    'nom_utilisateur' => $_POST['nom_utilisateur'],
                    'email' => $_POST['email']
                ];
                
                $success = $this->userModel->updateUser($_SESSION['user_id'], $userData);
                
                if ($success) {
                    // Mettre à jour le nom d'utilisateur dans la session
                    $_SESSION['user_name'] = $_POST['nom_utilisateur'];
                    
                    $this->setFlash('Profil mis à jour avec succès.', 'success');
                    redirect('users/profile');
                } else {
                    $this->setFlash('Erreur lors de la mise à jour du profil.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('users/profile', [
            'title' => 'Modifier le profil | ' . APP_NAME,
            'user' => $user,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Modifier le mot de passe de l'utilisateur
     * 
     * @return void
     */
    public function password() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour accéder à cette page.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider les données du formulaire
            $errors = [];
            
            // Valider le mot de passe actuel
            if (empty($_POST['mot_de_passe_actuel'])) {
                $errors['mot_de_passe_actuel'] = 'Le mot de passe actuel est requis';
            }
            
            // Valider le nouveau mot de passe
            if (empty($_POST['nouveau_mot_de_passe'])) {
                $errors['nouveau_mot_de_passe'] = 'Le nouveau mot de passe est requis';
            } elseif (strlen($_POST['nouveau_mot_de_passe']) < 8) {
                $errors['nouveau_mot_de_passe'] = 'Le nouveau mot de passe doit comporter au moins 8 caractères';
            }
            
            // Valider la confirmation du nouveau mot de passe
            if (empty($_POST['confirmer_mot_de_passe'])) {
                $errors['confirmer_mot_de_passe'] = 'La confirmation du mot de passe est requise';
            } elseif ($_POST['nouveau_mot_de_passe'] !== $_POST['confirmer_mot_de_passe']) {
                $errors['confirmer_mot_de_passe'] = 'Les mots de passe ne correspondent pas';
            }
            
            // S'il n'y a pas d'erreurs, mettre à jour le mot de passe
            if (empty($errors)) {
                $success = $this->userModel->updatePassword(
                    $_SESSION['user_id'],
                    $_POST['mot_de_passe_actuel'],
                    $_POST['nouveau_mot_de_passe']
                );
                
                if ($success) {
                    $this->setFlash('Mot de passe mis à jour avec succès.', 'success');
                    redirect('users/profile');
                } else {
                    $this->setFlash('Mot de passe actuel incorrect ou erreur lors de la mise à jour.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('users/password', [
            'title' => 'Modifier le mot de passe | ' . APP_NAME,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Afficher les équipes favorites de l'utilisateur
     * 
     * @return void
     */
    public function favorites() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            $this->setFlash('Vous devez être connecté pour accéder à cette page.', 'warning');
            redirect('users/login');
            return;
        }
        
        // Récupérer les équipes favorites
        $favoriteTeams = $this->userModel->getFavoriteTeams($_SESSION['user_id']);
        
        // Charger la vue
        $this->view('users/favorites', [
            'title' => 'Équipes favorites | ' . APP_NAME,
            'favoriteTeams' => $favoriteTeams
        ]);
    }
    
    /**
     * Page d'administration des utilisateurs (admin seulement)
     * 
     * @return void
     */
    public function admin() {
        // Vérifier si l'utilisateur est admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('');
            return;
        }
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 15;
        $offset = ($page - 1) * $perPage;
        
        // Récupérer les utilisateurs avec pagination
        $users = $this->userModel->getAllUsers($perPage, $offset);
        
        // Compter le nombre total d'utilisateurs pour la pagination
        $totalUsers = $this->userModel->countUsers();
        $totalPages = ceil($totalUsers / $perPage);
        
        // Charger la vue
        $this->view('admin/users', [
            'title' => 'Gestion des utilisateurs | ' . APP_NAME,
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalUsers' => $totalUsers
        ]);
    }
    
    /**
     * Modifier un utilisateur (admin seulement)
     * 
     * @param int $id ID de l'utilisateur
     * @return void
     */
    public function edit($id) {
        // Vérifier si l'utilisateur est admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('');
            return;
        }
        
        // Récupérer les informations de l'utilisateur
        $user = $this->userModel->getUserById($id);
        
        // Vérifier si l'utilisateur existe
        if (!$user) {
            $this->setFlash('Utilisateur non trouvé.', 'danger');
            redirect('users/admin');
            return;
        }
        
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider les données du formulaire
            $errors = [];
            
            // Valider le nom d'utilisateur
            if (empty($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur est requis';
            } elseif (strlen($_POST['nom_utilisateur']) < 3 || strlen($_POST['nom_utilisateur']) > 50) {
                $errors['nom_utilisateur'] = 'Le nom d\'utilisateur doit comporter entre 3 et 50 caractères';
            } elseif ($_POST['nom_utilisateur'] !== $user['nom_utilisateur'] && $this->userModel->getUserByUsername($_POST['nom_utilisateur'])) {
                $errors['nom_utilisateur'] = 'Ce nom d\'utilisateur est déjà utilisé';
            }
            
            // Valider l'email
            if (empty($_POST['email'])) {
                $errors['email'] = 'L\'email est requis';
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email n\'est pas valide';
            } elseif ($_POST['email'] !== $user['email'] && $this->userModel->getUserByEmail($_POST['email'])) {
                $errors['email'] = 'Cet email est déjà utilisé';
            }
            
            // S'il n'y a pas d'erreurs, mettre à jour l'utilisateur
            if (empty($errors)) {
                $userData = [
                    'nom_utilisateur' => $_POST['nom_utilisateur'],
                    'email' => $_POST['email'],
                    'est_admin' => isset($_POST['est_admin']) ? true : false
                ];
                
                $success = $this->userModel->updateUser($id, $userData);
                
                if ($success) {
                    $this->setFlash('Utilisateur mis à jour avec succès.', 'success');
                    redirect('users/admin');
                } else {
                    $this->setFlash('Erreur lors de la mise à jour de l\'utilisateur.', 'danger');
                }
            }
        }
        
        // Charger la vue
        $this->view('admin/editUser', [
            'title' => 'Modifier l\'utilisateur | ' . APP_NAME,
            'user' => $user,
            'errors' => $errors ?? []
        ]);
    }
    
    /**
     * Supprimer un utilisateur (admin seulement)
     * 
     * @param int $id ID de l'utilisateur
     * @return void
     */
    public function delete($id) {
        // Vérifier si l'utilisateur est admin
        if (!isLoggedIn() || !isAdmin()) {
            $this->setFlash('Accès non autorisé.', 'danger');
            redirect('');
            return;
        }
        
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('users/admin');
            return;
        }
        
        // Vérifier le jeton CSRF
        if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Jeton CSRF invalide.', 'danger');
            redirect('users/admin');
            return;
        }
        
        // Vérifier que l'utilisateur n'essaie pas de se supprimer lui-même
        if ($id == $_SESSION['user_id']) {
            $this->setFlash('Vous ne pouvez pas supprimer votre propre compte.', 'danger');
            redirect('users/admin');
            return;
        }
        
        // Supprimer l'utilisateur
        $success = $this->userModel->deleteUser($id);
        
        if ($success) {
            $this->setFlash('Utilisateur supprimé avec succès.', 'success');
        } else {
            $this->setFlash('Erreur lors de la suppression de l\'utilisateur.', 'danger');
        }
        
        redirect('users/admin');
    }
}