<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Comparaison de joueurs</h1>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-secondary">Saison <?= $season ?>-<?= $season + 1 ?></span>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=joueurs" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux joueurs
            </a>
        </div>
    </div>

    <!-- Formulaire de sélection de joueurs -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Sélection des joueurs</h3>
        </div>
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <input type="hidden" name="element" value="joueurs">
                <input type="hidden" name="action" value="compare">
                
                <div class="col-md-4">
                    <label for="joueur1" class="form-label">Joueur 1</label>
                    <select name="joueur1" id="joueur1" class="form-select" required>
                        <option value="<?= htmlspecialchars($joueur1['nom_joueur']) ?>" selected>
                            <?= htmlspecialchars($joueur1['nom_joueur']) ?> (<?= htmlspecialchars($joueur1['team_name'] ?? $joueur1['abr_equipe']) ?>)
                        </option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="joueur2" class="form-label">Joueur 2</label>
                    <select name="joueur2" id="joueur2" class="form-select" required>
                        <?php if ($joueur2): ?>
                            <option value="<?= htmlspecialchars($joueur2['nom_joueur']) ?>" selected>
                                <?= htmlspecialchars($joueur2['nom_joueur']) ?> (<?= htmlspecialchars($joueur2['team_name'] ?? $joueur2['abr_equipe']) ?>)
                            </option>
                        <?php else: ?>
                            <option value="">Sélectionnez un joueur</option>
                            <?php foreach ($otherPlayers as $player): ?>
                                <option value="<?= htmlspecialchars($player['nom_joueur']) ?>">
                                    <?= htmlspecialchars($player['nom_joueur']) ?> (<?= htmlspecialchars($player['team_name'] ?? $player['abr_equipe']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
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

    <?php if ($joueur2): ?>
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
                                    <th class="text-center">
                                        <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($joueur1['nom_joueur']) ?>&season=<?= $season ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($joueur1['nom_joueur']) ?>
                                        </a>
                                    </th>
                                    <th class="text-center">
                                        <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($joueur2['nom_joueur']) ?>&season=<?= $season ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($joueur2['nom_joueur']) ?>
                                        </a>
                                    </th>
                                    <th class="text-center">Avantage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Points par match -->
                                <tr>
                                    <td>Points par match</td>
                                    <td class="text-center fw-bold"><?= number_format($joueur1['points'], 1) ?></td>
                                    <td class="text-center fw-bold"><?= number_format($joueur2['points'], 1) ?></td>
                                    <td class="text-center">
                                        <?php if ($joueur1['points'] > $joueur2['points']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['points'] < $joueur2['points']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- Rebonds par match -->
                                <tr>
                                    <td>Rebonds par match</td>
                                    <td class="text-center"><?= number_format($joueur1['rebond'], 1) ?></td>
                                    <td class="text-center"><?= number_format($joueur2['rebond'], 1) ?></td>
                                    <td class="text-center">
                                        <?php if ($joueur1['rebond'] > $joueur2['rebond']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['rebond'] < $joueur2['rebond']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- Passes par match -->
                                <tr>
                                    <td>Passes par match</td>
                                    <td class="text-center"><?= number_format($joueur1['passe'], 1) ?></td>
                                    <td class="text-center"><?= number_format($joueur2['passe'], 1) ?></td>
                                    <td class="text-center">
                                        <?php if ($joueur1['passe'] > $joueur2['passe']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['passe'] < $joueur2['passe']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- Minutes par match -->
                                <tr>
                                    <td>Minutes par match</td>
                                    <td class="text-center"><?= number_format($joueur1['minutes_jouees'], 1) ?></td>
                                    <td class="text-center"><?= number_format($joueur2['minutes_jouees'], 1) ?></td>
                                    <td class="text-center">
                                        <?php if ($joueur1['minutes_jouees'] > $joueur2['minutes_jouees']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['minutes_jouees'] < $joueur2['minutes_jouees']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- % Tirs (FG) -->
                                <tr>
                                    <td>% Tirs (FG)</td>
                                    <td class="text-center"><?= number_format($joueur1['pourcent_fg'] * 100, 1) ?>%</td>
                                    <td class="text-center"><?= number_format($joueur2['pourcent_fg'] * 100, 1) ?>%</td>
                                    <td class="text-center">
                                        <?php if ($joueur1['pourcent_fg'] > $joueur2['pourcent_fg']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['pourcent_fg'] < $joueur2['pourcent_fg']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- % 3 Points -->
                                <tr>
                                    <td>% 3 Points</td>
                                    <td class="text-center"><?= number_format($joueur1['pourcent_trois_pts'] * 100, 1) ?>%</td>
                                    <td class="text-center"><?= number_format($joueur2['pourcent_trois_pts'] * 100, 1) ?>%</td>
                                    <td class="text-center">
                                        <?php if ($joueur1['pourcent_trois_pts'] > $joueur2['pourcent_trois_pts']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['pourcent_trois_pts'] < $joueur2['pourcent_trois_pts']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- % Lancers francs -->
                                <tr>
                                    <td>% Lancers francs</td>
                                    <td class="text-center"><?= number_format($joueur1['pourcent_ft'] * 100, 1) ?>%</td>
                                    <td class="text-center"><?= number_format($joueur2['pourcent_ft'] * 100, 1) ?>%</td>
                                    <td class="text-center">
                                        <?php if ($joueur1['pourcent_ft'] > $joueur2['pourcent_ft']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['pourcent_ft'] < $joueur2['pourcent_ft']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- Interceptions -->
                                <tr>
                                    <td>Interceptions par match</td>
                                    <td class="text-center"><?= number_format($joueur1['interception'], 1) ?></td>
                                    <td class="text-center"><?= number_format($joueur2['interception'], 1) ?></td>
                                    <td class="text-center">
                                        <?php if ($joueur1['interception'] > $joueur2['interception']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['interception'] < $joueur2['interception']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- Contres -->
                                <tr>
                                    <td>Contres par match</td>
                                    <td class="text-center"><?= number_format($joueur1['contre'], 1) ?></td>
                                    <td class="text-center"><?= number_format($joueur2['contre'], 1) ?></td>
                                    <td class="text-center">
                                        <?php if ($joueur1['contre'] > $joueur2['contre']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                        <?php elseif ($joueur1['contre'] < $joueur2['contre']): ?>
                                            <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Égalité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                
                                <!-- Statistiques avancées si disponibles -->
                                <?php if (isset($joueur1Advanced) && isset($joueur2Advanced) && $joueur1Advanced && $joueur2Advanced): ?>
                                    <!-- PER -->
                                    <tr>
                                        <td>PER (Player Efficiency Rating)</td>
                                        <td class="text-center"><?= number_format($joueur1Advanced['per'], 1) ?></td>
                                        <td class="text-center"><?= number_format($joueur2Advanced['per'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($joueur1Advanced['per'] > $joueur2Advanced['per']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                            <?php elseif ($joueur1Advanced['per'] < $joueur2Advanced['per']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <!-- Win Shares -->
                                    <tr>
                                        <td>Win Shares</td>
                                        <td class="text-center"><?= number_format($joueur1Advanced['ws'], 1) ?></td>
                                        <td class="text-center"><?= number_format($joueur2Advanced['ws'], 1) ?></td>
                                        <td class="text-center">
                                            <?php if ($joueur1Advanced['ws'] > $joueur2Advanced['ws']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($joueur1['nom_joueur']) ?></span>
                                            <?php elseif ($joueur1Advanced['ws'] < $joueur2Advanced['ws']): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($joueur2['nom_joueur']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Égalité</span>
                                            <?php endif; ?>
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

    <!-- Conclusion et prédiction -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Analyse comparative</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Compter les avantages de chaque joueur
                    $stats = [
                        'points', 'rebond', 'passe', 'minutes_jouees', 'pourcent_fg', 
                        'pourcent_trois_pts', 'pourcent_ft', 'interception', 'contre'
                    ];
                    
                    $j1Advantages = 0;
                    $j2Advantages = 0;
                    
                    foreach ($stats as $stat) {
                        if ($joueur1[$stat] > $joueur2[$stat]) {
                            $j1Advantages++;
                        } elseif ($joueur1[$stat] < $joueur2[$stat]) {
                            $j2Advantages++;
                        }
                    }
                    
                    // Analyser les statistiques avancées si disponibles
                    if (isset($joueur1Advanced) && isset($joueur2Advanced) && $joueur1Advanced && $joueur2Advanced) {
                        if ($joueur1Advanced['per'] > $joueur2Advanced['per']) {
                            $j1Advantages++;
                        } elseif ($joueur1Advanced['per'] < $joueur2Advanced['per']) {
                            $j2Advantages++;
                        }
                        
                        if ($joueur1Advanced['ws'] > $joueur2Advanced['ws']) {
                            $j1Advantages++;
                        } elseif ($joueur1Advanced['ws'] < $joueur2Advanced['ws']) {
                            $j2Advantages++;
                        }
                    }
                    
                    // Déterminer le meilleur joueur statistiquement
                    $betterPlayer = $j1Advantages > $j2Advantages ? $joueur1 : $joueur2;
                    $biggerDifference = abs($j1Advantages - $j2Advantages) >= 3; // Différence significative
                    ?>
                    
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4>Résumé</h4>
                            <p>
                                <?php if ($j1Advantages === $j2Advantages): ?>
                                    Les deux joueurs sont statistiquement très proches avec chacun <?= $j1Advantages ?> catégories 
                                    où ils sont meilleurs que l'autre.
                                <?php else: ?>
                                    <?= htmlspecialchars($betterPlayer['nom_joueur']) ?> est statistiquement 
                                    <?= $biggerDifference ? 'significativement' : 'légèrement' ?> supérieur avec
                                    <?= $betterPlayer === $joueur1 ? $j1Advantages : $j2Advantages ?> catégories
                                    contre <?= $betterPlayer === $joueur1 ? $j2Advantages : $j1Advantages ?> pour
                                    <?= htmlspecialchars($betterPlayer === $joueur1 ? $joueur2['nom_joueur'] : $joueur1['nom_joueur']) ?>.
                                <?php endif; ?>
                            </p>
                            
                            <p>Points forts de <?= htmlspecialchars($joueur1['nom_joueur']) ?> :</p>
                            <ul>
                                <?php
                                $strengths1 = [];
                                foreach ($stats as $stat) {
                                    if ($joueur1[$stat] > $joueur2[$stat] * 1.1) { // Au moins 10% meilleur
                                        switch ($stat) {
                                            case 'points': $strengths1[] = "Scoring (+" . round(($joueur1[$stat] - $joueur2[$stat]), 1) . " pts/match)"; break;
                                            case 'rebond': $strengths1[] = "Rebond (+" . round(($joueur1[$stat] - $joueur2[$stat]), 1) . " reb/match)"; break;
                                            case 'passe': $strengths1[] = "Passes (+" . round(($joueur1[$stat] - $joueur2[$stat]), 1) . " ast/match)"; break;
                                            case 'interception': $strengths1[] = "Interceptions (+" . round(($joueur1[$stat] - $joueur2[$stat]), 1) . " stl/match)"; break;
                                            case 'contre': $strengths1[] = "Contres (+" . round(($joueur1[$stat] - $joueur2[$stat]), 1) . " blk/match)"; break;
                                            case 'pourcent_fg': $strengths1[] = "Adresse aux tirs (+" . round(($joueur1[$stat] - $joueur2[$stat]) * 100, 1) . "%)"; break;
                                            case 'pourcent_trois_pts': $strengths1[] = "Adresse à 3 points (+" . round(($joueur1[$stat] - $joueur2[$stat]) * 100, 1) . "%)"; break;
                                            case 'pourcent_ft': $strengths1[] = "Adresse aux lancers francs (+" . round(($joueur1[$stat] - $joueur2[$stat]) * 100, 1) . "%)"; break;
                                        }
                                    }
                                }
                                if (empty($strengths1)) echo "<li>Pas d'avantage significatif identifié</li>";
                                else foreach ($strengths1 as $strength) echo "<li>$strength</li>";
                                ?>
                            </ul>
                            
                            <p>Points forts de <?= htmlspecialchars($joueur2['nom_joueur']) ?> :</p>
                            <ul>
                                <?php
                                $strengths2 = [];
                                foreach ($stats as $stat) {
                                    if ($joueur2[$stat] > $joueur1[$stat] * 1.1) { // Au moins 10% meilleur
                                        switch ($stat) {
                                            case 'points': $strengths2[] = "Scoring (+" . round(($joueur2[$stat] - $joueur1[$stat]), 1) . " pts/match)"; break;
                                            case 'rebond': $strengths2[] = "Rebond (+" . round(($joueur2[$stat] - $joueur1[$stat]), 1) . " reb/match)"; break;
                                            case 'passe': $strengths2[] = "Passes (+" . round(($joueur2[$stat] - $joueur1[$stat]), 1) . " ast/match)"; break;
                                            case 'interception': $strengths2[] = "Interceptions (+" . round(($joueur2[$stat] - $joueur1[$stat]), 1) . " stl/match)"; break;
                                            case 'contre': $strengths2[] = "Contres (+" . round(($joueur2[$stat] - $joueur1[$stat]), 1) . " blk/match)"; break;
                                            case 'pourcent_fg': $strengths2[] = "Adresse aux tirs (+" . round(($joueur2[$stat] - $joueur1[$stat]) * 100, 1) . "%)"; break;
                                            case 'pourcent_trois_pts': $strengths2[] = "Adresse à 3 points (+" . round(($joueur2[$stat] - $joueur1[$stat]) * 100, 1) . "%)"; break;
                                            case 'pourcent_ft': $strengths2[] = "Adresse aux lancers francs (+" . round(($joueur2[$stat] - $joueur1[$stat]) * 100, 1) . "%)"; break;
                                        }
                                    }
                                }
                                if (empty($strengths2)) echo "<li>Pas d'avantage significatif identifié</li>";
                                else foreach ($strengths2 as $strength) echo "<li>$strength</li>";
                                ?>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-dark text-white text-center">
                                    <h5 class="mb-0">Statistiquement meilleur</h5>
                                </div>
                                <div class="card-body text-center">
                                    <?php if ($j1Advantages === $j2Advantages): ?>
                                        <p class="mb-0">Égalité</p>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <img src="assets/img/players/placeholder.png" class="img-fluid rounded-circle" alt="Joueur 1">
                                                <p class="mt-2"><?= htmlspecialchars($joueur1['nom_joueur']) ?></p>
                                            </div>
                                            <div class="col-6">
                                                <img src="assets/img/players/placeholder.png" class="img-fluid rounded-circle" alt="Joueur 2">
                                                <p class="mt-2"><?= htmlspecialchars($joueur2['nom_joueur']) ?></p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <img src="assets/img/players/placeholder.png" class="img-fluid rounded-circle mb-3" alt="Meilleur joueur">
                                        <h4><?= htmlspecialchars($betterPlayer['nom_joueur']) ?></h4>
                                        <p class="mb-0">
                                            <?= $betterPlayer === $joueur1 ? $j1Advantages : $j2Advantages ?> - <?= $betterPlayer === $joueur1 ? $j2Advantages : $j1Advantages ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
