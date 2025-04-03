<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'NBA Predictor - Prédictions de résultats NBA' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #17408B;
            --secondary-color: #C9082A;
            --accent-color: #FFFFFF;
            --text-color: #333333;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--text-color);
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e5799 100%);
            color: white;
            padding: 4rem 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .team-logo {
            height: 50px;
            width: auto;
        }
        
        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #0d2f64;
            border-color: #0d2f64;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
        
        /* Styles spécifiques pour les pages d'authentification */
        .auth-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-logo {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        /* Autres styles spécifiques */
        .team-badge, .prediction-bar, .vs-badge, .match-card, .btn-social, .divider, .password-toggle, .password-requirements {
            /* Ces styles sont déjà définis dans les fichiers originaux */
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-basketball fa-bounce"></i> NBA Predictor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $_GET['page'] ?? '' === '' ? 'active' : '' ?>" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=teams">Équipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=players">Joueurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=matches">Matchs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=predictions">Prédictions</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Utilisateur connecté -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> <?= htmlspecialchars($_SESSION['user_email']) ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="index.php?page=profile"><i class="fas fa-user-circle me-1"></i> Mon profil</a></li>
                                <?php if ($_SESSION['is_admin']): ?>
                                    <li><a class="dropdown-item" href="index.php?page=admin"><i class="fas fa-cog me-1"></i> Administration</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?page=logout"><i class="fas fa-sign-out-alt me-1"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Utilisateur non connecté -->
                        <a href="index.php?page=login" class="btn btn-outline-light me-2 <?= $_GET['page'] ?? '' === 'login' ? 'active' : '' ?>">Connexion</a>
                        <a href="index.php?page=register" class="btn btn-light <?= $_GET['page'] ?? '' === 'register' ? 'active' : '' ?>">Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container flex-grow-1">
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>