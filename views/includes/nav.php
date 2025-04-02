<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?php echo url(); ?>">
            <i class="fas fa-basketball fa-bounce"></i> <?php echo APP_NAME; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['url'] ?? '') === '' ? 'active' : ''; ?>" href="<?php echo url(); ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['url']) && strpos($_GET['url'], 'teams') === 0 ? 'active' : ''; ?>" href="<?php echo url('teams'); ?>">Équipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['url']) && strpos($_GET['url'], 'players') === 0 ? 'active' : ''; ?>" href="<?php echo url('players'); ?>">Joueurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['url']) && strpos($_GET['url'], 'matches') === 0 ? 'active' : ''; ?>" href="<?php echo url('matches'); ?>">Matchs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['url']) && strpos($_GET['url'], 'predictions') === 0 ? 'active' : ''; ?>" href="<?php echo url('predictions'); ?>">Prédictions</a>
                </li>
            </ul>
            
            <!-- Section utilisateur -->
            <?php if (isLoggedIn()): ?>
                <div class="dropdown">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <?php echo e($_SESSION['user_name']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?php echo url('users/dashboard'); ?>"><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord</a></li>
                        <li><a class="dropdown-item" href="<?php echo url('users/profile'); ?>"><i class="fas fa-user-edit me-2"></i> Modifier le profil</a></li>
                        <li><a class="dropdown-item" href="<?php echo url('users/settings'); ?>"><i class="fas fa-cog me-2"></i> Paramètres</a></li>
                        <?php if (isAdmin()): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo url('admin'); ?>"><i class="fas fa-user-shield me-2"></i> Administration</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo url('users/logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="d-flex">
                    <a href="<?php echo url('users/login'); ?>" class="btn btn-outline-light me-2">Connexion</a>
                    <a href="<?php echo url('users/register'); ?>" class="btn btn-light">Inscription</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Message flash -->
<?php flash(); ?>