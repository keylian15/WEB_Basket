<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><?= htmlspecialchars($player['nom_joueur']) ?></h1>
            <div class="d-flex align-items-center mb-3">
                <a href="index.php?element=equipes&action=view&abbr=<?= $player['abr_equipe'] ?>&season=<?= $player['saison'] ?>" class="badge bg-primary me-2 text-decoration-none">
                    <?= htmlspecialchars($player['team_name'] ?? $player['abr_equipe']) ?>
                </a>
                <span class="badge bg-secondary">Saison <?= $player['saison'] ?>-<?= $player['saison'] + 1 ?></span>
            </div>
            
            <!-- Navigation entre les saisons du joueur -->
            <?php if (count($playerSeasons) > 1): ?>
                <div class="btn-group mb-4">
                    <?php foreach ($playerSeasons as $playerSeason): ?>
                        <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($player['nom_joueur']) ?>&season=<?= $playerSeason['saison'] ?>" 
                           class="btn <?= $player['saison'] == $playerSeason['saison'] ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <?= $playerSeason['saison'] ?>-<?= $playerSeason['saison'] + 1 ?>
                            <?php if ($playerSeason['abr_equipe'] !== $player['abr_equipe']): ?>
                                (<?= $playerSeason['abr_equipe'] ?>)
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=joueurs" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux joueurs
            </a>
        </div>
    </div>

    <!-- Statistiques du joueur -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Statistiques par match</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Points</h5>
                                    <p class="card-text fw-bold fs-4"><?= number_format($player['points'], 1) ?></p>
                                    <p class="card-text text-muted">par match</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Rebonds</h5>
                                    <p class="card-text fw-bold fs-4"><?= number_format($player['rebond'], 1) ?></p>
                                    <p class="card-text text-muted">par match</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Passes</h5>
                                    <p class="card-text fw-bold fs-4"><?= number_format($player['passe'], 1) ?></p>
                                    <p class="card-text text-muted">par match</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Minutes</h5>
                                    <p class="card-text fw-bold fs-4"><?= number_format($player['minutes_jouees'], 1) ?></p>
                                    <p class="card-text text-muted">par match</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques détaillées -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4>Statistiques offensives</h4>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Points par match</td>
                                        <td class="fw-bold"><?= number_format($player['points'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>% Tirs (FG)</td>
                                        <td class="fw-bold"><?= number_format($player['pourcent_fg'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>% 3 Points</td>
                                        <td class="fw-bold"><?= number_format($player['pourcent_trois_pts'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>% Lancers francs</td>
                                        <td class="fw-bold"><?= number_format($player['pourcent_ft'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>Passes par match</td>
                                        <td class="fw-bold"><?= number_format($player['passe'], 1) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Statistiques défensives</h4>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Rebonds par match</td>
                                        <td class="fw-bold"><?= number_format($player['rebond'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Interceptions par match</td>
                                        <td class="fw-bold"><?= number_format($player['interception'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Contres par match</td>
                                        <td class="fw-bold"><?= number_format($player['contre'], 1) ?></td>
                                    </tr>
                                    <?php if ($advancedStats): ?>
                                    <tr>
                                        <td>PER (Player Efficiency Rating)</td>
                                        <td class="fw-bold"><?= number_format($advancedStats['per'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Win Shares</td>
                                        <td class="fw-bold"><?= number_format($advancedStats['ws'], 1) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers matchs du joueur -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Derniers matchs</h3>
                </div>
                <div class="card-body">
                    <?php if (count($gameLogs) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Match</th>
                                        <th>MIN</th>
                                        <th>PTS</th>
                                        <th>REB</th>
                                        <th>AST</th>
                                        <th>FG</th>
                                        <th>3P</th>
                                        <th>FT</th>
                                        <th>STL</th>
                                        <th>BLK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($gameLogs as $game): ?>
                                        <?php
                                        $homeTeam = $game['home_team_name'] ?? $game['team_abbreviation_home'];
                                        $awayTeam = $game['away_team_name'] ?? $game['team_abbreviation_away'];
                                        $homeAbbr = $game['team_abbreviation_home'];
                                        $awayAbbr = $game['team_abbreviation_away'];
                                        $isHomeGame = $player['abr_equipe'] === $homeAbbr;
                                        $opponent = $isHomeGame ? $awayTeam : $homeTeam;
                                        $opponentAbbr = $isHomeGame ? $awayAbbr : $homeAbbr;
                                        $result = ($isHomeGame && $game['pts_home'] > $game['pts_away']) || (!$isHomeGame && $game['pts_away'] > $game['pts_home']) ? 'V' : 'D';
                                        $score = $isHomeGame ? $game['pts_home'] . '-' . $game['pts_away'] : $game['pts_away'] . '-' . $game['pts_home'];
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($game['game_date_est'])) ?></td>
                                            <td>
                                                <?= $isHomeGame ? 'vs ' : '@' ?>
                                                <a href="index.php?element=equipes&action=view&abbr=<?= $opponentAbbr ?>&season=<?= $player['saison'] ?>">
                                                    <?= htmlspecialchars($opponent) ?>
                                                </a>
                                                <span class="badge <?= $result === 'V' ? 'bg-success' : 'bg-danger' ?>"><?= $result ?> <?= $score ?></span>
                                            </td>
                                            <td><?= isset($game['min']) ? number_format($game['min'], 0) : '-' ?></td>
                                            <td class="fw-bold"><?= isset($game['pts']) ? number_format($game['pts'], 0) : '-' ?></td>
                                            <td><?= isset($game['reb']) ? number_format($game['reb'], 0) : '-' ?></td>
                                            <td><?= isset($game['ast']) ? number_format($game['ast'], 0) : '-' ?></td>
                                            <td><?= isset($game['fg']) && isset($game['fga']) ? number_format($game['fg']) . '/' . number_format($game['fga']) : '-' ?></td>
                                            <td><?= isset($game['fg3']) && isset($game['fg3a']) ? number_format($game['fg3']) . '/' . number_format($game['fg3a']) : '-' ?></td>
                                            <td><?= isset($game['ft']) && isset($game['fta']) ? number_format($game['ft']) . '/' . number_format($game['fta']) : '-' ?></td>
                                            <td><?= isset($game['stl']) ? number_format($game['stl'], 0) : '-' ?></td>
                                            <td><?= isset($game['blk']) ? number_format($game['blk'], 0) : '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">Aucune donnée de match disponible pour ce joueur.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Joueurs similaires -->
    <?php if (count($similarPlayers) > 0): ?>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Joueurs similaires</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($similarPlayers as $similarPlayer): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($similarPlayer['nom_joueur']) ?>&season=<?= $similarPlayer['saison'] ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($similarPlayer['nom_joueur']) ?>
                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            <a href="index.php?element=equipes&action=view&abbr=<?= $similarPlayer['abr_equipe'] ?>&season=<?= $similarPlayer['saison'] ?>" class="badge bg-primary text-decoration-none">
                                                <?= htmlspecialchars($similarPlayer['team_name'] ?? $similarPlayer['abr_equipe']) ?>
                                            </a>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center">
                                                <small class="d-block text-muted">PTS</small>
                                                <strong><?= number_format($similarPlayer['points'], 1) ?></strong>
                                            </div>
                                            <div class="text-center">
                                                <small class="d-block text-muted">REB</small>
                                                <strong><?= number_format($similarPlayer['rebond'], 1) ?></strong>
                                            </div>
                                            <div class="text-center">
                                                <small class="d-block text-muted">AST</small>
                                                <strong><?= number_format($similarPlayer['passe'], 1) ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="index.php?element=joueurs&action=compare&joueur1=<?= urlencode($player['nom_joueur']) ?>&joueur2=<?= urlencode($similarPlayer['nom_joueur']) ?>&season=<?= $player['saison'] ?>" class="btn btn-sm btn-outline-primary w-100">
                                            Comparer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
