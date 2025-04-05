<?php
if ($db) {
    $db = NULL;
}

// Affichage des messages de confirmation
if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php    
    foreach ($_SESSION['mesgs']['confirm'] as $index => $mesg) {
    ?>
        <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" id="confirmToast<?= $index ?>">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Confirmation</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= $mesg; ?>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
    <?php
    unset($_SESSION['mesgs']['confirm']);
}

// Affichage des messages d'erreur
if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php    
    foreach ($_SESSION['mesgs']['errors'] as $index => $err) {
    ?>
        <div class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast<?= $index ?>">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong class="me-auto">Erreur</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= $err; ?>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
    <?php
    unset($_SESSION['mesgs']['errors']);
}
?>

<!-- Footer -->
<footer class="footer bg-primary text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <h5>NBA Predictor</h5>
                <p class="mb-0">Analysez les performances NBA et obtenez des prédictions intelligentes sur les résultats des matchs.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="mb-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <p class="small mb-0">© 2025 NBA Predictor. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Script pour les toasts (alertes) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des toasts Bootstrap
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 5000
            });
            return toast;
        });
        
        // Auto-fermeture après 5 secondes
        setTimeout(function() {
            toastList.forEach(toast => toast.hide());
        }, 5000);
    });
</script>

</body>
</html>