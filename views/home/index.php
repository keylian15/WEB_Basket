<!-- Hero Section -->
<div class="hero-section text-center shadow">
    <h1 class="display-4 mb-3">NBA Predictor</h1>
    <p class="lead mb-4">Analysez les performances NBA et obtenez des prédictions intelligentes sur les résultats des matchs</p>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a href="index.php?page=predictions" class="btn btn-light btn-lg px-4 gap-3">Voir les prédictions</a>
        <a href="index.php?page=teams" class="btn btn-outline-light btn-lg px-4">Explorer les équipes</a>
    </div>
</div>

<!-- Stats Overview -->
<div class="row mb-5">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <i class="fas fa-users fa-2x mb-3 text-primary"></i>
                <h5 class="card-title">Équipes</h5>
                <p class="stat-value">30</p>
                <a href="index.php?page=teams" class="btn btn-outline-primary">Voir toutes les équipes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <i class="fas fa-basketball-ball fa-2x mb-3 text-primary"></i>
                <h5 class="card-title">Joueurs</h5>
                <p class="stat-value">450+</p>
                <a href="index.php?page=players" class="btn btn-outline-primary">Voir tous les joueurs</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <i class="fas fa-chart-line fa-2x mb-3 text-primary"></i>
                <h5 class="card-title">Matchs analysés</h5>
                <p class="stat-value">1200+</p>
                <a href="index.php?page=matches" class="btn btn-outline-primary">Voir tous les matchs</a>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Matches -->
<h2 class="mb-4">Matchs à venir</h2>
<div class="row mb-5">
    <!-- Match 1 -->
    <div class="col-md-4 mb-3">
        <div class="card match-card">
            <div class="vs-badge">VS</div>
            <div class="card-body pt-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="text-center w-45">
                        <img src="https://cdn.nba.com/logos/nba/1610612738/primary/L/logo.svg" alt="Boston Celtics" class="team-logo mb-2">
                        <h6>Boston Celtics</h6>
                    </div>
                    <div class="text-center w-45">
                        <img src="https://cdn.nba.com/logos/nba/1610612747/primary/L/logo.svg" alt="Los Angeles Lakers" class="team-logo mb-2">
                        <h6>LA Lakers</h6>
                    </div>
                </div>
                <h6 class="text-center mb-2">Probabilité de victoire</h6>
                <div class="prediction-bar d-flex">
                    <div class="team-home" style="width: 65%;">65%</div>
                    <div class="team-away" style="width: 35%;">35%</div>
                </div>
                <div class="text-center mt-3">
                    <p class="small text-muted mb-3">12 Avril 2025, 20:30</p>
                    <a href="index.php?page=match-details" class="btn btn-sm btn-primary">Voir les détails</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Match 2 -->
    <div class="col-md-4 mb-3">
        <div class="card match-card">
            <div class="vs-badge">VS</div>
            <div class="card-body pt-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="text-center w-45">
                        <img src="https://cdn.nba.com/logos/nba/1610612744/primary/L/logo.svg" alt="Golden State Warriors" class="team-logo mb-2">
                        <h6>GS Warriors</h6>
                    </div>
                    <div class="text-center w-45">
                        <img src="https://cdn.nba.com/logos/nba/1610612745/primary/L/logo.svg" alt="Houston Rockets" class="team-logo mb-2">
                        <h6>Rockets</h6>
                    </div>
                </div>
                <h6 class="text-center mb-2">Probabilité de victoire</h6>
                <div class="prediction-bar d-flex">
                    <div class="team-home" style="width: 72%;">72%</div>
                    <div class="team-away" style="width: 28%;">28%</div>
                </div>
                <div class="text-center mt-3">
                    <p class="small text-muted mb-3">12 Avril 2025, 22:00</p>
                    <a href="index.php?page=match-details" class="btn btn-sm btn-primary">Voir les détails</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Match 3 -->
    <div class="col-md-4 mb-3">
        <div class="card match-card">
            <div class="vs-badge">VS</div>
            <div class="card-body pt-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="text-center w-45">
                        <img src="https://cdn.nba.com/logos/nba/1610612749/primary/L/logo.svg" alt="Milwaukee Bucks" class="team-logo mb-2">
                        <h6>Bucks</h6>
                    </div>
                    <div class="text-center w-45">
                        <img src="https://cdn.nba.com/logos/nba/1610612761/primary/L/logo.svg" alt="Toronto Raptors" class="team-logo mb-2">
                        <h6>Raptors</h6>
                    </div>
                </div>
                <h6 class="text-center mb-2">Probabilité de victoire</h6>
                <div class="prediction-bar d-flex">
                    <div class="team-home" style="width: 58%;">58%</div>
                    <div class="team-away" style="width: 42%;">42%</div>
                </div>
                <div class="text-center mt-3">
                    <p class="small text-muted mb-3">13 Avril 2025, 19:00</p>
                    <a href="index.php?page=match-details" class="btn btn-sm btn-primary">Voir les détails</a>
                </div>
            </div>
        </div>
    </div>
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
                            <tr>
                                <td>10 Avril 2025</td>
                                <td>Celtics vs. Lakers</td>
                                <td><span class="badge bg-primary">Celtics</span></td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 65%"></div>
                                    </div>
                                    <small>65%</small>
                                </td>
                            </tr>
                            <tr>
                                <td>9 Avril 2025</td>
                                <td>Warriors vs. Rockets</td>
                                <td><span class="badge bg-primary">Warriors</span></td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 72%"></div>
                                    </div>
                                    <small>72%</small>
                                </td>
                            </tr>
                            <tr>
                                <td>8 Avril 2025</td>
                                <td>Bucks vs. Raptors</td>
                                <td><span class="badge bg-primary">Bucks</span></td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 58%"></div>
                                    </div>
                                    <small>58%</small>
                                </td>
                            </tr>
                            <tr>
                                <td>7 Avril 2025</td>
                                <td>Heat vs. Nets</td>
                                <td><span class="badge bg-primary">Heat</span></td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 53%"></div>
                                    </div>
                                    <small>53%</small>
                                </td>
                            </tr>
                            <tr>
                                <td>6 Avril 2025</td>
                                <td>Bulls vs. Knicks</td>
                                <td><span class="badge bg-primary">Knicks</span></td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 61%"></div>
                                    </div>
                                    <small>61%</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light text-center">
                <a href="index.php?page=predictions" class="btn btn-primary">Voir toutes les prédictions</a>
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
                <form>
                    <div class="mb-3">
                        <label for="homeTeam" class="form-label">Équipe à domicile</label>
                        <select class="form-select" id="homeTeam">
                            <option selected>Choisir une équipe...</option>
                            <option value="1">Boston Celtics</option>
                            <option value="2">Los Angeles Lakers</option>
                            <option value="3">Golden State Warriors</option>
                            <option value="4">Milwaukee Bucks</option>
                            <option value="5">Toronto Raptors</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="awayTeam" class="form-label">Équipe à l'extérieur</label>
                        <select class="form-select" id="awayTeam">
                            <option selected>Choisir une équipe...</option>
                            <option value="1">Boston Celtics</option>
                            <option value="2">Los Angeles Lakers</option>
                            <option value="3">Golden State Warriors</option>
                            <option value="4">Milwaukee Bucks</option>
                            <option value="5">Toronto Raptors</option>
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
    <div class="col-md-3 mb-4">
        <div class="card text-center h-100">
            <img src="https://cdn.nba.com/headshots/nba/latest/1040x760/203507.png" class="card-img-top" alt="Giannis Antetokounmpo">
            <div class="card-body">
                <h5 class="card-title">Giannis Antetokounmpo</h5>
                <p class="card-text">Milwaukee Bucks | #34</p>
                <a href="index.php?page=player-details" class="btn btn-sm btn-outline-primary">Voir le profil</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center h-100">
            <img src="https://cdn.nba.com/headshots/nba/latest/1040x760/201939.png" class="card-img-top" alt="Stephen Curry">
            <div class="card-body">
                <h5 class="card-title">Stephen Curry</h5>
                <p class="card-text">Golden State Warriors | #30</p>
                <a href="index.php?page=player-details" class="btn btn-sm btn-outline-primary">Voir le profil</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center h-100">
            <img src="https://cdn.nba.com/headshots/nba/latest/1040x760/2544.png" class="card-img-top" alt="LeBron James">
            <div class="card-body">
                <h5 class="card-title">LeBron James</h5>
                <p class="card-text">Los Angeles Lakers | #23</p>
                <a href="index.php?page=player-details" class="btn btn-sm btn-outline-primary">Voir le profil</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center h-100">
            <img src="https://cdn.nba.com/headshots/nba/latest/1040x760/1629029.png" class="card-img-top" alt="Luka Doncic">
            <div class="card-body">
                <h5 class="card-title">Luka Doncic</h5>
                <p class="card-text">Dallas Mavericks | #77</p>
                <a href="index.php?page=player-details" class="btn btn-sm btn-outline-primary">Voir le profil</a>
            </div>
        </div>
    </div>
</div>