<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Joueurs NBA</h1>
            <p class="text-muted">Liste des joueurs NBA et leurs statistiques.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="fas fa-home"></i> Accueil
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Recherche et Filtres</h3>
        </div>
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <input type="hidden" name="element" value="joueurs">
                
                <div class="col-md-4">
                    <label for="search" class="form-label">Rechercher un joueur</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nom du joueur" value="<?= htmlspecialchars($search) ?>">
                </div>
                
                <div class="col-md-2">
                    <label for="season" class="form-label">Saison</label>
                    <select name="season" id="season" class="form-select">
                        <option value="">Toutes les saisons</option>
                        <?php foreach ($seasons as $s): ?>
                            <option value="<?= $s ?>" <?= $season == $s ? 'selected' : '' ?>>
                                <?= $s ?>-<?= $s + 1 ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="team" class="form-label">Équipe</label>
                    <select name="team" id="team" class="form-select">
                        <option value="">Toutes les équipes</option>
                        <?php foreach ($teams as $t): ?>
                            <option value="<?= $t['abr_equipe'] ?>" <?= $team == $t['abr_equipe'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['team_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="position" class="form-label">Poste</label>
                    <select name="position" id="position" class="form-select">
                        <option value="">Tous les postes</option>
                        <?php foreach ($positions as $p): ?>
                            <option value="<?= $p ?>" <?= $position == $p ? 'selected' : '' ?>>
                                <?= $p ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des joueurs -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Joueurs (<?= $totalCount ?>)</h3>
        </div>
        <div class="card-body">
            <?php if (count($players) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Joueur</th>
                                <th>Équipe</th>
                                <th>Saison</th>
                                <th>MIN</th>
                                <th>PTS</th>
                                <th>REB</th>
                                <th>AST</th>
                                <th>FG%</th>
                                <th>3P%</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($players as $player): ?>
                                <tr>
                                    <td><?= htmlspecialchars($player['nom_joueur']) ?></td>
                                    <td>
                                        <a href="index.php?element=equipes&action=view&abbr=<?= $player['abr_equipe'] ?>&season=<?= $player['saison'] ?>">
                                            <?= htmlspecialchars($player['team_name'] ?? $player['abr_equipe']) ?>
                                        </a>
                                    </td>
                                    <td><?= $player['saison'] ?>-<?= $player['saison'] + 1 ?></td>
                                    <td><?= number_format($player['minutes_jouees'], 1) ?></td>
                                    <td class="fw-bold"><?= number_format($player['points'], 1) ?></td>
                                    <td><?= number_format($player['rebond'], 1) ?></td>
                                    <td><?= number_format($player['passe'], 1) ?></td>
                                    <td><?= number_format($player['pourcent_fg'] * 100, 1) ?>%</td>
                                    <td><?= number_format($player['pourcent_trois_pts'] * 100, 1) ?>%</td>
                                    <td>
                                        <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($player['nom_joueur']) ?>&season=<?= $player['saison'] ?>" class="btn btn-sm btn-outline-primary">
                                            Profil
                                        </a>
                                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                            <a href="index.php?element=joueurs&action=delete&nom_joueur=<?= urlencode($player['nom_joueur']) ?>&abr_equipe=<?= $player['abr_equipe'] ?>&saison=<?= $player['saison'] ?>" 
                                               class="btn btn-sm btn-outline-danger ms-1" 
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ? Cette action est irréversible.')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=joueurs&page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&season=<?= $season ?>&team=<?= $team ?>&position=<?= $position ?>">
                                        Précédent
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" href="index.php?element=joueurs&page=1&search=' . urlencode($search) . '&season=' . $season . '&team=' . $team . '&position=' . $position . '">1</a></li>';
                                if ($startPage > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                        <a class="page-link" href="index.php?element=joueurs&page=' . $i . '&search=' . urlencode($search) . '&season=' . $season . '&team=' . $team . '&position=' . $position . '">' . $i . '</a>
                                      </li>';
                            }
                            
                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="index.php?element=joueurs&page=' . $totalPages . '&search=' . urlencode($search) . '&season=' . $season . '&team=' . $team . '&position=' . $position . '">' . $totalPages . '</a></li>';
                            }
                            ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=joueurs&page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&season=<?= $season ?>&team=<?= $team ?>&position=<?= $position ?>">
                                        Suivant
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Aucun joueur ne correspond à vos critères de recherche.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
