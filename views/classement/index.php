<?php
/**
 * View for the ranking page
 */
include 'inc/top.php';
?>

<div class="container-fluid mt-5 pt-5">
    <h1 class="display-4 mb-4"><i class="fas fa-list-ol me-2"></i> Classements</h1>
    
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4" id="rankingTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'teams' ? 'active' : '' ?>" id="teams-tab" data-bs-toggle="tab" data-bs-target="#teams" type="button" role="tab" aria-controls="teams" aria-selected="<?= $active_tab == 'teams' ? 'true' : 'false' ?>">
                <i class="fas fa-shield-alt me-1"></i> Équipes (Points par match)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-points' ? 'active' : '' ?>" id="players-points-tab" data-bs-toggle="tab" data-bs-target="#players-points" type="button" role="tab" aria-controls="players-points" aria-selected="<?= $active_tab == 'players-points' ? 'true' : 'false' ?>">
                <i class="fas fa-basketball-ball me-1"></i> Joueurs (Points)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-fg' ? 'active' : '' ?>" id="players-fg-tab" data-bs-toggle="tab" data-bs-target="#players-fg" type="button" role="tab" aria-controls="players-fg" aria-selected="<?= $active_tab == 'players-fg' ? 'true' : 'false' ?>">
                <i class="fas fa-percentage me-1"></i> Joueurs (Field Goal)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-minutes' ? 'active' : '' ?>" id="players-minutes-tab" data-bs-toggle="tab" data-bs-target="#players-minutes" type="button" role="tab" aria-controls="players-minutes" aria-selected="<?= $active_tab == 'players-minutes' ? 'true' : 'false' ?>">
                <i class="fas fa-clock me-1"></i> Joueurs (Minutes)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'players-shot' ? 'active' : '' ?>" id="players-shot-tab" data-bs-toggle="tab" data-bs-target="#players-shot" type="button" role="tab" aria-controls="players-shot" aria-selected="<?= $active_tab == 'players-shot' ? 'true' : 'false' ?>">
                <i class="fas fa-bullseye me-1"></i> Joueurs (Tirs)
            </button>
        </li>
    </ul>
    
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
                                    <th>Saison</th>
                                    <th>Équipe</th>
                                    <th>Points par match</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teams_ranking as $team): ?>
                                <tr>
                                    <td><?= $team['classement'] ?></td>
                                    <td><?= $team['saison'] ?></td>
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
                            <?php for ($i = 1; $i <= $teams_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $teams_page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?element=classement&tab=teams&teams_page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
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
                                    <th>Saison</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_points_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['saison'] ?></td>
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
                            <?php for ($i = 1; $i <= $points_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $points_page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?element=classement&tab=players-points&points_page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
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
                                    <th>Saison</th>
                                    <th>Field Goal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_fg_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['saison'] ?></td>
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
                            <?php for ($i = 1; $i <= $fg_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $fg_page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?element=classement&tab=players-fg&fg_page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
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
                                    <th>Saison</th>
                                    <th>Minutes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_minutes_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['saison'] ?></td>
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
                            <?php for ($i = 1; $i <= $minutes_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $minutes_page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?element=classement&tab=players-minutes&minutes_page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
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
                                    <th>Saison</th>
                                    <th>Tirs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players_shot_ranking as $player): ?>
                                <tr>
                                    <td><?= $player['position'] ?></td>
                                    <td><?= $player['id_joueur'] ?></td>
                                    <td><?= $player['nom_joueur'] ?></td>
                                    <td><?= $player['saison'] ?></td>
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
                            <?php for ($i = 1; $i <= $shot_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $shot_page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?element=classement&tab=players-shot&shot_page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'inc/bottom.php';
?>
