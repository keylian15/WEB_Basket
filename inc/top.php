<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <!-- Logo et bouton de bienvenue -->
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-basketball fa-bounce me-2"></i> NBA Predictor
        </a>
        
        <!-- Bouton menu pour mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu principal -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                $list_menus = array(
                  'equipes' => ['title' => 'Équipes', 'icon' => 'fa-shield-alt'],
                  'joueurs' => ['title' => 'Joueurs', 'icon' => 'fa-user-alt'],
                  'matchs' => ['title' => 'Matchs', 'icon' => 'fa-trophy'],
                  'predictions' => ['title' => 'Prédictions', 'icon' => 'fa-chart-line'],
                  'classement' => ['title' => 'Classement', 'icon' => 'fa-list-ol'],
                );

                foreach ($list_menus as $key => $menu) {
                    if ($_SESSION['is_admin'] == 1) {;
                ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $element == $key ? 'active' : ''; ?>" href="index.php?element=<?= $key; ?>" id="dropdown-<?= $key; ?>"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas <?= $menu['icon']; ?> me-1"></i> <?= $menu['title']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-<?= $key; ?>">
                        <li><a class="dropdown-item" href="index.php?element=<?= $key; ?>">
                            <i class="fas fa-list me-2"></i> Liste
                        </a></li>
                        <li><a class="dropdown-item" href="index.php?element=<?= $key; ?>&action=add">
                            <i class="fas fa-plus me-2"></i> Nouveau
                        </a></li>
                    </ul>
                </li>
                <?php
                    }else {?>

                <li class="nav-item">
                    <a class="nav-link <?= $element == $key ? 'active' : ''; ?>" href="index.php?element=<?= $key; ?>">
                        <i class="fas <?= $menu['icon']; ?> me-1"></i> <?= $menu['title']; ?>
                    </a>
                </li>
                <?php    }
                }
                ?>
                
                <!-- Nouvel onglet API sans menu déroulant -->
                <li class="nav-item">
                    <a class="nav-link <?= $element == 'api' ? 'active' : ''; ?>" href="index.php?element=api">
                        <i class="fas fa-code me-1"></i> API
                    </a>
                </li>
            </ul>
            
            <!-- Menu utilisateur -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <?= $_SESSION['login']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="index.php">
                            <i class="fas fa-home me-2"></i> Accueil
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-user me-2"></i> <?= $_SESSION['user']['firstname'] .' '. $_SESSION['user']['lastname']; ?>
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="delog.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Se déconnecter
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>