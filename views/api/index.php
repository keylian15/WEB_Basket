<!-- views/api/index.php -->
<div class="container mt-4">
    <!-- En-tête de la page -->
    <div class="hero-section text-center shadow mb-5">
        <h1 class="display-5 mb-3">API NBA Predictor</h1>
        <p class="lead">Accédez aux données de prédiction NBA via notre API REST</p>
    </div>

    <div class="row">
        <!-- Carte d'introduction -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4"><i class="fas fa-code me-2"></i>Interface de Programmation</h2>
                    <p class="card-text">
                        Notre API vous permet d'accéder aux données de NBA Predictor directement depuis votre propre application.
                        Obtenez les informations sur les équipes, les joueurs, les matchs et les prédictions en temps réel.
                    </p>
                    <div class="alert alert-primary">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fs-4 me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-1">Authentification requise</h5>
                                <p class="mb-0">L'accès à l'API nécessite une clé d'authentification. Consultez la documentation pour plus de détails.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="<?= $lien_doc_api ?>" class="btn btn-primary btn-lg" target="_blank">
                            <i class="fas fa-book me-2"></i>Consulter la documentation
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartes d'information rapide -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-exchange-alt fa-3x text-primary mb-3"></i>
                    <h3 class="h5">Format de données</h3>
                    <p class="mb-0">Toutes les réponses sont au format JSON pour une intégration facile avec n'importe quel langage de programmation.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-key fa-3x text-primary mb-3"></i>
                    <h3 class="h5">Obtenir une clé API</h3>
                    <p class="mb-0">Contactez notre équipe pour obtenir une clé API afin d'accéder à nos services.</p>
                    <a href="mailto:api@nbapredictor.com" class="btn btn-outline-primary mt-3">
                        <i class="fas fa-envelope me-2"></i>Demander une clé
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .hero-section {
        background: linear-gradient(135deg, #17408B 0%, #1e5799 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 0.5rem;
    }
    
    pre {
        margin-bottom: 0;
    }
    
    code {
        color: #17408B;
    }
    
    pre code {
        color: inherit;
    }
    
    .card {
        transition: transform 0.3s;
        border-radius: 0.5rem;
    }
    
    .card:hover {
        transform: translateY(-3px);
    }
</style>