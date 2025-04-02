<!-- Footer -->
<footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5><?php echo APP_NAME; ?></h5>
                    <p>Analysez les performances NBA et obtenez des prédictions intelligentes sur les résultats des matchs.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo url(); ?>" class="text-white">Accueil</a></li>
                        <li><a href="<?php echo url('teams'); ?>" class="text-white">Équipes</a></li>
                        <li><a href="<?php echo url('players'); ?>" class="text-white">Joueurs</a></li>
                        <li><a href="<?php echo url('matches'); ?>" class="text-white">Matchs</a></li>
                        <li><a href="<?php echo url('predictions'); ?>" class="text-white">Prédictions</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> contact@nbapredictor.com</li>
                        <li><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-3 bg-light">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts spécifiques à la page -->
    <?php if (isset($pageScripts)): ?>
        <?php foreach ($pageScripts as $script): ?>
            <script src="<?php echo asset('js/' . $script . '.js'); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Script personnalisé -->
    <script src="<?php echo asset('js/main.js'); ?>"></script>
</body>
</html>