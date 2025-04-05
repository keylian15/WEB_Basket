<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Matchs NBA</h1>
            <p class="text-muted">Historique des matchs NBA et leurs résultats.</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <input type="hidden" name="element" value="matchs">
                
                <div class="col-md-3">
                    <label for="season" class="form-label">Saison</label>
                    <select name="season" id="season" class="form-select">
                        <?php foreach ($seasons as $s): ?>
                            <option value="<?= $s ?>" <?= $season == $s ? 'selected' : '' ?>><?= $s ?>-<?= $s + 1 ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="team" class="form-label">Équipe</label>
                    <select name="team" id="team" class="form-select">
                        <option value="">Toutes les équipes</option>
                        <?php foreach ($teams as $t): ?>
                            <option value="<?= $t['abr_equipe'] ?>" <?= $team == $t['abr_equipe'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['team_name']) ?> (<?= $t['abr_equipe'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Date début</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="<?= $dateFrom ?>">
                </div>
                
                <div class="col-md-2">
                    <label for="date_to" class="form-label">Date fin</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="<?= $dateTo ?>">
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des matchs -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Matchs (<?= $totalCount ?>)</h3>
        </div>
        <div class="card-body">
            <?php if (count($matchs) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Équipe Domicile</th>
                                <th>Score</th>
                                <th>Équipe Extérieur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matchs as $match): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($match['game_date_est'])) ?></td>
                                    <td>
                                        <a href="index.php?element=equipes&action=view&abbr=<?= $match['team_abbreviation_home'] ?>&season=<?= $season ?>">
                                            <?= htmlspecialchars($match['home_team_name'] ?? $match['team_abbreviation_home']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center fw-bold">
                                        <?= $match['pts_home'] ?> - <?= $match['pts_away'] ?>
                                    </td>
                                    <td>
                                        <a href="index.php?element=equipes&action=view&abbr=<?= $match['team_abbreviation_away'] ?>&season=<?= $season ?>">
                                            <?= htmlspecialchars($match['away_team_name'] ?? $match['team_abbreviation_away']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="index.php?element=matchs&action=view&id=<?= $match['game_id'] ?>" class="btn btn-sm btn-outline-primary">
                                            Détails
                                        </a>
                                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                            <a href="index.php?element=matchs&action=delete&id=<?= $match['game_id'] ?>" 
                                               class="btn btn-sm btn-outline-danger ms-1" 
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce match ? Cette action est irréversible.')">
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
                                    <a class="page-link" href="index.php?element=matchs&page=<?= $page - 1 ?>&season=<?= $season ?>&team=<?= $team ?>&date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>">
                                        Précédent
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php 
                            $startPage = max(1, min($page - 2, $totalPages - 4));
                            $endPage = min($totalPages, max($page + 2, 5));
                            
                            if ($startPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=matchs&page=1&season=<?= $season ?>&team=<?= $team ?>&date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?element=matchs&page=<?= $i ?>&season=<?= $season ?>&team=<?= $team ?>&date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=matchs&page=<?= $totalPages ?>&season=<?= $season ?>&team=<?= $team ?>&date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>">
                                        <?= $totalPages ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?element=matchs&page=<?= $page + 1 ?>&season=<?= $season ?>&team=<?= $team ?>&date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>">
                                        Suivant
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="alert alert-info">
                    Aucun match ne correspond à vos critères de recherche.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
