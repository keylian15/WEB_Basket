<!-- Main Content -->
<div class="container">
    <!-- Hero Section -->
    <div class="jumbotron bg-primary text-white rounded p-5 mb-4 shadow">
        <h1 class="display-4">NBA Predictor</h1>
        <p class="lead">Analysez les performances NBA et obtenez des prédictions intelligentes sur les résultats des matchs</p>
        <hr class="my-4 bg-white">
        <p>Explorez nos statistiques détaillées, suivez vos équipes préférées et découvrez nos prédictions basées sur l'intelligence artificielle.</p>
        <a class="btn btn-light btn-lg" href="<?php echo url('predictions'); ?>" role="button">Voir les prédictions</a>
    </div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Équipes</h5>
                    <p class="card-text display-4"><?php echo $stats['teamCount']; ?></p>
                    <a href="<?php echo url('teams'); ?>" class="btn btn-outline-primary">Voir toutes les équipes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Joueurs</h5>
                    <p class="card-text display-4"><?php echo $stats['playerCount']; ?></p>
                    <a href="<?php echo url('players'); ?>" class="btn btn-outline-primary">Voir tous les joueurs</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Matchs</h5>
                    <p class="card-text display-4"><?php echo $stats['matchCount']; ?></p>
                    <a href="<?php echo url('matches'); ?>" class="btn btn-outline-primary">Voir tous les matchs</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Matchs à venir avec prédictions -->
    <h2 class="mb-4">Matchs à venir</h2>
    <div class="row mb-5">
        <?php if (!empty($upcomingMatches)): ?>
            <?php foreach ($upcomingMatches as $match): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title text-center mb-0">
                                <?php echo e($match['ville_equipe_domicile']); ?> vs 
                                <?php echo e($match['ville_equipe_exterieure']); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-center w-45">
                                    <span class="badge bg-primary p-2"><?php echo e($match['abreviation_equipe_domicile']); ?></span>
                                    <h6 class="mt-2"><?php echo e($match['ville_equipe_domicile']); ?></h6>
                                </div>
                                <div class="text-center">
                                    <span class="fw-bold">VS</span>
                                </div>
                                <div class="text-center w-45">
                                    <span class="badge bg-danger p-2"><?php echo e($match['abreviation_equipe_exterieure']); ?></span>
                                    <h6 class="mt-2"><?php echo e($match['ville_equipe_exterieure']); ?></h6>
                                </div>
                            </div>
                            
                            <?php if (isset($match['probabilite_victoire_domicile']) && isset($match['probabilite_victoire_exterieure'])): ?>
                                <h6 class="text-center mb-3">Probabilités de victoire</h6>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $match['probabilite_victoire_domicile'] * 100; ?>%" 
                                        aria-valuenow="<?php echo $match['probabilite_victoire_domicile'] * 100; ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo number_format($match['probabilite_victoire_domicile'] * 100, 1); ?>%
                                    </div>
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $match['probabilite_victoire_exterieure'] * 100; ?>%" 
                                        aria-valuenow="<?php echo $match['probabilite_victoire_exterieure'] * 100; ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo number_format($match['probabilite_victoire_exterieure'] * 100, 1); ?>%
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">Aucune prédiction disponible</p>
                            <?php endif; ?>
                            
                            <div class="text-center mt-3">
                                <a href="<?php echo url('matches/view/' . $match['id_stat_match']); ?>" class="btn btn-sm btn-outline-secondary">Détails du match</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Aucun match à venir pour le moment.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Featured Predictions -->
    <h2 class="mb-4">Prédictions populaires</h2>
    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tableau des prédictions récentes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Match</th>
                                    <th>Prédiction</th>
                                    <th>Confiance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentPredictions)): ?>
                                    <?php foreach ($recentPredictions as $prediction): ?>
                                        <tr>
                                            <td><?php echo formatDate($prediction['date_prediction'], 'j M Y'); ?></td>
                                            <td><?php echo e($prediction['equipe_domicile']); ?> vs. <?php echo e($prediction['equipe_exterieure']); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $prediction['probabilite_victoire_domicile'] > $prediction['probabilite_victoire_exterieure'] ? 'primary' : 'danger'; ?>">
                                                    <?php echo e($prediction['probabilite_victoire_domicile'] > $prediction['probabilite_victoire_exterieure'] ? $prediction['equipe_domicile'] : $prediction['equipe_exterieure']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php $confiance = max($prediction['probabilite_victoire_domicile'], $prediction['probabilite_victoire_exterieure']) * 100; ?>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-success" style="width: <?php echo $confiance; ?>%"></div>
                                                </div>
                                                <small><?php echo number_format($confiance, 1); ?>%</small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Aucune prédiction récente.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="<?php echo url('predictions'); ?>" class="btn btn-primary">Voir toutes les prédictions</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Créer votre prédiction</h5>
                </div>
                <div class="card-body">
                    <p>Utilisez notre modèle prédictif pour analyser les probabilités de victoire entre deux équipes.</p>
                    <form action="<?php echo url('predictions/generate'); ?>" method="get">
                        <div class="mb-3">
                            <label for="homeTeam" class="form-label">Équipe à domicile</label>
                            <select class="form-select" id="homeTeam" name="home_team" required>
                                <option value="" selected disabled>Choisir une équipe...</option>
                                <!-- Les options seraient générées dynamiquement par PHP -->
                                <?php foreach ($teams ?? [] as $team): ?>
                                    <option value="<?php echo $team['id_club']; ?>"><?php echo e($team['ville_club']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="awayTeam" class="form-label">Équipe à l'extérieur</label>
                            <select class="form-select" id="awayTeam" name="away_team" required>
                                <option value="" selected disabled>Choisir une équipe...</option>
                                <!-- Les options seraient générées dynamiquement par PHP -->
                                <?php foreach ($teams ?? [] as $team): ?>
                                    <option value="<?php echo $team['id_club']; ?>"><?php echo e($team['ville_club']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Générer une prédiction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Players -->
    <h2 class="mb-4">Joueurs en vedette</h2>
    <div class="row mb-5">
        <?php if (!empty($featuredPlayers)): ?>
            <?php foreach ($featuredPlayers as $player): ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center h-100">
                        <img src="<?php echo asset('img/players/' . ($player['photo'] ?? 'default.png')); ?>" class="card-img-top" alt="<?php echo e($player['full_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($player['full_name']); ?></h5>
                            <p class="card-text"><?php echo e($player['equipe']); ?> | #<?php echo e($player['numero_maillot'] ?? '00'); ?></p>
                            <a href="<?php echo url('players/view/' . $player['id_joueur']); ?>" class="btn btn-sm btn-outline-primary">Voir le profil</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Aucun joueur en vedette pour le moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>