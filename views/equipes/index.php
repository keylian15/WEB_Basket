<div class="container mt-4">
    <h1 class="mb-4">Équipes NBA</h1>
    
    <!-- Filtres par saison -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Filtrer par saison</h5>
        </div>
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <input type="hidden" name="element" value="equipes">
                <div class="col-md-6">
                    <select name="season" class="form-select" onchange="this.form.submit()">
                        <?php foreach ($seasons as $season): ?>
                            <option value="<?= $season ?>" <?= $currentSeason == $season ? 'selected' : '' ?>>
                                Saison <?= $season ?>-<?= $season + 1 ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des équipes -->
    <div class="row">
        <?php foreach ($filtered_teams as $team): ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($team['team_name']) ?></h5>
                        <p class="card-text">
                            <span class="badge bg-primary"><?= htmlspecialchars($team['abr_equipe']) ?></span>
                            <span class="badge bg-secondary">Saison <?= $team['saison'] ?></span>
                        </p>
                        <a href="index.php?element=equipes&action=view&abbr=<?= $team['abr_equipe'] ?>&season=<?= $team['saison'] ?>" class="btn btn-outline-primary">
                            Voir l'équipe
                        </a>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                            <a href="index.php?element=equipes&action=delete&abbr=<?= $team['abr_equipe'] ?>&saison=<?= $team['saison'] ?>" 
                               class="btn btn-outline-danger mt-2" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette équipe ? Cette action est irréversible.')">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
