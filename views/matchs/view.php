<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Détails du match</h1>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-secondary me-2">
                    <?= date('d/m/Y', strtotime($match['game_date_est'])) ?>
                </span>
                <?php if (isset($season)): ?>
                    <span class="badge bg-primary">Saison <?= $season ?>-<?= $season + 1 ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=matchs" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux matchs
            </a>
        </div>
    </div>

    <!-- Tableau des scores -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Résultat</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-5">
                            <a href="index.php?element=equipes&action=view&abbr=<?= $match['team_abbreviation_home'] ?>&season=<?= $season ?>" class="text-decoration-none">
                                <h4><?= htmlspecialchars($match['home_team_name'] ?? $match['team_abbreviation_home']) ?></h4>
                                <span class="badge bg-secondary"><?= $match['team_abbreviation_home'] ?></span>
                            </a>
                        </div>
                        <div class="col-2">
                            <h2 class="display-5 fw-bold">
                                <?= $match['pts_home'] ?> - <?= $match['pts_away'] ?>
                            </h2>
                        </div>
                        <div class="col-5">
                            <a href="index.php?element=equipes&action=view&abbr=<?= $match['team_abbreviation_away'] ?>&season=<?= $season ?>" class="text-decoration-none">
                                <h4><?= htmlspecialchars($match['away_team_name'] ?? $match['team_abbreviation_away']) ?></h4>
                                <span class="badge bg-secondary"><?= $match['team_abbreviation_away'] ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques des équipes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Statistiques des équipes</h3>
                </div>
                <div class="card-body">
                    <?php if ($homeStats && $awayStats): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Statistique</th>
                                        <th class="text-center"><?= htmlspecialchars($match['home_team_name'] ?? $match['team_abbreviation_home']) ?></th>
                                        <th class="text-center"><?= htmlspecialchars($match['away_team_name'] ?? $match['team_abbreviation_away']) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Points par match</td>
                                        <td class="text-center"><?= number_format($homeStats['pts_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($awayStats['pts_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>% Tirs</td>
                                        <td class="text-center"><?= number_format($homeStats['fg_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center"><?= number_format($awayStats['fg_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>% 3-points</td>
                                        <td class="text-center"><?= number_format($homeStats['x3p_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center"><?= number_format($awayStats['x3p_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>% Lancers-francs</td>
                                        <td class="text-center"><?= number_format($homeStats['ft_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center"><?= number_format($awayStats['ft_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>Rebonds</td>
                                        <td class="text-center"><?= number_format($homeStats['trb_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($awayStats['trb_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Passes</td>
                                        <td class="text-center"><?= number_format($homeStats['ast_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($awayStats['ast_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Interceptions</td>
                                        <td class="text-center"><?= number_format($homeStats['stl_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($awayStats['stl_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Contres</td>
                                        <td class="text-center"><?= number_format($homeStats['blk_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($awayStats['blk_par_match'], 1) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Les statistiques détaillées des équipes ne sont pas disponibles pour ce match.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Performances des joueurs -->
    <div class="row">
        <!-- Joueurs équipe domicile -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <?= htmlspecialchars($match['home_team_name'] ?? $match['team_abbreviation_home']) ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (count($homePlayers) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Joueur</th>
                                        <th class="text-center">MIN</th>
                                        <th class="text-center">PTS</th>
                                        <th class="text-center">REB</th>
                                        <th class="text-center">AST</th>
                                        <th class="text-center">FG%</th>
                                        <th class="text-center">3P%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($homePlayers as $player): ?>
                                        <tr>
                                            <td>
                                                <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($player['nom_joueur']) ?>&season=<?= $player['saison'] ?>">
                                                    <?= htmlspecialchars($player['nom_joueur']) ?>
                                                </a>
                                            </td>
                                            <td class="text-center"><?= number_format($player['minutes_jouees'], 1) ?></td>
                                            <td class="text-center fw-bold"><?= $player['points'] ?></td>
                                            <td class="text-center"><?= $player['rebond'] ?></td>
                                            <td class="text-center"><?= $player['passe'] ?></td>
                                            <td class="text-center"><?= number_format($player['pourcent_fg'] * 100, 1) ?>%</td>
                                            <td class="text-center"><?= number_format($player['pourcent_trois_pts'] * 100, 1) ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Les statistiques des joueurs ne sont pas disponibles pour cette équipe.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Joueurs équipe extérieur -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <?= htmlspecialchars($match['away_team_name'] ?? $match['team_abbreviation_away']) ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (count($awayPlayers) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Joueur</th>
                                        <th class="text-center">MIN</th>
                                        <th class="text-center">PTS</th>
                                        <th class="text-center">REB</th>
                                        <th class="text-center">AST</th>
                                        <th class="text-center">FG%</th>
                                        <th class="text-center">3P%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($awayPlayers as $player): ?>
                                        <tr>
                                            <td>
                                                <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($player['nom_joueur']) ?>&season=<?= $player['saison'] ?>">
                                                    <?= htmlspecialchars($player['nom_joueur']) ?>
                                                </a>
                                            </td>
                                            <td class="text-center"><?= number_format($player['minutes_jouees'], 1) ?></td>
                                            <td class="text-center fw-bold"><?= $player['points'] ?></td>
                                            <td class="text-center"><?= $player['rebond'] ?></td>
                                            <td class="text-center"><?= $player['passe'] ?></td>
                                            <td class="text-center"><?= number_format($player['pourcent_fg'] * 100, 1) ?>%</td>
                                            <td class="text-center"><?= number_format($player['pourcent_trois_pts'] * 100, 1) ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Les statistiques des joueurs ne sont pas disponibles pour cette équipe.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
