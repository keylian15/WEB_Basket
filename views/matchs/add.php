<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Ajouter un nouveau match</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=matchs" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux matchs
            </a>
        </div>
    </div>

    <!-- Affichage des erreurs -->
    <?php if (isset($_SESSION['form_errors']) && !empty($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($_SESSION['form_errors'] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php 
        // Récupération des données du formulaire en cas d'erreur
        $form_data = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_data']);
        ?>
    <?php endif; ?>

    <!-- Formulaire d'ajout de match -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Informations du match</h3>
        </div>
        <div class="card-body">
            <form method="post" action="index.php?element=matchs&action=add">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="game_id" class="form-label">ID du match</label>
                        <input type="number" class="form-control" id="game_id" name="game_id" 
                               value="<?= htmlspecialchars($form_data['game_id'] ?? $game_id) ?>" required>
                        <div class="form-text">Identifiant unique du match</div>
                    </div>
                    <div class="col-md-6">
                        <label for="game_date_est" class="form-label">Date du match</label>
                        <input type="date" class="form-control" id="game_date_est" name="game_date_est" 
                               value="<?= htmlspecialchars($form_data['game_date_est'] ?? $game_date_est) ?>" required>
                        <div class="form-text">Format: YYYY-MM-DD</div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                Équipe à domicile
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="team_abbreviation_home" class="form-label">Équipe</label>
                                    <select class="form-select" id="team_abbreviation_home" name="team_abbreviation_home" required>
                                        <option value="">Sélectionner une équipe</option>
                                        <?php foreach ($teams as $team): ?>
                                            <option value="<?= $team['abr_equipe'] ?>" 
                                                <?= (($form_data['team_abbreviation_home'] ?? $team_abbreviation_home) == $team['abr_equipe']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($team['team_name']) ?> (<?= $team['abr_equipe'] ?>) - <?= $team['saison'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pts_home" class="form-label">Points marqués</label>
                                    <input type="number" class="form-control" id="pts_home" name="pts_home" min="0"
                                           value="<?= htmlspecialchars($form_data['pts_home'] ?? $pts_home) ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                Équipe à l'extérieur
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="team_abbreviation_away" class="form-label">Équipe</label>
                                    <select class="form-select" id="team_abbreviation_away" name="team_abbreviation_away" required>
                                        <option value="">Sélectionner une équipe</option>
                                        <?php foreach ($teams as $team): ?>
                                            <option value="<?= $team['abr_equipe'] ?>" 
                                                <?= (($form_data['team_abbreviation_away'] ?? $team_abbreviation_away) == $team['abr_equipe']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($team['team_name']) ?> (<?= $team['abr_equipe'] ?>) - <?= $team['saison'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pts_away" class="form-label">Points marqués</label>
                                    <input type="number" class="form-control" id="pts_away" name="pts_away" min="0"
                                           value="<?= htmlspecialchars($form_data['pts_away'] ?? $pts_away) ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
