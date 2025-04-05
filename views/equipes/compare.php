<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Comparaison d'équipes</h1>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-secondary">Saison <?= $season ?>-<?= $season + 1 ?></span>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=equipes" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux équipes
            </a>
        </div>
    </div>

    <!-- Formulaire de comparaison -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Sélection des équipes</h3>
        </div>
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <input type="hidden" name="element" value="equipes">
                <input type="hidden" name="action" value="compare">
                
                <div class="col-md-4">
                    <label for="team1" class="form-label">Équipe 1</label>
                    <select name="team1" id="team1" class="form-select" required>
                        <option value="">Sélectionnez une équipe</option>
                        <?php foreach ($allTeams as $t): ?>
                            <option value="<?= $t['abr_equipe'] ?>" <?= $team1Abbr == $t['abr_equipe'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['team_name']) ?> (<?= $t['abr_equipe'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="team2" class="form-label">Équipe 2</label>
                    <select name="team2" id="team2" class="form-select" required>
                        <option value="">Sélectionnez une équipe</option>
                        <?php foreach ($allTeams as $t): ?>
                            <option value="<?= $t['abr_equipe'] ?>" <?= $team2Abbr == $t['abr_equipe'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['team_name']) ?> (<?= $t['abr_equipe'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="season" class="form-label">Saison</label>
                    <select name="season" id="season" class="form-select" required>
                        <?php foreach ($seasons as $s): ?>
                            <option value="<?= $s ?>" <?= $season == $s ? 'selected' : '' ?>>
                                <?= $s ?>-<?= $s + 1 ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Comparer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau comparatif -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Statistiques comparatives</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Statistique</th>
                                    <th class="text-center"><?= htmlspecialchars($team1['team_name']) ?></th>
                                    <th class="text-center"><?= htmlspecialchars($team2['team_name']) ?></th>
                                    <th class="text-center">Avantage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($team1Stats && $team2Stats): ?>
                                    <!-- Points par match -->
                                    <tr>
                                        <td>Points par match</td>
                                        <td class="text-center fw-bold"><?= number_format($team1Stats['pts_par_match'], 1) ?></td>
                                        <td class="text-center fw-bold"><?= number_format($team2Stats['pts_par_match'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['pts_par_match'] > $team2Stats['pts_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['pts_par_match'] < $team2Stats['pts_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- % Tirs -->
                                    <tr>
                                        <td>% Tirs (FG)</td>
                                        <td class="text-center"><?= number_format($team1Stats['fg_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center"><?= number_format($team2Stats['fg_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['fg_pourcent'] > $team2Stats['fg_pourcent']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['fg_pourcent'] < $team2Stats['fg_pourcent']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- % 3 Points -->
                                    <tr>
                                        <td>% 3 Points</td>
                                        <td class="text-center"><?= number_format($team1Stats['x3p_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center"><?= number_format($team2Stats['x3p_pourcent'] * 100, 1) ?>%</td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['x3p_pourcent'] > $team2Stats['x3p_pourcent']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['x3p_pourcent'] < $team2Stats['x3p_pourcent']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- Rebonds -->
                                    <tr>
                                        <td>Rebonds par match</td>
                                        <td class="text-center"><?= number_format($team1Stats['trb_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($team2Stats['trb_par_match'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['trb_par_match'] > $team2Stats['trb_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['trb_par_match'] < $team2Stats['trb_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- Passes -->
                                    <tr>
                                        <td>Passes par match</td>
                                        <td class="text-center"><?= number_format($team1Stats['ast_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($team2Stats['ast_par_match'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['ast_par_match'] > $team2Stats['ast_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['ast_par_match'] < $team2Stats['ast_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- Interceptions -->
                                    <tr>
                                        <td>Interceptions par match</td>
                                        <td class="text-center"><?= number_format($team1Stats['stl_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($team2Stats['stl_par_match'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['stl_par_match'] > $team2Stats['stl_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['stl_par_match'] < $team2Stats['stl_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- Contres -->
                                    <tr>
                                        <td>Contres par match</td>
                                        <td class="text-center"><?= number_format($team1Stats['blk_par_match'], 1) ?></td>
                                        <td class="text-center"><?= number_format($team2Stats['blk_par_match'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($team1Stats['blk_par_match'] > $team2Stats['blk_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team1['team_name']) ?></span>
                                            <?php elseif ($team1Stats['blk_par_match'] < $team2Stats['blk_par_match']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($team2['team_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div class="alert alert-info mb-0">
                                                Aucune statistique disponible pour la comparaison.
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prédiction du match -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Prédiction</h3>
                </div>
                <div class="card-body">
                    <?php if ($predictedWinner): ?>
                        <div class="text-center mb-4">
                            <h4>Pronostic du match</h4>
                            <p class="lead">
                                <strong><?= htmlspecialchars($predictedWinner['team_name']) ?></strong> 
                                remporte le match avec 
                                <span class="badge bg-primary"><?= number_format($winProbability, 1) ?>%</span> 
                                de probabilité
                            </p>
                        </div>
                        
                        <div class="prediction-bar position-relative mb-4" style="height: 40px; background-color: #e9ecef; border-radius: 20px; overflow: hidden;">
                            <?php if ($predictedWinner['abr_equipe'] == $team1Abbr): ?>
                                <div class="position-absolute h-100" style="left: 0; width: <?= $winProbability ?>%; background-color: #17408B; color: white; text-align: center; line-height: 40px;">
                                    <?= htmlspecialchars($team1['team_name']) ?> (<?= number_format($winProbability, 1) ?>%)
                                </div>
                                <div class="position-absolute h-100" style="right: 0; width: <?= 100 - $winProbability ?>%; background-color: #C9082A; color: white; text-align: center; line-height: 40px;">
                                    <?= htmlspecialchars($team2['team_name']) ?> (<?= number_format(100 - $winProbability, 1) ?>%)
                                </div>
                            <?php else: ?>
                                <div class="position-absolute h-100" style="left: 0; width: <?= 100 - $winProbability ?>%; background-color: #17408B; color: white; text-align: center; line-height: 40px;">
                                    <?= htmlspecialchars($team1['team_name']) ?> (<?= number_format(100 - $winProbability, 1) ?>%)
                                </div>
                                <div class="position-absolute h-100" style="right: 0; width: <?= $winProbability ?>%; background-color: #C9082A; color: white; text-align: center; line-height: 40px;">
                                    <?= htmlspecialchars($team2['team_name']) ?> (<?= number_format($winProbability, 1) ?>%)
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="alert alert-info">
                            <p><strong>Note :</strong> Cette prédiction est basée sur une analyse statistique des performances des équipes au cours de la saison <?= $season ?>-<?= $season + 1 ?>. La prédiction prend en compte les points marqués, la défense, et d'autres statistiques clés.</p>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <p>Impossible de générer une prédiction avec les données disponibles.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique des confrontations directes -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Historique des confrontations</h3>
                </div>
                <div class="card-body">
                    <?php if (count($directMatches) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Domicile</th>
                                        <th>Score</th>
                                        <th>Extérieur</th>
                                        <th>Vainqueur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($directMatches as $match): ?>
                                        <?php 
                                        $homeScore = $match['pts_home'];
                                        $awayScore = $match['pts_away'];
                                        $homeWin = $homeScore > $awayScore;
                                        $winnerAbbr = $homeWin ? $match['team_abbreviation_home'] : $match['team_abbreviation_away'];
                                        $winnerName = $homeWin ? ($match['home_team_name'] ?? $match['team_abbreviation_home']) : ($match['away_team_name'] ?? $match['team_abbreviation_away']);
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($match['game_date_est'])) ?></td>
                                            <td><?= htmlspecialchars($match['home_team_name'] ?? $match['team_abbreviation_home']) ?></td>
                                            <td class="text-center fw-bold"><?= $homeScore ?> - <?= $awayScore ?></td>
                                            <td><?= htmlspecialchars($match['away_team_name'] ?? $match['team_abbreviation_away']) ?></td>
                                            <td>
                                                <span class="badge <?= $winnerAbbr == $team1Abbr ? 'bg-primary' : 'bg-danger' ?>">
                                                    <?= htmlspecialchars($winnerName) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Aucune confrontation directe trouvée entre ces deux équipes pour la saison <?= $season ?>-<?= $season + 1 ?>.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
