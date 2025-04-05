<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><?= htmlspecialchars($team['team_name']) ?></h1>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-primary me-2"><?= htmlspecialchars($team['abr_equipe']) ?></span>
                <span class="badge bg-secondary">Saison <?= $team['saison'] ?>-<?= $team['saison'] + 1 ?></span>
            </div>
            
            <!-- Navigation entre les saisons de l'équipe -->
            <div class="btn-group mb-4">
                <?php foreach ($seasons as $teamSeason): ?>
                    <a href="index.php?element=equipes&action=view&abbr=<?= $team['abr_equipe'] ?>&season=<?= $teamSeason ?>" 
                       class="btn <?= $team['saison'] == $teamSeason ? 'btn-primary' : 'btn-outline-primary' ?>">
                        <?= $teamSeason ?>-<?= $teamSeason + 1 ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=equipes" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux équipes
            </a>
        </div>
    </div>

    <!-- Statistiques d'équipe -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Statistiques de l'équipe</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if ($teamStats): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Points</h5>
                                        <p class="card-text fw-bold fs-4"><?= number_format($teamStats['pts_par_match'], 1) ?></p>
                                        <p class="card-text text-muted">par match</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Rebonds</h5>
                                        <p class="card-text fw-bold fs-4"><?= number_format($teamStats['trb_par_match'], 1) ?></p>
                                        <p class="card-text text-muted">par match</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Passes</h5>
                                        <p class="card-text fw-bold fs-4"><?= number_format($teamStats['ast_par_match'], 1) ?></p>
                                        <p class="card-text text-muted">par match</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">% Tirs</h5>
                                        <p class="card-text fw-bold fs-4"><?= number_format($teamStats['fg_pourcent'] * 100, 1) ?>%</p>
                                        <p class="card-text text-muted">réussite</p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Aucune statistique disponible pour cette équipe.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Statistiques détaillées -->
                    <?php if ($teamStats): ?>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4>Statistiques offensives</h4>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Points par match</td>
                                        <td class="fw-bold"><?= number_format($teamStats['pts_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>% Tirs (FG)</td>
                                        <td class="fw-bold"><?= number_format($teamStats['fg_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>% 3 Points</td>
                                        <td class="fw-bold"><?= number_format($teamStats['x3p_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>% Lancers francs</td>
                                        <td class="fw-bold"><?= number_format($teamStats['ft_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td>Passes par match</td>
                                        <td class="fw-bold"><?= number_format($teamStats['ast_par_match'], 1) ?></td>
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
                                        <td class="fw-bold"><?= number_format($teamStats['trb_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Interceptions par match</td>
                                        <td class="fw-bold"><?= number_format($teamStats['stl_par_match'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Contres par match</td>
                                        <td class="fw-bold"><?= number_format($teamStats['blk_par_match'], 1) ?></td>
                                    </tr>
                                    <?php if ($teamOppStats): ?>
                                    <tr>
                                        <td>Points adverses par match</td>
                                        <td class="fw-bold"><?= number_format($teamOppStats['opp_pts_per_game_'], 1) ?></td>
                                    </tr>
                                    <tr>
                                        <td>% Tirs adverses</td>
                                        <td class="fw-bold"><?= number_format($teamOppStats['opp_fg_pourcent'] * 100, 1) ?>%</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Joueurs de l'équipe -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Joueurs clés</h3>
                </div>
                <div class="card-body">
                    <?php if (count($players) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Minutes</th>
                                        <th>Points</th>
                                        <th>Rebonds</th>
                                        <th>Passes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($players as $player): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($player['nom_joueur']) ?></td>
                                            <td><?= number_format($player['minutes_jouees'], 1) ?></td>
                                            <td><?= number_format($player['points'], 1) ?></td>
                                            <td><?= number_format($player['rebond'], 1) ?></td>
                                            <td><?= number_format($player['passe'], 1) ?></td>
                                            <td>
                                                <a href="index.php?element=joueurs&action=view&nom=<?= urlencode($player['nom_joueur']) ?>&season=<?= $player['saison'] ?>" class="btn btn-sm btn-outline-primary">
                                                    Profil
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">Aucun joueur trouvé pour cette équipe.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Matchs récents -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Matchs récents</h3>
                </div>
                <div class="card-body">
                    <?php if (count($matches) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Domicile</th>
                                        <th>Score</th>
                                        <th>Extérieur</th>
                                        <th>Résultat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($matches as $match): ?>
                                        <?php 
                                        $isHomeTeam = $match['team_abbreviation_home'] === $abbr;
                                        $homeScore = $match['pts_home'];
                                        $awayScore = $match['pts_away'];
                                        $win = ($isHomeTeam && $homeScore > $awayScore) || (!$isHomeTeam && $awayScore > $homeScore);
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($match['game_date_est'])) ?></td>
                                            <td>
                                                <a href="index.php?element=equipes&action=view&abbr=<?= $match['team_abbreviation_home'] ?>&season=<?= $team['saison'] ?>"
                                                   class="<?= $match['team_abbreviation_home'] === $abbr ? 'fw-bold text-decoration-none' : '' ?>">
                                                    <?= htmlspecialchars($match['home_team_name'] ?? $match['team_abbreviation_home']) ?>
                                                </a>
                                            </td>
                                            <td class="text-center fw-bold"><?= $homeScore ?> - <?= $awayScore ?></td>
                                            <td>
                                                <a href="index.php?element=equipes&action=view&abbr=<?= $match['team_abbreviation_away'] ?>&season=<?= $team['saison'] ?>"
                                                   class="<?= $match['team_abbreviation_away'] === $abbr ? 'fw-bold text-decoration-none' : '' ?>">
                                                    <?= htmlspecialchars($match['away_team_name'] ?? $match['team_abbreviation_away']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge <?= $win ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $win ? 'Victoire' : 'Défaite' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">Aucun match trouvé pour cette équipe.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparaison avec d'autres équipes -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Comparer avec une autre équipe</h3>
        </div>
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <input type="hidden" name="element" value="equipes">
                <input type="hidden" name="action" value="compare">
                <input type="hidden" name="team1" value="<?= $team['abr_equipe'] ?>">
                <input type="hidden" name="season" value="<?= $team['saison'] ?>">
                
                <div class="col-md-8">
                    <label for="team2" class="form-label">Choisir une équipe à comparer</label>
                    <select name="team2" id="team2" class="form-select" required>
                        <option value="">Sélectionnez une équipe</option>
                        <?php 
                        // Requête pour obtenir toutes les équipes de la même saison
                        $sql_all_teams = "SELECT abr_equipe, team_name FROM team WHERE saison = :saison AND abr_equipe != :abbr ORDER BY team_name";
                        $stmt_all_teams = $db->prepare($sql_all_teams);
                        $stmt_all_teams->bindParam(':saison', $team['saison']);
                        $stmt_all_teams->bindParam(':abbr', $team['abr_equipe']);
                        $stmt_all_teams->execute();
                        $all_teams = $stmt_all_teams->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($all_teams as $otherTeam):
                        ?>
                            <option value="<?= $otherTeam['abr_equipe'] ?>">
                                <?= htmlspecialchars($otherTeam['team_name']) ?> (<?= $otherTeam['abr_equipe'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Comparer</button>
                </div>
            </form>
        </div>
    </div>
</div>
