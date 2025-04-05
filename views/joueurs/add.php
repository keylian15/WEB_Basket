<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Ajouter un nouveau joueur</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=joueurs" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux joueurs
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

    <!-- Formulaire d'ajout de joueur -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Informations du joueur</h3>
        </div>
        <div class="card-body">
            <form method="post" action="index.php?element=joueurs&action=add">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="id_joueur" class="form-label">ID Joueur</label>
                        <input type="number" class="form-control" id="id_joueur" name="id_joueur" 
                               value="<?= htmlspecialchars($form_data['id_joueur'] ?? $id_joueur) ?>">
                        <div class="form-text">Identifiant unique du joueur</div>
                    </div>
                    <div class="col-md-4">
                        <label for="nom_joueur" class="form-label">Nom du joueur</label>
                        <input type="text" class="form-control" id="nom_joueur" name="nom_joueur" 
                               value="<?= htmlspecialchars($form_data['nom_joueur'] ?? $nom_joueur) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="annee_naissance" class="form-label">Année de naissance</label>
                        <input type="number" class="form-control" id="annee_naissance" name="annee_naissance" 
                               value="<?= htmlspecialchars($form_data['annee_naissance'] ?? $annee_naissance) ?>">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="abr_equipe" class="form-label">Équipe</label>
                        <select class="form-select" id="abr_equipe" name="abr_equipe" required>
                            <option value="">Sélectionner une équipe</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= $team['abr_equipe'] ?>" 
                                    <?= (($form_data['abr_equipe'] ?? $abr_equipe) == $team['abr_equipe']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($team['team_name']) ?> (<?= $team['abr_equipe'] ?>) - <?= $team['saison'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="saison" class="form-label">Saison</label>
                        <input type="number" class="form-control" id="saison" name="saison" 
                               value="<?= htmlspecialchars($form_data['saison'] ?? $saison) ?>" required>
                        <div class="form-text">Année de début de la saison (ex: 2023 pour 2023-2024)</div>
                    </div>
                </div>

                <h4 class="mt-4 mb-3">Statistiques</h4>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="minutes_jouees" class="form-label">Minutes jouées</label>
                        <input type="number" step="0.1" class="form-control" id="minutes_jouees" name="minutes_jouees" 
                               value="<?= htmlspecialchars($form_data['minutes_jouees'] ?? 0) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" class="form-control" id="points" name="points" 
                               value="<?= htmlspecialchars($form_data['points'] ?? 0) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="rebond" class="form-label">Rebonds</label>
                        <input type="number" class="form-control" id="rebond" name="rebond" 
                               value="<?= htmlspecialchars($form_data['rebond'] ?? 0) ?>">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="passe" class="form-label">Passes</label>
                        <input type="number" class="form-control" id="passe" name="passe" 
                               value="<?= htmlspecialchars($form_data['passe'] ?? 0) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="interception" class="form-label">Interceptions</label>
                        <input type="number" class="form-control" id="interception" name="interception" 
                               value="<?= htmlspecialchars($form_data['interception'] ?? 0) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="contre" class="form-label">Contres</label>
                        <input type="number" class="form-control" id="contre" name="contre" 
                               value="<?= htmlspecialchars($form_data['contre'] ?? 0) ?>">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="pourcent_fg" class="form-label">% Tirs (FG)</label>
                        <input type="number" step="0.001" class="form-control" id="pourcent_fg" name="pourcent_fg" 
                               value="<?= htmlspecialchars($form_data['pourcent_fg'] ?? 0) ?>">
                        <div class="form-text">Valeur entre 0 et 1 (ex: 0.45 pour 45%)</div>
                    </div>
                    <div class="col-md-3">
                        <label for="pourcent_trois_pts" class="form-label">% 3 Points</label>
                        <input type="number" step="0.001" class="form-control" id="pourcent_trois_pts" name="pourcent_trois_pts" 
                               value="<?= htmlspecialchars($form_data['pourcent_trois_pts'] ?? 0) ?>">
                        <div class="form-text">Valeur entre 0 et 1 (ex: 0.35 pour 35%)</div>
                    </div>
                    <div class="col-md-3">
                        <label for="pourcent_efg" class="form-label">% EFG</label>
                        <input type="number" step="0.001" class="form-control" id="pourcent_efg" name="pourcent_efg" 
                               value="<?= htmlspecialchars($form_data['pourcent_efg'] ?? 0) ?>">
                        <div class="form-text">Valeur entre 0 et 1</div>
                    </div>
                    <div class="col-md-3">
                        <label for="pourcent_ft" class="form-label">% Lancers francs</label>
                        <input type="number" step="0.001" class="form-control" id="pourcent_ft" name="pourcent_ft" 
                               value="<?= htmlspecialchars($form_data['pourcent_ft'] ?? 0) ?>">
                        <div class="form-text">Valeur entre 0 et 1 (ex: 0.8 pour 80%)</div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
