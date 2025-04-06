<div class="container-fluid mt-5 pt-5">
    <h1 class="display-4 mb-4"><i class="fas fa-list-ol me-2"></i> Classements</h1>
    
    <!-- Sélecteur de saison -->
    <div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="get" class="d-flex align-items-center" id="season-form">
            <input type="hidden" name="element" value="classement">
            <!-- Préserver l'onglet actif lors du changement de saison -->
            <input type="hidden" name="tab" value="<?= $active_tab ?>">
            
            <!-- Préserver la pagination actuelle pour chaque onglet -->
            <input type="hidden" name="teams_page" value="<?= $teams_page ?>">
            <input type="hidden" name="points_page" value="<?= $points_page ?>">
            <input type="hidden" name="fg_page" value="<?= $fg_page ?>">
            <input type="hidden" name="minutes_page" value="<?= $minutes_page ?>">
            <input type="hidden" name="shot_page" value="<?= $shot_page ?>">
            
            <div class="input-group">
                <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-calendar-alt me-2"></i> Saison
                </span>
                <select name="season" id="season-select" class="form-select" onchange="document.getElementById('season-form').submit();">
                    <?php foreach ($all_seasons as $season): ?>
                        <option value="<?= $season['id'] ?>" <?= $selected_season == $season['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($season['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
    
    <!-- Nav tabs - Améliorés pour une meilleure visibilité -->
    <ul class="nav nav-tabs nav-fill mb-4" id="rankingTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'teams' ? 'active' : '' ?> fw-bold py-3" id="teams-tab" data-bs-toggle="tab" data-bs-target="#teams" type="button" role="tab" aria-controls="teams" aria-selected="<?= $active_tab == 'teams' ? 'true' : 'false' ?>">
                <i class="fas fa-shield-alt me-1"></i> Équipes (Points)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-points' ? 'active' : '' ?> fw-bold py-3" id="players-points-tab" data-bs-toggle="tab" data-bs-target="#players-points" type="button" role="tab" aria-controls="players-points" aria-selected="<?= $active_tab == 'players-points' ? 'true' : 'false' ?>">
                <i class="fas fa-basketball-ball me-1"></i> Joueurs (Points)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-fg' ? 'active' : '' ?> fw-bold py-3" id="players-fg-tab" data-bs-toggle="tab" data-bs-target="#players-fg" type="button" role="tab" aria-controls="players-fg" aria-selected="<?= $active_tab == 'players-fg' ? 'true' : 'false' ?>">
                <i class="fas fa-percentage me-1"></i> Joueurs (FG)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-minutes' ? 'active' : '' ?> fw-bold py-3" id="players-minutes-tab" data-bs-toggle="tab" data-bs-target="#players-minutes" type="button" role="tab" aria-controls="players-minutes" aria-selected="<?= $active_tab == 'players-minutes' ? 'true' : 'false' ?>">
                <i class="fas fa-clock me-1"></i> Joueurs (Minutes)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-shot' ? 'active' : '' ?> fw-bold py-3" id="players-shot-tab" data-bs-toggle="tab" data-bs-target="#players-shot" type="button" role="tab" aria-controls="players-shot" aria-selected="<?= $active_tab == 'players-shot' ? 'true' : 'false' ?>">
                <i class="fas fa-bullseye me-1"></i> Joueurs (Tirs)
            </button>
        </li>
    </ul>
    
    <!-- Styles personnalisés pour les onglets -->
    <style>
        .nav-tabs .nav-link {
            color: #000000;
            background-color: #f8f9fa;
            border-color: #dee2e6 #dee2e6 #fff;
            border-width: 2px;
            transition: all 0.3s ease;
            margin-right: 2px;
        }
        
        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            font-weight: bold;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            background-color: #e9ecef;
            border-color: #dee2e6 #dee2e6 #fff;
            transform: translateY(-3px);
        }
        
        /* Styles spécifiques pour chaque onglet */
        #teams-tab.active { background-color: #0d6efd; border-color: #0d6efd; }
        #players-points-tab.active { background-color: #198754; border-color: #198754; }
        #players-fg-tab.active { background-color: #0dcaf0; border-color: #0dcaf0; }
        #players-minutes-tab.active { background-color: #ffc107; border-color: #ffc107; color: #212529; }
        #players-shot-tab.active { background-color: #dc3545; border-color: #dc3545; }
    </style>
    
    <!-- Tab content -->
    <div class="tab-content" id="rankingTabsContent">
        <!-- Teams Ranking -->
        <div class="tab-pane fade <?= $active_tab == 'teams' ? 'show active' : '' ?>" id="teams" role="tabpanel" aria-labelledby="teams-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i> Classement des équipes par points par match</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Équipe</th>
                                    <th>Points par match</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teams_ranking as $team): ?>
                                <tr>
                                    <td><?= $team['classement'] ?></td>
                                    <td><?= $team['abr_equipe'] ?></td>
                                    <td><?= number_format($team['pts_par_match'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($teams_total_pages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Pagination des équipes">
                        <ul class="pagination justify-content-center mb-0">
                            <?php
                            // Afficher seulement la pagination compacte
                            $range = 2; // Nombre de pages à afficher avant et après la page courante
                            
                            // Lien "Précédent"
                            if ($teams_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=teams&teams_page=<?= $teams_page-1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif;
                            
                            // Première page
                            if ($teams_page > $range + 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=teams&teams_page=1&season=<?= $selected_season ?>">1</a>
                                </li>
                                <?php if ($teams_page > $range + 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                            endif;
                            
                            // Pages autour de la page courante
                            for ($i = max(1, $teams_page - $range); $i <= min($teams_total_pages, $teams_page + $range); $i++): ?>
                                <li class="page-item <?= $i == $teams_page ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?element=classement&tab=teams&teams_page=<?= $i ?>&season=<?= $selected_season ?>"><?= $i ?></a>
                                </li>
                            <?php endfor;
                            
                            // Dernière page
                            if ($teams_page < $teams_total_pages - $range): 
                                if ($teams_page < $teams_total_pages - $range - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=teams&teams_page=<?= $teams_total_pages ?>&season=<?= $selected_season ?>"><?= $teams_total_pages ?></a>
                                </li>
                            <?php endif;
                            
                            // Lien "Suivant"
                            if ($teams_page < $teams_total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=teams&teams_page=<?= $teams_page+1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Players Points Ranking -->
        <div class="tab-pane fade <?= $active_tab == 'players-points' ? 'show active' : '' ?>" id="players-points" role="tabpanel" aria-labelledby="players-points-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-basketball-ball me-2"></i> Classement des joueurs par points</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Position</th>
                                    <th>ID Joueur</th>
                                    <th>Nom</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_points_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['stat_points'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($points_total_pages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Pagination des joueurs (points)">
                        <ul class="pagination justify-content-center mb-0">
                            <?php
                            // Afficher seulement la pagination compacte
                            $range = 2; // Nombre de pages à afficher avant et après la page courante
                            
                            // Lien "Précédent"
                            if ($points_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-points&points_page=<?= $points_page-1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif;
                            
                            // Première page
                            if ($points_page > $range + 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-points&points_page=1&season=<?= $selected_season ?>">1</a>
                                </li>
                                <?php if ($points_page > $range + 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                            endif;
                            
                            // Pages autour de la page courante
                            for ($i = max(1, $points_page - $range); $i <= min($points_total_pages, $points_page + $range); $i++): ?>
                                <li class="page-item <?= $i == $points_page ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?element=classement&tab=players-points&points_page=<?= $i ?>&season=<?= $selected_season ?>"><?= $i ?></a>
                                </li>
                            <?php endfor;
                            
                            // Dernière page
                            if ($points_page < $points_total_pages - $range): 
                                if ($points_page < $points_total_pages - $range - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-points&points_page=<?= $points_total_pages ?>&season=<?= $selected_season ?>"><?= $points_total_pages ?></a>
                                </li>
                            <?php endif;
                            
                            // Lien "Suivant"
                            if ($points_page < $points_total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-points&points_page=<?= $points_page+1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Players FG Ranking -->
        <div class="tab-pane fade <?= $active_tab == 'players-fg' ? 'show active' : '' ?>" id="players-fg" role="tabpanel" aria-labelledby="players-fg-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-percentage me-2"></i> Classement des joueurs par Field Goal</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Position</th>
                                    <th>ID Joueur</th>
                                    <th>Nom</th>
                                    <th>Field Goal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_fg_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['stat_fg'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($fg_total_pages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Pagination des joueurs (field goal)">
                        <ul class="pagination justify-content-center mb-0">
                            <?php
                            // Afficher seulement la pagination compacte
                            $range = 2; // Nombre de pages à afficher avant et après la page courante
                            
                            // Lien "Précédent"
                            if ($fg_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-fg&fg_page=<?= $fg_page-1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif;
                            
                            // Première page
                            if ($fg_page > $range + 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-fg&fg_page=1&season=<?= $selected_season ?>">1</a>
                                </li>
                                <?php if ($fg_page > $range + 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                            endif;
                            
                            // Pages autour de la page courante
                            for ($i = max(1, $fg_page - $range); $i <= min($fg_total_pages, $fg_page + $range); $i++): ?>
                                <li class="page-item <?= $i == $fg_page ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?element=classement&tab=players-fg&fg_page=<?= $i ?>&season=<?= $selected_season ?>"><?= $i ?></a>
                                </li>
                            <?php endfor;
                            
                            // Dernière page
                            if ($fg_page < $fg_total_pages - $range): 
                                if ($fg_page < $fg_total_pages - $range - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-fg&fg_page=<?= $fg_total_pages ?>&season=<?= $selected_season ?>"><?= $fg_total_pages ?></a>
                                </li>
                            <?php endif;
                            
                            // Lien "Suivant"
                            if ($fg_page < $fg_total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-fg&fg_page=<?= $fg_page+1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Players Minutes Ranking -->
        <div class="tab-pane fade <?= $active_tab == 'players-minutes' ? 'show active' : '' ?>" id="players-minutes" role="tabpanel" aria-labelledby="players-minutes-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i> Classement des joueurs par minutes jouées</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Position</th>
                                    <th>ID Joueur</th>
                                    <th>Nom</th>
                                    <th>Minutes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_minutes_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['stat_minutes'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($minutes_total_pages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Pagination des joueurs (minutes)">
                        <ul class="pagination justify-content-center mb-0">
                            <?php
                            // Afficher seulement la pagination compacte
                            $range = 2; // Nombre de pages à afficher avant et après la page courante
                            
                            // Lien "Précédent"
                            if ($minutes_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-minutes&minutes_page=<?= $minutes_page-1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif;
                            
                            // Première page
                            if ($minutes_page > $range + 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-minutes&minutes_page=1&season=<?= $selected_season ?>">1</a>
                                </li>
                                <?php if ($minutes_page > $range + 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                            endif;
                            
                            // Pages autour de la page courante
                            for ($i = max(1, $minutes_page - $range); $i <= min($minutes_total_pages, $minutes_page + $range); $i++): ?>
                                <li class="page-item <?= $i == $minutes_page ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?element=classement&tab=players-minutes&minutes_page=<?= $i ?>&season=<?= $selected_season ?>"><?= $i ?></a>
                                </li>
                            <?php endfor;
                            
                            // Dernière page
                            if ($minutes_page < $minutes_total_pages - $range): 
                                if ($minutes_page < $minutes_total_pages - $range - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-minutes&minutes_page=<?= $minutes_total_pages ?>&season=<?= $selected_season ?>"><?= $minutes_total_pages ?></a>
                                </li>
                            <?php endif;
                            
                            // Lien "Suivant"
                            if ($minutes_page < $minutes_total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-minutes&minutes_page=<?= $minutes_page+1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Players Shot Ranking -->
        <div class="tab-pane fade <?= $active_tab == 'players-shot' ? 'show active' : '' ?>" id="players-shot" role="tabpanel" aria-labelledby="players-shot-tab">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i> Classement des joueurs par tirs</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Position</th>
                                    <th>ID Joueur</th>
                                    <th>Nom</th>
                                    <th>Tirs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_shot_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['stat_tir'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($shot_total_pages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Pagination des joueurs (tirs)">
                        <ul class="pagination justify-content-center mb-0">
                            <?php
                            // Afficher seulement la pagination compacte
                            $range = 2; // Nombre de pages à afficher avant et après la page courante
                            
                            // Lien "Précédent"
                            if ($shot_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-shot&shot_page=<?= $shot_page-1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif;
                            
                            // Première page
                            if ($shot_page > $range + 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-shot&shot_page=1&season=<?= $selected_season ?>">1</a>
                                </li>
                                <?php if ($shot_page > $range + 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                            endif;
                            
                            // Pages autour de la page courante
                            for ($i = max(1, $shot_page - $range); $i <= min($shot_total_pages, $shot_page + $range); $i++): ?>
                                <li class="page-item <?= $i == $shot_page ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?element=classement&tab=players-shot&shot_page=<?= $i ?>&season=<?= $selected_season ?>"><?= $i ?></a>
                                </li>
                            <?php endfor;
                            
                            // Dernière page
                            if ($shot_page < $shot_total_pages - $range): 
                                if ($shot_page < $shot_total_pages - $range - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-shot&shot_page=<?= $shot_total_pages ?>&season=<?= $selected_season ?>"><?= $shot_total_pages ?></a>
                                </li>
                            <?php endif;
                            
                            // Lien "Suivant"
                            if ($shot_page < $shot_total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=classement&tab=players-shot&shot_page=<?= $shot_page+1 ?>&season=<?= $selected_season ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour améliorer l'expérience utilisateur avec onglets -->
<script>
    // Gestion des clics sur les onglets pour mettre à jour l'URL
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
            // Récupérer l'ID de l'onglet actif
            const tabId = this.id.replace('-tab', '');
            
            // Construire l'URL avec les paramètres
            let url = new URL(window.location.href);
            url.searchParams.set('tab', tabId);
            
            // Mettre à jour l'historique du navigateur sans recharger la page
            history.pushState({}, '', url);
        });
    });
</script>