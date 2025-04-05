<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Ajouter une nouvelle équipe</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?element=equipes" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux équipes
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

    <!-- Formulaire d'ajout d'équipe -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Informations de l'équipe</h3>
        </div>
        <div class="card-body">
            <form method="post" action="index.php?element=equipes&action=add">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="abr_equipe" class="form-label">Abréviation de l'équipe</label>
                        <input type="text" class="form-control" id="abr_equipe" name="abr_equipe" maxlength="3" 
                               value="<?= htmlspecialchars($form_data['abr_equipe'] ?? $abr_equipe) ?>" required>
                        <div class="form-text">L'abréviation de l'équipe (max 3 caractères)</div>
                    </div>
                    <div class="col-md-4">
                        <label for="saison" class="form-label">Saison</label>
                        <input type="number" class="form-control" id="saison" name="saison" min="1946" max="<?= date('Y') ?>" 
                               value="<?= htmlspecialchars($form_data['saison'] ?? $saison) ?>" required>
                        <div class="form-text">Année de début de la saison (ex: 2023 pour 2023-2024)</div>
                    </div>
                    <div class="col-md-4">
                        <label for="team_name" class="form-label">Nom de l'équipe</label>
                        <input type="text" class="form-control" id="team_name" name="team_name" 
                               value="<?= htmlspecialchars($form_data['team_name'] ?? $team_name) ?>" required>
                        <div class="form-text">Nom complet de l'équipe</div>
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
