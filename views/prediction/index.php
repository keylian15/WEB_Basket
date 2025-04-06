<div class="container-fluid mt-5 pt-5">
    <h1 class="display-4 mb-4"><i class="fas fa-crystal-ball me-2"></i> Prédiction de Matchs</h1>
    
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i> Sélectionner les équipes</h5>
                </div>
                <div class="card-body">
                    <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?= $error_message ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="post" action="index.php?element=prediction">
                        <div class="row g-3 mb-3">
                            <div class="col-md-5">
                                <label for="home_team" class="form-label">Équipe à domicile</label>
                                <select class="form-select" id="home_team" name="home_team" required>
                                    <option value="" disabled <?= empty($home_team) ? 'selected' : '' ?>>Sélectionner une équipe</option>
                                    <?php foreach ($teams as $team): ?>
                                    <option value="<?= $team['abr_equipe'] ?>" <?= $home_team === $team['abr_equipe'] ? 'selected' : '' ?>>
                                        <?= $team['team_name'] ?> (<?= $team['abr_equipe'] ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                <span class="fs-4 text-center">VS</span>
                            </div>
                            
                            <div class="col-md-5">
                                <label for="away_team" class="form-label">Équipe à l'extérieur</label>
                                <select class="form-select" id="away_team" name="away_team" required>
                                    <option value="" disabled <?= empty($away_team) ? 'selected' : '' ?>>Sélectionner une équipe</option>
                                    <?php foreach ($teams as $team): ?>
                                    <option value="<?= $team['abr_equipe'] ?>" <?= $away_team === $team['abr_equipe'] ? 'selected' : '' ?>>
                                        <?= $team['team_name'] ?> (<?= $team['abr_equipe'] ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" name="predict" class="btn btn-primary">
                                <i class="fas fa-chart-line me-2"></i> Prédire le résultat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php if ($prediction_result && isset($prediction_result['prediction'])): ?>
        <div class="col-12">
            <?php 
                $winner = $prediction_result['prediction']['winner'];
                $percent = $prediction_result['prediction']['percent'];
                $has_stats = isset($prediction_result['matchPrediction']['minute_par_match']) && $prediction_result['matchPrediction']['minute_par_match'] !== null;
                
                $winner_text = '';
                $winner_team = '';
                
                if ($winner === 'abr_home') {
                    $winner_text = 'l\'équipe à domicile';
                    $winner_team = $home_team;
                } elseif ($winner === 'abr_away') {
                    $winner_text = 'l\'équipe à l\'extérieur';
                    $winner_team = $away_team;
                } elseif ($winner === 'draw') {
                    $winner_text = 'match nul';
                    $winner_team = "égalité";
                }
            ?>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i> Résultat de la Prédiction</h5>
                </div>
                <div class="card-body">
                    <?php if (!$has_stats): ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> Aucune donnée disponible pour ce match.
                        </div>
                    <?php else: ?>
                        <div class="text-center mb-4">
                            <h4 class="mb-3">Vainqueur Prédit: <strong><?= $winner_team ?></strong></h4>
                            <div class="progress" style="height: 30px;">
                                <?php
                                $home_percent = $winner === 'abr_home' ? $percent : 100 - $percent;
                                $away_percent = $winner === 'abr_away' ? $percent : 100 - $percent;
                                if ($winner === 'draw') {
                                    $home_percent = 50;
                                    $away_percent = 50;
                                }
                                ?>
                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $home_percent ?>%"
                                     aria-valuenow="<?= $home_percent ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= $home_team ?> (<?= $home_percent ?>%)
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $away_percent ?>%"
                                     aria-valuenow="<?= $away_percent ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= $away_team ?> (<?= $away_percent ?>%)
                                </div>
                            </div>
                            <p class="mt-2 text-muted">Pourcentage de confiance: <?= $percent ?>%</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($has_stats): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Statistiques Prédites du Match</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Statistique</th>
                                    <th>Valeur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Minutes par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['minute_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Tirs réussis par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['fg_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Tirs tentés par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['fga_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Pourcentage de tirs réussis</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['fg_pourcent'] * 100, 2) ?>%</td>
                                </tr>
                                <tr>
                                    <td>Tirs à 3 points réussis par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['x3p_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Tirs à 3 points tentés par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['x3pa_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Pourcentage de tirs à 3 points réussis</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['x3p_pourcent'] * 100, 2) ?>%</td>
                                </tr>
                                <tr>
                                    <td>Tirs à 2 points réussis par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['x2p_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Tirs à 2 points tentés par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['x2pa_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Pourcentage de tirs à 2 points réussis</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['x2p_pourcent'] * 100, 2) ?>%</td>
                                </tr>
                                <tr>
                                    <td>Lancers francs réussis par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['ft_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Lancers francs tentés par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['fta_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Pourcentage de lancers francs réussis</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['ft_pourcent'] * 100, 2) ?>%</td>
                                </tr>
                                <tr>
                                    <td>Rebonds offensifs par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['orb_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Rebonds défensifs par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['drb_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Total des rebonds par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['trb_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Passes décisives par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['ast_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Interceptions par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['stl_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Contres par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['blk_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Pertes de balle par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['tov_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Fautes personnelles par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['pf_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Points par match</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['pts_par_match'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Possessions</td>
                                    <td><?= number_format($prediction_result['matchPrediction']['possession'], 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>